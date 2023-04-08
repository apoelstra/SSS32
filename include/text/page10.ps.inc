[
/subsubsection (III.2.A Recovery by Table Lookup) /endsubsubsection
(If your volvelles are missing or otherwise inconvenient to access, you)
(can do the entire process using the Principal Tables located at the front)
(of this booklet.)

/paragraph
($k = 2$. For each share, find that share's *column* in the recovery table)
(and find the symbol on the *row* of the other share. Copy this symbol into)
(the translation worksheet.)
/paragraph
($k > 2$. For each share, find that share's *column* in the recovery table)
(and find all of the symbols in the *rows* of the other shares. Fuse these)
(symbols together pairwise using the fusion table until you have)
(only one left. Copy this into the translation worksheet.)
/paragraph
(Notice that the fusion table is symmetric, so it does not matter)
(if you swap rows and columns. The recovery table is *not* symmetric, so)
(you must use this table in the correct order.)
/paragraph
(Once you have copied everything into the translation worksheet, follow the)
(Translation Worksheet Instructions page as though you were deriving a new share.)
(Rather than using the addition wheel, you can use the addition table.)
(The result should be a share with index `S`, which is your recovered secret.)

/subsubsection (III.2.B Recovery by Volvelle) /endsubsubsection
(Using the volvelles is easier and less error-prone than using the tables.)
(If you have your volvelles, the recovery process is as follows.)
/paragraph
($k = 2$. For each share, turn the recovery wheel to *that* *share's* *index*.)
(Look up the symbol pointed to by the *other* *share's* *index* and copy that)
(into the translation worksheet.)
/paragraph
($k > 2$. For each share, turn the recovery wheel to *that* *share's* *index*.)
(Look up the symbols pointed to by the other shares' indices. Fuse these)
(symbols together using the fusion wheel:)
/startlist
/listitem1 (Turn the wheel so that it is pointing to the first symbol.) /endlistitem
/listitem1 (Find the next symbol on the inner part of the wheel. This symbol)
(will point to a new symbol. Turn the wheel so that it points to the new symbol.)
/endlistitem
/listitem1 (Repeat the above step for all the remaining symbols to fuse.)
(\(If $k = 3$, then no repetition is needed.\) The resulting symbol is your)
(result. Copy this into the translation worksheet.) /endlistitem

/paragraph
(Once you have copied everything into the translation worksheet, follow the)
(Translation Worksheet Instructions page as though you were deriving a new share.)
(The result should be a share with index `S`, which is your recovered secret.)
] drawPageContent
