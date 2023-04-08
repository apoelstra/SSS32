%************************************************************************
%************************************************************************
%*
%* Section Two: Graphics
%*
%************************************************************************
%************************************************************************

%******************
%* Helper Functions and Utilities
%*

/pgsize currentpagedevice /PageSize known
  { currentpagedevice /PageSize get
  } {
    [611.842163 791.842163] % letter size
  } ifelse
def

20 dict dup /portraitPage exch def begin
  pgsize aload pop [ /pageH /pageW ] { exch def } forall
  /centerX pageW 2 div def
  /centerY pageH 2 div def
  /marginX1 36 def
  /marginX2 pageW 36 sub def
  /marginY1 pageH 48 sub def
  /marginY2 48 def
  /marginW marginX2 marginX1 sub def
  /marginH marginY2 marginY1 sub def

  % Draw a line indicating where the margins of the page are; can be used
  % for debugging graphical output
  /drawMargin {
    gsave
      0 setgray thin line
      marginX1 marginY1 marginW marginH rectstroke
    grestore
  } bind def

  % Draw the page number and any (TODO) content in the page content array
  % Takes the pagenum as a numeric value
  /drawFooter {
    10 dict begin
    /pagenum exch def
    gsave
      /Times-Roman findfont 12 scalefont setfont
      centerX marginY2 moveto
      pagenum pagenum 10 lt { 1 } { 2 } ifelse string cvs show

      /Courier findfont 10 scalefont setfont
      marginX1 marginY2 4 sub moveto
      ver show
    grestore
    end
  } bind def
end

% landscapePage is a modified copy of portraitPage
portraitPage dup 20 dict copy dup /landscapePage exch def begin
  pgsize aload pop exch [ /pageH /pageW ] { exch def } forall
  /centerX pageW 2 div def
  /centerY pageH 2 div def
  /marginX1 36 def
  /marginX2 pageW 36 sub def
  /marginY1 pageH 48 sub def
  /marginY2 48 def
  /marginW marginX2 marginX1 sub def
  /marginH marginY2 marginY1 sub def
  /pageW portraitPage /pageH get def
  /pageH portraitPage /pageW get def

  /drawFooter {
    90 rotate
    0 pageH neg translate
    portraitPage /drawFooter get exec
  } bind def
end

% line : width --
/line {
  setlinewidth
  1 setlinecap
  1 setlinejoin
  [] 0 setdash
} bind def

/verythin 0.2 def
/thin 0.4 def
/thick 0.8 def
/verythick 1.2 def

/pen {
  50 setlinewidth
  1 setlinecap
  1 setlinejoin
  [] 0 setdash
} bind def

% Runs stroke under a uniformly scaled matrix.
% ps2pdf doesn't seem to handle strokes under a non-uniformly scaled matrix properly.
/resetstroke {
matrix currentmatrix
  dup determinant abs
  initmatrix
  matrix currentmatrix determinant abs div
  sqrt dup scale
  stroke
setmatrix
} bind def

/brass { 0.7098 0.651 0.2588 } def
/pink { 1 0.9 0.9 } def

/substitute <<
  /Omega /uni03A9
  /circleplus /uni2295
>> def

% codexshow : /glyph size --
/codexshow {
10 dict begin
  /sz exch def
  /charname exch def
  /basefont /Courier findfont def
  /basechars basefont /CharStrings get def
  /backupfont /Symbol findfont def
  substitute charname known basechars charname known not and
    { basechars substitute charname get known { /charname substitute charname get def } if } if
  basechars charname known
  { basefont sz scalefont setfont charname glyphshow }
  { backupfont sz scalefont setfont charname glyphshow } ifelse
end
} bind def

