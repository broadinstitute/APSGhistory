#!/bin/bash -x

#SOLID=%SOLID%
#RUN=%RUN%

SOLID=SolidTEST
RUN=S100

# Timestamp
echo "Start: "`date`

# Working directory is root of source.
cd /data/results/

# Sanity Check that $SOLID and $RUN make sense
if [ "x${SOLID}" = "x" ] || [ "x${RUN}" = "x" ]; then
  echo "Empty values for instrument and/or run names."
  exit 1
fi

if [ ! -d ${SOLID}/${RUN} ]; then
  echo "${SOLID}/${RUN} not found in `pwd`"
  exit 2
fi 

for dir in `find ${SOLID}/${RUN} -depth -type d`
do
  echo -e "\n\nProcessing $dir"

  # Check for existance of target, create if missing
  if [ ! -d /data/results_new/$dir ]; then
      echo "Creating target: $dir"
      mkdir -p /data/results_new/$dir
  fi
  
  rsync -a $dir/* /data/results_new/$dir
  RSYNC=$?

  # Since we do depth first, any errors should propogate
  # out as each rsync from higher up fails so that we 
  # delete anything that doesn't get successfully rsync'd
  if [ "x$RSYNC" = "x0" ]; then
    echo "${dir} transferred succesfully, *DELETING*."
    pushd /data/results
    rm -rfv ${dir}
    popd

  else 
    echo "rsync error: ${RSYNC} during transfer of ${dir}"
  fi
done

# Final Rsync of run
rsync -a /data/results/${SOLID}/${RUN} /data/results_new/${SOLID}/

if [ "x$?" = "x0" ]; then 
  pushd /data/results/${SOLID}
  rm -rfv ${RUN}
  popd
fi

echo "End: "`date`

