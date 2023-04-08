%******************
%* Volvelle and Slide Charts
%*
/magic 94 def % a magic angle for making nice looking spirals.
/drawBottomWheelPage
 { 10 dict begin
   /outerperm exch def
   /outercode exch def
   /innercode exch def
   /title exch def
   /binop exch def
   /angle 360 outerperm length div neg def
   % Move cursor to center of page
   pgsize aload pop 2 div exch 2 div exch translate
   % Draw white interior circle
   newpath 0 0 6 40 mul 0 360 arc stroke
   gsave verythin line
     newpath 0 0 6 40 mul 28 add 0 360 arc stroke
     newpath 0 0 6 0 360 arc stroke
   grestore
   % Draw title (small text, repeated)
   /Helvetica findfont 12 scalefont setfont
   title 12 270 30 insidecircletext
   % Draw letters (using human-centric ABCD... permutation)
   /Helvetica findfont 6 scalefont setfont
   gsave
   360 16 div 360 64 div sub rotate
   0 360 8 div 360 {title 6 3 -1 roll 262 outsidecircletext} for
   grestore
   outerperm {0 38 sqrt 40 mul moveto outercode exch get 18 centrecodexshow angle rotate} forall
   % Draw inside contents
   0 1 31 { % Draw 32 circles of increasing radius
       dup 1 add magic mul 24 add
       /theta exch def
       outerperm {
           1 index 2 add sqrt 40 mul 2 sub
           /lam exch def
           lam theta sin mul
           lam theta cos mul neg
           moveto
           0 -3 rmoveto
           1 index 31 exch sub % 31 - inner index
           permV exch get binop % apply binary operation to the permuted letter and the inner index
           innercode exch get 12 centrecodexshow % display the result
           angle rotate % rotate one entry
       } forall pop
   } for
   end
 } bind def

/showTopWheelPage
 {
   % Move cursor to center of page
   pgsize aload pop 2 div exch 2 div exch translate
   gsave verythin line
     newpath 0 0 6 40 mul 0 360 arc stroke
   grestore
   % Draw gray "handle" and white interior circle
   gsave
     0.8 setgray
     newpath 0 0 7.25 40 mul 140 40 arc clip fill
     1 setgray
     newpath 0 0 6 40 mul 0 360 arc fill
     0 setgray
     newpath 0 0 6 40 mul 0 360 arc stroke
   grestore
   % Draw centre cross
   gsave verythin line
     newpath 0 6 moveto 0 -6 lineto stroke
     newpath 6 0 moveto -6 0 lineto stroke
   grestore
   % Draw indicator arrow
   newpath 0 6 40 mul moveto 10 -20 rlineto -20 0 rlineto closepath fill
   % Draw text
   0 1 31 {
       dup 1 add magic mul 24 add
       /theta exch def
       dup 2 add sqrt 40 mul 2 sub % lam = 40*sqrt(idx + 0.5) - 2
       /lam exch def
       newpath
       lam theta sin mul
       lam theta cos mul neg
       2 copy moveto
       12 centresquare % draw square
       moveto % return to midpoint
       -26 -3 rmoveto % Move to the left
       31 exch sub % 31 - loop index
       permV exch get code exch get % Permute index and extract 1-char substring of alphabet
       12 codexshow % ...and draw it
       /Symbol findfont 12 scalefont setfont /arrowright glyphshow % Draw a right arrow
   } for
 } bind def

% drawPointer : sz --
% draws a fillied triangle of sz pointing up (or down if sz is negative).
/drawPointer {
  /sz exch def
  0 sz eq not {
    sz 2 div sz neg rlineto sz neg 0 rlineto closepath fill
  } if
} bind def

