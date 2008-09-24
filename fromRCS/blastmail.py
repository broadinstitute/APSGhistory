#!/util/bin/python

import os, stat, glob, time, datetime, smtplib

download_dir = glob.glob('/broad/data/blastdb/.unpack_done')
databases = os.listdir('/broad/data/blastdb')
#remove .unpack_done from databases

mail = os.popen('mail -s "Blast databases updated in /local/blastdb" ckd@broad.mit.edu', "w")

#print download_dir[0]
download_stat = os.stat(download_dir[0])
dtime = time.asctime(time.localtime(download_stat[stat.ST_MTIME]))
mail.write("Blast databases downloaded on ")
mail.write(dtime)
mail.write("\n")
mail.write("The following databases have been distributed to the blade farm:\n")
for db in databases:
    mail.write(db)
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
    
