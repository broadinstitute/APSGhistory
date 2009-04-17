HASH_DIR   := /sysman/scratch/apsg
HASH_FILES := $(addprefix ${HASH_DIR}/,$(addsuffix .md5,$(shell find 1000genomes/data -type f -not -name '*.md5')))

SOURCE     := ftp-trace.ncbi.nih.gov

# TODO: add lock and turn on sync for cron job; currently deferred while initial sync runs.

.DEFAULT: mail-sync-plan

.PHONY: MANIFEST.ncbi mail-sync-plan sync

#sync: sync-plan
#	egrep '^(CHANGED|ADDED): ' sync-plan | perl -lane 'system("ascp", "-QTdpr", "-l", "200M", "-i", "/opt/aspera/connect/etc/asperaweb_id_dsa.putty", "ascp://${SOURCE}/$$F[1]", $$F[1])'

sync: sync-plan
	egrep '^(CHANGED|ADDED): ' sync-plan | perl -lane 'system("curl", "-sS", "--create-dirs", "-o", $$F[1], "ftp://${SOURCE}/$$F[1]")'

sync-plan: MANIFEST.ncbi MANIFEST.broad
	join -j 2      MANIFEST.broad MANIFEST.ncbi | perl -lane 'print "CHANGED: $$F[0]" unless $$F[-1] eq $$F[-2]'  > sync-plan
	join -j 2 -v 2 MANIFEST.broad MANIFEST.ncbi | perl -lane 'print "ADDED:   $$F[0]"' >> sync-plan
	join -j 2 -v 1 MANIFEST.broad MANIFEST.ncbi | perl -lane 'print "REMOVED: $$F[0]"' >> sync-plan

mail-sync-plan: sync-plan
	< sync-plan mail -s '1000genomes mirror sync plan' broad-1kg-downloads@broad.mit.edu

MANIFEST.ncbi:
	curl -sS ftp://${SOURCE}/1000genomes/alignment.index > 1000genomes/alignment.index
	curl -sS ftp://${SOURCE}/1000genomes/sequence.index  > 1000genomes/sequence.index
	(perl -lane 'print "$$F[1]  1000genomes/$$F[0]"' 1000genomes/alignment.index ; \
         perl -lane 'print "$$F[1]  1000genomes/$$F[0]"' 1000genomes/sequence.index  | tail +2 ) | sort -k2,999 > MANIFEST.ncbi

MANIFEST.broad: ${HASH_FILES}
	find ${HASH_DIR}/1000genomes/data -name '*.md5' -print0 | xargs -0 cat | sort -k2,999 > MANIFEST.broad

.PRECIOUS: ${HASH_FILES}

${HASH_DIR}/%.md5: %
	mkdir -p `dirname $@`
	bsub -o $@.log -g /apsg/gold_standard -R 'rusage[hydrogen_io=5]' -R 'rusage[thumper19_io=2]' -q short -K -E 'cd '`dirname $@` -E 'cd /broad/gold_standard' 'md5sum $? > $@' >> $@.log 2>&1
	rm -f $@.log
