[
/section (Part I: High-Level Introduction)/endsection

/dropcap (C) (ryptography is the art of hiding information. In particular, *Shamir*)
(*Secret* *Sharing* *Scheme* *(SSSS)* is used to hide secrets in a distributed way.)
(*codex32* describes a way for users, assisted by paper computers in the form of)
(slide charts and circular slide rules \(i.e., volvelles\),)
(to perform checksums and SSSS on Bitcoin secrets.)
(If you are ready to begin using this process, jump to page 7 to follow)
(the cheatsheet. For a more in-depth primer,)
(continue reading the high-level introduction below.)
/subsection (I.1. Shamir Secret Sharing Scheme)/endsubsection
/dropcap (T) (he *Shamir Secret Sharing Scheme \(SSSS\)* splits a)
(*secret* $s$ into $n$ *shares*, any $k$ of which can be used)
(to reconstruct the original secret. Shares can be kept in separate)
(places. The shares can later be used to reconstruct the original)
(secret. It is important to emphasize that SSSS is a mechanism for)
(storing backups, not a mechanism for enforcing a signing)
(policy, as is done with multisig. In fact, even when using a multisignature)
(scheme, there are still keys to be backed up, which could use SSSS.)

23 { /linebreak } repeat

/paragraph
()   
(With SSSS, $n$ is typically five or more, depending on your desire)
(for redundancy, while $k$ is two or three, reflecting your fear of)
(individual shares being compromised. There is an inherent)
(trade-off between the availability of a)
(secret and its risk of theft. If you make many copies of your seed words,)
(one of them may fall into the wrong hands. However, if you make too)
(few, they could become lost, destroyed, or misplaced. The consequence in)
(either case is a complete and total loss of funds.)
(By using shares rather than complete copies of our seed, we can make this)
(tradeoff in a more flexible way.)

/paragraph
(Shamir Secret Sharing Scheme was first proposed in the 1970s,)
(and has historically required the use of computers to generate)
(secrets and shares. Instead, this codex outlines a novel method)
(of secret sharing that can be done entirely on paper.)
] drawPageContent
