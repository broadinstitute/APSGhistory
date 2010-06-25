#!/bin/bash

set -e

DIR=/broad/gold_standard/1000genomes/ftp
cd $DIR

TARGETS=`mktemp /tmp/check.targets.XXXXXXXX`
MESSY=`mktemp -d /broad/hptmp/apsg/1kg/check.messy.XXXXXXXX`
HASHES=`mktemp /tmp/check.hashes.XXXXXXXX`

perl -nae 'print "$F[1]  $F[0]\n$F[5]  $F[4]\n$F[7]  $F[6]\n"' pilot_data/alignment.index | grep -i '^[0-9a-f]' | sort -k2 > $TARGETS

< $TARGETS awk '{ print $2 }' | xargs -n 3 bsub -M 1 -P apsg/1kg-validation -q short -o $MESSY/%J.out -u adb -g /apsg/1kg/md5sum "md5sum >>$MESSY/\$RANDOM.md5"

# Wait for the above to end;  failed jobs will show up as missing hashes.

while bjobs -g /apsg/1kg/md5sum 2>/dev/null| grep .
do
  sleep 60
done

sort -k2 $MESSY/*.md5 > $HASHES

(
echo Files with incorrect hashes:
echo

echo 'HASH (alignment.index)           HASH (local file)                PATH'

join -j 2 -a 1 -a 2 -o '1.1 2.1 0' -e '----------FILE-MISSING----------' $TARGETS $HASHES | perl -lane 'print if $F[0] ne $F[1]'
) | mailx -s 'alignment.index incorrect hashes' adb@broadinstitute.org
