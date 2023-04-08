[
/startText
(The good news is that unlike electronic computers, paper cannot)
(remember or leak secrets! When handled correctly and disposed)
(of securely, and this can be done without special skills,)
(equipment, or magic.)

/paragraph
(Some limitations of SSSS include:)
/startlist
/listitem* (SSSS requires that the complete secret be reconstructed)
  (in a single place before it can be used. If the shares)
  (created were initially distributed among different individuals)
  (in a group, the party that brings together the shares to)
  (recreate the secret has the opportunity to spend funds,)
  (even if their single-party authority was not intended.)/endlistitem
/listitem* (SSSS requires the generation of additional random)
  (data beyond the original secret, which must be generated)
  (securely.) /endlistitem
/listitem* (If any share is corrupted, the reconstructed secret)
  (will be wrong, and it's impossible to determine which share was)
  (responsible, or how many.) /endlistitem

/paragraph
(We have addressed the latter issue through the clever use of)
(error-correcting codes, inspired by SLIP39. However, not much)
(can be done about the fact that SSSS)
(involves a single point of failure at the time that the secret)
(key material is used. This is why this scheme is only to be)
(used for backups, and not for enforcing a signing policy.)

/subsection (I.4. Checksumming and Error Correction) /endsubsection
/dropcap (W) (hen you copy or transfer keys, and especially when)
(you are conducting hand computations, it is possible that)
(errors may arise. A *checksum* is a technique used to determine the)
(authenticity of received data, to detect whether there was an error)
(in transmission, storage, or copying. Errors might also)
(crop up during long-term storage \(e.g., if a paper backup suffers water)
(damage, or a cryptosteels' tiles are damaged making some of the letters illegible\).)

16 { /linebreak } repeat

/paragraph
(This scheme does not support BIP39 mnemonic codes, which is)
(currently the most popular way of storing private key backups.)
(Users should note that the BIP39 checksum is less than one word)
(long, and may fail to detect even a single incorrect word.)
(Its primary effects are to cause your key data to be an awkward)
(length, and to prevent you from verifying your data's integrity)
(by hand.)
/paragraph
(In contrast, the SLIP39 Shamir Secret Sharing Scheme)
(can detect up to three word errors and correct up to one word 100%)
(of the time. Additionally, it will detect other random)
(errors with extremely high probability. However, the SLIP39)
(checksum is also quite difficult to compute or verify by hand.)
] drawPageContent
