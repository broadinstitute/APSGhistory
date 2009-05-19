#!/bin/bash

#PBS -V
#PBS -j oe
#PBS -o /data/results/output/SolidTEST-S100-S100.A-jobs
#PBS -N SolidTEST-S100-S100.A-jobs
#PBS -l nodes=1:ppn=2
#PBS -l walltime=96:00:00

#pushd /data/results/SolidTEST/S100/S100.A/jobs
#cd ..
#tar --remove-files -cvzf jobs.tar.gz /data/results/SolidTEST/S100/S100.A/jobs
