%****************************************************************
%* Definition of codex32 BCH code
%****************************************************************

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

/perm [29 24 13 25 9 8 23 18 22 31 27 19 1 0 3 16 11 28 12 14 6 4 2 15 10 17 21 20 26 30 7 5 ] def
/permS [16 29 24 13 25 9 8 23 18 22 31 27 19 1 0 3 11 28 12 14 6 4 2 15 10 17 21 20 26 30 7 5 ] def
/permV [22 11 10 29 31 28 17 24 27 12 21 13 19 14 20 25 1 6 26 9 0 4 30 8 3 2 7 23 16 15 5 18 ] def
/permId [ 0 1 31 {} for ] def

/code [/Q /P /Z /R /Y /nine /X /eight /G /F /two /T /V /D /W /zero /S /three /J /N /five /four /K /H /C /E /six /M /U /A /seven /L /space] def
/code2 [/multiply /aleph /alpha /beta /Gamma /Delta /epsilon /eta /Theta /Lambda /mu /Xi /Pi /rho /Sigma /Phi /Psi /Omega /at /numbersign /percent /cent /yen /Euro /currency /circleplus /dagger /daggerdbl /section /paragraph /diamond /heart /space ] def

% For inverse of code see Checksum Worksheet section
