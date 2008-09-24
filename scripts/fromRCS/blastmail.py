#!/util/bin/python

import os, stat, glob, time, datetime, smtplib

download_dir = '/broad/data/blastdb'
semaphore_file = '.unpack_done'
semaphore_path = os.path.join(download_dir,semaphore_file)

databases = os.listdir(download_dir)

if semaphore_file in databases:
    databases.remove(semaphore_file)

mail = os.popen('mail -s "Blast databases updated in /local/blastdb" blast@broad.mit.edu', "w")

#print download_dir[0]
download_stat = os.stat(semaphore_path)
dtime = time.asctime(time.localtime(download_stat[stat.ST_MTIME]))
mail.write("Blast databases updated on ")
mail.write(dtime)
mail.write("\n")
mail.write("The following databases have been distributed to the blade farm:\n")
mail.write(' '.join(databases))
mail.write("\n\n")

#print source_file[0]
mail.write("See timestamp on files for original NCBI database creation date:")
mail.write("\n\n")


source_all = os.popen('ls -lR /broad/data/blastdb/*')


for line in source_all:
    line = line.rstrip()
    mail.write(line)
    mail.write("\n")
source_all.close()
mail.close()
    
