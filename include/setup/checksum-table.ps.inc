%******************
%* Checksum Table
%*
%* Draws the giant lookup table used by the checksum worksheet
%*

/drawChecksumTable {
  10 dict begin
  { /startVal /tHeight /tWidth /y /x } {exch def} forall

  /cellH tHeight 32 div def
  /cellW tWidth 8 div def

  % Draw horizontal background lines: one black one for the heading then
  % alternating 4-cell-height white/gray for the content background
  x y moveto
  0 1 31 {
    dup 0 eq { 0.808 0.923 0.953 } {
      8 mod 4 lt { 0.808 0.923 0.953 } { 1 1 1 } ifelse
    } ifelse setrgbcolor

    gsave
      tWidth 0 rlineto
      0 cellH neg rlineto tWidth neg 0 rlineto closepath fill
    grestore
    0 cellH neg rmoveto
  } for

  % Draw vertical background lines: one double-wide black one per column
  0 setgray
  x y moveto
  0 1 7 {
    gsave
      0 tHeight neg rlineto
      cellW 2 mul 13 div 0 rlineto 0 tHeight rlineto closepath fill
    grestore
    cellW 0 rmoveto
  } for

  % Draw content
  startVal 1 startVal 7 add {
    /xVal exch def
    x xVal startVal sub cellW mul add 2 add y 1.5 add moveto
    0 1 31 {
      /yVal exch def
      0 cellH neg rmoveto

      gsave
        /Courier-Bold findfont 8.5 scalefont setfont
        1 setgray
        code perm xVal get get glyphshow
        code perm yVal get get glyphshow
      grestore

      gsave
        cellW 2 mul 13 div 0 rmoveto
        perm xVal get perm yVal get polymodshift2 {
          code exch get glyphshow
          0.25 0 rmoveto
        } forall
      grestore
    } for
  } for

  % Bounding box
  0.5 setlinewidth
  x y moveto
  0 tHeight neg rlineto
  tWidth 0 rlineto
  0 tHeight rlineto
  closepath stroke

  end
} bind def
