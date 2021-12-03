# High-Level Introduction

The SSS32 package describes a way for users, assisted by paper computers in the
form of slide charts (volvelles) and circular slide rules, to perform checksumming
and Shamir Secret Sharing on their Bitcoin secrets.

With this said, we made **no cryptographic compromises** (except that we lack the
ability to support passphrases or key hardening, instead relying on dice rolls
to have sufficient entropy) for the sake of enabling hand-computation. This would
be a perfectly secure and reasonable scheme to use for secret storage even for
users who are willing and able to use electronic computers. Although such users
may prefer to use the more-popular
[SLIP39](https://github.com/satoshilabs/slips/blob/master/slip-0039.md) scheme,
which also supports passphrases, and allows users to split their secret into
more than 31 shares.

## Bitcoin and Seed Values

The most common way that Bitcoin wallets derive addresses is using a scheme
developed in 2012 by Pieter Wuille called
[BIP32 Hierarchical Derivation](https://github.com/bitcoin/bips/blob/master/bip-0032.mediawiki),
known more commonly as "HD Keys". Under this scheme, a single uniformly random
"master seed", which is typically 128 or 256 bits in length, can be used to
derive an effectively unlimited number of Bitcoin addresses, largely eliminating
the need for frequent backups.

Most users interact with BIP32 master seeds indirectly, for example by storing a
set of 12 or 24 [BIP39](https://github.com/bitcoin/bips/blob/master/bip-0039.mediawiki)
or [SLIP39](https://github.com/satoshilabs/slips/blob/master/slip-0039.md) seed words.
These seed words are transformed, using a password-protected hardening function and/or
a hash, into a BIP32 master seed, which is then used by the wallet to derive elliptic
curve keys for addresses.

It is possible to convert from a set of seed words to a master seed, though in the
case of BIP39 the reverse conversion is not possible. For this reason, while this
package is primarily focused on storing 128-bit master seeds, we also provide a
module for storing (and restoring) BIP39 seed words.

## Shamir Secret Sharing

There is an inherent trade-off between the availability of a secret and its
risk of theft. If a user makes many copies of her seed words, one of them may
eventually fall into the wrong hands. But if she makes too few, then they all
may become lost, destroyed or misplaced. The consequence in either case is
a total loss of funds.

One way to achieve higher redundancy with less risk is *secret sharing*, in
which the key is spread across N *shares*, and any K of these shares are
sufficient to reconstruct the original key. For example, if K = 2 and N = 3,
the user might store her key across three secure locations, and if one of
those becomes unavailable, the remaining two are sufficient to get the key.
On the other hand, if one of the locations is accessed by an attacker, the
key remains safe.

There is a simple way to do 2-of-3 secret sharing with a 24 seed words:
store the first 16 in one location, the last 16 in another, and the first
and last 8 in yet a third. Then each individual location is missing eight
words (and eight words, representing at least 80 bits of information,
very probably cannot be guessed). However, this scheme is on the edge of
what can reasonably be considered secure, and is very fragile to partial
leakage. (If an attacker gains the first 16 words, and later learns four
of the remaining ones, the last four will not be too hard to guess.) It
also requires the user to use a 24-word seed phrase, even though 12 would
otherwise be sufficiently secure, and it does not generalize beyond 2-of-3.

There is a more sophisticated way of splitting up secrets, due to cryptographer
[Adi Shamir](https://en.wikipedia.org/wiki/Adi_Shamir) based on the work of
mathematician [Joseph-Louis Lagrange](https://en.wikipedia.org/wiki/Joseph-Louis_Lagrange),
known as [Shamir's Secret Sharing](https://en.wikipedia.org/wiki/Shamir%27s_Secret_Sharing)
or SSS.

SSS can be used to split a secret, of arbitrary length, into an arbitrary
number of shares, such that the secret can be constructed by a certain number
(the *threshold*) of them. The threshold is determined at the time that the
shares are created. There are a number of limitations to SSS which have
plagued past implementations of the scheme:
* First, no matter how it is implemented, SSS requires that the original
secret be reconstructed on a single piece of hardware before it can be
used. Therefore, if at all possible, it is better to use
[threshold signatures](https://en.bitcoin.it/wiki/OP_CHECKMULTISIG) instead.
* SSS requires the generation of extra random data beyond the original secret,
which [must be generated securely](https://bitcointalk.org/index.php?topic=2199659.0)
* If any share is corrupted, the reconstructed secret will be wrong and it is
impossible to determine which share (or how many shares) was responsible

The latter issues have been addressed, by the clever use of error-correcting
codes, in Satoshi Labs' [SLIP39](https://github.com/satoshilabs/slips/blob/master/slip-0039.md)
protocol, but the fact remains that SSS involves a single point of failure
at the time that the secret key material is actually used. We emphasize that
SSS is a mechanism for **storing backups** and not a mechanism for **enforcing
a signing policy**.

Having said that, SLIP39 has one big limitation: that it requires the use of
electronic computing hardware (e.g. a Trezor) to create shares, validate
checksums, and reconstruct secrets. We discuss this in the next section.

(It also has the small limitation that it could've used a bigger error correction
code, which we also addressed, but which is very unlikely to be a problem in
practice.)

## Computers and Trust

It is infeasible to  sign Bitcoin transactions without the aid of electronic
computers, which are needed to perform elliptic curve operations and SHA256
hashes. To do this, these computers need access to secret key material, which
puts the user in an uncomfortable position: this key material, if misused
(or initially generated without sufficient randomness), can be used to steal
all of the users' coins. And there is no way for the user to be assured of
what, exactly, an electronic computer is doing with her keys.

General-purpose computers are so complex and exposed to so much adversarial
input (in the form of Internet connections, running arbitrary programs, and
being exposed to many users) that users are advised to never expose their
key material to such machines. Instead, they provide their seed words to
hardware wallets, which interact with host computers through a narrow interface
which never reveals secret key data in any form.

However, even hardware wallets are opaque and inscrutable, and there are many
reasons to consider their use risky:
* They may have bugs which cause key leakage, either now or as a consequence
of some future firmware update.
* They may store key material in a physical form which can be extracted by an
attacker with physical access, even after it has been "deleted" from the
perspective of the wallet itself.
* They may expose data through *side channels*, such as the electromagnetic
waves emitted by processor activity, or a varying power draw from an untrustworthy
USB port.
* If tasked with generating random data, they may do so with insufficient entropy.

Furthermore, when working with Shamir Secret Sharing, it is necessary to handle
secret key data, and expose secret shares to the user, which introduces a new
set of risks -- how can the hardware wallet be sure that it is communicating
only with the correct user under the correct circumstances?

These risks have varying degrees of plausibility, but the fact is that no matter
how trustworthy the hardware or its manufacturer, these are nontrivial risks and
over the lifetime of a Bitcoin secret (which may, perhaps, exceed any one human's
lifetime), they add up to a very serious risk.

We propose then, to eliminate this risk factor entirely, by providing the user
a way to
* Compute and verify very powerful checksums (see the next section)
* Split their secret into up to 31 "shares", of which some number are needed to
reconstruct the secret (see the previous section)
* Recombine their secret, perhaps to redo the splitting if some old shares are
compromised
* Recursively split shares, so that they may themselves be spread across multiple
parties

entirely without the use of electronic computers. In this way, coins which do
not need to be spent may have their secure storage refreshed or reorganized an
arbitrary number of times, without the uncertainty and risk associated with
electronic computers ever entering the picture.

## Checksumming and Error Correction

When users are storing key data, it is possible that errors may arise, especially
during the initial storage, or when the data is being copied or transferred to a
new container. Errors might also crop up during long-term storage, for example
if Cryptosteel tiles are subjected to extreme heat which makes some letters
unclear, or if a seed word stored on paper suffers water damage.

In this scheme, users will also be doing finicky and time-consuming computations
on their seed data, without the aid of electronic computers, and it is very likely
that errors will appear during these computations.

Both BIP39 and SLIP39, in addition to encoding the raw cryptographic data, also
store a *checksum*, which is a small amount of extra redundant data used to
detect errors. BIP39's checksum is less than one word long, will fail to detect
errors with probability 1/256, and cannot reliably correct any number of errors.
It is also effectively impossible to compute or verify by hand.

SLIP39, by contrast, can detect up to 3 errors and correct up to one error 100%
of the time, and will fail to detect other errors with probability roughly one
in a billion. However, the SLIP39 checksum is also very difficult to compute or
verify by hand.

In this scheme, we introduce a new checksum, *russ32* (lol let's rename this -AP),
which can detect up to *8* errors, correct up to 4, and has probability less than
one in a million million million of failing to detect other random errors. Further,
russ32 checksums can be computed and verified entirely by hand, 

# Detailed Introduction


   - bech32 alphabet has 32 characters and is missing letters
     - every share has a single-character index. you can only have 31 shares
     - the 32nd "share", the S share, is your actual secret
   - tables and volvelles

   - definition of russ32
   - link to error correction code


