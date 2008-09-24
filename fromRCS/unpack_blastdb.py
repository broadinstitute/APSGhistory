#!/util/bin/python

import os,tarfile

downloads_dir = '/broad/test/apsg/download'
unpack_dir = '/broad/test/apsg/unpack'

tarfiles = sorted(os.listdir(downloads_dir))

for file in tarfiles:
    dbname = file.split('.')[0]
    tarpath = os.path.join(downloads_dir,file)
    dstpath = os.path.join(unpack_dir,dbname)
    if not os.path.exists(dstpath):
        os.makedirs(dstpath,0755)
    print tarpath
    tar = tarfile.open(tarpath)
    # throw an exception for *any* problems
    tar.errorlevel = 2
    # XXX python 2.5 would use: tar.extractall(dstpath)
    for member in tar.getmembers():
        tar.extract(member,dstpath)
    tar.close()
