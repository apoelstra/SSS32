%******************
%* Code Parameters
%*
%* Data related to the representation of GF(32) elements
%*

/perm [29 24 13 25 9 8 23 18 22 31 27 19 1 0 3 16 11 28 12 14 6 4 2 15 10 17 21 20 26 30 7 5 ] def
/permS [16 29 24 13 25 9 8 23 18 22 31 27 19 1 0 3 11 28 12 14 6 4 2 15 10 17 21 20 26 30 7 5 ] def
/permV [22 11 10 29 31 28 17 24 27 12 21 13 19 14 20 25 1 6 26 9 0 4 30 8 3 2 7 23 16 15 5 18 ] def
/permId [ 0 1 31 {} for ] def

/code [/Q /P /Z /R /Y /nine /X /eight /G /F /two /T /V /D /W /zero /S /three /J /N /five /four /K /H /C /E /six /M /U /A /seven /L /space] def
/code2 [/multiply /aleph /alpha /beta /Gamma /Delta /epsilon /eta /Theta /Lambda /mu /Xi /Pi /rho /Sigma /Phi /Psi /Omega /at /numbersign /percent /cent /yen /Euro /currency /circleplus /dagger /daggerdbl /section /paragraph /diamond /heart /space ] def

/decode {
 [ exch { <<
113 0
81 0
112 1
80 1
122 2
90 2
114 3
82 3
121 4
89 4
57 5
120 6
88 6
56 7
103 8
71 8
102 9
70 9
50 10
116 11
84 11
118 12
86 12
100 13
68 13
119 14
87 14
48 15
115 16
83 16
51 17
106 18
74 18
110 19
78 19
53 20
52 21
107 22
75 22
104 23
72 23
99 24
67 24
101 25
69 25
54 26
109 27
77 27
117 28
85 28
97 29
65 29
55 30
108 31
76 31
32 32
 >> exch get } forall ]
} bind def
