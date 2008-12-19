#!/usr/bin/env python

import pty
import subprocess
import os
import sys



p = subprocess.Popen("ssh -T gold", 
                     stdin=subprocess.PIPE, 
                     stdout=subprocess.PIPE, 
                     stderr=subprocess.STDOUT, 
                     shell=True)
while True:

    ch = os.read(p.stdout.fileno(),1)
    while ch != '':
        sys.stdout.write(ch) 
        ch = os.read(p.stdout.fileno(),1)

    cmd = sys.stdin.readline()
    print cmd
    if cmd == "exit\n":
        break

    os.write(p.stdin.fileno(), cmd)
