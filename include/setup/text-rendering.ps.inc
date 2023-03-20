%****************************************************************
%* Text Content Rendering
%*
%* The bulk of the exposition in the booklet is rendered using this streaming parser.
%****************************************************************

/nullFont <<
  /face /Times-Roman
  /size 12
  /yDisp 0
  /rgbColor [ 0 0 0 ]
>> def

/textFont <<
  /face /Times-Roman
  /boldface /Times-Bold
  /italicface /Times-Italic
  /ttface /Courier
  /size 12
  /footnotesize 10
  /yDisp 13
  /rgbColor [ 0 0 0 ]
>> def

/sectionFont <<
  /face /Times-Roman
  /italicface /Times-Italic
  /size 32
  /yDisp 32
  /rgbColor [ 0.820 0.204 0.220 ]
>> def

/subSectionFont <<
  /face /Times-Roman
  /italicface /Times-Italic
  /size 24
  /yDisp 20
  /rgbColor [ 0.820 0.204 0.220 ]
>> def

/subSubSectionFont <<
  /face /Times-Roman
  /size 18
  /yDisp 20
  /rgbColor [ 0.820 0.204 0.220 ]
>> def

% Shows a dropcap (giant letter with a bounding box around it)
%
% Takes coordinates to start drawing at, and the character to draw
% the bounding box in. Returns the height and width of the bounding
% box
/drawDropcap { % x y strdata -> h w
  10 dict begin
  gsave
    /Times-Roman findfont 64 scalefont setfont
    3 copy pop moveto

    gsave
      dup false charpath strokepath flattenpath pathbbox
      { /y2 /x2 /y1 /x1 } {exch def} forall
      % Flip box so it is going downward rather than upward
      /y2 y1 2 mul y2 sub store
    grestore

    % Draw letter
    0 y2 y1 sub rmoveto
    gsave
      dup true charpath
      x1 y2 moveto x1 y1 lineto x2 y1 lineto x2 y2 lineto closepath
      0.820 0.204 0.220 setrgbcolor
      % TODO Replace with a pattern fill.
      fill
    grestore
    dup false charpath
    x1 y2 moveto x1 y1 lineto x2 y1 lineto x2 y2 lineto closepath
    1 setlinewidth
    stroke

    % Return width and height
    pop pop
    x2 x1 sub
    y1 y2 sub
  grestore
  end
} bind def

