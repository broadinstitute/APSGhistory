#!/bin/bash

for dir in $(<list); do
  MYJOB=`echo $dir | sed -e 's/\//-/g'`
  echo "#!/bin/bash" > $MYJOB
  echo "#PBS -V" >> $MYJOB
  echo "#PBS -j oe" >> $MYJOB
  echo "#PBS -o /data/results/output/$MYJOB" >> $MYJOB
  echo "#PBS -N $MYJOB" >> $MYJOB
  echo "#PBS -l nodes=1:ppn=2" >> $MYJOB
  echo "#PBS -l walltime=96:00:00" >> $MYJOB
  echo "pushd /data/results/$dir" >> $MYJOB
  echo "cd .." >> $MYJOB
  TARFILE=`basename /data/results/$dir`.tar.gz
  echo "tar --remove-files -cvzf $TARFILE /data/results/$dir" >> $MYJOB
done
