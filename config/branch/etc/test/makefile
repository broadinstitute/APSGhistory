TEST =

test:
	@ ./dk-test ${TEST}

bashtest:
	@ TESTSHELL=bash ./dk-test ${TEST}

cshtest:
	@ TESTSHELL=csh ./dk-test ${TEST}

kshtest:
	@ TESTSHELL=ksh ./dk-test ${TEST}

tcshtest:
	@ TESTSHELL=tcsh ./dk-test ${TEST}

clean:
	rm -f new/*.*sh dif/*.*sh

refclean: clean
	rm -f ref/*.ksh
