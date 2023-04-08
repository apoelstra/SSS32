%******************
%* Reference Sheet
%*

% Draws the data format box. Assumes that position 0 0 is the top-center of the page
/drawDataFormat {
  10 dict begin
  /boxW 14 def
  /boxH 14 def

  /Courier findfont boxH scalefont setfont
  boxW -17 mul 0 moveto
  % Draw left 13 boxes
  1 1 13 {
    pop
    gsave
      [] 0 setdash
      boxW 0 rlineto
      0 boxH neg rlineto
      boxW neg 0 rlineto
      closepath stroke
    grestore
    boxW 0 rmoveto
  } for
  % Draw dashed line (4 boxes wide)
  boxW 2 div 0 rmoveto
  0 -7 rmoveto
  [1 2] 0 setdash
  boxW 4 mul 0
  gsave 2 copy rlineto stroke grestore
  rmoveto
  0 7 rmoveto
  boxW 2 div 0 rmoveto
  % Draw right 17 boxes
  1 1 17 {
    pop
    gsave
      [] 0 setdash
      boxW 0 rlineto
      0 boxH neg rlineto
      boxW neg 0 rlineto
      closepath stroke
    grestore
    boxW 0 rmoveto
  } for

  % Draw a brace, moving the current point to the right
  % by width many pts
  /drawBrace { % width height -> nil
    10 dict begin
    {/height /width} {exch def} forall
    gsave
      -2 height 2 div rmoveto
      [] 0 setdash
      height abs height rlineto
      width 4 add 2 height mul abs sub 0 rlineto
      height abs height neg rlineto
      stroke
    grestore
    width 0 rmoveto
    end
  } bind def

  boxW -17 mul 0 moveto
  /braceH -3 def
  3 boxW mul 0 rmoveto
  [ 1 4 1 13 13 ] {
    0 5 braceH mul rmoveto
    boxW exch mul braceH drawBrace
    /braceH braceH neg store
  } forall

  boxW -17 mul 0 moveto
  % Draw example characters in boxes
  2 -12 rmoveto % manually center characters in box
  /sampleString (MS12NAMEAXXXX     XXXXCE43R337JKVTZ) def
  0 1 sampleString length 1 sub {
    sampleString exch 1 getinterval gsave show grestore
    boxW 0 rmoveto
  } for

  boxW -17 mul -32 moveto
  % Draw headings above/below braces
  /Helvetica findfont 12 scalefont setfont
  3.5 boxW mul 0 rmoveto
  gsave
    gsave (recovery) centreshow grestore
    0 -12 rmoveto gsave (threshold) centreshow grestore
    0 -12 rmoveto gsave (\(k\)) centreshow grestore
  grestore

  2.5 boxW mul 40 rmoveto
  gsave
    gsave (ID) centreshow grestore
  grestore

  2.5 boxW mul -40 rmoveto
  gsave
    gsave (share) centreshow grestore
    0 -12 rmoveto gsave (index) centreshow grestore
  grestore

  6.5 boxW mul 40 rmoveto
  gsave (data \(26 chars for 128 bits\)) centreshow grestore

  13 boxW mul -40 rmoveto
  gsave (checksum \(13 chars\)) centreshow grestore

  end
} bind def

% Draws the bech32->binary conversion table. Assumes that position 0 0 is the top-center of the page
/drawBech32BinaryTable {
  10 dict begin
  /invTable exch def
  /Courier findfont 12 scalefont setfont

  /entryW 8 string stringwidth pop def
  /entryS 36 def

  0 0 moveto
  entryW -2 mul entryS -1.5 mul add 0 rmoveto % centering logic
  0 4 {
    gsave 8 {
      dup
      gsave
      invTable {
        32 5 { 2 idiv 2 copy and 0 eq {(0)} {(1)} ifelse show } repeat pop
        (: ) show code 1 index get 12 codexshow
      } {
        perm exch get
        code 1 index get 12 codexshow (: ) show
        32 5 { 2 idiv 2 copy and 0 eq {(0)} {(1)} ifelse show } repeat pop
      } ifelse
      pop
      grestore
      1 add
      0 -14 rmoveto
    } repeat grestore
    entryW entryS add 0 rmoveto
  } repeat pop

  end
} bind def

% Draws the symbol pronunciation table. Assumes that position 0 0 is the top-center of the page
/drawSymbolTable {
  10 dict begin

  /pronunciation <<
    /aleph       (Aleph)      /alpha    (Alpha)    /beta        (Beta)           /Gamma     (Gamma)
    /Delta       (Delta)      /epsilon  (Epsilon)  /eta         (Eta)            /Theta     (Theta)
    /Lambda      (Lambda)     /mu       (Mu)       /Xi          (Xi)             /Pi        (Pi)
    /rho         (Rho)        /Sigma    (Sigma)    /Phi         (Phi)            /Psi       (Psi)
    /Omega       (Omega)      /at       (At)       /numbersign  (Hash)           /percent   (Percent)
    /cent        (Cent)       /yen      (Yen)      /Euro        (Euro)           /currency  (Scarab)
    /circleplus  (Earth)      /dagger   (Dagger)   /daggerdbl   (Double-dagger)  /section   (Section)
    /paragraph   (Paragraph)  /diamond  (Diamond)  /heart       (Heart)
  >> def

  0 0 moveto
  4 string stringwidth pop 90 2 mul add neg 0 rmoveto % goofy centering logic
  gsave
  1 1 31 {
    dup dup
    code2 exch get 12 codexshow
    ( ) show
    gsave
      /Helvetica findfont 12 scalefont setfont
      code2 exch get pronunciation exch get show
    grestore
    90 0 rmoveto

    4 mod 0 eq {
      grestore 0 -20 rmoveto gsave
    } if
  } for
  grestore

  end
} bind def