/showWordControlDict <<
  ($) {
    italicOn {
      currentFont /face get findfont currentFont /size get scalefont setfont
    } {
      currentFont /italicface get findfont currentFont /size get scalefont setfont
    } ifelse
    /italicOn italicOn not store
  }
  (*) {
    boldOn {
      currentFont /face get findfont currentFont /size get scalefont setfont
    } {
      currentFont /boldface get findfont currentFont /size get scalefont setfont
    } ifelse
    /boldOn boldOn not store
  }
  (`) {
    ttOn {
      currentFont /face get findfont currentFont /size get scalefont setfont
    } {
      currentFont /ttface get findfont currentFont /size get scalefont setfont
    } ifelse
    /ttOn ttOn not store
  }
>> def

% Displays a single word on the current device with the current font
% Returns the number of points before the end of the line, which will be
% negative in case of an overrun
/showWord { % word kernX -> distance to marginX2
  10 dict begin
  {/actuallyDraw /kernX /word} { exch def } forall

  <<
    /nametype {
      currentpoint {/y /x} { exch def } forall

      <<
        /footnotemark {
          /footnoteCount footnoteCount 1 add store
          % We need to idiv the footnote count by two since we double-increment
          % it accidentally (once when simulating and once when actually drawing)
          footnoteCount 2 idiv 2 string cvs
          gsave
            currentFont /face get findfont 6 scalefont setfont
            0 5 rmoveto
            actuallyDraw {
              show
            } {
              stringwidth pop 0 rmoveto
            } ifelse
          grestore
          % Adjust kerning because /footnotemark is a word
          kernX 0 rmoveto
          % Add an actual space though so the footnote isn't too crammed
          actuallyDraw { ( ) show } { ( ) stringwidth pop 0 rmoveto } ifelse
        }
      >> dup
      word known { word get exec } { pop } ifelse
      1 % arbitrary positive return value
    }
    /stringtype {
      word length 0 gt {
        % Prepend kerning (we expect the caller to set 0 kerning on the first word)
        kernX 0 rmoveto
        % Draw the actual word
        0 1 word length 1 sub {
          word exch 1 getinterval
          showWordControlDict 1 index known {
            showWordControlDict exch get exec
          } {
            actuallyDraw {
              show
            } {
              stringwidth rmoveto
            } ifelse
          } ifelse
        } for
        marginX2 currentpoint pop sub % compute return value prior to trailing space
        ( ) show % print a space so that copy/paste has a hope of working
      } { 0 } ifelse
    }
  >> begin word type exec end

  end
} bind def

% Takes as input a single page's contents and draws it
/drawPageContent { % [page content] -> nothing
  20 dict begin
  /pagecontent exch def

  marginX1 marginY1 moveto

  % state machine
  /buffer 200 string def
  <<
    % state
    /state /buffering
    /currentFont nullFont
    /x marginX1
    /y marginY1
    /dropcapWidth 0
    /dropcapHeight 0
    /wordBuffer 100 array
    /wordN 0
    /totalKern 0
    /footnoteCount 0
    /listItemCount 0
    /sublistItemCount 0
    /ttOn false
    /boldOn false
    /italicOn false

    /offsetX {
      x add /x exch store
      x y moveto
    }

    /offsetY {
      y dropcapHeight lt not % if we currently aren't past the dropcap...
      exch y add /y exch store
      y dropcapHeight lt and { % ...but after moving, we are...
        dropcapWidth neg offsetX % ...then shift x back to its original value
      } if
      x y moveto
    }

    /setCurrentFont {
      /currentFont exch store
      currentFont /face get findfont
      currentFont /size get scalefont
      setfont
      currentFont /rgbColor get aload pop setrgbcolor
    }

    % Output text, buffering mode (needed for fill justification)
    /buffering {
      /word exch def

      % Simulate writing the word, to see if it causes an overrun. If so...
      word 0 false showWord dup 0 lt {
        % ...dump the previous line, with kerning
        totalKern wordN 1 gt { wordN 1 sub div } if dumpLastLine
        currentFont /yDisp get neg offsetY
        % ...then retry the word
        pop word buffering exec
      } {
        % ...otherwise, add word to buffer for next line's display
        /totalKern exch store
        wordBuffer wordN word put
        /wordN wordN 1 add store
      } ifelse
    }

    % Draw the contents of the current line buffer and flush it
    /dumpLastLine {
      x y moveto
      wordN 0 gt {
        wordBuffer 0 get 0 true showWord pop
        wordBuffer 1 wordN 1 sub getinterval {
          1 index true showWord pop
        } forall
      } if
      pop
      /wordN 0 store
    }

    /doLineBreak {
      0 dumpLastLine
      currentFont /yDisp get neg offsetY
    }

    % Output a dropcap
    /dropcapOneshot {
      % show dropcap, bumped up a bit
      x exch y 8 add exch drawDropcap
      % Store dropcap width and height of the bottom of the dropcap
      /dropcapHeight exch y sub neg store
      /dropcapWidth exch 4 add store
      % Move x and switch back to normal text mode
      dropcapWidth offsetX
      /state /buffering store
    }

    % content parsing
    /stringtype {
      { % loop through words in the string
        ( ) search {
          exch pop
          state load exec % Execute current state on word
        } {
          state load exec % Execute current state on last word
          exit
        } ifelse
      } loop
    }
    /nametype {
      <<
        /notoc {} % just eat table-of-contents token
        /toc {} % just eat table-of-contents token
        /dropcap { /state /dropcapOneshot store }
        /linebreak { doLineBreak }
        /paragraph { doLineBreak doLineBreak }
        /startlist { /listItemCount 0 store }
        /startsublist { /sublistItemCount 0 store }
        /listitem* {
          doLineBreak
          /y y 4 sub store
          /x x 24 add store
          x y moveto
          /bullet glyphwidth 8 add neg 0 rmoveto
          /bullet glyphshow
          x y moveto
        }
        /listitem1 {
          doLineBreak
          /listItemCount listItemCount 1 add store
          /y y 4 sub store
          /x x 24 add store
          x y moveto
          -5 0 rmoveto
          listItemCount 2 string cvs
          dup stringwidth pop neg 0 rmoveto show
          (.) show
          x y moveto
        }
        /sublistitem1 {
          doLineBreak
          /sublistItemCount sublistItemCount 1 add store
          /y y 4 sub store
          /x x 36 add store
          x y moveto
          -5 0 rmoveto
          sublistItemCount 2 string cvs
          dup stringwidth pop neg 0 rmoveto show
          (.) show
          x y moveto
        }
        /endsublistitem {
          0 dumpLastLine
          /x x 36 sub store
          x y moveto
        }
        /endlistitem {
          0 dumpLastLine
          /x x 24 sub store
          x y moveto
        }
        /startText {
          textFont setCurrentFont
        }
        /section {
          doLineBreak doLineBreak
          sectionFont setCurrentFont
          doLineBreak
        }
        /endsection {
          0 dumpLastLine
          % Draw underline
          currentpoint
          x y 4 sub moveto
          pop y 4 sub lineto 2 setlinewidth stroke

          doLineBreak
          textFont setCurrentFont
          /state /buffering store
        }
        /subsection {
          doLineBreak doLineBreak
          subSectionFont setCurrentFont
          doLineBreak
        }
        /endsubsection {
          0 dumpLastLine
          % Draw underline
          currentpoint
          x y 4 sub moveto
          pop y 4 sub lineto 1.5 setlinewidth stroke

          doLineBreak
          textFont setCurrentFont
          /state /buffering store
        }
        /subsubsection {
          doLineBreak doLineBreak
          subSubSectionFont setCurrentFont
          doLineBreak
        }
        /endsubsubsection {
          0 dumpLastLine
          % Draw underline
          currentpoint
          x y 4 sub moveto
          pop y 4 sub lineto 0.75 setlinewidth stroke

          doLineBreak
          textFont setCurrentFont
          /state /buffering store
        }
        /footnotes {
          0 dumpLastLine

          /footnoteCount 0 store
          /y y 12 sub store
          x y moveto x 100 add y lineto 0.5 setlinewidth stroke
          /y y 12 sub store
          x y moveto
          currentFont /face get findfont currentFont /footnotesize get scalefont setfont
        }
      >> exch 2 copy
      known {
        get exec
      } {
        % just pass unknown symbols to buffering so that they will wind up
        % in the line buffer, and take effect both during the simulated
        % (spacing-computing) layout and the real layout
        buffering pop
      } ifelse
    }
  >> begin
    pagecontent { dup type exec } forall
    0 dumpLastLine
  end

  end
} bind def

