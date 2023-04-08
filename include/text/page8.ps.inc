[
/subsection (III.1 Generate a New Secret) /endsubsection
(We generate new secrets indirectly by generating our $n$ shares, which will imply)
(the final secret. The process for generating a new secret seed is as follows:)

/startlist
/listitem1 (Choose a threshold $k$ and total number of shares)
  ($n$ that suits your needs. The threshold $k$ should be two or three,)
  (and $n$ must be 31 or less. For $k > 3$ see Module 2, but this)
  (is not recommended.) /endlistitem
/listitem1 (Choose a four-character identifier for your new secret)
  (seed. The identifier can be anything (e.g., a name or nym), as)
  (long as it only uses the Bech32 character set. The identifier)
  (itself is not secret. However, the identifier should be unique)
  (for each secret seed.) /endlistitem
/listitem1 (Follow Section III.1.A to generate the first $k$)
  (shares.) /endlistitem
/listitem1 (Follow Section III.1.B to generate the remaining)
  (\($n - k$\).) /endlistitem
/listitem1
  (Copy and distribute your $n$ shares into safe and secure)
  (locations. Additionally, remember that you will need to recover at least)
  ($k$ of these shares to recover your secret seed. Also remember)
  (that anyone else who recovers $k$ of these shares can also)
  (recover your secret seed and control your coins.) /endlistitem
/listitem1
  (Securely dispose of all worksheets that you used in the)
  (generation procedure. If these worksheets are not securely)
  (disposed of, they could be used to recover your secret seed.) /endlistitem
/listitem1 ((Optional) Load your shares into your codex32-compliant wallet)
  (or use the Recover Secret procedure in Section III.2)
  (to compute addresses or access your coins.) /endlistitem

/subsubsection (III.1.A Create First Share) /endsubsubsection
  (You will need: 2$k$ copies of the checksum worksheet and)
  (the dice de-biasing worksheet.)
/startlist
/listitem1 (Fill out the header portion of the $k$ checksum worksheets)
  (with your chosen threshold $k$ and chosen identifier.) /endlistitem
/listitem1 (Place a unique share index on each worksheet starting with)
  (share `A` on the first worksheet, `C` on the second worksheet, and so)
  (on through $k$ characters from the Bech32 characters. Recall)
  (that the `B` and `I` are not valid characters.) /endlistitem
/listitem1 (Using the dice de-biasing worksheet, generate 26 random)
  (characters and write them in the *bold squares* of the checksum)
  (worksheet.) /endlistitem
/listitem1 (Once all of the random data is generated, use the rest of the)
  (checksum worksheet to generate a checksum for each share.) /endlistitem
/listitem1 (*Critical Step*: Verify your checksum by copying each of the 48)
  (characters of the share into a fresh checksum worksheet.)
  (Follow the checksum verification instructions to verify)
  (each checksum. If any checksum fails to verify, make more copies)
  (of the checksum worksheet and redo the checksum generation and)
  (checksum verification steps. Failure to verify each checksum may)
  (lead to irrecoverable loss of the secret seed and funds.) /endlistitem
/paragraph
  ($Special rules for k = 1$. If you are not splitting your)
  (secret, use a 0 digit in the threshold place, and use the `S`)
  (character in the share index place. Follow the same instructions)
  (for generating the data portion and the checksum.)
/paragraph
  ($Special rules for pre-existing secrets$. If you have a pre-existing seed,)
  (include this as an initial share, using `S` for its share index. When)
  (deriving additional shares, use the alternate table in Module 2 rather)
  (than the table in the following section. This process is not recommended,)
  (but may be useful in some scenarios such as re-sharing an existing secret.)
] drawPageContent
