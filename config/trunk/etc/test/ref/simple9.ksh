Test: simple9.t
Check operation of car, cdr, and DK_IFS
CAR
car a:b:c:d:e:f
a
car a:b:c:d:e:f 0 :
a
car a:b:c:d:e:f 1 :
b
car a:b:c:d:e:f 2 :
c
car a:b:c:d:e:f 3 :
d
car a:b:c:d:e:f 4 :
e
car a:b:c:d:e:f 5 :
f
car a:b:c:d:e:f 6 :


CDR
cdr a:b:c:d:e:f
b:c:d:e:f
cdr a:b:c:d:e:f 0 :
a:b:c:d:e:f
cdr a:b:c:d:e:f 1 :
b:c:d:e:f
cdr a:b:c:d:e:f 2 :
c:d:e:f
cdr a:b:c:d:e:f 3 :
d:e:f
cdr a:b:c:d:e:f 4 :
e:f
cdr a:b:c:d:e:f 5 :
f
cdr a:b:c:d:e:f 6 :


Now white space in tab-separated fields
CAR
car 'a b	c d	e f	g h' 0 '	'
a b
car 'a b	c d	e f	g h' 1 '	'
c d
car 'a b	c d	e f	g h' 2 '	'
e f
car 'a b	c d	e f	g h' 3 '	'
g h
car 'a b	c d	e f	g h' 4 '	'


CDR
cdr 'a b	c d	e f	g h' 0 '	'
a b	c d	e f	g h
cdr 'a b	c d	e f	g h' 1 '	'
c d	e f	g h
cdr 'a b	c d	e f	g h' 2 '	'
e f	g h
cdr 'a b	c d	e f	g h' 3 '	'
g h
cdr 'a b	c d	e f	g h' 4 '	'


Setting DK_IFS to TAB

CDR, with DK_IFS separators
cdr 'a b	c d	e f	g h' 0
a b	c d	e f	g h
cdr 'a b	c d	e f	g h' 1
c d	e f	g h
cdr 'a b	c d	e f	g h' 2
e f	g h
cdr 'a b	c d	e f	g h' 3
g h
cdr 'a b	c d	e f	g h' 4

###
