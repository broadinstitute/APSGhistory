#!/usr/bin/perl
use strict;
use warnings;
use diagnostics;
use Net::SMTP;

my ($cmd,$bjobsOutput,$bjobsLongOutput,$machine,@recipients,$count);
my ($from,$subject,$prefixMessage,$mesg,$mailServer,$smtp,$cc);

$machine = $ARGV[0];
$cmd = "bjobs -u all -m $machine";
$bjobsOutput = `$cmd`;
$cmd = "bjobs -l -u all -m $machine";
$bjobsLongOutput = `$cmd`;

$mailServer = "smtp.broadinstitute.org";
$from = q(lsfadmin@broadinstitute.org);
$cc = $from;
$subject = "Heads up on your jobs";
$mesg = "The following jobs are running on a node that is currently stuck:\n\n\n";
$mesg = $mesg.$bjobsOutput."\n\n\n$bjobsLongOutput\n\n";
$mesg = $mesg."This node will need to be restarted to restore proper operation; however, this will also kill your jobs.\n\n";
$mesg = $mesg.q(For future reference, you can submit jobs as re-runnable (bsub -r) if there's no worry about having them automatically restarted.);
$mesg = $mesg.q(Re-runnable jobs should automatically re-queue if the node the job was running on dies.)."\n\n";
$mesg = $mesg."Please let me know if you have any questions, comments, or concerns.\n\n";
$mesg = $mesg."Thanks,\n";
$mesg = $mesg."LSF Administrator";

$cmd = "bjobs -u all -m $machine -w";
$cmd = $cmd.q( | egrep -vi user | awk '{print $2}' | sort | uniq);

push(@recipients,`$cmd`);

for ($count = 0; $count < @recipients; $count++)
{
	$recipients[$count] =~ s/\n/\@broadinstitute.org/g;
}
push(@recipients,$from);

$smtp = Net::SMTP->new($mailServer) || die "Could not connect to service";
$smtp->mail($from);
$smtp->to(@recipients);
$smtp->data();
$smtp->datasend("From: $from\n");
foreach(@recipients) { $smtp->datasend("To: $_\n"); }
$smtp->datasend("Subject: $subject\n");
$smtp->datasend($mesg);
$smtp->dataend();
$smtp->quit();

`badmin hclose -C "Wedged Node" $machine`;