/withcrosses true def
% draftingshow : /glyph size --
/draftingshow {
gsave
10 dict begin
  currentpoint translate
  1000 div dup scale
  [1 0 10 tan 1 -100 -100] concat
  <<
  /space { }
  /A { newpath
         100 100 moveto
         400 700 lineto
         700 100 lineto
         200 300 moveto
         600 300 lineto
       pen stroke }
  /C { newpath
         400 400 300 2 3 arccos -2 3 arccos 180 add arc
       pen stroke }
  /D { newpath
         100 100 moveto
         300 400 300 270 90 arc
         100 700 lineto
         closepath
       pen stroke }
  /E { newpath
         600 700 moveto
         100 700 lineto
         100 100 lineto
         600 100 lineto
         100 400 moveto
         400 400 lineto
       pen stroke }
  /F { newpath
         600 700 moveto
         100 700 lineto
         100 100 lineto
         100 400 moveto
         400 400 lineto
       pen stroke }
  /G { newpath
         400 400 300 2 3 arccos -2 3 arccos 180 add arc
         600 400 lineto
         400 400 lineto
       pen stroke }
  /H { newpath
         600 700 moveto
         600 100 lineto
         100 700 moveto
         100 100 lineto
         100 400 moveto
         600 400 lineto
       pen stroke }
  /J { newpath
         600 700 moveto
         matrix currentmatrix
         100 100 translate
         1 4 5 div scale
         250 250 250 0 180 arcn
         setmatrix
       pen stroke }
  /L { newpath
         100 700 moveto
         100 100 lineto
         600 100 lineto
       pen stroke }
  /K { newpath
         600 700 moveto
         100 300 lineto
         100 700 moveto
         100 100 lineto
         300 460 moveto
         600 100 lineto
       pen stroke }
  /M { newpath
         100 100 moveto
         100 700 lineto
         400 100 lineto
         700 700 lineto
         700 100 lineto
       pen stroke }
  /N { newpath
         600 700 moveto
         600 100 lineto
         100 700 lineto
         100 100 lineto
       pen stroke }
  /P { newpath
         100 400 moveto
         450 550 150 270 90 arc
         100 700 lineto
         100 100 lineto
       pen stroke }
  /Q { newpath
         400 400 300 0 360 arc
         500 250 moveto
         600 100 lineto
       pen stroke }
  /R { newpath
         100 400 moveto
         450 550 150 270 90 arc
         100 700 lineto
         100 100 lineto
         400 400 moveto
         600 100 lineto
       pen stroke }
  /S { newpath
         matrix currentmatrix
         100 100 translate
         5 3 div 1 scale
         150 150 150 -90 1 3 arccos sub 90 arc
         setmatrix
         matrix currentmatrix
         150 400 translate
         4 3 div 1 scale
         150 150 150 270 90 1 3 arccos sub arcn
         setmatrix
         withcrosses {
          350 50 moveto
          350 750 lineto
         } if
       pen stroke }
  /T { newpath
         100 700 moveto
         700 700 lineto
         400 700 moveto
         400 100 lineto
       pen stroke }
  /U { newpath
         600 700 moveto
         matrix currentmatrix
         100 100 translate
         1 4 5 div scale
         250 250 250 0 180 arcn
         setmatrix
         100 700 lineto
       pen stroke }
  /V { newpath
         100 700 moveto
         400 100 lineto
         700 700 lineto
       pen stroke }
  /W { newpath
         100 700 moveto
         300 100 lineto
         500 700 lineto
         700 100 lineto
         900 700 lineto
       pen stroke }
  /X { newpath
         100 100 moveto
         650 700 lineto
         150 700 moveto
         700 100 lineto
       pen stroke }
  /Y { newpath
         100 700 moveto
         400 400 lineto
         700 700 lineto
         400 400 moveto
         400 100 lineto
       pen stroke }
  /Z { newpath
         100 700 moveto
         600 700 lineto
         100 100 lineto
         600 100 lineto
         withcrosses {
          200 400 moveto
          500 400 lineto
         } if
       pen stroke }
  /zero { newpath
         matrix currentmatrix
         100 100 translate
         5 6 div 1 scale
         300 300 300 0 360 arc
         setmatrix
         withcrosses {
          100 100 moveto
          600 700 lineto
         } if
       pen stroke }
  /two { newpath
         matrix currentmatrix
         150 400 translate
         4 3 div 1 scale
         150 150 150 90 1 3 arccos add -90 arcn
         setmatrix
         matrix currentmatrix
         100 -200 translate
         5 6 div 1 scale
         300 300 300 90 180 arc
         setmatrix
         600 100 lineto
       pen stroke }
  /three { newpath
         matrix currentmatrix
         100 100 translate
         5 3 div 1 scale
         150 150 150 -90 1 3 arccos sub 90 arc
         setmatrix
         matrix currentmatrix
         150 400 translate
         4 3 div 1 scale
         150 150 150 -90 90 1 3 arccos add arc
         setmatrix
       pen stroke }
  /four { newpath
         500 100 moveto
         500 700 lineto
         100 250 lineto
         600 250 lineto
       pen stroke }
  /five { newpath
         matrix currentmatrix
         100 100 translate
         5 4 div 1 scale
         200 200 200 -90 1 2 arccos sub 180 4 5 arccos sub arc
         setmatrix
         150 700 lineto
         550 700 lineto
       pen stroke }
  /six { newpath
         matrix currentmatrix
         100 100 translate
         5 6 div 1 scale
         300 300 300 90 2 3 arccos sub 270 arc
         setmatrix
         matrix currentmatrix
         100 100 translate
         5 4 div 1 scale
         200 200 200 -90 90 arc
         setmatrix
       pen stroke
         newpath
         matrix currentmatrix
         100 100 translate
         5 6 div 1 scale
         300 300 300 0 360 arc
         setmatrix
         clip
         newpath
         matrix currentmatrix
         100 100 translate
         5 4 div 1 scale
         200 200 200 90 180 arc
         setmatrix
       stroke }
  /seven { newpath
         100 700 moveto
         600 700 lineto
         400 400 300 300 300 100 curveto
         withcrosses {
          300 400 moveto
          500 400 lineto
         } if
       pen stroke }
  /eight { newpath
         matrix currentmatrix
         100 100 translate
         5 3 div 1 scale
         150 150 150 90 450 arc
         setmatrix
         matrix currentmatrix
         150 400 translate
         4 3 div 1 scale
         150 150 150 -90 270 arc
         setmatrix
       pen stroke }
  /nine { newpath
         matrix currentmatrix
         100 100 translate
         5 6 div 1 scale
         300 300 300 -90 2 3 arccos sub 90 arc
         setmatrix
         matrix currentmatrix
         100 300 translate
         5 4 div 1 scale
         200 200 200 90 -90 arc
         setmatrix
       pen stroke
         newpath
         matrix currentmatrix
         100 100 translate
         5 6 div 1 scale
         300 300 300 0 360 arc
         setmatrix
         clip
         newpath
         matrix currentmatrix
         100 300 translate
         5 4 div 1 scale
         200 200 200 -90 0 arc
         setmatrix
       stroke }
  >>
  exch get exec
end
grestore
} bind def

