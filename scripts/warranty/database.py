#!/usr/bin/env python
from MySQLdb import *
from sys import stderr

class Database(object):

    def __init__(self):
        self.conn=connect(host='itdb',user='fsdb',passwd='E2PpA8j7',db='fsdb')
        self.curs=self.conn.cursor()
    
    def rollback(self,e):
        print >>stderr,"Error:",e
        self.conn.rollback()
        exit(1)

    def finish(self):
        self.conn.commit()
        self.conn.close()
        exit(0)
