%****************************************************************
%* Share Tables (tables for quick derivation of k=2 shares)
%****************************************************************

/showShareTable {
/offsety exch def
/offsetx exch def
/page exch def
/Courier findfont 10 scalefont setfont
20 offsetx add offsety moveto (Page: ) show
/Courier-Bold findfont 8 scalefont setfont
code page get glyphshow
2 1 31 {
dup 7 mul offsetx add offsety 10 sub moveto
permS exch get
code exch get glyphshow
} for

0 1 31 {
/Courier-Bold findfont 8 scalefont setfont
offsetx offsety 20 sub 2 index 8 mul sub moveto
dup code exch perm exch get get glyphshow
/Courier findfont 8 scalefont setfont
2 1 31 {
dup 7 mul offsetx add offsety 20 sub 3 index 8 mul sub moveto
permS exch get
page exch perm 3 index get exch  makeShare code exch get glyphshow
} for pop } for
} bind def

/showShareTablePage {
325 400 showShareTable
50 400 showShareTable
325 720 showShareTable
50 720 showShareTable
} bind def
