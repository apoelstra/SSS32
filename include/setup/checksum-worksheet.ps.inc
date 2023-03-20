%****************************************************************
%* Checksum Worksheet
%****************************************************************

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

30 dict dup /ladder exch def begin
  /hrp (MS) def
  /sharelen 48 def
  /xsize 14 def
  /xgap 2 def
  /ysize -14 def
  /ygap -1 def
  /fsize 15 def
  /fgap 2.5 def
  /hrplen hrp length def
  /checksumlen checksum length def
  /numsteps sharelen hrplen sub checksumlen sub 2 idiv def
  /firstrowlen sharelen hrplen sub 1 sub numsteps 2 mul sub def
  /odd checksumlen firstrowlen sub def
  /initresidue [hrp polymodhrp aload pop firstrowlen {0} repeat ] polymod0 def
  /offset {
    dup ysize mul exch 2 idiv ygap mul add exch
    dup xsize mul exch 4 idiv xgap mul add exch
  } bind def
  /drawgrid {
  10 dict begin
  gsave
    pink setrgbcolor
    0 2 checksumlen {
      /j exch def
      0 1 j checksumlen 2 mod add 1 sub {
        /i exch def
        i sharelen checksumlen sub add j numsteps 2 mul checksumlen 2 idiv 2 mul sub add offset xsize ysize rectfill
      } for
    } for
  grestore
  gsave
    /Courier findfont 3 scalefont setfont
    thick line
    0 1 firstrowlen hrplen add {
      /i exch def
      i 0 offset 2 copy xsize ysize rectstroke moveto
      xsize 4.5 sub -3 rmoveto
      /n i 1 add def
      n 10 lt { ( ) show } if n 2 string cvs show
    } for

    thin line
    0 1 firstrowlen 1 sub {
      hrplen 1 add add 1 offset xsize ysize rectstroke
    } for

    0 1 checksumlen 1 sub {
      sharelen checksumlen sub add /i exch def
      thin line
      i numsteps 1 add 2 mul offset xsize ysize rectstroke
    } for

    1 1 numsteps {
      2 mul /j exch def
      0 1 checksumlen 1 sub {
        hrplen add j add 1 sub odd sub /i exch def
        thin line
        i j offset xsize ysize rectstroke
        i 2 add j 1 add offset xsize ysize rectstroke
      } for
      thick line
      i 1 add j offset 2 copy xsize ysize rectstroke moveto
      xsize 4.5 sub -3 rmoveto
      /Courier findfont 3 scalefont setfont
      /n i 2 add def
      n 10 lt { ( ) show } if n 2 string cvs show
      i 2 add j offset 2 copy xsize ysize rectstroke moveto
      xsize 4.5 sub -3 rmoveto
      /n i 3 add def
      n 10 lt { ( ) show } if n 2 string cvs show
    } for

    /Helvetica-Bold findfont 10 scalefont setfont
    1 1 numsteps 1 add {
      2 mul /j exch def
      j j offset moveto xsize 0.7 mul 5 rmoveto (+) centreshow
      j j 1 add offset moveto xsize 0.7 mul 5 rmoveto (=) centreshow
    } for

    /Courier findfont fsize scalefont setfont
    0 1 hrplen 1 sub {
      dup 0 offset moveto xsize 2 div ysize fgap add rmoveto hrp exch 1 getinterval centreshow
    } for
    hrplen 0 offset moveto xsize 2 div ysize fgap add rmoveto (1) centreshow
    0 1 checksumlen 1 sub {
      /i exch def
      i hrplen add 1 add odd sub 1 0 i eq {odd add} if offset moveto xsize 2 div ysize fgap add rmoveto initresidue i get code exch get fsize centrecodexshow
    } for
    0.85 setgray
    0 1 checksumlen 1 sub {
      /i exch def
      i sharelen checksumlen sub add numsteps 1 add 2 mul offset moveto xsize 2 div ysize fgap add rmoveto checksum i get code exch get fsize centrecodexshow
    } for
  grestore
  end
  } bind def

  /fillgrid {
  10 dict begin
  gsave
    /data exch decode def
    /fsize fsize 2 sub def
    0 1 firstrowlen 1 sub {
     /i exch def
     i hrplen add 1 add 0 offset moveto xsize 2 div ysize fgap add rmoveto
     code data i get get fsize centredraftingshow
    } for
    /residue
      data 0 firstrowlen getinterval polymod0
      initresidue gf32addarray
    def
    0 2 numsteps 1 sub 2 mul {
      /y exch def
      /residue
      [ residue polymod0 aload pop
        data firstrowlen y add get
        data firstrowlen y add 1 add get
      ] def
      0 1 checksumlen 1 add {
        /i exch def
        i hrplen add y add 1 add odd sub 2 y add offset moveto xsize 2 div ysize fgap add rmoveto
        odd 1 eq 0 i eq and 0 y eq and not {code residue i get get fsize centredraftingshow} if
      } for
      /addrow residue 0 get residue 1 get polymodshift2 def
      0 1 checksumlen 1 sub {
        /i exch def
        i hrplen add y add 3 add odd sub 3 y add offset moveto xsize 2 div ysize fgap add rmoveto
        code addrow i get get fsize centredraftingshow
      } for
    } for
    /residue residue polymod0 def
    0 1 checksumlen 1 sub { 
      /i exch def
      i hrplen add numsteps 2 mul add 1 add 2 numsteps 2 mul add offset moveto xsize 2 div ysize fgap add rmoveto
      code residue i get get fsize centredraftingshow
    } for
  grestore
  end
  } bind def
end

/arraySpace 13 def

/showParagraphs {
  10 dict begin
  { /paragraphs /height /width } {exch def} forall
  paragraphs {
    /lines exch def
    lines 0 lines length 1 sub getinterval {
      /line exch def
      % Compute amount of space needed for each /space character
      width line stringwidth pop sub 0 line { 32 eq { 1 add } if} forall div
      0 32 line gsave widthshow grestore
      0 height neg rmoveto
    } forall
    lines lines length 1 sub get gsave show grestore
    0 height neg 2 mul rmoveto
  } forall
  end
} bind def
