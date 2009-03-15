# Makefile to help maintain dotkit
# We assume your present working directory is $DK_ROOT/etc.

DKU = $${USER:-$${LOGNAME}}

help:
	@ echo "Type \"make links\" to create needed symbolic links."
	@ echo "Type \"make export\" to create /tmp/dk-<USER>.tgz."
	@ echo "Type \"make clean\" to remove test junk, man pages."
	@ echo "Type \"make cleanexport\" to recreate man pages before export."

# You need write access to make links:
links:
	@ rm -f ../bash/unuse && ln -s ../ksh/use ../bash/unuse
	@ rm -f ../bash/use && ln -s ../ksh/use ../bash
	@ rm -f ../bash/prompt1.dk && ln -s ../ksh/prompt1.dk ../bash
	@ rm -f ../bash/prompt2.dk && ln -s ../ksh/prompt2.dk ../bash 
	@ rm -f ../bash/envdiff.dk && ln -s ../ksh/envdiff.dk ../bash 
	@ rm -f ../bash/macos_10 && ln -s ../ksh/macos_10 ../bash 
	@ rm -f ../bash/.dk_init && ln -s ../ksh/.dk_init ../bash 
	@ rm -f test/ksh && ln -s ../../ksh test
	@ rm -f test/bash && ln -s ../../bash test
	@ rm -f test/etc && ln -s ../../etc test
	@ rm -f test/csh && ln -s ../../csh test
	@ rm -f test/tcsh && ln -s ../../tcsh test
	@ rm -f ../ksh/unuse && ln -s use ../ksh/unuse
	@ rm -f ../ksh/setenv && ln -s use ../ksh/setenv
	@ rm -f ../ksh/unsetenv && ln -s use ../ksh/unsetenv
	@ rm -f ../ksh/car && ln -s use ../ksh/car
	@ rm -f ../ksh/cdr && ln -s use ../ksh/cdr
	@ rm -f ../ksh/alter && ln -s use ../ksh/alter
	@ rm -f ../ksh/unalter && ln -s use ../ksh/unalter
	@ rm -f ../tcsh && ln -s csh ../tcsh 

# You need write access to make clean:
clean:
	@ cd test && make clean
	@ cd ../man && make clean

# Write access is NOT required to run "make export":
export:
	@ cd ../.. && \
	  tar cf - `find dotkit \( -name CVS -prune \) -o \
	    \( -name DK_MAINTAINER -prune \) -o \
	    \( -name DK_NODE -prune \) -o \
	    \( -name "site=*" -prune \) -o \
            \( -type f -print \) -o \( -type l -print \)` | \
          gzip -c > /tmp/dk-$(DKU).tgz && \
          echo "Created gzipped tar file: /tmp/dk-$(DKU).tgz"

# This one cleans up, then re-creates man pages as needed:
# (Write access is required.)
cleanexport: clean links
	@ cd ../man && make
	@ make export
