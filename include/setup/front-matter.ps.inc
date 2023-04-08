[(Shamir's Secret) (Sharing Codex)]
(revision alpha-4.6)
[
(MIT License)
()
(Copyright (c) 2020 Blockstream)
()
(Permission is hereby granted, free of charge, to any person obtaining a copy)
(of this software and associated documentation files (the "Software"), to deal)
(in the Software without restriction, including without limitation the rights)
(to use, copy, modify, merge, publish, distribute, sublicense, and/or sell)
(copies of the Software, and to permit persons to whom the Software is)
(furnished to do so, subject to the following conditions:)
()
(The above copyright notice and this permission notice shall be included in all)
(copies or substantial portions of the Software.)
()
(THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR)
(IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,)
(FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE)
(AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER)
(LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,)
(OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE)
(SOFTWARE.)
]
[
(WARNING: Seriously, this is a work in progress, and it is only a concept right now.)
(If you try to use this for your valuable data, I promise you will lose your data.)
(You will lose this document and come back here only to find that I have made incompatible changes,)
(and your data is lost forever. Even if you don't lose this document, there is no warranty or)
(guarantee of any kind that you will be able to recover successfully recover your data.)
]
%************************************************************************
%************************************************************************
%*
%* Section One: Preamble
%*
%************************************************************************
%************************************************************************

%******************
%* Front matter
%*
%* Define variables for the preceeding front matter text.
%*
/warning exch def
/MIT exch def
/ver exch def
/title exch def

/README [
(MATERIALS: Scissors, X-Acto knife, brass fasteners)
()
(CONSTRUCTION:)
(The bottom discs are the discs with a small circle in the center of them.)
(The top discs are the discs with a small cross in the centre. All the top discs are identical. Cut out each disc.)
(Cut out the small centre circle in each the bottom discs. Cut out each of the 32 squares of each top disc.)
(Cut a slit along one one of the small lines of the cross in each of the top discs.)
(Pass the brass fastener through a top disc and bottom disc.)
(Fold the legs of the fastener apart to secure the top and bottom discs together.)
(The two discs should now be able to rotate about their common centre.)
()
(SECRET RECOVERY:)
(Find 2 of your secured shares.)
(Make sure all your shares have the same identifier and a valid checksum (see checksum worksheet).)
(Dial the recover share disc to the share index of the first secured share (the 5th character).)
(Look up the symbol associated with the share index of the other share.)
(Set your translation disc to that symbol and translate the first secured share by looking up every charater in turn.)
(Dial the recover share disc to the share index of the second secured share (the 5th character).)
(Look up the symbol associated with the share index of the first share.)
(Set your translation disc to that symbol and translate the second secured share by looking up every charater in turn.)
(Add the two translated shares, character by character, using the Addition disc.)
(The result is your secret share and will have share index S and a valid checksum.)
] def
