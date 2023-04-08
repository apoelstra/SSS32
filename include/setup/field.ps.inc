%******************
%* Field Arthmetic
%*
%* Calculations within GF(32), extended with the "null element", represented by
%* numberic 32, which is displayed as a blank, and on which every operation
%* returns null again. Used to represent incomplete/unknown data.
%*
%* Our generator for GF(32) has minimum polynomial x^5 + x^3 + 1.
%*
/gf32add % x y -> x [+] y where [+] is addition in GF32.
         % returns 32 if x or y is out of range.
         % Note that x [+] y = x [-] y in GF32.
{               % x y
 2 copy 32 ge   % x y x (y >= 32)
 exch 32 ge or  % x y (y >= 32 || x >= 32)
 {pop pop 32}     % 32
 {xor}            % x [+] y
 ifelse         % if (y >= 32 || x >= 32) then 32 else (x [+] y)
} bind def

/gf32mulalpha % x -> x [*] alpha where [*] is multiplicaiton in GF32 and alpha is represted by 0b00010.
{               % x
 2 mul          % 2*x
 dup 32 ge      % 2*x (2*x >= 0b100000)
 { 41 xor }       % 2*x `xor` 0b101001
 if             % if (2*x >= 0xb100000) then 2*x `xor` 0x0b101001 else 2*x
} bind def

/gf32mul % x y -> x [*] y where [*] is multiplication in GF32.
         % returns 32 if x or y is out of range.
{                % x y
 10 dict begin
 { /y /x } {exch def} forall
 x 32 ge y 32 ge or  % (y >= 32 || x >= 32)
 {32}                  % 32
 {
   /xShift x def
   /yAlpha y def
   0                   % 0
   5 {                                % ((x & 0b001..1) [*] y) (x >> i) (y [*] alpha[^i])
     xShift 1 and yAlpha mul xor      % ((x & 0b001..1) [*] y [+] ((x >> i) & 1) * (y [*] alpha [^i]))
     /xShift xShift -1 bitshift def
     /yAlpha yAlpha gf32mulalpha def
   } repeat            % ((x & 0b11111) [*] y)
 } ifelse            % if (y >= 32 || x >= 32) then 32 else (x [*] y)
 end
} bind def

/gf32inv % x -> x [^-1] where [^-1] is the inverse operation in GF32.
         % returns 0 when given 0.
         % returns 32 if x is out of range.
{                        % x
 dup dup gf32mul         % x x[^2]
 dup gf32mul gf32mul     % x[^5]
 dup dup gf32mul gf32mul % x[^15]
 dup gf32mul             % x[^30]
                         % x[^-1]
} bind def

/lagrange % x xj [x[0] .. x[k]] -> l[j](x)
          % returns the lagrange basis polynomial l[j] evaluated at x for interpolation of coordinates [x[0] .. x[k]].
          % Requires xj `elem` [x[0] ... x[k]]
{               % x xj [x[0] .. x[k]]
 10 dict begin
 { /xs /xj /x } {exch def} forall
 1 xs           % 1 [x[0] .. x[k]]
 {                % let P = product [(x [-] x[m]) [/] (xj [-] x[m]) | m <- [0..i-1], x[m] /= xj]
                  % P x[i]
   /xi exch def   % P
   xi xj gf32add  % P (xj [-] x[i])
   dup 0 eq       % P (xj [-] x[i]) (xj [-] x[i] == 0)
   { pop }                 % P
   { gf32inv gf32mul       % (P [/] (xj [-] x[i])
     xi x gf32add gf32mul  % (P [*] (x [-] x[i]) [/] (xj [-] x[i]))
   }
   ifelse         % (if xj == x[i] then P else (P [*] (x [-] x[i]) [/] (xj [-] x[i]))
 } forall       % x xj (product [(x [-] x[m]) [/] (xj [-] x[m]) | m <- [0..k], x[m] /= xj])
 end
} bind def

/makeShare % sS sA i -> si
       { 3 2 roll 1 index permS 0 get permS 0 2 getinterval lagrange gf32mul
         3 1 roll permS 1 get permS 0 2 getinterval lagrange gf32mul
         xor
       } bind def

/gf32mularray % x b -> x * b
  { [ 3 1 roll { 1 index gf32mul exch } forall pop ]
  } bind def

/gf32addarray % a b -> a + b pointwise
  { [ 3 1 roll 0 1 2 index length 1 sub { 2 index 1 index get 2 index 2 index get gf32add exch pop 3 1 roll } for pop pop ]
  } bind def
