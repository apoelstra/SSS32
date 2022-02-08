# High-Level Introduction

The SSSS Codex describes a way, using circular paper computers (volvelles),
to perform checksumming and Shamir Secret Sharing on their Bitcoin secrets.
It defines an error-correcting code, **codex32**, and a complete scheme for
checksumming, splitting and recovering secret data.

Hand-computation comes with some practical limits: to generate random values we
rely on series of (de-biased) dice rolls. We do not support passphrases or key
hardening, so our security rests solely on the strength of this randomness.
With that said, assuming you can generate strong randomness, you will find
**no cryptographic compromise** in the design or implementation of the Codex.

If you prefer the added security of passphrase-based key hardening, you should
instead use the more-popular
[SLIP39](https://github.com/satoshilabs/slips/blob/master/slip-0039.md),
which requires the use of electronic computers.

## Bitcoin and Seed Values

We assume that your secret is a 128-bit [BIP32 master seed](https://github.com/bitcoin/bips/blob/master/bip-0032.mediawiki).
Such seeds are used to derive an effectively unlimited number of addresses from
a single secret value, eliminating the need for frequent backups.

Many users interact with BIP32 master seeds indirectly, for example by storing a
set of 12 or 24 [BIP39](https://github.com/bitcoin/bips/blob/master/bip-0039.mediawiki)
seed words. These seed words represent a 132- or 264-bit secret, which is
converted in the BIP39 protocol to a pointlessly large master seed by means
of a needlessly complicated and irreversible process. If your coins are
stored using BIP39, we have provided a module to assist converting
the seed words to binary (and back) so they can be used in the Codex
in lieu of a master seed. The longer data greatly increases the tedium and
risk of mistakes, but the procedures are essentially unchanged.

Instead, we encourage you to switch from BIP39 to something else, such as Satoshi Labs'
[SLIP39](https://github.com/satoshilabs/slips/blob/master/slip-0039.md)
or the Codex, in which you directly work with the 128-bit BIP32 seed.

## Shamir's Secret Sharing Scheme

There is an inherent trade-off between the availability of a secret and its
risk of theft. If you make many copies of your seed words, one of them may
eventually fall into the wrong hands. But if you makes too few, they may all
become lost, destroyed or misplaced. The consequence in either case is
a total loss of funds.

A more precise way to make this trade-off is [Shamir's Secret Sharing Scheme](https://en.wikipedia.org/wiki/Shamir%27s_Secret_Sharing)
(SSSS), in which you split your secret into N "shares", any K of which can
be used to reconstruct the original secret. Here N is typically five
or more, depending on your desire for redundancy, while K is two or three,
reflecting your fear of individual shares being compromised.

Before continuing, we should mention some limitations of SSSS:
* First, electronic computers or not, SSSS requires that the complete secret be
reconstructed in a single place before it can be used. To avoid this, for
most use-cases we instead recommend [threshold signatures](https://en.bitcoin.it/wiki/OP_CHECKMULTISIG)
instead.
* SSSS requires the generation of extra random data beyond the original secret,
which [must be generated securely](https://bitcointalk.org/index.php?topic=2199659.0)
* If any share is corrupted, the reconstructed secret will be wrong and it is
impossible to determine which share (or how many shares) was responsible

We have addressed the latter issue by the clever use of error-correcting
codes, inspired by SLIP39, but the fact remains that SSSS involves a single
point of failure at the time that the secret key material is actually used.
We emphasize that SSSS is a mechanism for **storing backups** and not a
mechanism for **enforcing a signing policy**.

## Computers and Trust

It is infeasible to sign Bitcoin transactions without the aid of electronic
computers. To do this, these computers need access to secret key material,
which puts you in an uncomfortable position: key material, if misused or badly
generated, can be used to steal all of your coins. And there is no way to be
assured of how, exactly, an electronic computer is manipulating your keys.

General-purpose computers are so complex and exposed to adversarial input (in
the form of Internet connections, arbitrary programs, and human beings) that
standard advice is to never expose your key material to such machines. Instead,
you should provide your keys only to *hardware wallets*, which interact with
general-purpose computers only through a narrow interface that never exposes
secret key data in any form.

However, even hardware wallets are opaque and inscrutable:
* they may have bugs which cause key leakage, either now or as a consequence
of some future firmware update;
* they store key material in physical form which can be extracted by an
attacker with physical access, even if it the wallet has "deleted" it;
* they may expose data through *sidechannels*, such as the electromagnetic
waves emitted by processor activity, or by the varying power draw from a
USB hub;
* if tasked with generating random data, they may do so insecurely.

Furthermore, when working with secret shares, it is necessary to directly export
share data, violating the usual "never expose secret data" maxim. This introduces
more questions -- how can the hardware wallet be sure that it is communicating
only with the correct user, and under correct circumstances? It cannot.

These risks have varying degrees of plausibility, but the fact is that no matter
how trustworthy the hardware or its manufacturer, over the lifetime of a Bitcoin
secret (which may, perhaps, exceed any one human's lifetime), even "trivial"
risks add up to become very serious.

Unlike electronic computers, paper cannot remember or leak secrets, at least
when handled correctly, and this can be easily seen without special skills
or equipment. In this document, we have provided a paper-based means to
* Securely generate random data from potentially biased dice or coin flips
* Compute and verify very powerful checksums
* Split your secret into up to 31 "shares", of which some number are needed to
reconstruct the secret
* Recombine your secret, perhaps to redo the splitting if some old shares are
compromised

In this way, coins which do not need to be frequently spent may have their
secure storage refreshed or reorganized an unlimited number of times, without
ever introducing the uncertainty and risk associated with electronic computers.

## Checksumming and Error Correction

When you copy or transfer keys, or especially when you are doing hand-computations
on them, it is possible that errors may arise. Errors might also crop up during
long-term storage, for example if Cryptosteel tiles are subjected to extreme heat
which makes some letters unclear, or if printer paper suffers water damage.

Both BIP39 and SLIP39, in addition to encoding the raw cryptographic data, also
store a *checksum*, which is a small amount of extra redundant data used to
detect such errors. BIP39's checksum is less than one word long, may fail to
detect even a single incorrect word, and is practically impossible to compute
by hand. Its primary effects are to cause your key data to be a non-standard
length, and to prevent you from verifying your data's integrity by hand.

SLIP39, by contrast, can detect up to 3 errors and correct up to one error 100%
of the time, and will fail to detect other random errors with probability roughly
one in a billion. However, the SLIP39 checksum is also quite difficult to compute
or verify by hand.

In the Codex, we introduce a new checksum, **codex32** (FIXME link to BIP),
which can detect up to 8 errors, correct up to 4, and has probability less than
one in a million million million of failing to detect other random errors.
Further, codex32 checksums can be computed and verified entirely by hand,

## Bech32 and the Alphabet

In order to store 128-bit secrets, we re-use the
[Bech32 alphabet](https://github.com/bitcoin/bips/blob/master/bip-0173.mediawiki)
which provides 32 5-bit characters. These characters consist of the 26 letters
of the Latin alphabet and 10 Arabic numerals, except `B` (which looks like 8),
`O` (which looks like 0), and `I` and `1` (which look like each other).

We also use an alternate alphabet, consisting mostly of Greek letters, which
is used for intermediate computations. It is never used for storage, and
nothing represented in this alphabet is ever secret data. We have provided
a table of pronunciation to help with its use.

The remainder of this document provides detailed, but mechanical, instructions.
If you are interested in learning the mathematical theory behind this all, we
encourage you to check out the
[mathematical companion](https://github.com/apoelstra/SSS32/blob/2021-12--math-intro/volvelles/main.tex),
or to contact Andrew `volvelles@wpsoftware.net' or Russel `bob@aol.com`. (FIXME
does russell want contact info?)

Godspeed.

