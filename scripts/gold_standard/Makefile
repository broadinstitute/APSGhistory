# management port for local asperacentral process (get manually from netstat after restart)
ASCP_PORT    := 39188
ASCP_SOURCE  := anonftp\@ftp-private.ncbi.nih.gov
ASCP_OPTIONS := $(if $(filter -s,${MAKEFLAGS}),-q) -k 1 -m 80M -l 350M -QT -i /opt/aspera/connect/etc/asperaweb_id_dsa.putty -M ${ASCP_PORT}

FTP_SOURCE   := ftp-trace.ncbi.nih.gov
CURL_OPTIONS := $(if $(filter -s,${MAKEFLAGS}),-s) -S

LOCAL_PATH  := /broad/gold_standard/1000genomes/ftp
REMOTE_PATH := 1000genomes/ftp

T := $(if $(filter -s,${MAKEFLAGS}),,--verbose)

sync: sync-plan
	for file in `sed -re '/^REMOVED: /d;s/^(CHANGED|ADDED): *//' sync-plan`; do mkdir -p `dirname $$file`; done
	sed -re '/^REMOVED: /d;s/^(CHANGED|ADDED): *//' sync-plan | xargs -r $T -n1 -IPATH ascp ${ASCP_OPTIONS} ${ASCP_SOURCE}:/PATH PATH

sync-plan: MANIFEST.ncbi MANIFEST.broad
	join -j 2      MANIFEST.broad MANIFEST.ncbi | perl -lane 'print "CHANGED: $$F[0]" unless $$F[-1] eq $$F[-2]'  > sync-plan
	join -j 2 -v 2 MANIFEST.broad MANIFEST.ncbi | perl -lane 'print "ADDED:   $$F[0]"' >> sync-plan
	join -j 2 -v 1 MANIFEST.broad MANIFEST.ncbi | perl -lane 'print "REMOVED: $$F[0]"' >> sync-plan

MANIFEST.ncbi:
	curl ${CURL_OPTIONS} ftp://${FTP_SOURCE}/${REMOTE_PATH}/alignment.index > ${LOCAL_PATH}/alignment.index
	curl ${CURL_OPTIONS} ftp://${FTP_SOURCE}/${REMOTE_PATH}/sequence.index  > ${LOCAL_PATH}/sequence.index
	(perl -lane 'print "$$F[1]  ${REMOTE_PATH}/$$F[0]"' ${LOCAL_PATH}/alignment.index ; \
         perl -ne '@F = split /\t/, $$_; print "$$F[1]  ${REMOTE_PATH}/$$F[0]" unless 1 == $$F[20];' ${LOCAL_PATH}/sequence.index | tail +2 ) \
         | sort -k2,999 > MANIFEST.ncbi

MANIFEST.broad:
	$(MAKE) -f Makefile.broad-manifest

clean:
	pgrep ascp >/dev/null || </dev/null find ${LOCAL_PATH} -name '*.aspx' -exec rm {} \;
	find ${LOCAL_PATH} -type d -print0 | xargs -r -0 chmod 2755
	find ${LOCAL_PATH} -type f -print0 | xargs -r -0 chmod og=u-w

mail-download-plan: sync-plan
	if egrep -q '^(CHANGED|ADDED): ' sync-plan ;\
	then \
	      egrep '^(CHANGED|ADDED): ' sync-plan | mail -s '1000genomes mirror download plan' broad-1kg-downloads@broad.mit.edu ;\
	fi

mail-deletion-plan: sync-plan /broad/1KG/gold_standard_preserve
	if egrep '^(REMOVED): ' sync-plan | awk '{ print $$2 }' | grep -qvF "$$(cat /broad/1KG/gold_standard_preserve)" ;\
	then \
	      egrep '^(REMOVED): ' sync-plan | awk '{ print $$2 }' | grep -vF "$$(cat /broad/1KG/gold_standard_preserve)" \
	      | mail -s '1000genomes mirror files to delete' broad-1kg-downloads@broad.mit.edu ;\
	fi

nightly: mail-download-plan sync clean

weekly: mail-deletion-plan nightly

# MANIFEST.broad included because its dependency calculation is delegated to a sub-make;  MANIFEST.ncbi's dependencies are offsite
.PHONY: mail-download-plan mail-deletion-plan sync clean nightly weekly MANIFEST.broad MANIFEST.ncbi
