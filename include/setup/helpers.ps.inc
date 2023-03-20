%****************************************************************
%* Helpers and Utilities
%****************************************************************

% determinant : matrix -- det(matrix)
/determinant {
 1 0 2 index dtransform
 0 1 5 4 roll dtransform
 3 1 roll mul
 3 1 roll mul
 exch sub
} bind def

% tan : angle -- tan(angle)
/tan {
  dup sin exch cos div
} bind def

% arcsin: y h -- arcsin(y/h)
/arcsin {
   dup mul 1 index dup mul sub sqrt
   atan
} bind def

% arccos: x h -- arccos(x/h)
/arccos {
   dup mul 1 index dup mul sub sqrt
   exch atan
} bind def

% Given a rod of length 2r, what angle does it fit inside a w by h sized box so that
% the ends of the rod are equaldistant from the two sides making a corner with the box.
/angleinbox {
10 dict begin
  { /r /h /w } {exch def} forall
  h w sub
  2 2 sqrt r mul mul
  arcsin 45 sub
end
} bind def

% Constructs a coordinate transformation used for the illustration of folding volvelles.
/foldprojection {
10 dict begin
  /foldangle exch def
  /squish 0.25 def
  /squash 1 squish dup mul sub sqrt def % sqrt (1 - squish^2)
  /rollangle squish neg 1 atan def
  [rollangle cos squish mul
   rollangle sin
   dup neg squish mul foldangle cos mul foldangle sin squash mul add
   rollangle cos foldangle cos mul
   0 0 ]
end

} bind def
/concatstrings % (a) (b) -> (ab)
   { exch dup length
     2 index length add string
     dup dup 4 2 roll copy length
     4 -1 roll putinterval
   } bind def