% drawPin : sz --
% draws a sylized brass fasstener
/drawPin {
gsave
  /sz exch def
  currentpoint newpath moveto
  sz -2 div sz 3.5 mul rmoveto
  sz 0 rlineto
  sz 0 sz sz sz -2 div sz rcurveto
  sz -1.5 mul 0 sz -1.5 mul sz neg sz -2 div sz neg rcurveto
  0 sz -3 mul rlineto
  sz 2 div dup neg rlineto
  sz 2 div dup rlineto
  0 sz 3 mul rlineto
  closepath
  gsave brass setrgbcolor fill grestore
  thin line stroke
grestore
} bind def
% drawSplitPin : sz --
% draws a sylaized open brass fastener.
/drawSplitPin {
  /sz exch def
  currentpoint
  newpath moveto
  0 sz -3.5 mul rmoveto
  sz -2 div sz 3.5 mul rmoveto
  0 sz -3 mul rlineto
  sz 2 div dup neg rlineto
  sz 2 div dup rlineto
  0 sz 3 mul rlineto
  closepath
  sz 2 div sz 3.5 mul rmoveto
  sz 2 div sz -3.5 mul rmoveto
  0 sz 3 mul rlineto
  sz -2 div dup neg rlineto
  sz -2 div dup rlineto
  0 sz -3 mul rlineto
  closepath
  gsave brass setrgbcolor fill grestore
  gsave thin line stroke grestore
} bind def

% arrowHeadPath : x y r angle sz --
% creates an arrow head path for the end of a arc
/arrowHeadPath {
10 dict begin
  { /sz /angle /r /y /x } {exch def} forall
  matrix currentmatrix
    x y translate
    angle rotate
    r sz add sz neg moveto
    r 0 lineto
    sz neg dup rlineto
  setmatrix
end
} bind def

30 dict dup /multiplicationDisc exch def begin
  /radius 200 def
  /title (Multiplication) def
  /outerTitleSz 6 def
  /outerglyphSz 18 def
  /outerPointerSz 0 def
  /innerRadius { radius outerTitleSz outerglyphSz add sub outerPointerSz add } bind def
  /innerglyphSz { outerglyphSz } def
  /innerTitleSz 12 def
  /innerPointerSz 6 def
  /handlePointerSz -16 def
  % the fold line for the bottom disc is slightly less that the disc radius.
  /bottomfoldline { radius angle 2 div cos mul } bind def
  /topfoldline { radius 27 add } bind def
  /handlewidth 54 def

  /logbase 19 def
  /coding code2 def
  /numglyphs 31 def
  /angle 360 numglyphs div def
  /outerglyphs { [ [ 1 numglyphs 1 sub {dup logbase gf32mul} repeat ] {coding exch get} forall ] } bind def
  /innerglyphs { outerglyphs } def

  /outlineBottomDisc {
      radius 0 moveto
      0 0 radius 0 360 arc
      4.5 0 moveto
      0 0 4.5 360 0 arcn
  } bind def

  /drawBottomDisc {
     % Draw white interior circle
     newpath
     outlineBottomDisc
     verythin line resetstroke
     newpath 0 0 innerRadius 0 360 arc thick line resetstroke
     % Draw letters
     gsave
       /Helvetica findfont outerTitleSz scalefont setfont
       360 8 div dup 2 div exch 360 {title outerTitleSz 3 -1 roll radius outerTitleSz sub outsidecircletext} for
     grestore
     outerglyphs {
       0 radius outerTitleSz outerglyphSz 0.8 mul add sub moveto outerglyphSz centrecodexshow
       % Draw indicator pointer
       0 innerRadius moveto outerPointerSz drawPointer
       angle neg rotate
     } forall
  } bind def

  /handleCapPath {
      handlewidth 2 div topfoldline 5 sub moveto
      handlewidth 2 div topfoldline handlewidth -2 div topfoldline 5 arct
      handlewidth -2 div topfoldline 2 copy 5 sub 5 arct
  } bind def
  /outlineTopDisc {
      handleCapPath
      0 0 innerRadius handlewidth 2 innerRadius mul arcsin dup 90 add exch 450 exch sub arc
      closepath
      /charwidth /space innerglyphSz codexwidth pop 1.2 mul def
      charwidth 2 div innerRadius outerPointerSz sub moveto
      charwidth 2 div neg innerRadius outerPointerSz sub lineto
      charwidth 2 div neg radius outerTitleSz sub lineto
      charwidth 2 div radius outerTitleSz sub lineto
      closepath
  } bind def

  /drawTopDisc {
     gsave decorateTopDisc grestore

     /charwidth /space innerglyphSz codexwidth pop 1.2 mul def

     % Draw handle
     gsave
       newpath innerRadius topfoldline moveto
       0 0 innerRadius 0 180 arc
       innerRadius neg topfoldline lineto
       closepath
       clip
       newpath
       handleCapPath
       handlewidth -2 div 0 lineto
       handlewidth 2 div 0 lineto
       closepath
       charwidth 2 div innerRadius outerPointerSz sub moveto
       charwidth 2 div neg innerRadius outerPointerSz sub lineto
       charwidth 2 div neg radius outerTitleSz sub lineto
       charwidth 2 div radius outerTitleSz sub lineto
       closepath
       0.8 setgray
       fill
     grestore

     % Draw indicator pointer
     0 radius outerTitleSz sub moveto handlePointerSz drawPointer

     gsave verythin line
       % Draw white interior circle
       newpath 0 0 innerRadius 0 360 arc resetstroke
       % Draw centre cross
       newpath 0 4.5 moveto 0 -4.5 lineto 4.5 0 moveto -4.5 0 lineto resetstroke
     grestore
     % Draw title
     gsave
       /Helvetica findfont innerTitleSz scalefont setfont
       title innerTitleSz 270 30 insidecircletext
     grestore
     % Draw letters
     innerglyphs {
        0 innerRadius innerglyphSz 0.8 mul sub innerPointerSz sub moveto innerglyphSz centrecodexshow
        % Draw indicator pointer
        0 innerRadius moveto innerPointerSz drawPointer
        angle neg rotate
     } forall
  } bind def
  /decorateTopDisc {} def