/glyphwidth {
  gsave
  nulldevice newpath 0 0 moveto glyphshow currentpoint
  grestore
} bind def

/codexwidth {
  gsave
  nulldevice newpath 0 0 moveto codexshow currentpoint
  grestore
} bind def

/draftingwidth {
  exch
32 dict begin
  /M 800 def
  /N 700 def
  /W 1000 def
  /A M def
  /C N def
  /D N def
  /E N def
  /F N def
  /G N def
  /H N def
  /J N def
  /K N def
  /L N def
  /P N def
  /Q M def
  /R N def
  /S N def
  /T M def
  /U N def
  /V M def
  /X M def
  /Y M def
  /Z N def
  /zero N def
  /two N def
  /three N def
  /four N def
  /five N def
  /six N def
  /seven N def
  /eight N def
  /nine N def
  /space N def
  load
end
  mul 1000 div
  0
} bind def

/centreshow {dup stringwidth pop 2 div neg 0 rmoveto show} bind def

/centrecodexshow {2 copy codexwidth pop 2 div neg 0 rmoveto codexshow} bind def

/centresquare {dup neg 2 div dup rmoveto dup 0 rlineto dup 0 exch rlineto neg 0 rlineto closepath stroke} bind def

/centredraftingshow {2 copy draftingwidth pop 2 div neg 0 rmoveto draftingshow} bind def

% From BLUEBOOK Program #10
/outsidecircletext
  { circtextdict begin
      /radius exch def
      /centerangle exch def
      /ptsize exch def
      /str exch def
      /xradius radius ptsize 4 div add def

      gsave
        centerangle str findhalfangle add rotate

        str
          { /charcode exch def
            ( ) dup 0 charcode put outsideplacechar
          } forall
      grestore
    end
  } def

/insidecircletext
{ circtextdict begin
  /radius exch def /centerangle exch def
  /ptsize exch def /str exch def
  /xradius radius ptsize 3 div sub def
  gsave
   centerangle str findhalfangle sub rotate
   str
    { /charcode exch def
      ( ) dup 0 charcode put insideplacechar
    } forall
  grestore
  end
} def

/circtextdict 16 dict def
circtextdict begin
 /findhalfangle
  { stringwidth pop 2 div
    2 xradius mul pi mul div 360 mul
  } def

/outsideplacechar
    { /char exch def
      /halfangle char findhalfangle def
      gsave
        halfangle neg rotate
        radius 0 translate
        -90 rotate
        char stringwidth pop 2 div neg 0 moveto
        char show
      grestore
      halfangle 2 mul neg rotate
    } def

/insideplacechar
 { /char exch def
   /halfangle char findhalfangle def
   gsave
    halfangle rotate
    radius 0 translate
    90 rotate
    char stringwidth pop 2 div neg 0 moveto
    char show
   grestore
   halfangle 2 mul rotate
 } def

/pi 3.1415923 def
end
