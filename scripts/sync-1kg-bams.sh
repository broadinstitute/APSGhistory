#!/bin/bash

SYNC_ALL=no

set -e

#EMAIL=broad-1kg-downloads@broadinstitute.org
EMAIL=adb@broadinstitute.org

ASCP="/bin/ascp -i /opt/aspera/connect/etc/asperaweb_id_dsa.putty -M "`cat /var/run/aspera/asperacentral.port`" -k2 -l10G -T -p"

SOURCE=anonftp@ftp-private.ncbi.nih.gov:/1000genomes/ftp

cd /broad/gold_standard/1000genomes/ftp

$ASCP $SOURCE/alignment.index ./

# get the EBI version instead
#wget -O- ftp://ftp.1000genomes.ebi.ac.uk/vol1/ftp/alignment.index > alignment.index

TARGETS=`mktemp /tmp/sync.targets.XXXXXXXX`

perl -lane 'for (@F) { print if m!/.*/! }' ./alignment.index | sort > $TARGETS

if [[ ! -s $TARGETS ]]
then
    echo 'Empty target list!' >&2
    exit 123
fi

if [[ $SYNC_ALL == 'yes' ]]
then
    DOWNLOAD=$TARGETS
else
    EXISTING=`mktemp /tmp/sync.existing.XXXXXXXX`

    find data/ \( -name '*.bam' -o -name '*.bam.*' \) -type f | sort > $EXISTING
# always re-download .bam.bas
#    find pilot_data \( -name '*.bam' -o -name '*.bam.bai' \) -type f | sort > $EXISTING

    DELETE=`mktemp /tmp/sync.delete.XXXXXXXX`
    DOWNLOAD=`mktemp /tmp/sync.download.XXXXXXXX`

    join -v1 $EXISTING $TARGETS > $DELETE
    join -v2 $EXISTING $TARGETS > $DOWNLOAD
fi

[[ -s $DOWNLOAD || -s $DELETE ]] &&
(
    [[ -s $DOWNLOAD ]] && (
	echo 'Files to be downloaded:'
	echo
	cat $DOWNLOAD
	echo
	)

    [[ -s $DELETE ]] && (
	echo 'Files deleted:'
	echo
#	< $DELETE xargs rm
#	cat $DELETE
	)
) 2>&1| mailx -s 'alignment.index sync plan' $EMAIL

if [[ -s $DOWNLOAD ]]
then

HASHES=`mktemp /tmp/sync.hashes.XXXXXXXX`

< $DOWNLOAD xargs /broad/tools/scripts/sync-some-files.pl $SOURCE .
< $DOWNLOAD xargs /usr/local/bin/md5sum | sort -k2 > $HASHES

TARGET_HASHES=`mktemp /tmp/sync.target-hashes.XXXXXXXX`

perl -nae 'print "$F[1]  $F[0]\n$F[5]  $F[4]\n$F[7]  $F[6]\n"' ./alignment.index | grep '^[0-9a-f]\{32\}  ' | sort -k2 > $TARGET_HASHES

BAD=`mktemp /tmp/sync.bad.XXXXXXXX`

/usr/local/bin/join -j 2 -a 1 -a 2 -o '1.1 2.1 0' -e '----------FILE-MISSING----------' $TARGET_HASHES $HASHES | perl -lane 'print unless $F[0] eq $F[1]' > $BAD

(

[[ -s "$BAD" ]] && (
echo Mismatched/missing files:
echo

echo 'HASH (alignment.index)           HASH (local file)                PATH'
cat $BAD
echo
)

echo Download results:
echo

echo 'HASH (alignment.index)           HASH (local file)                PATH'

join -j 2 -a 1 -a 2 -o '1.1 2.1 0' -e '----------FILE-MISSING----------' $TARGET_HASHES $HASHES
) | mailx -s 'alignment.index sync complete' $EMAIL

fi

rm -f $EXISTING $TARGETS $DELETE $DOWNLOAD $TARGET_HASHES $HASHES

# get all but fastq files

$ASCP -E '*.fastq*' $SOURCE .
