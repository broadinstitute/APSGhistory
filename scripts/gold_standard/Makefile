
HASH_DIR   := /broad/hptmp/apsg
HASH_FILES := $(addprefix ${HASH_DIR}/,$(addsuffix .md5,$(shell find 1000genomes/data -type f -not -name '*.md5')))

FTP_SOURCE  := ftp-trace.ncbi.nih.gov
ASCP_SOURCE := anonftp\@ftp-private.ncbi.nih.gov

# TODO: add lock and turn on sync for cron job; currently deferred while initial sync runs.

.DEFAULT: mail-download-plan sync

.PHONY: MANIFEST.ncbi mail-download-plan sync

sync: sync-plan
	egrep '^(CHANGED|ADDED): ' sync-plan | perl -lane 'system("ascp", "${ASCP_SOURCE}:/$$F[1]", $$F[1], "-k", "1", "-m", "80M", "-l", "100M", "-QTqi", "/opt/aspera/connect/etc/asperaweb_id_dsa.putty", "-M", "39188")'
	find /broad/gold_standard/1000genomes -type d -print0 | xargs -0 chmod 2755
	find /broad/gold_standard/1000genomes -type f -print0 | xargs -0 chmod og=u-w

sync-plan: MANIFEST.ncbi MANIFEST.broad
	join -j 2      MANIFEST.broad MANIFEST.ncbi | perl -lane 'print "CHANGED: $$F[0]" unless $$F[-1] eq $$F[-2]'  > sync-plan
	join -j 2 -v 2 MANIFEST.broad MANIFEST.ncbi | perl -lane 'print "ADDED:   $$F[0]"' >> sync-plan
	join -j 2 -v 1 MANIFEST.broad MANIFEST.ncbi | perl -lane 'print "REMOVED: $$F[0]"' >> sync-plan

mail-download-plan: sync-plan
	egrep -q '^(CHANGED|ADDED): ' sync-plan && \
	      egrep '^(CHANGED|ADDED): ' sync-plan | mail -s '1000genomes mirror download plan' broad-1kg-downloads@broad.mit.edu

mail-deletion-plan: sync-plan /broad/1KG/gold_standard_preserve
	(egrep '^(REMOVED): ' sync-plan | grep -qF "$(cat /broad/1KG/gold_standard_preserve)") && \
	      egrep '^(REMOVED): ' sync-plan | awk '{ print $2 }' | grep -F "$(cat /broad/1KG/gold_standard_preserve)" | mail -s '1000genomes mirror files to delete' broad-1kg-downloads@broad.mit.edu

MANIFEST.ncbi:
	curl -sS ftp://${FTP_SOURCE}/1000genomes/alignment.index > 1000genomes/alignment.index
	curl -sS ftp://${FTP_SOURCE}/1000genomes/sequence.index  > 1000genomes/sequence.index
	(perl -lane 'print "$$F[1]  1000genomes/$$F[0]"' 1000genomes/alignment.index ; \
         perl -ne '@F = split /\t/, $$_; print "$$F[1]  1000genomes/$$F[0]" unless 1 == $$F[20];' 1000genomes/sequence.index  | tail +2 | perl -ne '' ) \
         | sort -k2,999 > MANIFEST.ncbi

MANIFEST.broad: ${HASH_FILES}
	find ${HASH_DIR}/1000genomes/data -name '*.md5' -print0 | xargs -0 cat | sort -k2,999 > MANIFEST.broad

.PRECIOUS: ${HASH_FILES}

${HASH_DIR}/%.md5: %
	mkdir -p `dirname $@`
	bsub -o /dev/null -g /apsg/gold_standard -R 'rusage[hydrogen_io=2]' -R 'rusage[thumper19_io=2]' -q short -K -E 'cd '`dirname $@` -E 'cd /broad/gold_standard' 'md5sum $? > $@.partial && mv $@.partial $@' >/dev/null 2>&1

