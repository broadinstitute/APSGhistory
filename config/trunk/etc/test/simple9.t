echo "Check operation of car, cdr, and DK_IFS"

echo "CAR"
echo "car a:b:c:d:e:f"
car a:b:c:d:e:f
echo "car a:b:c:d:e:f 0 :"
car a:b:c:d:e:f 0 :
echo "car a:b:c:d:e:f 1 :"
car a:b:c:d:e:f 1 :
echo "car a:b:c:d:e:f 2 :"
car a:b:c:d:e:f 2 :
echo "car a:b:c:d:e:f 3 :"
car a:b:c:d:e:f 3 :
echo "car a:b:c:d:e:f 4 :"
car a:b:c:d:e:f 4 :
echo "car a:b:c:d:e:f 5 :"
car a:b:c:d:e:f 5 :
echo "car a:b:c:d:e:f 6 :"
car a:b:c:d:e:f 6 :

echo ""
echo "CDR"
echo "cdr a:b:c:d:e:f"
cdr a:b:c:d:e:f
echo "cdr a:b:c:d:e:f 0 :"
cdr a:b:c:d:e:f 0 :
echo "cdr a:b:c:d:e:f 1 :"
cdr a:b:c:d:e:f 1 :
echo "cdr a:b:c:d:e:f 2 :"
cdr a:b:c:d:e:f 2 :
echo "cdr a:b:c:d:e:f 3 :"
cdr a:b:c:d:e:f 3 :
echo "cdr a:b:c:d:e:f 4 :"
cdr a:b:c:d:e:f 4 :
echo "cdr a:b:c:d:e:f 5 :"
cdr a:b:c:d:e:f 5 :
echo "cdr a:b:c:d:e:f 6 :"
cdr a:b:c:d:e:f 6 :

echo ""
echo "Now white space in tab-separated fields"
echo "CAR"
echo "car 'a b	c d	e f	g h' 0 '	'"
car 'a b	c d	e f	g h' 0 '	'
echo "car 'a b	c d	e f	g h' 1 '	'"
car 'a b	c d	e f	g h' 1 '	'
echo "car 'a b	c d	e f	g h' 2 '	'"
car 'a b	c d	e f	g h' 2 '	'
echo "car 'a b	c d	e f	g h' 3 '	'"
car 'a b	c d	e f	g h' 3 '	'
echo "car 'a b	c d	e f	g h' 4 '	'"
car 'a b	c d	e f	g h' 4 '	'

echo ""
echo "CDR"

echo "cdr 'a b	c d	e f	g h' 0 '	'"
cdr 'a b	c d	e f	g h' 0 '	'
echo "cdr 'a b	c d	e f	g h' 1 '	'"
cdr 'a b	c d	e f	g h' 1 '	'
echo "cdr 'a b	c d	e f	g h' 2 '	'"
cdr 'a b	c d	e f	g h' 2 '	'
echo "cdr 'a b	c d	e f	g h' 3 '	'"
cdr 'a b	c d	e f	g h' 3 '	'
echo "cdr 'a b	c d	e f	g h' 4 '	'"
cdr 'a b	c d	e f	g h' 4 '	'

echo ""
echo "Setting DK_IFS to TAB"
setenv DK_IFS '	'

echo ""
echo "CDR, with DK_IFS separators"

echo "cdr 'a b	c d	e f	g h' 0"
cdr 'a b	c d	e f	g h' 0
echo "cdr 'a b	c d	e f	g h' 1"
cdr 'a b	c d	e f	g h' 1
echo "cdr 'a b	c d	e f	g h' 2"
cdr 'a b	c d	e f	g h' 2
echo "cdr 'a b	c d	e f	g h' 3"
cdr 'a b	c d	e f	g h' 3
echo "cdr 'a b	c d	e f	g h' 4"
cdr 'a b	c d	e f	g h' 4
