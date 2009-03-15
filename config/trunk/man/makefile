REL = "Dotkit 1.0"
STR = "AX Local Docs"

# Must have DK_ROOT defined before making html files.
HTPREP = pod2html --htmlroot=${DK_ROOT}/html --podpath=.
PREP = pod2man

all: checkprep man html

man: man1/use.1 man5/dk-commands.5 man5/dk-examples.5 man7/dotkit.7 \
     man8/dk-admin.8

html: ../html/use.html ../html/dk-commands.html \
      ../html/dk-examples.html ../html/dotkit.html \
      ../html/dk-admin.html cleanpod

checkprep:
	@ $(PREP) ./chk.pod > /dev/null

man1/use.1: use.pod
	$(PREP) --release=$(REL) --center=$(STR) $? > $@
	cd man1 && rm -f unuse.1 && ln -s use.1 unuse.1

../html/use.html: use.pod
	$(HTPREP) $? > $@

man5/dk-commands.5: dk-commands.pod
	$(PREP) --release=$(REL) --center=$(STR) $? > $@
	(cd man5; \
	for i in reuse alter unalter car cdr \
	  dk_alter dk_setenv dk_setdef dk_alias dk_cev dk_op \
	  dk_rep dk_source dk_test dk_where; do \
	  rm -f $$i.5 && ln -s dk-commands.5 $$i.5; \
	done)

../html/dk-commands.html: dk-commands.pod
	$(HTPREP) $? > $@

man5/dk-examples.5: dk-examples.pod
	$(PREP) --release=$(REL) --center=$(STR) $? > $@

../html/dk-examples.html: dk-examples.pod
	$(HTPREP) $? > $@

man7/dotkit.7: dotkit.pod
	$(PREP) --release=$(REL) --center=$(STR) $? > $@

../html/dotkit.html: dotkit.pod
	$(HTPREP) $? > $@

man8/dk-admin.8: dk-admin.pod
	$(PREP) --release=$(REL) --center=$(STR) $? > $@

../html/dk-admin.html: dk-admin.pod
	$(HTPREP) $? > $@

clean: cleanpod
	rm -f man[0-9]/*.[0-9] ../html/*.html

cleanpod:
	rm -f pod2htm* index.bt

ps: man1/use.1 man5/dk-commands.5 man5/dk-examples.5 \
	man7/dotkit.7 man8/dk-admin.8
	@ man -t man1/use.1 > /tmp/use.ps
	@ man -t man5/dk-commands.5 > /tmp/dk-commands.ps
	@ man -t man5/dk-examples.5 > /tmp/dk-examples.ps
	@ man -t man7/dotkit.7 > /tmp/dotkit.ps
	@ man -t man8/dk-admin.8 > /tmp/dk-admin.ps
