#!/bin/sh
zfs create zpool1/$1
zfs create zpool1/$1_images
zfs set compress=on zpool1/$1 zpool1/$1_images
zfs set quota=500G zpool1/$1 
zfs set quota=6T zpool1/$1_images
mkdir /zpool1/$1_images/transfer /zpool1/$1/analyzed
chmod 775 /zpool1/$1_images/transfer /zpool1/$1/analyzed
chown -R prodinfo:sequence /zpool1/$1 /zpool1/$1_images
ln -s /slxa/$1_images/transfer /zpool1/$1
ln -s /seq/solexaproc/solexaproc01/Instruments /zpool1/$1
zfs set sharenfs=rw=@18.103.8.0/22:@18.103.32.0/20,root=@18.103.8.0/22:@18.103.32.0/20 zpool1/$1
zfs set sharenfs=rw=@18.103.8.0/22:@18.103.32.0/20,root=@18.103.8.0/22:@18.103.32.0/20 zpool1/$1_images
