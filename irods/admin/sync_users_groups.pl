#!/usr/bin/env perl

use strict;


# Using users from NIS now
#my $rusers = '/home/radon00/irods/admin/role_users.txt';
#my $binddn = 'cn=Jean Chang,ou=UserOU,dc=broad,dc=mit,dc=edu';
my $iadmin = '/opt/iRODS/clients/icommands/bin/iadmin';

my $debug = 0;

my $run_iadmin;
if ($debug eq 1) {
  $run_iadmin = 'echo';
}
else {
  $run_iadmin = $iadmin;
}

my %irods_users = ();
foreach (`$iadmin lu`) {
  my ($user) = split /#/;
  $irods_users{$user} = 1;
}

my %irods_groups = ();
foreach (`$iadmin lg`) {
  s/(\w+)\s*$/$1/; # clean trailing whitespace
  $irods_groups{$_} = 1;
}

#
# Build up a list of NIS groups with member lists
#
my %nis_groups_by_name = ();
my %nis_groups_by_gid = ();
my ($group, $pw, $gid, $members);
open(YPCAT, "ypcat group|") or die "Can't run ypcat: $!\n";
while (<YPCAT>) {
  chop;
  ($group, $pw, $gid, $members) = split /:/;
  $nis_groups_by_gid{$gid} = $group;
  $nis_groups_by_name{$group} = $members;
}
close(YPCAT);

#
# First create all the groups in iRODS
#
foreach $group (keys %nis_groups_by_name) {
  if ($irods_groups{$group}) {
    print "Group $group already exists in iRODS.\n";
  }
  else {
    print "Creating group $group in iRODS.\n";
    print "$iadmin mkgroup $group\n" if $debug;
    my @out = `$run_iadmin mkgroup $group 2>&1`;
    if ($?) {
      print "Error adding group $group. iadmin output:\n";
      print @out;
      next;
    }
  }
}

# DEPRECATED in favour of using NIS users
#
# Get the list of users to add to the system. The list comes from the 
# "Broad users" group from Active Directory, which corresponds to all
# real users (vs role users)
#
#print "Connecting to AD as user \"$binddn\" to retrieve members of group 'Broad users'.\n";
#my @broad_users = `ldapsearch -E 'pr=1000/noprompt' -LLL -D "$binddn" -W -x -h ldapdc1 -b 'ou=UserOU,dc=broad,dc=mit,dc=edu' '(&(memberOf=CN=Broad Users,OU=User Security Groups,OU=UserOU,DC=broad,DC=mit,DC=edu)(objectclass=person))' sAMAccountName`;

#
# Extract the user name from the record and add to iRODS if it isn't 
# already in iRODS. Normalize the user name to lower case along the way.
#
#print "Synchronizing iRODS user DB with members of AD group 'Broad users'.\n";
#my $user;
#foreach (@broad_users) {
#  chop;
#  next if /^$/;
#  next if /^dn: /;
#  if (/^sAMAccountName: (\w+)$/) {
#    $user = lc $1;
#    if ($irods_users{$user}) {
#      print "User $user already in iRODS.\n";
#    }
#    else {
#      addIrodsUser($user, 1);
#      $irods_users{$user} = 1;
#    }	
#  }
#}

#
# Add the role users from a file
#
#print "Synchronizing iRODS user DB with role users from $rusers.\n";
#open(RU, $rusers) or die "Cannot open $rusers: $!";
#foreach $user (<RU>) {
#  chop $user;
#  if ($irods_users{$user}) {
#    print "User $user already in iRODS.\n";
#  }
#  else {
#    print "Adding role user $user to iRODS user DB.\n";
#    addIrodsUser($user, 0);
#    $irods_users{$user} = 1;
#  }
#}
#close(RU);

# Get the list of NIS users to add to iRODS.
print "Synchronizing iRODS user DB with NIS users.\n";
open(YPCAT, "ypcat passwd|") or die "Can't run ypcat passwd: $!";
while (<YPCAT>) {
  my ($user, $rest) = split(':');
  if ($irods_users{$user}) {
    print "User $user already in iRODS.\n";
  }
  else {
    print "Adding role user $user to iRODS user DB.\n";
    addIrodsUser($user, 0);
    $irods_users{$user} = 1;
  }
}
close(YPCAT);

#
# Now iterate through the member lists for the NIS groups
# and add the users to the corresponding iRODS groups
#
foreach $group (keys %nis_groups_by_name) {
  next if length($nis_groups_by_name{$group}) == 0;
  my @memberlist = split(',', $nis_groups_by_name{$group});
  print "Adding ", scalar(@memberlist), " members to group $group...\n";
  foreach my $user (@memberlist) {
    next if not $irods_users{$user}; # skip if user is not in iRODS
    addIrodsUserToGroup($user, $group);
  }
}

print "All done.\n";
exit 0;


use String::Random qw(random_regex);
sub addIrodsUser {
	my ($user, $addprinc) = @_;

        print "Adding $user to iRODS user DB.\n";
        print "$iadmin mkuser $user rodsuser\n" if $debug;
	my @out = `$run_iadmin mkuser $user rodsuser 2>&1`;
        print @out if $debug;
	if ($?) {
          print "Error adding user $user to iRODS. iadmin output:\n";
          print @out;
          return;
	}

	my $password = random_regex("[a-zA-Z0-9]{32}");
        print "$iadmin moduser $user password XXXXXXXX\n" if $debug;
	@out = `$run_iadmin moduser $user password $password 2>&1`;
	if ($?) {
          print "Error setting password for user $user in iRODS. iadmin output:\n";
          print @out;
	}

	if ($addprinc) {
          my $princ = $user.'@BROAD.MIT.EDU';
          print "$iadmin aua $user $princ\n" if $debug;
          @out = `$run_iadmin aua $user $princ 2>&1`;
          if ($?) {
            print "Error associating user to KRB principal in iRODS. iadmin output:\n";
            print @out;
          }
	}

        my @pwent = getpwnam($user);
        if (exists($nis_groups_by_gid{$pwent[3]})) {
          print "Adding $user to iRODS group $group.\n";
          addIrodsUserToGroup($user, $nis_groups_by_gid{$pwent[3]});
        }
        
	return;
}

sub addIrodsUserToGroup {
  my ($user, $group) = @_;

  print "$iadmin atg $group $user\n" if $debug;
  my @out = `$run_iadmin atg $group $user 2>&1`;
  if ($?) {
    # Error code 809000 means the user is already in the group
    my $rc = grep(/809000/, @out);
    if ($rc == 0) {
      print "Error adding user $user to group $group. iadmin output:\n";
      print @out;
    }
  }
}
    


