[
/subsubsection (III.1.B Create Derived Shares) /endsubsubsection
(You will need: \($n - k$\) checksum worksheets, and the translation worksheet for your value of $k$.)

/paragraph
  (The remaining \($n - k$\) shares are derived from the first $k$ shares,)
  (using the translation worksheet. For each derived share, use the following)
  (process to derive it:)
/startlist
/listitem1 (Make a copy of the translation worksheet for the value)
  (of $k$ that you are using and label the shares with the share)
  (indices from the shares that you have already generated)
  (\(e.g., A, C, and D, if $k = 3$\).) /endlistitem
/listitem1 (Label the final share index with the new share index that you)
  (want to derive. This can be any bech32 character, but most likely you)
  (will just want to use the next available character.) /endlistitem
/listitem1 (In the derivation table (below) for your value of $k$, find the)
  (column corresponding to the new share index. Copy the symbols from that)
  (that column into the translation worksheet, next to the share index for)
  (each row. There is an illustration on Page 18 if this is unclear.) /endlistitem
9 { /linebreak } repeat %% derivation table
/listitem1 (Follow the translation worksheet instructions to derive)
  (the new share.) /endlistitem

/paragraph
(Derivation tables for $k$ from four up to eight can be found in)
(Module 2. However, we discourage the use of large $k$ values, which)
(are difficult to use and increase the chance of key loss.)

  /subsection (III.2 Recover a Secret) /endsubsection
(You will need: $k$ checksum worksheets, and the translation worksheet for your value of $k$.)
/paragraph
(Normally, you would not recover a secret seed yourself. Instead,)
(you would load shares into a codex32-compliant wallet. However,)
(you can recover the secret seed by hand if no compatible wallets)
(are available or you feel a need to demonstrate your conjuring)
(ability. The recovery procedure uses exactly $k$ shares. If you)
(have more than $k$ shares, you can select any $k$ of them and)
(set the other shares aside.)
/paragraph
(Use the following procedure to recover the share:)
/startlist
/listitem1
  (For each share, fill in a checksum worksheet and verify the)
  (checksum. If a checksum fails to verify, you may have made an)
  (error on your worksheet, or there may be an error in your)
  (shared data. If there is an error in your share data, you can)
  (try substituting the share with a different one. Otherwise,)
  (you will need to perform the error correction procedure on)
  (your share, which will involve the assistance of an electronic)
  (computer.) /endlistitem
/listitem1
  (Label the translation worksheet as though you were deriving a new)
  (share. Use your existing shares' indices)
  (as the "initial shares" and `S` as the "new share" index.) /endlistitem
/listitem1
  (Rather than using a derivation table, fill in the symbols for each share)
  (on the translation worksheet using one of the following procedures:)
  /endlistitem
] drawPageContent
