[
/subsection (I.2. codex32)/endsubsection
/dropcap (U) (sing volvelles)
(this codex illustrates a method for Shamir Secret Sharing Bitcoin)
(secrets. This document also defines an error-correcting code and)
(complete scheme for generating, checksumming, splitting, and)
(reconstructing secret data.)
()   

/paragraph
/linebreak
(The function of this codex is to provide a paper-based means to:)
/startlist
/listitem* (Securely generate random data from  potentially)
  (biased dice rolls or coin flips to create shares.) /endlistitem
/listitem* (Split a secret into up to 31 shares, of which some)
  (number of them are needed to reconstruct the secret.) /endlistitem
/listitem* (Recombine your shares into your original secret.) /endlistitem
/listitem* (Compute and verify powerful checksums)
  (as part of each share.) /endlistitem

/paragraph
(This scheme does not support passphrases or key hardening, so)
(security rests solely on the strength of your randomness.)
(Because of this, it is extremely important to generate)
(truly random numbers. This document provides a dice de-biasing)
(worksheet to generate random values from dice rolls by hand.)
(If you prefer the added security of passphrase-based key hardening,)
(you should instead use SLIP39. SLIP39 is a non-paper-based)
(Shamir Secret Sharing Scheme for Bitcoin secrets. Which does, however,)
(require the use of electronic computers.)

/subsection (I.3. Computers and Trust)/endsubsection
/dropcap (I) (t is impossible to sign a Bitcoin transaction without)
(giving an electronic computer access to secret key data, which)
(puts the user in an unfortunate position. If misused or badly)
(generated, private key data can be used to steal all of your)
(coins. To make matters worse, there is no way to know how exactly)
(an electronic computer is interacting with your keys.)

/paragraph
()
(General-purpose computers are so complex and exposed to an)
(adversarial environment \(i.e., in the form of Internet)
(connections, arbitrary programs, and human beings\).)
(The standard advice is to never expose your key material to such)
(machines. Instead, you should provide your keys only to hardware)
(wallets, which interact with general-purpose computers narrowly,)
(through an interface that does not expose your secret key data.)
(But this introduces additional questions: how can the hardware)
(wallet be sure that it's communicating with the correct user,)
(and under correct circumstances?)
($Ultimately, there is no hardware wallet that a wizard can fully trust.$)

/paragraph
(Even hardware wallets are opaque and imperfect:)
/startlist
/listitem* (If tasked with generating random data, it may do so)
  (insecurely.) /endlistitem
/listitem* (It may have bugs that cause key leakage, either now or)
  (as a consequence of some future software update.) /endlistitem
/listitem* (Key material stored in physical form can be)
  (extracted by an attacker with physical access, even if the)
  (wallet has "deleted" it.)/endlistitem
/listitem* (It may expose secret data through side channels, such)
  (as the electromagnetic waves emitted by processor activity, or)
  (by the varying power draw from a USB hub.) /endlistitem
/paragraph
(These risks have varying degrees of plausibility, but for a)
(Bitcoin secret, which may exceed any one person's lifetime, even)
("trivial" risks add up to become very serious.)
] drawPageContent
