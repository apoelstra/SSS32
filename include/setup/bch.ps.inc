%******************
%* BCH
%*
%* Data and functions related to the error-correcting code.
%*
/polymodulus [25 27 17 8 0 25 25 25 31 27 24 16 16] def % coefficents from c12 to c0
/checksum [16 25 24 3 25 11 16 23 29 3 25 17 10] def
/checksumstring { polymodulus length array checksum 0 1 polymodulus length 1 sub {3 copy exch 1 index get code exch 1 getinterval putinterval pop } for pop } bind def

/polymod0 % array -> [ c5 c4 c3 c2 c1 c0 ]
 { [ polymodulus length {0} repeat ]
   exch
   { [ exch 2 index 1 polymodulus length 1 sub getinterval aload pop polymodulus length dup 1 sub roll ] exch 0 get polymodulus gf32mularray gf32addarray  } forall
 } bind def

/polymodshift2 % c7 c6 -> [ c5 c4 c3 c2 c1 c0 ]
 {  [ 3 1 roll polymodulus length {0} repeat ] polymod0
 } bind def

/polymodhrp % string -> [ c5 c4 c3 c2 c1 c0 ]
 {
   [ exch 1 exch dup { dup dup 65 ge exch 90 le exch and { 32 add } if 32 idiv exch } forall 0 exch { 31 and } forall ] polymod0
 } bind def
