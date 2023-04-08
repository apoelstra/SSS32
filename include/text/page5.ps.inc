[
/section (Part II: codex32 Components) /endsection
/subsection (II.1. Share Data) /endsubsection
/dropcap (F) (or a 128-bit secret seed, each share is 48 characters)
(long. Shares begin with the three-character prefix MS1. This is)
(followed by a six-character *header*. The next 26 characters are the)
(data portion. The final 13 characters are the checksum.)

8 { /linebreak } repeat

/paragraph
(The header consists of:)

/startlist
/listitem*
  (The *threshold*, which is the value $k$, a digit between two and)
  (nine inclusive, although the main document only supports $k$)
  (values two and three. When secret splitting is not used, a zero)
  (digit is placed here instead.)/endlistitem
/listitem*
  (The *identifier*, which is four bech32 characters.)/endlistitem
/listitem*
  (The *share index*, which is any bech32 character except for $S$.)
  (The $S$ index is the *secret index*. The data portion of the)
  (secret index contains the secret seed.)/endlistitem

  /paragraph
  (Shares of one secret all have the same threshold and)
  (identifiers. If you have multiple secrets, you should use)
  (distinct identifiers for each to avoid mixing up shares of)
  (different secrets with each other. The identifiers are not)
  (considered secret themselves.)

  /paragraph
  (If the user merely wants to checksum their secret and not use)
  (secret splitting, they should use the same format, but with the)
  (digit 0 for the threshold value and S for the share index.)

  /subsection (II.2. Paper Computers & Volvelles) /endsubsection
  /dropcap (H) (and computation for the procedures in this document)
  (can be performed either by using the volvelle wheels or principal)
  (tables (at the front of this document) to look up values. Although the)
  (volvelle wheels take time to cut out and assemble, they are)
  (generally easier to use than the tables, when available.)
] drawPageContent

centerX marginY1 200 sub translate drawDataFormat
