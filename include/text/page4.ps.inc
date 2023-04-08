[
/startText
(In the Codex32 book, we introduce the *codex32* checksum, which can detect up)
(to eight character errors and correct up to four. codex32 has an even)
(higher probability than SLIP39 of successfully detecting random)
(errors. And most importantly, codex32 checksums can be computed)
(and verified entirely by hand.)

/subsection (I.5. Seeds and Seed Words) /endsubsection
/dropcap (B) (IP32 is a protocol for deriving an effectively unlimited)
(number of addresses from a single *master* *seed*, which may be between)
(128 and 512 bits long. Many users interact with BIP32 master seeds)
(indirectly, (e.g., by storing a set of 12 or 24 BIP39 seed words).)
(Unfortunately, these seed words correspond to a 512-bit secret, while)
(codex32 works best with 128-bit secrets. It is recommended that users)
(of codex32 generate a fresh 128-bit seed, using the)
(instructions in this book, and sweep their coins to addresses derived)
(from the new seed.)
/paragraph
(We note that Bitcoin's EC signatures have only 128)
(bits of security, so as long as your secret is randomly generated and)
(securely stored, additional bit-length serves no purpose except to)
(complicate things.)

/subsection (I.6. Bech32 and Alternative Alphabets) /endsubsection
/dropcap (C) (odex32 inherits its name from the Bech32 alphabet.)
(In order to store 128-bit secrets, we re-use the Bech32 alphabet,)
(which consists of 9 of the 10 Arabic numerals and 23 of the 26 letters)
(of the Latin alphabet. The excluded letters are B, which may be)
(confused with 8; O, which may be confused with 0; and I and 1,)
(which may be confused with many things, such as each other.)

/paragraph
()
(Parts of the codex32 process use an alternate alphabet, consisting)
(mostly of Greek letters. This alphabet is used for intermediate)
(computations, but never for data storage, and nothing represented in it)
(is ever secret data. A table of pronunciation is provided on the)
(Reference page at the beginning of this document.)

/paragraph
(The remainder of this document provides detailed mechanical)
(instructions. If you are interested in learning the mathematical)
(theory behind this all, users are encouraged to check out the)
(mathematical companion or contact Pearlwort at)
(`pearlwort@secretcodex32.com`.)
] drawPageContent
