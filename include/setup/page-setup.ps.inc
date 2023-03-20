%****************************************************************
%* Page Setup
%****************************************************************

/pgsize currentpagedevice /PageSize known
  { currentpagedevice /PageSize get
  } {
    [611.842163 791.842163] % letter size
  } ifelse
def

/centreshow {dup stringwidth pop 2 div neg 0 rmoveto show} bind def

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
      pagenum pagenum 10 lt { 1 } { 2 } ifelse string cvs centreshow

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