end

% /translationDisc is a modified copy of multiplicaitonDisc.
multiplicationDisc dup maxlength dict copy dup /translationDisc exch def begin
  /title (Translation) def
  /logbase 23 def
  /coding code def
  /handlePointerSz 0 def
  /decorateTopDisc {
    [/Q /arrowboth /Q]
    dup 0 exch {outerglyphSz 2 mul codexwidth pop add} forall -2 div outerglyphSz 2 mul moveto
    {outerglyphSz 2 mul codexshow} forall
  } bind def
end

% /recoveryDisc is a modified copy of multiplicaitonDisc.
multiplicationDisc dup maxlength dict copy dup /recoveryDisc exch def begin
  /title (Recovery) def
  /logbase 10 def
  /outerglyphs {
     [ [ 1 numglyphs 1 sub {dup logbase gf32mul} repeat ]
       {16 xor code exch get} forall ]
  } bind def
  /outerPointerSz -6 def
  /innerglyphs {
     [ [ 1 numglyphs 1 sub {dup logbase gf32mul} repeat ]
       { 16 xor [ exch 17 ] 16 17 3 -1 roll lagrange
         dup 1 eq {pop 32} if
         code2 exch get
       } forall ]
  } bind def
  /innerPointerSz 0 def
  /decorateTopDisc {
     /littleR 1 def
     /bigR innerRadius innerPointerSz sub innerglyphSz sub littleR sub def
     thin line
     0.8 setgray
     1 1 numglyphs 2 idiv {
       angle mul dup sin bigR mul exch cos bigR mul
       newpath 2 copy littleR -180 180 arc
       exch neg exch littleR 0 360 arc
       resetstroke
     } for
  } bind def
end

% foldingBottomDiscs: angle1 angle2 --
% Renders an illustration of a folded multiplication and translation bottom disc pair.
/foldingBottomDiscs {
10 dict begin
  { /angle2 /angle1 } {exch def} forall

  matrix currentmatrix
  dup determinant /det exch def
    angle2 foldprojection concat
    translationDisc begin
      0 bottomfoldline translate
      180 rotate
      radius neg dup radius 2 mul radius bottomfoldline add rectclip
      gsave newpath outlineBottomDisc 1 setgray fill grestore
      matrix currentmatrix determinant det mul 0 gt
      { drawBottomDisc }
      { newpath outlineBottomDisc verythin line resetstroke }
      ifelse
      initclip
    end
  dup setmatrix
    angle1 foldprojection concat
    multiplicationDisc begin
      0 bottomfoldline neg translate
      radius neg dup radius 2 mul radius bottomfoldline add rectclip
      gsave newpath outlineBottomDisc 1 setgray fill grestore
      drawBottomDisc
      % draw fold line
      initclip
      0 0 radius 0 360 arc clip
      newpath radius bottomfoldline moveto radius -2 mul 0 rlineto verythin line resetstroke
      initclip
    end
  setmatrix
end
} bind def
