<?php

$current_page = 1;
$current_page_cont = 0;

function new_page($landscape = false) {
    GLOBAL $current_page;
    GLOBAL $current_page_cont;
    static $current_page_disp = 6;

    echo "%%Page: $current_page $current_page_disp\n";
    if ($landscape) {
        echo "%%PageOrientation: Landscape\n";
    }
    echo "%%BeginPageSetup\n";
    echo "/pgsave save def\n";
    echo "%%EndPageSetup\n";

    $current_page++;
    $current_page_cont++;
    $current_page_disp++;
}

function end_page() {
    echo "end pgsave restore showpage\n";
}

function content_page($landscape = false, $override_margin = false) {
    GLOBAL $current_page_cont;
    new_page($landscape);
    if ($landscape) {
        echo "landscapePage";
    } else {
        echo "portraitPage";
    }
    echo " begin $current_page_cont ";
    if ($override_margin) {
        echo "/marginX2 marginX2 1.75 div def ";
    }
    echo "drawPageContent\n";
}

?>
%!PS-Adobe-3.0
%%Orientation: Portrait
%%Pages: 43
%%EndComments
%%BeginSetup
[(Shamir's Secret) (Sharing Codex)]
(revision alpha-4.6)
[
(MIT License)
()
(Copyright (c) 2022 Blockstream)
()
(Permission is hereby granted, free of charge, to any person obtaining a copy)
(of this software and associated documentation files (the "Software"), to deal)
(in the Software without restriction, including without limitation the rights)
(to use, copy, modify, merge, publish, distribute, sublicense, and/or sell)
(copies of the Software, and to permit persons to whom the Software is)
(furnished to do so, subject to the following conditions:)
()
(The above copyright notice and this permission notice shall be included in all)
(copies or substantial portions of the Software.)
()
(THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR)
(IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,)
(FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE)
(AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER)
(LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,)
(OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE)
(SOFTWARE.)
()
()
(All Artwork Copyright (c) 2022 Micaela Paez)
(The artwork, including the title page, volvelle drawings, and dropcap illustrations,)
(is licensed under the Creative Commons Attribution 4.0 International License.)
(To view a copy of this license, visit http://creativecommons.org/licenses/by/4.0/)
(or send a letter to Creative Commons, PO Box 1866, Mountain View, CA 94042, USA.)
()
]
%************************************************************************
%************************************************************************
%*
%* Section One: Preamble
%*
%************************************************************************
%************************************************************************

%******************
%* Front matter
%*
%* Define variables for the preceeding front matter text.
%*
/MIT exch def
/ver exch def
/title exch def

%******************
%* Main text content
%*
/allPageContent [
  [ ] % dummy so we can 1-index the array
  [
    /section (Overview / Cheatsheet) /endsection
    /notoc % turn off table of contents indexing
    /dropcap (C) (ryptography is the art of hiding information. In particular, Shamir's)
    (Secret Sharing Scheme (SSSS) is used to hide secrets in a distributed way.)
    (A secret is split into multiple parts, called shares, that can be given)
    (to different people or kept in separate places. The)
    (shares can then be  used to reconstruct the original secret. For the)
    (wizards in the Bitcoin community, SSSS can be use to hide the single BIP32 master)
    (seed from which all their private keys are derived.)
    /paragraph
    (This codex describes a way for users, assisted by paper computers in the)
    (form of slide charts \(volvelles\) and circular slide rules, to perform)
    (checksums and SSSS on their Bitcoin secrets.)

    /subsection (Assembly) /endsubsection
    (*You will need*: craft knife, cardstock or heavy paper, brass fasteners, disc printouts.) /linebreak
    (Using the printouts from Module 0 \(which have pictographic instructions\),)
    /startlist
    /listitem1 (Cut out each disc with scissors. Cut out the windows on the top discs with the craft knife.) /endlistitem
    /listitem1 (Cut out the small centre circle in each bottom disc.)
      (Cut a slit along one one of the small lines of the cross in each top disc.) /endlistitem
    /listitem1 (Attach the discs with a brass fastener through the centre holes.) /endlistitem

    /subsection (Initial \(First $k$\) Share Creation) /endsubsection
    (*You will need*: Addition Volvelle, Random Character Worksheet, Checksum Worksheet, pencil and eraser)
    /linebreak
    (For each of your initial $k$ shares, you should)
    /startlist
    /listitem1 (Generate random data by rolling dice, following the instructions on the Random Character Worksheet.) /endlistitem
    /listitem1 (Follow the instructions on the Checksum Worksheet to affix a checksum.) /endlistitem

    /subsection (Derived \(Remaining\) Share Creation) /endsubsection
    (*You will need*: Addition Volvelle, Multiplication/Translation Wheel, pencil)
    /startlist
    /listitem1 (Translate the initial shares using the symbols in the Derived Shares section) /endlistitem
    /listitem1 (Add the translated initial shares to get the new derived share.) /endlistitem

    /subsection (Secret Recovery) /endsubsection
    (*You will need*: Addition Volvelle, Multiplication/Translation Wheel, Recovery Wheel, pencil)
    (To recover your secret you must have $k$ shares available. Then)
    /startlist
    /listitem1 (Look up their recovery symbols with the Recovery Wheel.) /endlistitem
    /listitem1 (Multiply all the symbols for each share with the Multiplication Wheel to get)
    (a single symbol for each share.) /endlistitem
    /listitem1 (Translate the share by that symbol.) /endlistitem
    /listitem1 (Add all the translated shares to get your secret.) /endlistitem
    /toc % turn off table of contents indexing
  ] [ % pagebreak
    /section (Part I: High-Level Introduction) /endsection
    /notoc % turn off table of contents indexing
    /dropcap (T) (he SSSS Codex describes a way, using circular paper computers)
    (\(volvelles\), to perform checksumming and Shamir Secret Sharing on their)
    (Bitcoin secrets. It defines an error-correcting code, *codex32*, and a)
    (complete scheme for generating, checksumming, splitting and reconstructing)
    (secret data.)
    /paragraph
    (Hand-computation comes with some practical limits: to generate random values)
    (we rely on series of (de-biased) dice rolls. We do not support passphrases)
    (or key hardening, so our security rests solely on the strength of this)
    (randomness. With that said, assuming you can generate strong randomness,)
    (you will find no cryptographic compromise in the design or implementation)
    (of the Codex.)
    /paragraph
    (If you prefer the added security of passphrase-based key hardening, you)
    (should instead use the more-popular SLIP39, which requires the use of electronic)
    (computers.)

    /subsection (Bitcoin and Seed Values) /endsubsection
    /dropcap (W) (e assume that your secret is a 128-bit BIP32 master seed. Such)
    (seeds are used to derive an effectively unlimited number of addresses from a)
    (single secret value, eliminating the need for frequent backups.)
    /paragraph
    (Many users interact with BIP32 master seeds indirectly, for example by storing)
    (a set of 12 or 24 BIP39 seed words. These seed words represent a 132- or)
    (264-bit secret, which is converted in the BIP39 protocol to a pointlessly)
    (large master seed by means of a needlessly complicated and irreversible)
    (process. If your coins are stored using BIP39, we have provided a module to)
    (assist converting the seed words to binary \(and back\) so they can be used)
    (in the Codex in lieu of a master seed. The longer data greatly increases the)
    (tedium and risk of mistakes, but the procedures are essentially unchanged.)
    /paragraph
    (In general, we encourage you to switch from BIP39 to Satoshi Labs' SLIP39,)
    (or better, to directly work with 128-bit BIP32 seeds using the Codex.)

    /subsection (Shamir's Secret Sharing Scheme) /endsubsection
    /dropcap (T) (here is an inherent trade-off between the availability of a)
    (secret and its risk of theft. If you make many copies of your seed words,)
    (one of them may eventually fall into the wrong hands. But if you makes too)
    (few, they may all become lost, destroyed or misplaced. The consequence in)
    (either case is a total loss of funds.)
    /paragraph
    (A more nuanced way to make this trade-off is Shamir's Secret Sharing Scheme)
    (\(SSSS\), in which you split your secret into $N$ "shares", any $K$ of which)
    (can be used to reconstruct the original secret. Here $N$ is typically five)
    (or more, depending on your desire for redundancy, while $K$ is two or three,)
    (reflecting your fear of individual shares being compromised.)
    /paragraph
    (Before continuing, we should mention some limitations of SSSS:)
    /startlist
    /listitem* (First, electronic computers or not, SSSS requires that the)
      (complete secret be reconstructed in a single place before it can be used.)
      (To avoid this, for most use-cases we instead recommend threshold)
      (signatures instead.) /endlistitem
  ] [ % pagebreak
    /startText
    /listitem* (SSSS requires the generation of extra random data beyond the)
      (original secret, which must be generated securely. If any share is corrupted,)
      (the reconstructed secret will be wrong and it is impossible to determine)
      (which share \(or how many shares\) was responsible.) /endlistitem
    /paragraph
    (We have addressed the latter issue by the clever use of error-correcting codes,)
    (inspired by SLIP39, but the fact remains that SSSS involves a single point of)
    (failure at the time that the secret key material is actually used. We emphasize)
    (that SSSS is a *mechanism* *for* *storing* *backups* and not a mechanism for enforcing)
    (a signing policy.)

    /subsection (Computers and Trust) /endsubsection
    /dropcap (I) (t is infeasible to sign Bitcoin transactions without the aid of)
    (electronic computers. To do this, these computers need access to secret key)
    (material, which puts you in an uncomfortable position: key material, if)
    (misused or badly generated, can be used to steal all of your coins. And)
    (there is no way to be assured of how, exactly, an electronic computer is)
    (manipulating your keys.)

    /paragraph
    (General-purpose computers are so complex and exposed to adversarial input)
    (\(in the form of Internet connections, arbitrary programs, and human beings\))
    (that standard advice is to never expose your key material to such machines.)
    (Instead, you should provide your keys only to hardware wallets, which)
    (interact with general-purpose computers only through a narrow interface that)
    (never exposes secret key data in any form.)
    /paragraph
    (However, even hardware wallets are opaque and inscrutable:)

    /startlist
    /listitem* (they may have bugs which cause key leakage, either now or as a)
      (consequence of some future firmware update;) /endlistitem
    /listitem* (they store key material in physical form which can be extracted)
      (by an attacker with physical access, even if it the wallet has "deleted")
      (it;) /endlistitem
    /listitem* (they may expose data through sidechannels, such as the)
      (electromagnetic waves emitted by processor activity, or by the varying)
      (power draw from a USB hub;) /endlistitem
    /listitem* (if tasked with generating random data, they may do so insecurely.) /endlistitem

    /paragraph
    (Furthermore, when working with secret shares, it is necessary to directly)
    (export share data, violating the usual "never expose secret data" maxim.)
    (This introduces more questions: how can the hardware wallet be sure that)
    (it is communicating only with the correct user, and under correct)
    (circumstances? It cannot.)
    /paragraph
    (These risks have varying degrees of plausibility, but the fact is that no)
    (matter how trustworthy the hardware or its manufacturer, over the lifetime)
    (of a Bitcoin secret \(which may, perhaps, exceed any one human's lifetime\),)
    (even "trivial" risks add up to become very serious.)
    /paragraph
    (Unlike electronic computers, paper cannot remember or leak secrets, at least)
    (when handled correctly and disposed of securely, and this can be easily seen without special skills)
    (or equipment. In this document, we have provided a paper-based means to)
    /startlist
    /listitem* (Securely generate random data from potentially biased dice or coin flips) /endlistitem
    /listitem* (Compute and verify very powerful checksums) /endlistitem
    /listitem* (Split your secret into up to 31 "shares", of which some number are)
      (needed to reconstruct the secret) /endlistitem
    /listitem* (Recombine your secret, perhaps to redo the splitting if some old)
      (shares are compromised) /endlistitem
  ] [ % pagebreak
    /startText
    (In this way, coins which do not need to be frequently spent may have their)
    (secure storage refreshed or reorganized an unlimited number of times, without)
    (ever introducing the uncertainty and risk associated with electronic computers.)

    /subsection (Checksumming and Error Correction) /endsubsection
    /dropcap (W) (hen you copy or transfer keys, or especially when you are doing)
    (hand-computations on them, it is possible that errors may arise. Errors)
    (might also crop up during long-term storage, for example if Cryptosteel)
    (tiles are subjected to extreme heat which makes some letters unclear, or)
    (if printer paper suffers water damage.)
    /paragraph
    (Both BIP39 and SLIP39, in addition to encoding the raw cryptographic data,)
    (also store a checksum, which is a small amount of extra redundant data used)
    (to detect such errors. BIP39's checksum is less than one word long, may fail)
    (to detect even a single incorrect word, and is practically impossible to)
    (compute by hand. Its primary effects are to cause your key data to be an)
    (awkward length, and to prevent you from verifying your data's integrity by)
    (hand.)
    /paragraph
    (SLIP39, by contrast, can detect up to 3 errors and correct up to one error)
    (100% of the time, and will fail to detect other random errors with extremely)
    (low probability. However, the SLIP39 checksum is also quite difficult to)
    (compute or verify by hand.)
    /paragraph
    (In the Codex, we introduce a new checksum, *codex32*, which can detect up to 8)
    (errors, correct up to 4, and has even lower probability than SLIP39 of failing)
    (to detect other random errors. Most importantly \(for us\), codex32 checksums)
    (can be computed and verified entirely by hand.)

    /subsection (Bech32 and the Alphabet) /endsubsection
    /dropcap (I) (n order to store 128-bit secrets, we re-use the Bech32 alphabet)
    (which provides 32 5-bit characters. These characters consist of the 26)
    (letters of the Latin alphabet and 10 Arabic numerals, except B \(which looks)
    (like 8\), O \(which looks like 0\), and I and 1 \(which look like each other\).)
    /paragraph
    (We also use an alternate alphabet, consisting mostly of Greek letters, which)
    (is used for intermediate computations. It is never used for storage, and)
    (nothing represented in this alphabet is ever secret data. We have provided)
    (a table of pronunciation to help with its use.)
    /paragraph
    (The remainder of this document provides detailed, but mechanical,)
    (instructions. If you are interested in learning the mathematical theory behind)
    (this all, we encourage you to check out the mathematical companion, or to)
    (contact Pearlwort at `pearlwort@wpsoftware.net`.)
    /toc % turn on table of contents indexing
  ] [ % pagebreak
    /section (Part II: Detailed Instructions) /endsection
    /subsection (II.1. Tables or Volvelles) /endsubsection
    /dropcap (H) (and computation for the procedures in this document can be)
    (performed either by using the Principal Tables to look up values, or by)
    (using volvelle wheels to look up values. While the volvelle wheels take)
    (time to cut out and assemble, they are generally easier to use than the)
    (tables when available.)

    /subsection (II.2. Share Format) /endsubsection
    /dropcap (F) (or 128-bit secret seeds, each share is 48 characters long.)
    (Shares begin with the three character prefix `MS1`. This is followed by a)
    (six character header. The next 26-characters is the data portion. The last)
    (13-characters are the checksum.)
    /paragraph
    (The header consists of:)
    /startlist
    /listitem* (The *threshold* which is the value $k$, a digit between)
    (`2` and `9` inclusive, however Module 0 only supports $k$ < 3. When)
    (secret splitting is not used, the a `0` digit is placed here instead.)
    /endlistitem
    /listitem* (The *identifier* which is four bech32 characters.) /endlistitem
    /listitem* (The *share index* which is any bech32 character except for)
    (`S`. The `S` index is the *secret* *index*. The data portion of the)
    (secret index contains the secret seed.) /endlistitem
    /paragraph
    (Shares of one secret all have the same threshold and identifiers. If you)
    (have multiple secrets, you should use distinct identifiers for each secret)
    (so as not to mix-up shares of different secrets with each other. The)
    (identifiers are not considered secret themselves.)

%| Human-readable Part | Threshold | Secret ID | Share Index | Secret data | Checksum |
%|---------------|--------|---------|--------|----------|----------|
%| 3 characters (`ms1`) | 1 character | 4 characters | 1 character | 26 characters | 13 characters |

    /paragraph
    /paragraph
    /paragraph
    /paragraph
    (The components of the header are:)
    /startlist
    /listitem* (The *threshold* indicates what the secret sharing)
     (threshold is, and should be a digit between `2` and `9`)
     (inclusive. Higher threshold values are not supported.) /endlistitem
    /listitem* (The *identifier* is four arbitrary bech32 characters.)
     (All shares of a given secret will have the same identifier, but distinct)
     (secrets should have distinct IDs.) /endlistitem
    /listitem* (The *share index* indicates which share this is,)
     (and may be any bech32 character except `S`. *The* *secret* *itself* *will*)
     (*have* *share* *index* `S`.) /endlistitem

    /paragraph
    (If the user merely wants to checksum her secret, and not use secret splitting,)
    (she should use the same format, but with the digit `0` for the threshold value)
    (and `S` for the share index.)
  ] [ % pagebreak
    /subsection (II.3. New Secret Seed) /endsubsection
    /dropcap (G) (enerating a $k$-of-$n$ scheme for a new random secret is most)
    (easily done by generating fresh random shares directly. This process generates)
    (a new random secret seed without directly revealing it.)
    /paragraph
    /startlist
    /listitem1 (Choose a threshold $k$ and total number of shares $n$ that suits)
    (your needs. The threshold $k$ must be 3 or less and $n$ must be 31 or less.)
    /endlistitem
    /listitem1 (Choose a 4 character identifier for your new secret seed. The)
    (identifier can be anything as long as it only uses the Bech32 character set.)
    (The identifier itself is not secret. However, the identifier should be)
    (unique for each secret seed.) /endlistitem
    /listitem1 (Follow Section II.3.a to generate the first $k$ shares.) /endlistitem
    /listitem1 (Follow Section II.3.b to generate the remaining $n$ - $k$ shares.) /endlistitem
    /listitem1 (Load your shares into your BIP-????) /footnotemark (compliant wallet or use the)
    (Recover Secret Seed procedure in Section II.4 to access your new secret seed)
    (value.) /endlistitem
    /listitem1 (Copy and distribute your $n$ shares into safe and secure locations.)
    (Remember that you will need to recover at least $k$ of these shares to)
    (recover your secret seed. Also remember that anyone else who recovers $k$ of)
    (these shares can also recover your secret seed.) /endlistitem
    /listitem1 (Securely dispose of all worksheets you used in the generation)
    (procedure. If these worksheets are not securely disposed of, the could be)
    (used to recover your secret seed.) /endlistitem

    /subsubsection (II.3.a. New Secret Seed: Stage 1) /endsubsubsection

    (Make 2$k$ copies of the Checksum Worksheet and save half of them for later.)
    /paragraph
    (Fill out the header portion of $k$ many Checksum Worksheets with your chosen)
    (threshold $k$ and chosen ID. Place a unique share index on each worksheet)
    (starting with share `A` on the first worksheet, `C` on the second worksheet,)
    (and so on through the $k$ first characters from the Bech32 character set.)
    (\(Note that `B` and `I` are not part of the Bech32 character set and are)
    (omitted\). However, if you are not splitting your secret, \(i.e. $k$ = 1\))
    (see the special instructions below.)
    /paragraph
    (Fill out the 26 character data portion of each Checksum Worksheet with random)
    (characters. Use the Random Character Worksheet to generate each random)
    (character.)
    /paragraph
    (Follow the Checksum Worksheet instructions to generate a checksum for each)
    (worksheet.)
    /paragraph
    (*Critical Step:* Verify your checksum by copying each of the 48 characters)
    (of the share onto an empty worksheet that you saved earlier. Follow the)
    (checksum verification instructions to verify each checksum. If any checksum)
    (fails to verify then make more copies of the Checksum worksheet and redo the)
    (checksum generation and checksum verification steps again.)
    /paragraph
    (*Failure to verify each checksum may lead to irrecoverable loss of)
    (the secret seed and funds.)
    /paragraph
    (*Special rules for $k$=1:* If you are not splitting your secret, then use)
    (a `0` digit in the threshold place, and use the `S` character in the share)
    (index place. Follow the same instructions for generating the data portion)
    (and the checksum.)
    /footnotes
    /footnotemark (Once we have a BIP number for codex32, we will replace "BIP-????" throughout the document.)
  ] [ % pagebreak
    /subsubsection (II.3.b. New Secret Seed: Stage 2) /endsubsubsection
    (The remaining $n$ - $k$ are derived from the first $k$ shares using the)
    (addition worksheet corresponding to the $k$ value you have chosen. Label)
    (the entries of the addition worksheet with the share indices that you will)
    (be using. We recommend following the Bech32 character order following the)
    (last index you generated in Stage 1.)
    /paragraph
    (Use the following procedure to derive a new share:)
    /startlist
    /listitem1 (Make a copy of the Translation Worksheet for the value of $k$ that)
    (you are using and label the shares with the share indices from the shares)
    (you have already generated, `A`, `C` and `D` if $k$=3. Label the Final)
    (Share Index with the new share index you want to derive.) /endlistitem
    /listitem1 (In the derivation table for your value of $k$, find the column)
    (corresponding to the new share index you want to derive. Fill in the symbols)
    (on the Translation Worksheet with the symbols from that column next to the)
    (share index for each row.) /endlistitem
    /listitem1 (Follow the Translation Worksheet instructions to derive the new share.)
    /endlistitem

    /notoc /subsubsection (Derivation Table) /endsubsubsection /toc
    (Derivation tables for $k$ = 4 through 9 can be found in Module 2.)
    /paragraph
    /paragraph
    /paragraph %% derivation table
    /paragraph
    /paragraph

    /subsection (II.4. Recover Secret Seed) /endsubsection

    /dropcap (N) (ormally you would not recover a secret seed yourself, and)
    (instead load shares into a BIP-???? compliant wallet. However, you can)
    (recover the secret seed by hand if no compatible wallets are available)
    (or you feel a need to prove your own conjuring ability.)
    /paragraph
    (The recovery procedure uses exactly $k$ many shares. If you have more than $k$)
    (many shares, you can select any $k$ of them and set the other shares aside.)
    /paragraph
    (Use the following procedure to recover the share:)
    /startlist
    /listitem1 (For each share, fill in a Checksum Worksheet and verify the checksum.)
    (If a checksum fails to verify, you may have made an error on your worksheet,)
    (or there may be an error in your share data. If there is an error in your)
    (share data, you can try substituting the share with a different one.)
    (Otherwise you will need to perform the Error Correction Procedure on your)
    (share, which will involve the assistance of a electronic computer.) /endlistitem
    /listitem1 (Make a copy of the Translation Worksheet for the value of $k$ that you)
    (are using and label the shares with the share indices from the shares you)
    (have selected to recover from, and label the Final Share Index as `S`.) /endlistitem
    /listitem1 (You can fill in the symbols for each share on the Addition)
    (Worksheet using either the table lookup, or the volvelle lookup:)
] [ % pagebreak
    /listitem1 /endlistitem
    /listitem1 /endlistitem
    /listitem1
    /startText
    ($Table lookup $k$ = 2:$ Fill in the symbol from the Recover table by)
    (finding the column with the associated share, and the row for the other)
    (share.)
    /paragraph
    ($Volvelle lookup $k$ = 2:$ Turn the Recovery Volvelle to point to the)
    (share being considered. Find the symbol pointed to under the other share)
    (index on the wheel and fill in that symbol next to the share we are)
    (considering on the Translation Worksheet.)
    /paragraph
    ($Table lookup $k$ = 3:$ Finding the column with the associated share.)
    (Lookup the two symbols from the two rows corresponding to the two other)
    (shares. Make a note of these two symbols on a scrap piece of paper. Use the)
    (multiplication table to multiply the the two symbols and fill in that)
    (share's symbol on the Translation Worksheet with the resulting product.)
    /paragraph
    ($Volvelle lookup $k$ = 3:$ Turn the Recovery Volvelle to point to the)
    (share being considered. Find the two symbols pointed to under the other share)
    (indices on the wheel. Turn the multiplication wheel to the first of these)
    (two symbols. Find the second symbol on the lower ring, and lookup the symbol)
    (it is pointing to. Fill that symbol next to the share we are considering on)
    (the Translation Worksheet.)
    /endlistitem
    /listitem1 (Repeat step 3 for each share on the Addition worksheet.)
    /endlistitem
    /listitem1 (Follow the Translation Worksheet instructions recover the secret)
    (share.) /endlistitem
%    /listitem1 (After completing the checksum verification you may run the Binary)
%    (Worksheet on the secret share to convert the secret seed into binary format.)
%    /endlistitem
  ] [ % pagebreak
    /section (Random Character Worksheet) /endsection
    (*You will need:* five distinct dice, five markets, this and the following page)
    /startlist
    /listitem1 (Label each Die Track to indicate which die it corresponds to.)
      /linebreak /linebreak
      (*Do* *not* *otherwise* *mark* *these* *two* *pages.*) /endlistitem
    /listitem1 (Roll all five dice. Set markers on each Die Pad indicating)
      (their values.) /endlistitem
    /listitem1 (Roll all five dice again and set the dice on each Die Track)
      (indicating) /linebreak (their second values.) /endlistitem
    /listitem1 (Repeat steps 2 and 3 for each die that showed the same value)
      /linebreak (twice.) /endlistitem
    /listitem1 (Using your finger, follow the tree to the right using the results)
      /linebreak (indicated on the Die Tracks: take the first left branch if the)
      /linebreak (first die is to the left of its marker, the right branch if it is)
      /linebreak (to the right. Similarly, take the second branch based on)
      /linebreak (the results on the second Die Track, and)
      (so on, until) /linebreak (the bottom of the tree.) /endlistitem
    /listitem1 (Repeat Steps 2-5 to generate more characters.) /endlistetim

  4 { ] [ } repeat % lol postscript
    /section (Checksum Worksheet) /endsection
    /notoc %% don't put all the checksum worksheets into the ToC
    (The Checksum Worksheet is used to generate and verify checksums. It is the)
    (most frequently used and important worksheet of this codex.)
    /linebreak
    (*You will need:* Checksum Worksheet, Checksum Table, Addition Wheel)
    /linebreak
    (Generating a checksum:)
    /startlist
    /listitem1 (Fill in the top diagonal squares \(the bold ones\) with your random data; you should)
      (have enough to fill the non-pink bolded squares) /endlistitem
    /listitem1 (Add the first row to the second to fill in the third row, using the)
      (Addition Wheel.) /endlistitem
    /listitem1 (Look up the two leftmost underhanging hanging symbols from the third)
      (row in the Checksum Table to fill in the fourth row.) /endlistitem
    /listitem1 (Repeat the above two steps, adding the third and fourth row, looking)
      (up the fourth to fill in the fifth, and so on. You will be able to complete)
      (the entire sheet except for the pink squares this way.) /endlistitem
    /listitem1 (To complete the pink squares, work from the bottom up, adding each row)
      (to the one above it until all the squares are filled.) /endlistitem
    /linebreak
    /linebreak
    (The completed share can now be read from the top diagonal, including the checksum.)
  ] [
    /section (Checksum Worksheet) /endsection
    (Verifying a checksum:)
    /startlist
    /listitem1 (Fill in the top diagonal with your share data; you should have enough)
      (to fill all the bolded squares) /endlistitem
    /listitem1 (\(Optional.\) Fill the bottom diagonal, if you have access to this)
      (data. It will help you catch mistakes.) /endlistitem
    /listitem1 (Fill in the rest of the worksheet as you did when generating a checksum.)
      (If your final row does not match `SECRETSHARE32`, or if any of your computed)
      (bottom diagonal values don't match the expected values, there is a mistake in)
      (the worksheet or your data has been corrupted.)
      /endlistitem
    /linebreak /linebreak
    (In case of error, first recompute every value in the bad column; then check)
    (that you copied all the share data correctly; then try redoing the worksheet)
    (entirely. If the checksum is consistently bad your data is corrupt and you)
    (need to attempt the online recovery process. \(Under construction; but try)
    (contacting Pearlwort for help.\))
  2 { ] [ } repeat
    /toc
    /section (Translation Worksheet) /endsection
    /notoc %% don't put all the translation worksheets into the ToC
    (The translation worksheet is used to derive shares, when splitting keys, and)
    (during key recovery. In both cases, the process is to translate a set of shares)
    (using the Translation Wheel, then to add the translated results using the)
    (Addition Wheel.)
    /linebreak
    /linebreak
    (*You will need:* Translation Worksheet, Translation/Multiplication Wheel, Addition Wheel)
    /linebreak
    /linebreak
    (In both cases, the number of shares to combine is your k value, the number of)
    (required shares to reconstruct the secret. The process is:) 
    /startlist
    /listitem1 (Make sure that you have completed checksum worksheets for all input shares.) /endlistitem
    /listitem1 (Look up the translation symbols for each share, either in tables or)
      (using the Recovery Wheel and Multiplication Wheel.) /endlistitem
    /listitem1 (Mark down each share's index \(the sixth character of its header\))
      (and translation symbol in the appropriate squares.) /endlistitem
    /listitem1 (Character by character, translate each share from its Checksum Worksheet)
      (to its row, using the Translation Wheel.) /endlistitem
    /listitem1 (Using the Addition Wheel, add all rows together.) /endlistitem
    /linebreak
    /linebreak
    (Notice that the resulting share will automatically have the correct share index in its header.)
  3 { ] [ } repeat
    /toc
    /section (Module 0: Volvelles) /endsection
  5 { ] [ } repeat
    /section (Module 1: Share Booklet) /endsection

    (In the common case that your threshold value k is 2, there is a much faster)
    (way to generate shares rather than using the Translation Worksheet and the)
    (volvelles.)
    /paragraph
    (In this case, your two initially generated shares will be `S` and `A`. To)
    (generate further shares, go through the characters of your `S` share one by)
    (one. For each character, find the table labeled by the character; then find)
    (the row labeled by the corresponding character of your `A` share.)
  9 { ] [ } repeat
    /section (Module 2: Share Generation Tables) /endsection
    (The main instructional section contains share derivation tables for $k$ values of)
    (2 or 3, assuming that initially generated shares are `A`, `C`, and \(sometimes\))
    (`D`. This page provides tables for higher $k$ values; the next provides tables)
    (for the case where your `S` share is an initial one.)
    /paragraph
    (Even higher values of $k$ can be obtained by editing the PostScript source of)
    (this document. Search for the text `EDITME` to find the right section.)
    /paragraph
    (We caution users that higher $k$ values, in our view, are a bad trade-off between)
    (usability and robustness \(which are damaged\) and security \(which is improved\).)
  ] [
    /startText
    (These tables allow you to generate shares in the case that your `S` share is)
    (an initial share. Ordinarily, you would generate the first few shares randomly,)
    (and infer your `S` share form those; but in some cases, for example when using)
    (and existing seed with this scheme, you need to generate the `S` share first.)
    /paragraph
    (In particular, BIP-39 users will need to use this table.)
  ] [
    /section (Module 39: BIP-39 Support) /endsection
    (BIP-39 users can use the following pages to convert their seed words into bech32)
    (format and attach checksums. These seed words will be encoded in the same way that)
    (ordinary secrets are, other than having a different length; the process for share)
    (splitting and recovery is the same.)
    /paragraph
    (The additional steps are as follows:)
    /startlist
    /listitem1 (Using the BIP-39 Conversion worksheet and the following four)
      (pages of binary conversion tables, convert your 12- or 24-word seedphrase)
      (to bech32.)
      /paragraph
      (Set your threshold and share ID as usual. *Set the share index of the)
      (converted data to* `S`.)
    /endlistitem
    /listitem1 (For a 12-word secret, checksum the bech32 data using the `BIP39_12w`)
      (checksum worksheet. For a 24-word secret, use the `BIP39_24W` worksheet. The)
      (instructions are essentially the same as for the ordinary `MS1` checksum)
      (worksheet, although some rows have been moved to fit everything onto one)
      (page.) /endlistitem
    /listitem1 (Split your secret. The instructions are essentially the same as in)
      (the standard setup, with two minor adjustments:)
      /startsublist
      /sublistitem1 (First, your data will not fit in the standard Translation)
        (Worksheet; we have provided an extended one in this module.) /endsublistitem
      /sublistitem1 (More importantly, your `S` share will be an initial share)
        (rather than a derived share. The standard derivation tables assumes)
        (otherwise. We have provided an alternate set of derivation tables in)
        (Module 2.) /endsublistitem
      /endlistitem
    /listitem1 (Similarly, recover your secret as usual.) /endlistitem
    /listitem1 (Convert the recovered secret back to seed words, again using the)
      (BIP-39 Conversion Worksheet. The same table will work for converting)
      (bits-to-words as for words-to-bits, since the binary and alphabetical ordering)
      (is the same.) /endlistitem

    /paragraph
    (We encourage users to move away from BIP-39 to avoid this extra inconvenience.)
  ] [ % pagebreak
  10 { ] [ } repeat  % add a bunch of trailing pages to avoid overflow
  ]
] def

%******************
%* Helper Functions and Utilities
%*

% determinant : matrix -- det(matrix)
/determinant {
 1 0 2 index dtransform
 0 1 5 4 roll dtransform
 3 1 roll mul
 3 1 roll mul
 exch sub
} bind def

% tan : angle -- tan(angle)
/tan {
  dup sin exch cos div
} bind def

% arcsin: y h -- arcsin(y/h)
/arcsin {
   dup mul 1 index dup mul sub sqrt
   atan
} bind def

% arccos: x h -- arccos(x/h)
/arccos {
   dup mul 1 index dup mul sub sqrt
   exch atan
} bind def

% Given a rod of length 2r, what angle does it fit inside a w by h sized box so that
% the ends of the rod are equaldistant from the two sides making a corner with the box.
/angleinbox {
10 dict begin
  { /r /h /w } {exch def} forall
  h w sub
  2 2 sqrt r mul mul
  arcsin 45 sub
end
} bind def

% Constructs a coordinate transformation used for the illustration of folding volvelles.
/foldprojection {
10 dict begin
  /foldangle exch def
  /squish 0.25 def
  /squash 1 squish dup mul sub sqrt def % sqrt (1 - squish^2)
  /rollangle squish neg 1 atan def
  [rollangle cos squish mul
   rollangle sin
   dup neg squish mul foldangle cos mul foldangle sin squash mul add
   rollangle cos foldangle cos mul
   0 0 ]
end

} bind def
/concatstrings % (a) (b) -> (ab)
   { exch dup length
     2 index length add string
     dup dup 4 2 roll copy length
     4 -1 roll putinterval
   } bind def

/checklast { % string ch -> bool
  exch
  dup length 0 gt {
    dup length 1 sub get eq
  } {
    pop pop false
  } ifelse
} bind def

%******************
%* Field Arthmetic
%*
%* Calculations within GF(32), extended with the "null element", represented by
%* numberic 32, which is displayed as a blank, and on which every operation
%* returns null again. Used to represent incomplete/unknown data.
%*
%* Our generator for GF(32) has minimum polynomial x^5 + x^3 + 1.
%*
/gf32add % x y -> x [+] y where [+] is addition in GF32.
         % returns 32 if x or y is out of range.
         % Note that x [+] y = x [-] y in GF32.
{               % x y
 2 copy 32 ge   % x y x (y >= 32)
 exch 32 ge or  % x y (y >= 32 || x >= 32)
 {pop pop 32}     % 32
 {xor}            % x [+] y
 ifelse         % if (y >= 32 || x >= 32) then 32 else (x [+] y)
} bind def

/gf32mulalpha % x -> x [*] alpha where [*] is multiplicaiton in GF32 and alpha is represted by 0b00010.
{               % x
 2 mul          % 2*x
 dup 32 ge      % 2*x (2*x >= 0b100000)
 { 41 xor }       % 2*x `xor` 0b101001
 if             % if (2*x >= 0xb100000) then 2*x `xor` 0x0b101001 else 2*x
} bind def

/gf32mul % x y -> x [*] y where [*] is multiplication in GF32.
         % returns 32 if x or y is out of range.
{                % x y
 10 dict begin
 { /y /x } {exch def} forall
 x 32 ge y 32 ge or  % (y >= 32 || x >= 32)
 {32}                  % 32
 {
   /xShift x def
   /yAlpha y def
   0                   % 0
   5 {                                % ((x & 0b001..1) [*] y) (x >> i) (y [*] alpha[^i])
     xShift 1 and yAlpha mul xor      % ((x & 0b001..1) [*] y [+] ((x >> i) & 1) * (y [*] alpha [^i]))
     /xShift xShift -1 bitshift def
     /yAlpha yAlpha gf32mulalpha def
   } repeat            % ((x & 0b11111) [*] y)
 } ifelse            % if (y >= 32 || x >= 32) then 32 else (x [*] y)
 end
} bind def

/gf32inv % x -> x [^-1] where [^-1] is the inverse operation in GF32.
         % returns 0 when given 0.
         % returns 32 if x is out of range.
{                        % x
 dup dup gf32mul         % x x[^2]
 dup gf32mul gf32mul     % x[^5]
 dup dup gf32mul gf32mul % x[^15]
 dup gf32mul             % x[^30]
                         % x[^-1]
} bind def

/lagrange % x xj [x[0] .. x[k]] -> l[j](x)
          % returns the lagrange basis polynomial l[j] evaluated at x for interpolation of coordinates [x[0] .. x[k]].
          % Requires xj `elem` [x[0] ... x[k]]
{               % x xj [x[0] .. x[k]]
 10 dict begin
 { /xs /xj /x } {exch def} forall
 1 xs           % 1 [x[0] .. x[k]]
 {                % let P = product [(x [-] x[m]) [/] (xj [-] x[m]) | m <- [0..i-1], x[m] /= xj]
                  % P x[i]
   /xi exch def   % P
   xi xj gf32add  % P (xj [-] x[i])
   dup 0 eq       % P (xj [-] x[i]) (xj [-] x[i] == 0)
   { pop }                 % P
   { gf32inv gf32mul       % (P [/] (xj [-] x[i])
     xi x gf32add gf32mul  % (P [*] (x [-] x[i]) [/] (xj [-] x[i]))
   }
   ifelse         % (if xj == x[i] then P else (P [*] (x [-] x[i]) [/] (xj [-] x[i]))
 } forall       % x xj (product [(x [-] x[m]) [/] (xj [-] x[m]) | m <- [0..k], x[m] /= xj])
 end
} bind def

/makeShare % sS sA i -> si
       { 3 2 roll 1 index permS 0 get permS 0 2 getinterval lagrange gf32mul
         3 1 roll permS 1 get permS 0 2 getinterval lagrange gf32mul
         xor
       } bind def

/gf32mularray % x b -> x * b
  { [ 3 1 roll { 1 index gf32mul exch } forall pop ]
  } bind def

/gf32addarray % a b -> a + b pointwise
  { [ 3 1 roll 0 1 2 index length 1 sub { 2 index 1 index get 2 index 2 index get gf32add exch pop 3 1 roll } for pop pop ]
  } bind def

%******************
%* Code Parameters
%*
%* Data related to the representation of GF(32) elements
%*

/perm [29 24 13 25 9 8 23 18 22 31 27 19 1 0 3 16 11 28 12 14 6 4 2 15 10 17 21 20 26 30 7 5 ] def
/permS [16 29 24 13 25 9 8 23 18 22 31 27 19 1 0 3 11 28 12 14 6 4 2 15 10 17 21 20 26 30 7 5 ] def
/permV [22 11 10 29 31 28 17 24 27 12 21 13 19 14 20 25 1 6 26 9 0 4 30 8 3 2 7 23 16 15 5 18 ] def
/permId [ 0 1 31 {} for ] def

/code [/Q /P /Z /R /Y /nine /X /eight /G /F /two /T /V /D /W /zero /S /three /J /N /five /four /K /H /C /E /six /M /U /A /seven /L /space] def
/code2 [/multiply /aleph /alpha /beta /Gamma /Delta /epsilon /eta /Theta /Lambda /mu /Xi /Pi /rho /Sigma /Phi /Psi /Omega /at /numbersign /percent /cent /yen /Euro /currency /circleplus /dagger /daggerdbl /section /paragraph /diamond /heart /space ] def

/decode {
 [ exch { <<
113 0
81 0
112 1
80 1
122 2
90 2
114 3
82 3
121 4
89 4
57 5
120 6
88 6
56 7
103 8
71 8
102 9
70 9
50 10
116 11
84 11
118 12
86 12
100 13
68 13
119 14
87 14
48 15
115 16
83 16
51 17
106 18
74 18
110 19
78 19
53 20
52 21
107 22
75 22
104 23
72 23
99 24
67 24
101 25
69 25
54 26
109 27
77 27
117 28
85 28
97 29
65 29
55 30
108 31
76 31
32 32
 >> exch get } forall ]
} bind def

%******************
%* BCH
%*
%* Data and functions related to the error-correcting code.
%*
/polymodulus [ 25 27 17 8 0 25 25 25 31 27 24 16 16] def % coefficents from c12 to c0
/checksum [16 25 24 3 25 11 16 23 29 3 25 17 10] def
/checksumstring { polymodulus length array checksum 0 1 polymodulus length 1 sub {3 copy exch 1 index get code exch 1 getinterval putinterval pop } for pop } bind def

/polymod0 % array -> [ c5 c4 c3 c2 c1 c0 ]
 { [ polymodulus length {0} repeat ]
   exch
   { [ exch 2 index 1 polymodulus length 1 sub getinterval aload pop polymodulus length dup 1 sub roll ] exch 0 get polymodulus gf32mularray gf32addarray  } forall
 } bind def

/polymodshift2 % c7 c6 -> [ c5 c4 c3 c2 c1 c0 ]
 {  [ 3 1 roll polymodulus length {0} repeat ] polymod0
 } bind def

/polymodhrp % string -> [ c5 c4 c3 c2 c1 c0 ]
 {
   [ exch 1 exch dup { dup dup 65 ge exch 90 le exch and { 32 add } if 32 idiv exch } forall 0 exch { 31 and } forall ] polymod0
 } bind def

%************************************************************************
%************************************************************************
%*
%* Section Two: Graphics
%*
%************************************************************************
%************************************************************************

%******************
%* Helper Functions and Utilities
%*
/nullFont <<
  /face /Times-Roman
  /size 12
  /yDisp 0
  /rgbColor [ 0 0 0 ]
>> def

/textFont <<
  /face /Times-Roman
  /boldface /Times-Bold
  /italicface /Times-Italic
  /ttface /Courier
  /size 12
  /footnotesize 10
  /yDisp 13
  /rgbColor [ 0 0 0 ]
>> def

/sectionFont <<
  /face /Times-Roman
  /italicface /Times-Italic
  /size 32
  /yDisp 32
  /rgbColor [ 0.820 0.204 0.220 ]
>> def

/subSectionFont <<
  /face /Times-Roman
  /italicface /Times-Italic
  /size 24
  /yDisp 20
  /rgbColor [ 0.820 0.204 0.220 ]
>> def

/subSubSectionFont <<
  /face /Times-Roman
  /size 18
  /yDisp 20
  /rgbColor [ 0.820 0.204 0.220 ]
>> def


/pgsize currentpagedevice /PageSize known
  { currentpagedevice /PageSize get
  } {
    [611.842163 791.842163] % letter size
  } ifelse
def

20 dict dup /portraitPage exch def begin
  pgsize aload pop [ /pageH /pageW ] { exch def } forall
  /centerX pageW 2 div def
  /centerY pageH 2 div def
  /marginX1 36 def
  /marginX2 pageW 36 sub def
  /marginY1 pageH 48 sub def
  /marginY2 48 def
  /marginW marginX2 marginX1 sub def
  /marginH marginY2 marginY1 sub def

  % Draw a line indicating where the margins of the page are; can be used
  % for debugging graphical output
  /drawMargin {
    gsave
      0 setgray thin line
      marginX1 marginY1 marginW marginH rectstroke
    grestore
  } bind def

  % Draw the page number and any (TODO) content in the page content array
  % Takes the pagenum as a numeric value
  /drawPageContent {
    10 dict begin
    /pagenum exch def
    % Page content
    gsave
      allPageContent pagenum get drawPageContentInner
    grestore
    % Footer
    gsave
      /Times-Roman findfont 12 scalefont setfont
      centerX marginY2 moveto
      pagenum pagenum 10 lt { 1 } { 2 } ifelse string cvs show
      % version
      /Courier findfont 8 scalefont setfont
      marginX1 marginY2 moveto
      (03-31-alpha) show
    grestore
    end
  } bind def
end

% landscapePage is a modified copy of portraitPage
portraitPage dup 20 dict copy dup /landscapePage exch def begin
  pgsize aload pop exch [ /pageH /pageW ] { exch def } forall
  /centerX pageW 2 div def
  /centerY pageH 2 div def
  /marginX1 36 def
  /marginX2 pageW 36 sub def
  /marginY1 pageH 48 sub def
  /marginY2 48 def
  /marginW marginX2 marginX1 sub def
  /marginH marginY1 marginY2 sub def

  /drawPageContent {
    90 rotate
    0 pageH neg translate
    portraitPage /drawPageContent get exec
  } bind def
end

% line : width --

/marginpath {
10 dict begin
  pgsize aload pop
  /h exch def /w exch def
  /margin 18 def
  newpath
  margin margin moveto
  w margin sub margin lineto
  w margin sub h margin sub lineto
  margin h margin sub lineto
  closepath
end } bind def

% line : width --
/line {
  setlinewidth
  1 setlinecap
  1 setlinejoin
  [] 0 setdash
} bind def

/verythin 0.2 def
/thin 0.4 def
/thick 0.8 def
/verythick 1.2 def

/pen {
  50 setlinewidth
  1 setlinecap
  1 setlinejoin
  [] 0 setdash
} bind def

% Runs stroke under a uniformly scaled matrix.
% ps2pdf doesn't seem to handle strokes under a non-uniformly scaled matrix properly.
/resetstroke {
matrix currentmatrix
  dup determinant abs
  initmatrix
  matrix currentmatrix determinant abs div
  sqrt dup scale
  stroke
setmatrix
} bind def

/brass { 0.7098 0.651 0.2588 } def
/pink { 1 0.9 0.9 } def

/substitute <<
  /Omega /uni03A9
  /circleplus /uni2295
>> def

% codexshow : /glyph size --
/codexshow {
10 dict begin
  /sz exch def
  /charname exch def
  /basefont /Courier findfont def
  /basechars basefont /CharStrings get def
  /backupfont /Symbol findfont def
  substitute charname known basechars charname known not and
    { basechars substitute charname get known { /charname substitute charname get def } if } if
  basechars charname known
  { basefont sz scalefont setfont charname glyphshow }
  { backupfont sz scalefont setfont charname glyphshow } ifelse
end
} bind def

/withcrosses true def
% draftingshow : /glyph size --
/draftingshow {
gsave
10 dict begin
  currentpoint translate
  1000 div dup scale
  [1 0 10 tan 1 -100 -100] concat
  <<
  /space { }
  /A { newpath
         100 100 moveto
         400 700 lineto
         700 100 lineto
         200 300 moveto
         600 300 lineto
       pen stroke }
  /C { newpath
         400 400 300 2 3 arccos -2 3 arccos 180 add arc
       pen stroke }
  /D { newpath
         100 100 moveto
         300 400 300 270 90 arc
         100 700 lineto
         closepath
       pen stroke }
  /E { newpath
         600 700 moveto
         100 700 lineto
         100 100 lineto
         600 100 lineto
         100 400 moveto
         400 400 lineto
       pen stroke }
  /F { newpath
         600 700 moveto
         100 700 lineto
         100 100 lineto
         100 400 moveto
         400 400 lineto
       pen stroke }
  /G { newpath
         400 400 300 2 3 arccos -2 3 arccos 180 add arc
         600 400 lineto
         400 400 lineto
       pen stroke }
  /H { newpath
         600 700 moveto
         600 100 lineto
         100 700 moveto
         100 100 lineto
         100 400 moveto
         600 400 lineto
       pen stroke }
  /J { newpath
         600 700 moveto
         matrix currentmatrix
         100 100 translate
         1 4 5 div scale
         250 250 250 0 180 arcn
         setmatrix
       pen stroke }
  /L { newpath
         100 700 moveto
         100 100 lineto
         600 100 lineto
       pen stroke }
  /K { newpath
         600 700 moveto
         100 300 lineto
         100 700 moveto
         100 100 lineto
         300 460 moveto
         600 100 lineto
       pen stroke }
  /M { newpath
         100 100 moveto
         100 700 lineto
         400 100 lineto
         700 700 lineto
         700 100 lineto
       pen stroke }
  /N { newpath
         600 700 moveto
         600 100 lineto
         100 700 lineto
         100 100 lineto
       pen stroke }
  /P { newpath
         100 400 moveto
         450 550 150 270 90 arc
         100 700 lineto
         100 100 lineto
       pen stroke }
  /Q { newpath
         400 400 300 0 360 arc
         500 250 moveto
         600 100 lineto
       pen stroke }
  /R { newpath
         100 400 moveto
         450 550 150 270 90 arc
         100 700 lineto
         100 100 lineto
         400 400 moveto
         600 100 lineto
       pen stroke }
  /S { newpath
         matrix currentmatrix
         100 100 translate
         5 3 div 1 scale
         150 150 150 -90 1 3 arccos sub 90 arc
         setmatrix
         matrix currentmatrix
         150 400 translate
         4 3 div 1 scale
         150 150 150 270 90 1 3 arccos sub arcn
         setmatrix
         withcrosses {
          350 50 moveto
          350 750 lineto
         } if
       pen stroke }
  /T { newpath
         100 700 moveto
         700 700 lineto
         400 700 moveto
         400 100 lineto
       pen stroke }
  /U { newpath
         600 700 moveto
         matrix currentmatrix
         100 100 translate
         1 4 5 div scale
         250 250 250 0 180 arcn
         setmatrix
         100 700 lineto
       pen stroke }
  /V { newpath
         100 700 moveto
         400 100 lineto
         700 700 lineto
       pen stroke }
  /W { newpath
         100 700 moveto
         300 100 lineto
         500 700 lineto
         700 100 lineto
         900 700 lineto
       pen stroke }
  /X { newpath
         100 100 moveto
         650 700 lineto
         150 700 moveto
         700 100 lineto
       pen stroke }
  /Y { newpath
         100 700 moveto
         400 400 lineto
         700 700 lineto
         400 400 moveto
         400 100 lineto
       pen stroke }
  /Z { newpath
         100 700 moveto
         600 700 lineto
         100 100 lineto
         600 100 lineto
         withcrosses {
          200 400 moveto
          500 400 lineto
         } if
       pen stroke }
  /zero { newpath
         matrix currentmatrix
         100 100 translate
         5 6 div 1 scale
         300 300 300 0 360 arc
         setmatrix
         withcrosses {
          100 100 moveto
          600 700 lineto
         } if
       pen stroke }
  /two { newpath
         matrix currentmatrix
         150 400 translate
         4 3 div 1 scale
         150 150 150 90 1 3 arccos add -90 arcn
         setmatrix
         matrix currentmatrix
         100 -200 translate
         5 6 div 1 scale
         300 300 300 90 180 arc
         setmatrix
         600 100 lineto
       pen stroke }
  /three { newpath
         matrix currentmatrix
         100 100 translate
         5 3 div 1 scale
         150 150 150 -90 1 3 arccos sub 90 arc
         setmatrix
         matrix currentmatrix
         150 400 translate
         4 3 div 1 scale
         150 150 150 -90 90 1 3 arccos add arc
         setmatrix
       pen stroke }
  /four { newpath
         500 100 moveto
         500 700 lineto
         100 250 lineto
         600 250 lineto
       pen stroke }
  /five { newpath
         matrix currentmatrix
         100 100 translate
         5 4 div 1 scale
         200 200 200 -90 1 2 arccos sub 180 4 5 arccos sub arc
         setmatrix
         150 700 lineto
         550 700 lineto
       pen stroke }
  /six { newpath
         matrix currentmatrix
         100 100 translate
         5 6 div 1 scale
         300 300 300 90 2 3 arccos sub 270 arc
         setmatrix
         matrix currentmatrix
         100 100 translate
         5 4 div 1 scale
         200 200 200 -90 90 arc
         setmatrix
       pen stroke
         newpath
         matrix currentmatrix
         100 100 translate
         5 6 div 1 scale
         300 300 300 0 360 arc
         setmatrix
         clip
         newpath
         matrix currentmatrix
         100 100 translate
         5 4 div 1 scale
         200 200 200 90 180 arc
         setmatrix
       stroke }
  /seven { newpath
         100 700 moveto
         600 700 lineto
         400 400 300 300 300 100 curveto
         withcrosses {
          300 400 moveto
          500 400 lineto
         } if
       pen stroke }
  /eight { newpath
         matrix currentmatrix
         100 100 translate
         5 3 div 1 scale
         150 150 150 90 450 arc
         setmatrix
         matrix currentmatrix
         150 400 translate
         4 3 div 1 scale
         150 150 150 -90 270 arc
         setmatrix
       pen stroke }
  /nine { newpath
         matrix currentmatrix
         100 100 translate
         5 6 div 1 scale
         300 300 300 -90 2 3 arccos sub 90 arc
         setmatrix
         matrix currentmatrix
         100 300 translate
         5 4 div 1 scale
         200 200 200 90 -90 arc
         setmatrix
       pen stroke
         newpath
         matrix currentmatrix
         100 100 translate
         5 6 div 1 scale
         300 300 300 0 360 arc
         setmatrix
         clip
         newpath
         matrix currentmatrix
         100 300 translate
         5 4 div 1 scale
         200 200 200 -90 0 arc
         setmatrix
       stroke }
  >>
  exch get exec
end
grestore
} bind def

/glyphwidth {
  gsave
  nulldevice newpath 0 0 moveto glyphshow currentpoint
  grestore
} bind def

/codexwidth {
  gsave
  nulldevice newpath 0 0 moveto codexshow currentpoint
  grestore
} bind def

/draftingwidth {
  exch
32 dict begin
  /M 800 def
  /N 700 def
  /W 1000 def
  /A M def
  /C N def
  /D N def
  /E N def
  /F N def
  /G N def
  /H N def
  /J N def
  /K N def
  /L N def
  /P N def
  /Q M def
  /R N def
  /S N def
  /T M def
  /U N def
  /V M def
  /X M def
  /Y M def
  /Z N def
  /zero N def
  /two N def
  /three N def
  /four N def
  /five N def
  /six N def
  /seven N def
  /eight N def
  /nine N def
  /space N def
  load
end
  mul 1000 div
  0
} bind def

/underlinecodexshow {
    exch
    dup dup /six eq exch /nine eq or { % if the string is (6) or (9)
        gsave /underscore 2 index codexshow grestore % draw an underline
    } if
    exch codexshow
} bind def

/underlineshow {
    dup dup /six eq exch /nine eq or { % if the string is (6) or (9)
        gsave /underscore glyphshow grestore % draw an underline
    } if
    glyphshow
} bind def

/centreshow {dup stringwidth pop 2 div neg 0 rmoveto show} bind def

/centreglyphshow {dup glyphwidth pop 2 div neg 0 rmoveto underlineshow} bind def

/centrecodexshow {2 copy codexwidth pop 2 div neg 0 rmoveto underlinecodexshow} bind def

/centresquare {dup neg 2 div dup rmoveto dup 0 rlineto dup 0 exch rlineto neg 0 rlineto closepath stroke} bind def

/centredraftingshow {2 copy draftingwidth pop 2 div neg 0 rmoveto draftingshow} bind def

% From BLUEBOOK Program #10
/outsidecircletext
  { circtextdict begin
      /radius exch def
      /centerangle exch def
      /ptsize exch def
      /str exch def
      /xradius radius ptsize 4 div add def

      gsave
        centerangle str findhalfangle add rotate

        str
          { /charcode exch def
            ( ) dup 0 charcode put outsideplacechar
          } forall
      grestore
    end
  } def

/insidecircletext
{ circtextdict begin
  /radius exch def /centerangle exch def
  /ptsize exch def /str exch def
  /xradius radius ptsize 3 div sub def
  gsave
   centerangle str findhalfangle sub rotate
   str
    { /charcode exch def
      ( ) dup 0 charcode put insideplacechar
    } forall
  grestore
  end
} def

/circtextdict 16 dict def
circtextdict begin
 /findhalfangle
  { stringwidth pop 2 div
    2 xradius mul pi mul div 360 mul
  } def

/outsideplacechar
    { /char exch def
      /halfangle char findhalfangle def
      gsave
        halfangle neg rotate
        radius 0 translate
        -90 rotate
        char stringwidth pop 2 div neg 0 moveto
        char show
      grestore
      halfangle 2 mul neg rotate
    } def

/insideplacechar
 { /char exch def
   /halfangle char findhalfangle def
   gsave
    halfangle rotate
    radius 0 translate
    90 rotate
    char stringwidth pop 2 div neg 0 moveto
    char gsave dup false charpath 1 setlinewidth stroke grestore 1 setgray show
   grestore
   halfangle 2 mul rotate
 } def

/pi 3.1415923 def
end

%******************
%* Content Rendering
%*
%* The bulk of the text is rendered using this streaming parser.
%*

% Shows a dropcap (giant letter with a bounding box around it)
%
% Takes coordinates to start drawing at, and the character to draw
% the bounding box in. Returns the height and width of the bounding
% box
/drawDropcap { % x y strdata -> h w
  10 dict begin
  gsave
    /Times-Roman findfont 64 scalefont setfont
    3 copy pop moveto

    gsave
      dup false charpath strokepath flattenpath pathbbox
      { /y2 /x2 /y1 /x1 } {exch def} forall
      % Flip box so it is going downward rather than upward
      /y2 y1 2 mul y2 sub store
    grestore

    % Draw letter
    0 y2 y1 sub rmoveto
    gsave
      dup true charpath
      x1 y2 moveto x1 y1 lineto x2 y1 lineto x2 y2 lineto closepath
      0.820 0.204 0.220 setrgbcolor
      % TODO Replace with a pattern fill.
      fill
    grestore
    dup false charpath
    x1 y2 moveto x1 y1 lineto x2 y1 lineto x2 y2 lineto closepath
    1 setlinewidth
    stroke

    % Return width and height
    pop pop
    x2 x1 sub
    y1 y2 sub
  grestore
  end
} bind def

/showWordControlDict <<
  ($) {
    italicOn {
      currentFont /face get findfont currentFont /size get scalefont setfont
    } {
      currentFont /italicface get findfont currentFont /size get scalefont setfont
    } ifelse
    /italicOn italicOn not store
  }
  (*) {
    boldOn {
      currentFont /face get findfont currentFont /size get scalefont setfont
    } {
      currentFont /boldface get findfont currentFont /size get scalefont setfont
    } ifelse
    /boldOn boldOn not store
  }
  (`) {
    ttOn {
      currentFont /face get findfont currentFont /size get scalefont setfont
    } {
      currentFont /ttface get findfont currentFont /size get scalefont setfont
    } ifelse
    /ttOn ttOn not store
  }
>> def

% Displays a single word on the current device with the current font
% Returns the number of points before the end of the line, which will be
% negative in case of an overrun
/showWord { % word kernX -> distance to marginX2
  10 dict begin
  {/actuallyDraw /kernX /word} { exch def } forall

  <<
    /nametype {
      currentpoint {/y /x} { exch def } forall

      <<
        /footnotemark {
          /footnoteCount footnoteCount 1 add store
          % We need to idiv the footnote count by two since we double-increment
          % it accidentally (once when simulating and once when actually drawing)
          footnoteCount 2 idiv 2 string cvs
          gsave
            currentFont /face get findfont 6 scalefont setfont
            0 5 rmoveto
            actuallyDraw {
              show
            } {
              stringwidth pop 0 rmoveto
            } ifelse
          grestore
          % Adjust kerning because /footnotemark is a word
          kernX 0 rmoveto
          % Add an actual space though so the footnote isn't too crammed
          actuallyDraw { ( ) show } { ( ) stringwidth pop 0 rmoveto } ifelse
        }
      >> dup
      word known { word get exec } { pop } ifelse
      1 % arbitrary positive return value
    }
    /stringtype {
      word length 0 gt {
        % Prepend kerning (we expect the caller to set 0 kerning on the first word)
        kernX 0 rmoveto
        % Draw the actual word
        0 1 word length 1 sub {
          word exch 1 getinterval
          showWordControlDict 1 index known {
            showWordControlDict exch get exec
          } {
            actuallyDraw {
              show
            } {
              stringwidth rmoveto
            } ifelse
          } ifelse
        } for
        marginX2 currentpoint pop sub % compute return value prior to trailing space
        ( ) show % print a space so that copy/paste has a hope of working
      } { 0 } ifelse
    }
  >> begin word type exec end

  end
} bind def

% Takes as input a single page's contents and draws it
/drawPageContentInner { % x y [page content] -> nothing
  20 dict begin
  /pagecontent exch def

  marginX1 marginY1 moveto

  % state machine
  /buffer 200 string def
  <<
    % state
    /state /buffering
    /currentFont nullFont
    /x marginX1
    /y marginY1
    /dropcapWidth 0
    /dropcapHeight 0
    /wordBuffer 100 array
    /wordN 0
    /totalKern 0
    /footnoteCount 0
    /listItemCount 0
    /sublistItemCount 0
    /ttOn false
    /boldOn false
    /italicOn false

    /offsetX {
      x add /x exch store
      x y moveto
    }

    /offsetY {
      y dropcapHeight lt not % if we currently aren't past the dropcap...
      exch y add /y exch store
      y dropcapHeight lt and { % ...but after moving, we are...
        dropcapWidth neg offsetX % ...then shift x back to its original value
      } if
      x y moveto
    }

    /setCurrentFont {
      /currentFont exch store
      currentFont /face get findfont
      currentFont /size get scalefont
      setfont
      currentFont /rgbColor get aload pop setrgbcolor
    }

    % Output text, buffering mode (needed for fill justification)
    /buffering {
      /word exch def

      % Simulate writing the word, to see if it causes an overrun. If so...
      word 0 false showWord dup 0 lt {
        % ...dump the previous line, with kerning
        totalKern wordN 1 gt { wordN 1 sub div } if dumpLastLine
        currentFont /yDisp get neg offsetY
        % ...then retry the word
        pop word buffering exec
      } {
        % ...otherwise, add word to buffer for next line's display
        /totalKern exch store
        wordBuffer wordN word put
        /wordN wordN 1 add store
      } ifelse
    }

    % Draw the contents of the current line buffer and flush it
    /dumpLastLine {
      x y moveto
      wordN 0 gt {
        wordBuffer 0 get 0 true showWord pop
        wordBuffer 1 wordN 1 sub getinterval {
          1 index true showWord pop
        } forall
      } if
      pop
      /wordN 0 store
    }

    /doLineBreak {
      0 dumpLastLine
      currentFont /yDisp get neg offsetY
    }

    % Output a dropcap
    /dropcapOneshot {
      % show dropcap, bumped up a bit
      x exch y 8 add exch drawDropcap
      % Store dropcap width and height of the bottom of the dropcap
      /dropcapHeight exch y sub neg store
      /dropcapWidth exch 4 add store
      % Move x and switch back to normal text mode
      dropcapWidth offsetX
      /state /buffering store
    }

    % content parsing
    /stringtype {
      { % loop through words in the string
        ( ) search {
          exch pop
          state load exec % Execute current state on word
        } {
          state load exec % Execute current state on last word
          exit
        } ifelse
      } loop
    }
    /nametype {
      <<
        /notoc {} % just eat table-of-contents token
        /toc {} % just eat table-of-contents token
        /dropcap { /state /dropcapOneshot store }
        /linebreak { doLineBreak }
        /paragraph { doLineBreak doLineBreak }
        /startlist { /listItemCount 0 store }
        /startsublist { /sublistItemCount 0 store }
        /listitem* {
          doLineBreak
          /y y 4 sub store
          /x x 24 add store
          x y moveto
          /bullet glyphwidth 8 add neg 0 rmoveto
          /bullet glyphshow
          x y moveto
        }
        /listitem1 {
          doLineBreak
          /listItemCount listItemCount 1 add store
          /y y 4 sub store
          /x x 24 add store
          x y moveto
          -5 0 rmoveto
          listItemCount 2 string cvs
          dup stringwidth pop neg 0 rmoveto show
          (.) show
          x y moveto
        }
        /sublistitem1 {
          doLineBreak
          /sublistItemCount sublistItemCount 1 add store
          /y y 4 sub store
          /x x 48 add store
          x y moveto
          -5 0 rmoveto
          sublistItemCount 2 string cvs
          dup stringwidth pop neg 0 rmoveto show
          (.) show
          x y moveto
        }
        /endsublistitem {
          0 dumpLastLine
          /x x 48 sub store
          x y moveto
        }
        /endlistitem {
          0 dumpLastLine
          /x x 24 sub store
          x y moveto
        }
        /startText {
          textFont setCurrentFont
          doLineBreak
        }
        /section {
          doLineBreak doLineBreak
          sectionFont setCurrentFont
          doLineBreak
        }
        /endsection {
          0 dumpLastLine
          % Draw underline
          currentpoint
          x y 4 sub moveto
          pop y 4 sub lineto 2 setlinewidth stroke

          doLineBreak
          textFont setCurrentFont
          /state /buffering store
        }
        /subsection {
          doLineBreak doLineBreak
          subSectionFont setCurrentFont
          doLineBreak
        }
        /endsubsection {
          0 dumpLastLine
          % Draw underline
          currentpoint
          x y 4 sub moveto
          pop y 4 sub lineto 1.5 setlinewidth stroke

          doLineBreak
          textFont setCurrentFont
          /state /buffering store
        }
        /subsubsection {
          doLineBreak doLineBreak
          subSubSectionFont setCurrentFont
          doLineBreak
        }
        /endsubsubsection {
          0 dumpLastLine
          % Draw underline
          currentpoint
          x y 4 sub moveto
          pop y 4 sub lineto 0.75 setlinewidth stroke

          doLineBreak
          textFont setCurrentFont
          /state /buffering store
        }
        /footnotes {
          0 dumpLastLine

          /footnoteCount 0 store
          /y y 12 sub store
          x y moveto x 100 add y lineto 0.5 setlinewidth stroke
          /y y 12 sub store
          x y moveto
          currentFont /face get findfont currentFont /footnotesize get scalefont setfont
        }
      >> exch 2 copy
      known {
        get exec
      } {
        % just pass unknown symbols to buffering so that they will wind up
        % in the line buffer, and take effect both during the simulated
        % (spacing-computing) layout and the real layout
        buffering pop
      } ifelse
    }
  >> begin
    pagecontent { dup type exec } forall
    0 dumpLastLine
  end

  end
} bind def

%******************
%* Volvelle and Slide Charts
%*
/magic 94 def % a magic angle for making nice looking spirals.
/drawBottomWheelPage
 { 10 dict begin
   /outerperm exch def
   /outercode exch def
   /innercode exch def
   /title exch def
   /binop exch def
   /angle 360 outerperm length div neg def
   % Move cursor to center of page
   pgsize aload pop 2 div exch 2 div exch translate
   % Draw white interior circle
   newpath 0 0 6 40 mul 0 360 arc stroke
   gsave verythin line
     newpath 0 0 6 40 mul 28 add 0 360 arc stroke
     newpath 0 0 6 0 360 arc stroke
   grestore
   % Draw title (small text, repeated)
   /Helvetica findfont 12 scalefont setfont
   title 12 270 30 insidecircletext
   % Draw letters (using human-centric ABCD... permutation)
   /Helvetica findfont 6 scalefont setfont
   gsave
   360 16 div 360 64 div sub rotate
   0 360 8 div 360 {title 6 3 -1 roll 262 outsidecircletext} for
   grestore
   outerperm {0 38 sqrt 40 mul moveto outercode exch get 18 centrecodexshow angle rotate} forall
   % Draw inside contents
   0 1 31 { % Draw 32 circles of increasing radius
       dup 1 add magic mul 24 add
       /theta exch def
       outerperm {
           1 index 2 add sqrt 40 mul 2 sub
           /lam exch def
           lam theta sin mul
           lam theta cos mul neg
           moveto
           0 -3 rmoveto
           1 index 31 exch sub % 31 - inner index
           permV exch get binop % apply binary operation to the permuted letter and the inner index
           innercode exch get 12 centrecodexshow % display the result
           angle rotate % rotate one entry
       } forall pop
   } for
   end
 } bind def

/showTopWheelPage
 {
   % Move cursor to center of page
   pgsize aload pop 2 div exch 2 div exch translate
   gsave verythin line
     newpath 0 0 6 40 mul 0 360 arc stroke
   grestore
   % Draw centre cross
   gsave verythin line
     newpath 0 6 moveto 0 -6 lineto stroke
     newpath 6 0 moveto -6 0 lineto stroke
   grestore
   % Draw indicator arrow
   newpath 0 6 40 mul moveto 10 -20 rlineto -20 0 rlineto closepath fill
   % Draw text
   0 1 31 {
       dup 1 add magic mul 24 add
       /theta exch def
       dup 2 add sqrt 40 mul 2 sub % lam = 40*sqrt(idx + 0.5) - 2
       /lam exch def
       newpath
       lam theta sin mul
       lam theta cos mul neg
      gsave
       newpath
       2 copy moveto
       8 8 rmoveto
       -36 0 rlineto
       0 -16 rlineto
       36 0 rlineto
       closepath
       gsave 0 setgray stroke grestore
       1 setgray fill
      grestore

       2 copy moveto
       12 centresquare % draw square
       moveto % return to midpoint
       -26 -3 rmoveto % Move to the left
       31 exch sub % 31 - loop index
       permV exch get code exch get % Permute index and extract 1-char substring of alphabet
       12 underlinecodexshow % ...and draw it
       /Symbol findfont 12 scalefont setfont /arrowright glyphshow % Draw a right arrow
   } for
 } bind def

% drawPointer : sz --
% draws a fillied triangle of sz pointing up (or down if sz is negative).
/drawPointer {
  /sz exch def
  0 sz eq not {
    sz 2 div sz neg rlineto sz neg 0 rlineto closepath fill
  } if
} bind def

% drawPin : sz --
% draws a sylized brass fasstener
/drawPin {
gsave
  /sz exch def
  currentpoint newpath moveto
  sz -2 div sz 3.5 mul rmoveto
  sz 0 rlineto
  sz 0 sz sz sz -2 div sz rcurveto
  sz -1.5 mul 0 sz -1.5 mul sz neg sz -2 div sz neg rcurveto
  0 sz -3 mul rlineto
  sz 2 div dup neg rlineto
  sz 2 div dup rlineto
  0 sz 3 mul rlineto
  closepath
  gsave brass setrgbcolor fill grestore
  thin line stroke
grestore
} bind def
% drawSplitPin : sz --
% draws a sylaized open brass fastener.
/drawSplitPin {
  /sz exch def
  currentpoint
  newpath moveto
  0 sz -3.5 mul rmoveto
  sz -2 div sz 3.5 mul rmoveto
  0 sz -3 mul rlineto
  sz 2 div dup neg rlineto
  sz 2 div dup rlineto
  0 sz 3 mul rlineto
  closepath
  sz 2 div sz 3.5 mul rmoveto
  sz 2 div sz -3.5 mul rmoveto
  0 sz 3 mul rlineto
  sz -2 div dup neg rlineto
  sz -2 div dup rlineto
  0 sz -3 mul rlineto
  closepath
  gsave brass setrgbcolor fill grestore
  gsave thin line stroke grestore
} bind def

% arrowHeadPath : x y r angle sz --
% creates an arrow head path for the end of a arc
/arrowHeadPath {
10 dict begin
  { /sz /angle /r /y /x } {exch def} forall
  matrix currentmatrix
    x y translate
    angle rotate
    r sz add sz neg moveto
    r 0 lineto
    sz neg dup rlineto
  setmatrix
end
} bind def

30 dict dup /multiplicationDisc exch def begin
  /radius 200 def
  /title (Multiplication) def
  /outerTitleSz 6 def
  /outerglyphSz 18 def
  /outerPointerSz 0 def
  /innerRadius { radius outerTitleSz outerglyphSz add sub outerPointerSz add } bind def
  /innerglyphSz { outerglyphSz } def
  /innerTitleSz 12 def
  /innerPointerSz 6 def
  /handlePointerSz -16 def
  % the fold line for the bottom disc is slightly less that the disc radius.
  /bottomfoldline { radius angle 2 div cos mul } bind def
  /topfoldline { radius 27 add } bind def
  /handlewidth 54 def

  /logbase 19 def
  /coding code2 def
  /numglyphs 31 def
  /angle 360 numglyphs div def
  /outerglyphs { [ [ 1 numglyphs 1 sub {dup logbase gf32inv gf32mul} repeat ] {coding exch get} forall ] } bind def
  /innerglyphs { outerglyphs } def

  /outlineBottomDisc {
      radius 0 moveto
      0 0 radius 0 360 arc
      4.5 0 moveto
      0 0 4.5 360 0 arcn
  } bind def

  /drawBottomDisc {
     % Draw white interior circle
     newpath
     outlineBottomDisc
     verythin line resetstroke
     newpath 0 0 innerRadius 0 360 arc thick line resetstroke
     % Draw letters
     gsave
       /Helvetica findfont outerTitleSz scalefont setfont
       360 8 div dup 2 div exch 360 {title outerTitleSz 3 -1 roll radius outerTitleSz sub outsidecircletext} for
     grestore
     outerglyphs {
       0 radius outerTitleSz outerglyphSz 0.8 mul add sub moveto outerglyphSz centrecodexshow
       % Draw indicator pointer
       0 innerRadius moveto outerPointerSz drawPointer
       angle rotate
     } forall
  } bind def

  /handleCapPath {
      handlewidth 2 div topfoldline 5 sub moveto
      handlewidth 2 div topfoldline handlewidth -2 div topfoldline 5 arct
      handlewidth -2 div topfoldline 2 copy 5 sub 5 arct
  } bind def
  /outlineTopDisc {
      handleCapPath
      0 0 innerRadius handlewidth 2 innerRadius mul arcsin dup 90 add exch 450 exch sub arc
      closepath
      /charwidth /space innerglyphSz codexwidth pop 1.2 mul def
      charwidth 2 div innerRadius outerPointerSz sub moveto
      charwidth 2 div neg innerRadius outerPointerSz sub lineto
      charwidth 2 div neg radius outerTitleSz sub lineto
      charwidth 2 div radius outerTitleSz sub lineto
      closepath
  } bind def

  /drawTopDisc {
     gsave decorateTopDisc grestore

     /charwidth /space innerglyphSz codexwidth pop 1.2 mul def

     % Draw handle
     gsave
       newpath innerRadius topfoldline moveto
       0 0 innerRadius 0 180 arc
       innerRadius neg topfoldline lineto
       closepath
       clip
       newpath
       handleCapPath
       handlewidth -2 div 0 lineto
       handlewidth 2 div 0 lineto
       closepath
       charwidth 2 div innerRadius outerPointerSz sub moveto
       charwidth 2 div neg innerRadius outerPointerSz sub lineto
       charwidth 2 div neg radius outerTitleSz sub lineto
       charwidth 2 div radius outerTitleSz sub lineto
       closepath
       0.8 setgray
       fill
     grestore

     % Draw indicator pointer
     0 radius outerTitleSz sub moveto handlePointerSz drawPointer

     gsave verythin line
       % Draw white interior circle
       newpath 0 0 innerRadius 0 360 arc resetstroke
       % Draw centre cross
       newpath 0 4.5 moveto 0 -4.5 lineto 4.5 0 moveto -4.5 0 lineto resetstroke
     grestore
     % Draw title
     gsave
       /Helvetica findfont innerTitleSz scalefont setfont
       title innerTitleSz 270 30 insidecircletext
     grestore
     % Draw letters
     innerglyphs {
        0 innerRadius innerglyphSz 0.8 mul sub innerPointerSz sub moveto innerglyphSz centrecodexshow
        % Draw indicator pointer
        0 innerRadius moveto innerPointerSz drawPointer
        angle rotate
     } forall
  } bind def
  /decorateTopDisc {
-45 rotate
0.8 setgray
% Potion fits into 0 0 380 380, but has rays going to the outside
% of the bounding box, so we shrink it further
0.85 0.85 scale
innerRadius 2 mul 177 div
innerRadius 2 mul 177 div scale
-177 2 div -177 2 div translate
drawPotion
} def
end

% /translationDisc is a modified copy of multiplicaitonDisc.
multiplicationDisc dup maxlength dict copy dup /translationDisc exch def begin
  /title (Translation) def
  /logbase 23 def
  /coding code def
  /handlePointerSz 0 def
  /decorateTopDisc {
gsave
% sun fits into 0 0 178 178
0.8 setgray
0.85 0.85 scale %% scale to match potion
innerRadius 2 mul 178 div
innerRadius 2 mul 178 div scale
-178 2 div -178 2 div translate
drawSun
grestore
    [/Q /arrowboth /Q]
    dup 0 exch {outerglyphSz 1.3 mul codexwidth pop add} forall -2 div outerglyphSz 0.75 mul moveto
    {outerglyphSz 1.3 mul codexshow} forall
  } bind def
end

% /recoveryDisc is a modified copy of multiplicaitonDisc.
multiplicationDisc dup maxlength dict copy dup /recoveryDisc exch def begin
  /title () def
  /logbase 10 def
  /outerglyphs {
     [ [ 1 numglyphs 1 sub {dup logbase gf32inv gf32mul} repeat ]
       {16 xor code exch get} forall ]
  } bind def
  /outerPointerSz -6 def
  /innerglyphs {
     [ [ 1 numglyphs 1 sub {dup logbase gf32inv gf32mul} repeat ]
       { 16 xor [ exch 17 ] 16 17 3 -1 roll lagrange
         dup 1 eq {pop 32} if
         code2 exch get
       } forall ]
  } bind def
  /innerPointerSz 0 def
  /decorateTopDisc {
gsave
/Helvetica findfont 8 scalefont setfont
0 154 moveto (share to) centreshow
0 146 moveto (translate) centreshow
0 160 moveto /arrowup 16 centrecodexshow
% Orb fits into 0 0 395 396, but for some reason needs some fine-tuning
0.85 0.85 scale %% scale to match potion
0.8 setgray
innerRadius 2 mul 312 div
innerRadius 2 mul 312 div scale
-156 -156 translate
% %%BoundingBox: 0 0 312 312
drawWheelLock
grestore
gsave
% manually draw some decorations to move text and whiten the cross
0 16 translate
       /Helvetica findfont innerTitleSz scalefont setfont
       (Recovery) innerTitleSz 270 30 insidecircletext
grestore
       % Draw centre cross
1 setgray
       newpath 0 4.5 moveto 0 -4.5 lineto 4.5 0 moveto -4.5 0 lineto resetstroke
  } bind def
end

% foldingBottomDiscs: angle1 angle2 --
% Renders an illustration of a folded multiplication and translation bottom disc pair.
/foldingBottomDiscs {
10 dict begin
  { /angle2 /angle1 } {exch def} forall

  matrix currentmatrix
  dup determinant /det exch def
    angle2 foldprojection concat
    translationDisc begin
      0 bottomfoldline translate
      180 rotate
      radius neg dup radius 2 mul radius bottomfoldline add rectclip
      gsave newpath outlineBottomDisc 1 setgray fill grestore
      matrix currentmatrix determinant det mul 0 gt
      { drawBottomDisc }
      { newpath outlineBottomDisc verythin line resetstroke }
      ifelse
      initclip
    end
  dup setmatrix
    angle1 foldprojection concat
    multiplicationDisc begin
      0 bottomfoldline neg translate
      radius neg dup radius 2 mul radius bottomfoldline add rectclip
      gsave newpath outlineBottomDisc 1 setgray fill grestore
      drawBottomDisc
      % draw fold line
      initclip
      0 0 radius 0 360 arc clip
      newpath radius bottomfoldline moveto radius -2 mul 0 rlineto verythin line resetstroke
      initclip
    end
  setmatrix
end
} bind def

%******************
%* Share Tables
%*
/showShareTable {
/offsety exch def
/offsetx exch def
/page exch def
/Courier findfont 10 scalefont setfont
20 offsetx add offsety moveto (Page: ) show
/Courier-Bold findfont 8 scalefont setfont
code page get glyphshow
2 1 31 {
dup 7 mul offsetx add offsety 10 sub moveto
permS exch get
code exch get glyphshow
} for

0 1 31 {
/Courier-Bold findfont 8 scalefont setfont
offsetx offsety 20 sub 2 index 8 mul sub moveto
dup code exch perm exch get get glyphshow
/Courier findfont 8 scalefont setfont
2 1 31 {
dup 7 mul offsetx add offsety 20 sub 3 index 8 mul sub moveto
permS exch get
page exch perm 3 index get exch  makeShare code exch get glyphshow
} for pop } for
} bind def

/showShareTablePage {
325 400 showShareTable
50 400 showShareTable
325 720 showShareTable
50 720 showShareTable
} bind def

%******************
%* Dice Worksheet
%*
%* Functionality for the dice worksheet - the tree and dice pads
%*

/drawDiceRow {
  10 dict begin
  % Characteristic size of the pads: equal to a side length for the square
  % pads, and 5/9 the side length for the hexagonal ones. (There is no good
  % mathematical reason for 5/9, it just fit the space requirements.)
  /sz 54 def

  gsave
    % Font for the numeric labels on the dice pads
    /Helvetica-Bold findfont 14 scalefont setfont

    % Draw label line
    gsave
      -4 sz 2 sqrt div add sz 2 sqrt div rmoveto
      -40 sz 2 sqrt div sub 0 rlineto stroke
    grestore
    % Draw six squares
    1 1 6 {
      /idx exch def
      /sz2 sz 2 sqrt div def

      % square
      gsave
        sz2 sz2 rlineto
        sz2 sz2 neg rlineto
        sz2 neg sz2 neg rlineto
        closepath gsave 0.95 setgray fill grestore stroke
      grestore
      % label
      gsave sz2 -5 rmoveto idx 2 string cvs centreshow grestore
      % move to origin for next iteration
      idx 2 mod 0 eq {
        sz2 sz2 neg rmoveto
        2 -2 rmoveto % add small gap
      } {
        sz2 sz2 rmoveto
        2 2 rmoveto % add small gap
      } ifelse
    } for

    % offset origin before starting hexagons, in an ad-hoc way
    sz2 2.5 div 2 sub dup neg 7 sub rmoveto

    % Draw 14 hexagons
    7 1 20 {
      /idx exch def
      /sz2 sz 1.8 div def % ad-hoc size adjustment

      % hexagon
      gsave
        0 sz2 rlineto
        sz2 3 sqrt mul 2 div sz2 2 div rlineto
        sz2 3 sqrt mul 2 div sz2 2 div neg rlineto
        0 sz2 neg rlineto
        sz2 3 sqrt mul 2 div neg sz2 2 div neg rlineto
        closepath gsave 0.95 setgray fill grestore stroke
      grestore
      % label
      gsave
        sz2 3 sqrt mul 2 div sz2 2 div 5 sub rmoveto
        idx 2 string cvs centreshow
      grestore
      % move to origin for next iteration
      idx 2 mod 0 eq {
        0 sz2 neg rmoveto
        sz2 3 sqrt mul 2 div sz2 2 div neg rmoveto
0 -8 rmoveto
      } {
        0 sz2 rmoveto
        sz2 3 sqrt mul 2 div sz2 2 div rmoveto
0 8 rmoveto
      } ifelse
    } for
  grestore
  end
} bind def

%******************
%* Checksum Worksheet
%*
%* Functionality for the checksum, addition, bit conversion, etc., worksheets,
%* to assist user manipulation of long bech32 strings
%*
/botalphabet (abcdefghijklmnopqrstuvwxyz) def

30 dict dup /ladder exch def begin
  /hrp (MS) def
  /sharelen 48 def
  /xsize 13 def
  /xgap 2 def
  /ysize -14 def
  /ygap -1 def
  /fsize 15 def
  /fgap 2.5 def
  /hrplen hrp length def
  /checksumlen checksum length def
  /numsteps sharelen hrplen sub checksumlen sub 2 idiv def
  /firstrowlen sharelen hrplen sub 1 sub numsteps 2 mul sub def
  /odd checksumlen firstrowlen sub def
  /initresidue [hrp polymodhrp aload pop firstrowlen {0} repeat ] polymod0 def
  /offset {
    dup ysize mul exch 2 idiv ygap mul add exch
    dup xsize mul exch 4 idiv xgap mul add exch
  } bind def

  /resetPos { pop } bind def
  /unresetPos { pop } bind def

  /drawrow {
  10 dict begin
  /nrows exch def

  /drawSingleRow {
    /drawTranslationSymbol exch def
    /drawShareIndex exch def
    gsave
      hrplen 1 add 48 sharelen 1 sub {
        /starti exch def
        /endi starti 47 add sharelen 1 sub min def

      /Courier findfont 3 scalefont setfont
      thick line
      % Draw share index & translation symbol
      drawShareIndex { 0 0 offset xsize ysize rectstroke } if
      drawTranslationSymbol { 1 0 offset exch xgap 3 mul add exch xsize ysize rectstroke } if

      % Draw main row contents
      thin line
      starti 1 endi {
        /i exch def
        i starti sub 3 add 0 offset 2 copy xsize ysize rectstroke moveto
        % upper-right index
        xsize 4.5 sub -3 rmoveto
        /n i 1 add def
        n 10 lt { ( ) show } if n 2 string cvs show
        % lower-left index
        i starti sub 3 add 0 offset ysize add moveto 1 1 rmoveto
        /idx i hrplen sub 1 sub def
        idx 26 gt { botalphabet idx 26 idiv 1 sub 1 getinterval show } if
        botalphabet idx 26 mod 1 getinterval show
      } for

0 nrows 2 mul offset translate
      } for
    grestore
  } bind def

  gsave
    true true drawSingleRow
    0 ysize translate true true drawSingleRow
    3 1 nrows {
      0 ysize ygap 3 mul add translate false false drawSingleRow
      0 ysize translate true true drawSingleRow
    } for
    0 ysize ygap 3 mul add translate true false drawSingleRow
  grestore

  end
  } bind def

  /drawgrid {
  10 dict begin
  gsave
    pink setrgbcolor
    0 2 checksumlen {
      /j exch def
      sharelen j add resetPos
      0 1 j checksumlen 2 mod add 1 sub {
        /i exch def
        i sharelen checksumlen sub add j numsteps 2 mul checksumlen 2 idiv 2 mul sub add offset xsize ysize rectfill
      } for
      sharelen j add unresetPos
    } for
  grestore
  gsave
    /Courier findfont 3 scalefont setfont
    % First (input) row
    thick line
    0 1 firstrowlen hrplen add {
      /i exch def
      i 0 offset 2 copy xsize ysize rectstroke moveto
      xsize 4.5 sub -3 rmoveto
      /n i 1 add def
      n 10 lt { ( ) show } if n 2 string cvs show
    } for

    % Second row (first non-input row)
    thin line
    0 1 firstrowlen 1 sub {
      hrplen 1 add add 1 offset xsize ysize rectstroke
    } for

    % Bottom-most row
    numsteps 2 mul resetPos
    0 1 checksumlen 1 sub {
      sharelen checksumlen sub add /i exch def
      thin line
      i numsteps 1 add 2 mul offset xsize ysize rectstroke
    } for
    numsteps 2 mul unresetPos

    1 1 numsteps {
      2 mul /j exch def
      j resetPos
      0 1 checksumlen 1 sub {
        hrplen add j add 1 sub odd sub /i exch def
        thin line
        i j sub hrplen odd sub le { % draw bottom-left numbers
          i j offset ysize add moveto 1 1 rmoveto
          /idx i 2 idiv j 2 idiv add 2 sub def
          idx 26 gt { botalphabet idx 26 idiv 1 sub 1 getinterval show } if
          botalphabet idx 26 mod 1 getinterval show
        } if
        i j offset xsize ysize rectstroke
        i 2 add j 1 add offset xsize ysize rectstroke
      } for
      thick line
      i 1 add j offset 2 copy xsize ysize rectstroke moveto
      xsize 4.5 sub -3 rmoveto
      /Courier findfont 3 scalefont setfont
      /n i 2 add def
      n 10 lt { ( ) show } if n 2 string cvs show
      i 2 add j offset 2 copy xsize ysize rectstroke moveto
      xsize 4.5 sub -3 rmoveto
      /n i 3 add def
      n 10 lt { ( ) show } if n 2 string cvs show
      j unresetPos
    } for

    /Helvetica-Bold findfont 10 scalefont setfont
    1 1 numsteps 1 add {
      2 mul /j exch def
      j 1 sub resetPos
      j hrplen add odd sub 2 sub j offset moveto xsize 0.7 mul 5 rmoveto (+) centreshow
      j 1 sub unresetPos
      j resetPos
      j hrplen add odd sub 2 sub j 1 add offset moveto xsize 0.7 mul 5 rmoveto (=) centreshow
      j unresetPos
    } for

    numsteps 2 mul resetPos
    numsteps 2 mul unresetPos
    /Courier findfont fsize scalefont setfont
    0 1 hrplen 1 sub {
      dup 0 offset moveto xsize 2 div ysize fgap add rmoveto hrp exch 1 getinterval centreshow
    } for
    hrplen 0 offset moveto xsize 2 div ysize fgap add rmoveto (1) centreshow
    0 1 checksumlen 1 sub {
      /i exch def
      i hrplen add 1 add odd sub 1 0 i eq {odd add} if offset moveto xsize 2 div ysize fgap add rmoveto initresidue i get code exch get fsize centrecodexshow
    } for
    0.85 setgray
    0 1 checksumlen 1 sub {
      /i exch def
      i sharelen checksumlen sub add numsteps 1 add 2 mul offset moveto xsize 2 div ysize fgap add rmoveto checksum i get code exch get fsize centrecodexshow
    } for
  grestore
  end
  } bind def % end /drawgrid

  /fillgrid {
  10 dict begin
  gsave
    /drawResidue exch def
    /drawBotDiag exch def
    /drawMiddle exch def
    /drawPink exch def
    /drawTopDiag exch def

    /data exch decode def
    /fsize fsize 2 sub def
    0 1 firstrowlen 1 sub {
     /i exch def
     i hrplen add 1 add 0 offset moveto xsize 2 div ysize fgap add rmoveto
     code data i get get fsize centredraftingshow
    } for
    /residue
      data 0 firstrowlen getinterval polymod0
      initresidue gf32addarray
    def
    0 2 numsteps 1 sub 2 mul {
      /y exch def
      /residue
      [ residue polymod0 aload pop
        data firstrowlen y add get
        data firstrowlen y add 1 add get
      ] def
      0 1 checksumlen 1 add {
        /i exch def
        /ispink i y add sharelen checksumlen sub hrplen sub 1 sub ge def
        i hrplen add y add 1 add odd sub 2 y add offset moveto xsize 2 div ysize fgap add rmoveto
        i 2 lt drawBotDiag and
        i checksumlen ge drawTopDiag and
        drawMiddle
        or or ispink { drawPink and } if {
          odd 1 eq 0 i eq and 0 y eq and not {code residue i get get fsize centredraftingshow} if
        } if
      } for
      /addrow residue 0 get residue 1 get polymodshift2 def
      0 1 checksumlen 1 sub {
        /i exch def
        i hrplen add y add 3 add odd sub 3 y add offset moveto xsize 2 div ysize fgap add rmoveto
        drawMiddle {
          code addrow i get get fsize centredraftingshow
        } if
      } for
    } for
    drawResidue {
      /residue residue polymod0 def
      0 1 checksumlen 1 sub {
        /i exch def
        i hrplen add numsteps 2 mul add 1 add 2 numsteps 2 mul add offset moveto xsize 2 div ysize fgap add rmoveto
        code residue i get get fsize centredraftingshow
      } for
    } if
  grestore
  end
  } bind def
end

% exampleladder is a copy of ladder
ladder dup 30 dict copy dup /exampleladder exch def begin
  /sharelen 32 def
  /numsteps sharelen hrplen sub checksumlen sub 2 idiv def
  /firstrowlen sharelen hrplen sub 1 sub numsteps 2 mul sub def
end

% bip3924ladder is a copy of ladder
ladder dup 30 dict copy dup /bip3924ladder exch def begin
  /hrp (BIP39_24W) def
  /hrplen hrp length def

  /sharelen 82 def
  /numsteps sharelen hrplen sub checksumlen sub 2 idiv def
  /firstrowlen sharelen hrplen sub 1 sub numsteps 2 mul sub def
  /odd checksumlen firstrowlen sub def
  /initresidue [hrp polymodhrp aload pop firstrowlen {0} repeat ] polymod0 def

  /resetPos {
      dup
      20 ge { -340 120 translate } if
      42 ge { -330 100 translate } if
  } bind def

  /unresetPos {
      dup
      20 ge { 340 -120 translate } if
      42 ge { 330 -100 translate } if
  } bind def
end

% bip3912ladder is a copy of ladder
ladder dup 30 dict copy dup /bip3912ladder exch def begin
  /hrp (BIP39_12W) def
  /hrplen hrp length def

  /resetPos {
      18 ge { -300 50 translate } if
  } bind def

  /unresetPos {
      18 ge { 300 -50 translate } if
  } bind def

  /sharelen 56 def
  /numsteps sharelen hrplen sub checksumlen sub 2 idiv def
  /firstrowlen sharelen hrplen sub 1 sub numsteps 2 mul sub def
  /odd checksumlen firstrowlen sub def
  /initresidue [hrp polymodhrp aload pop firstrowlen {0} repeat ] polymod0 def
end


/arraySpace 13 def
/gapSpace arraySpace 2 add def
/showArray {
  10 dict begin
  { /n /spaces /word } {exch def} forall
  0 1 spaces length 1 sub
    { code word n get get gsave 15 codexshow grestore
      spaces exch get 0 rmoveto
      /n n 1 add def
    } for
  end
} bind def

/showBox {
  10 dict begin
  { /n /spaces /word /decoration } {exch def} forall
  spaces { gsave n decoration grestore
      0 rmoveto
      /n n 1 add def
    } forall
  end
} bind def

/showArrayBox {
  4 copy gsave showBox grestore
  showArray pop
} bind def

/showParagraphs {
  10 dict begin
  { /paragraphs /height /width } {exch def} forall
  paragraphs {
    /lines exch def
    lines 0 lines length 1 sub getinterval {
      /line exch def
      % Compute amount of space needed for each /space character
      width line stringwidth pop sub 0 line { 32 eq { 1 add } if} forall div
      0 32 line gsave widthshow grestore
      0 height neg rmoveto
    } forall
    lines lines length 1 sub get gsave show grestore
    0 height neg 2 mul rmoveto
  } forall
  end
} bind def

/bip39words [
    (aban) (abil) (able) (abou) (abov) (abse) (abso) (abst) (absu) (abus) (acce) (acci) (acco) (accu) (achi) (acid)
    (acou) (acqu) (acro) (act ) (acti) (acto) (actr) (actu) (adap) (add ) (addi) (addr) (adju) (admi) (adul) (adva)
    (advi) (aero) (affa) (affo) (afra) (agai) (age ) (agen) (agre) (ahea) (aim ) (air ) (airp) (aisl) (alar) (albu)
    (alco) (aler) (alie) (all ) (alle) (allo) (almo) (alon) (alph) (alre) (also) (alte) (alwa) (amat) (amaz) (amon)
    (amou) (amus) (anal) (anch) (anci) (ange) (angl) (angr) (anim) (ankl) (anno) (annu) (anot) (answ) (ante) (anti)
    (anxi) (any ) (apar) (apol) (appe) (appl) (appr) (apri) (arch) (arct) (area) (aren) (argu) (arm ) (arme) (armo)
    (army) (arou) (arra) (arre) (arri) (arro) (art ) (arte) (arti) (artw) (ask ) (aspe) (assa) (asse) (assi) (assu)
    (asth) (athl) (atom) (atta) (atte) (atti) (attr) (auct) (audi) (augu) (aunt) (auth) (auto) (autu) (aver) (avoc)
    (avoi) (awak) (awar) (away) (awes) (awfu) (awkw) (axis) (baby) (bach) (baco) (badg) (bag ) (bala) (balc) (ball)
    (bamb) (bana) (bann) (bar ) (bare) (barg) (barr) (base) (basi) (bask) (batt) (beac) (bean) (beau) (beca) (beco)
    (beef) (befo) (begi) (beha) (behi) (beli) (belo) (belt) (benc) (bene) (best) (betr) (bett) (betw) (beyo) (bicy)
    (bid ) (bike) (bind) (biol) (bird) (birt) (bitt) (blac) (blad) (blam) (blan) (blas) (blea) (bles) (blin) (bloo)
    (blos) (blou) (blue) (blur) (blus) (boar) (boat) (body) (boil) (bomb) (bone) (bonu) (book) (boos) (bord) (bori)
    (borr) (boss) (bott) (boun) (box ) (boy ) (brac) (brai) (bran) (bras) (brav) (brea) (bree) (bric) (brid) (brie)
    (brig) (brin) (bris) (broc) (brok) (bron) (broo) (brot) (brow) (brus) (bubb) (budd) (budg) (buff) (buil) (bulb)
    (bulk) (bull) (bund) (bunk) (burd) (burg) (burs) (bus ) (busi) (busy) (butt) (buye) (buzz) (cabb) (cabi) (cabl)
    (cact) (cage) (cake) (call) (calm) (came) (camp) (can ) (cana) (canc) (cand) (cann) (cano) (canv) (cany) (capa)
    (capi) (capt) (car ) (carb) (card) (carg) (carp) (carr) (cart) (case) (cash) (casi) (cast) (casu) (cat ) (cata)
    (catc) (cate) (catt) (caug) (caus) (caut) (cave) (ceil) (cele) (ceme) (cens) (cent) (cere) (cert) (chai) (chal)
    (cham) (chan) (chao) (chap) (char) (chas) (chat) (chea) (chec) (chee) (chef) (cher) (ches) (chic) (chie) (chil)
    (chim) (choi) (choo) (chro) (chuc) (chun) (chur) (ciga) (cinn) (circ) (citi) (city) (civi) (clai) (clap) (clar)
    (claw) (clay) (clea) (cler) (clev) (clic) (clie) (clif) (clim) (clin) (clip) (cloc) (clog) (clos) (clot) (clou)
    (clow) (club) (clum) (clus) (clut) (coac) (coas) (coco) (code) (coff) (coil) (coin) (coll) (colo) (colu) (comb)
    (come) (comf) (comi) (comm) (comp) (conc) (cond) (conf) (cong) (conn) (cons) (cont) (conv) (cook) (cool) (copp)
    (copy) (cora) (core) (corn) (corr) (cost) (cott) (couc) (coun) (coup) (cour) (cous) (cove) (coyo) (crac) (crad)
    (craf) (cram) (cran) (cras) (crat) (craw) (craz) (crea) (cred) (cree) (crew) (cric) (crim) (cris) (crit) (crop)
    (cros) (crou) (crow) (cruc) (crue) (crui) (crum) (crun) (crus) (cry ) (crys) (cube) (cult) (cup ) (cupb) (curi)
    (curr) (curt) (curv) (cush) (cust) (cute) (cycl) (dad ) (dama) (damp) (danc) (dang) (dari) (dash) (daug) (dawn)
    (day ) (deal) (deba) (debr) (deca) (dece) (deci) (decl) (deco) (decr) (deer) (defe) (defi) (defy) (degr) (dela)
    (deli) (dema) (demi) (deni) (dent) (deny) (depa) (depe) (depo) (dept) (depu) (deri) (desc) (dese) (desi) (desk)
    (desp) (dest) (deta) (dete) (deve) (devi) (devo) (diag) (dial) (diam) (diar) (dice) (dies) (diet) (diff) (digi)
    (dign) (dile) (dinn) (dino) (dire) (dirt) (disa) (disc) (dise) (dish) (dism) (diso) (disp) (dist) (dive) (divi)
    (divo) (dizz) (doct) (docu) (dog ) (doll) (dolp) (doma) (dona) (donk) (dono) (door) (dose) (doub) (dove) (draf)
    (drag) (dram) (dras) (draw) (drea) (dres) (drif) (dril) (drin) (drip) (driv) (drop) (drum) (dry ) (duck) (dumb)
    (dune) (duri) (dust) (dutc) (duty) (dwar) (dyna) (eage) (eagl) (earl) (earn) (eart) (easi) (east) (easy) (echo)
    (ecol) (econ) (edge) (edit) (educ) (effo) (egg ) (eigh) (eith) (elbo) (elde) (elec) (eleg) (elem) (elep) (elev)
    (elit) (else) (emba) (embo) (embr) (emer) (emot) (empl) (empo) (empt) (enab) (enac) (end ) (endl) (endo) (enem)
    (ener) (enfo) (enga) (engi) (enha) (enjo) (enli) (enou) (enri) (enro) (ensu) (ente) (enti) (entr) (enve) (epis)
    (equa) (equi) (era ) (eras) (erod) (eros) (erro) (erup) (esca) (essa) (esse) (esta) (eter) (ethi) (evid) (evil)
    (evok) (evol) (exac) (exam) (exce) (exch) (exci) (excl) (excu) (exec) (exer) (exha) (exhi) (exil) (exis) (exit)
    (exot) (expa) (expe) (expi) (expl) (expo) (expr) (exte) (extr) (eye ) (eyeb) (fabr) (face) (facu) (fade) (fain)
    (fait) (fall) (fals) (fame) (fami) (famo) (fan ) (fanc) (fant) (farm) (fash) (fat ) (fata) (fath) (fati) (faul)
    (favo) (feat) (febr) (fede) (fee ) (feed) (feel) (fema) (fenc) (fest) (fetc) (feve) (few ) (fibe) (fict) (fiel)
    (figu) (file) (film) (filt) (fina) (find) (fine) (fing) (fini) (fire) (firm) (firs) (fisc) (fish) (fit ) (fitn)
    (fix ) (flag) (flam) (flas) (flat) (flav) (flee) (flig) (flip) (floa) (floc) (floo) (flow) (flui) (flus) (fly )
    (foam) (focu) (fog ) (foil) (fold) (foll) (food) (foot) (forc) (fore) (forg) (fork) (fort) (foru) (forw) (foss)
    (fost) (foun) (fox ) (frag) (fram) (freq) (fres) (frie) (frin) (frog) (fron) (fros) (frow) (froz) (frui) (fuel)
    (fun ) (funn) (furn) (fury) (futu) (gadg) (gain) (gala) (gall) (game) (gap ) (gara) (garb) (gard) (garl) (garm)
    (gas ) (gasp) (gate) (gath) (gaug) (gaze) (gene) (geni) (genr) (gent) (genu) (gest) (ghos) (gian) (gift) (gigg)
    (ging) (gira) (girl) (give) (glad) (glan) (glar) (glas) (glid) (glim) (glob) (gloo) (glor) (glov) (glow) (glue)
    (goat) (godd) (gold) (good) (goos) (gori) (gosp) (goss) (gove) (gown) (grab) (grac) (grai) (gran) (grap) (gras)
    (grav) (grea) (gree) (grid) (grie) (grit) (groc) (grou) (grow) (grun) (guar) (gues) (guid) (guil) (guit) (gun )
    (gym ) (habi) (hair) (half) (hamm) (hams) (hand) (happ) (harb) (hard) (hars) (harv) (hat ) (have) (hawk) (haza)
    (head) (heal) (hear) (heav) (hedg) (heig) (hell) (helm) (help) (hen ) (hero) (hidd) (high) (hill) (hint) (hip )
    (hire) (hist) (hobb) (hock) (hold) (hole) (holi) (holl) (home) (hone) (hood) (hope) (horn) (horr) (hors) (hosp)
    (host) (hote) (hour) (hove) (hub ) (huge) (huma) (humb) (humo) (hund) (hung) (hunt) (hurd) (hurr) (hurt) (husb)
    (hybr) (ice ) (icon) (idea) (iden) (idle) (igno) (ill ) (ille) (illn) (imag) (imit) (imme) (immu) (impa) (impo)
    (impr) (impu) (inch) (incl) (inco) (incr) (inde) (indi) (indo) (indu) (infa) (infl) (info) (inha) (inhe) (init)
    (inje) (inju) (inma) (inne) (inno) (inpu) (inqu) (insa) (inse) (insi) (insp) (inst) (inta) (inte) (into) (inve)
    (invi) (invo) (iron) (isla) (isol) (issu) (item) (ivor) (jack) (jagu) (jar ) (jazz) (jeal) (jean) (jell) (jewe)
    (job ) (join) (joke) (jour) (joy ) (judg) (juic) (jump) (jung) (juni) (junk) (just) (kang) (keen) (keep) (ketc)
    (key ) (kick) (kid ) (kidn) (kind) (king) (kiss) (kit ) (kitc) (kite) (kitt) (kiwi) (knee) (knif) (knoc) (know)
    (lab ) (labe) (labo) (ladd) (lady) (lake) (lamp) (lang) (lapt) (larg) (late) (lati) (laug) (laun) (lava) (law )
    (lawn) (laws) (laye) (lazy) (lead) (leaf) (lear) (leav) (lect) (left) (leg ) (lega) (lege) (leis) (lemo) (lend)
    (leng) (lens) (leop) (less) (lett) (leve) (liar) (libe) (libr) (lice) (life) (lift) (ligh) (like) (limb) (limi)
    (link) (lion) (liqu) (list) (litt) (live) (liza) (load) (loan) (lobs) (loca) (lock) (logi) (lone) (long) (loop)
    (lott) (loud) (loun) (love) (loya) (luck) (lugg) (lumb) (luna) (lunc) (luxu) (lyri) (mach) (mad ) (magi) (magn)
    (maid) (mail) (main) (majo) (make) (mamm) (man ) (mana) (mand) (mang) (mans) (manu) (mapl) (marb) (marc) (marg)
    (mari) (mark) (marr) (mask) (mass) (mast) (matc) (mate) (math) (matr) (matt) (maxi) (maze) (mead) (mean) (meas)
    (meat) (mech) (meda) (medi) (melo) (melt) (memb) (memo) (ment) (menu) (merc) (merg) (meri) (merr) (mesh) (mess)
    (meta) (meth) (midd) (midn) (milk) (mill) (mimi) (mind) (mini) (mino) (minu) (mira) (mirr) (mise) (miss) (mist)
    (mix ) (mixe) (mixt) (mobi) (mode) (modi) (mom ) (mome) (moni) (monk) (mons) (mont) (moon) (mora) (more) (morn)
    (mosq) (moth) (moti) (moto) (moun) (mous) (move) (movi) (much) (muff) (mule) (mult) (musc) (muse) (mush) (musi)
    (must) (mutu) (myse) (myst) (myth) (naiv) (name) (napk) (narr) (nast) (nati) (natu) (near) (neck) (need) (nega)
    (negl) (neit) (neph) (nerv) (nest) (net ) (netw) (neut) (neve) (news) (next) (nice) (nigh) (nobl) (nois) (nomi)
    (nood) (norm) (nort) (nose) (nota) (note) (noth) (noti) (nove) (now ) (nucl) (numb) (nurs) (nut ) (oak ) (obey)
    (obje) (obli) (obsc) (obse) (obta) (obvi) (occu) (ocea) (octo) (odor) (off ) (offe) (offi) (ofte) (oil ) (okay)
    (old ) (oliv) (olym) (omit) (once) (one ) (onio) (onli) (only) (open) (oper) (opin) (oppo) (opti) (oran) (orbi)
    (orch) (orde) (ordi) (orga) (orie) (orig) (orph) (ostr) (othe) (outd) (oute) (outp) (outs) (oval) (oven) (over)
    (own ) (owne) (oxyg) (oyst) (ozon) (pact) (padd) (page) (pair) (pala) (palm) (pand) (pane) (pani) (pant) (pape)
    (para) (pare) (park) (parr) (part) (pass) (patc) (path) (pati) (patr) (patt) (paus) (pave) (paym) (peac) (pean)
    (pear) (peas) (peli) (pen ) (pena) (penc) (peop) (pepp) (perf) (perm) (pers) (pet ) (phon) (phot) (phra) (phys)
    (pian) (picn) (pict) (piec) (pig ) (pige) (pill) (pilo) (pink) (pion) (pipe) (pist) (pitc) (pizz) (plac) (plan)
    (plas) (plat) (play) (plea) (pled) (pluc) (plug) (plun) (poem) (poet) (poin) (pola) (pole) (poli) (pond) (pony)
    (pool) (popu) (port) (posi) (poss) (post) (pota) (pott) (pove) (powd) (powe) (prac) (prai) (pred) (pref) (prep)
    (pres) (pret) (prev) (pric) (prid) (prim) (prin) (prio) (pris) (priv) (priz) (prob) (proc) (prod) (prof) (prog)
    (proj) (prom) (proo) (prop) (pros) (prot) (prou) (prov) (publ) (pudd) (pull) (pulp) (puls) (pump) (punc) (pupi)
    (pupp) (purc) (puri) (purp) (purs) (push) (put ) (puzz) (pyra) (qual) (quan) (quar) (ques) (quic) (quit) (quiz)
    (quot) (rabb) (racc) (race) (rack) (rada) (radi) (rail) (rain) (rais) (rall) (ramp) (ranc) (rand) (rang) (rapi)
    (rare) (rate) (rath) (rave) (raw ) (razo) (read) (real) (reas) (rebe) (rebu) (reca) (rece) (reci) (reco) (recy)
    (redu) (refl) (refo) (refu) (regi) (regr) (regu) (reje) (rela) (rele) (reli) (rely) (rema) (reme) (remi) (remo)
    (rend) (rene) (rent) (reop) (repa) (repe) (repl) (repo) (requ) (resc) (rese) (resi) (reso) (resp) (resu) (reti)
    (retr) (retu) (reun) (reve) (revi) (rewa) (rhyt) (rib ) (ribb) (rice) (rich) (ride) (ridg) (rifl) (righ) (rigi)
    (ring) (riot) (ripp) (risk) (ritu) (riva) (rive) (road) (roas) (robo) (robu) (rock) (roma) (roof) (rook) (room)
    (rose) (rota) (roug) (roun) (rout) (roya) (rubb) (rude) (rug ) (rule) (run ) (runw) (rura) (sad ) (sadd) (sadn)
    (safe) (sail) (sala) (salm) (salo) (salt) (salu) (same) (samp) (sand) (sati) (sato) (sauc) (saus) (save) (say )
    (scal) (scan) (scar) (scat) (scen) (sche) (scho) (scie) (scis) (scor) (scou) (scra) (scre) (scri) (scru) (sea )
    (sear) (seas) (seat) (seco) (secr) (sect) (secu) (seed) (seek) (segm) (sele) (sell) (semi) (seni) (sens) (sent)
    (seri) (serv) (sess) (sett) (setu) (seve) (shad) (shaf) (shal) (shar) (shed) (shel) (sher) (shie) (shif) (shin)
    (ship) (shiv) (shoc) (shoe) (shoo) (shop) (shor) (shou) (shov) (shri) (shru) (shuf) (shy ) (sibl) (sick) (side)
    (sieg) (sigh) (sign) (sile) (silk) (sill) (silv) (simi) (simp) (sinc) (sing) (sire) (sist) (situ) (six ) (size)
    (skat) (sket) (ski ) (skil) (skin) (skir) (skul) (slab) (slam) (slee) (slen) (slic) (slid) (slig) (slim) (slog)
    (slot) (slow) (slus) (smal) (smar) (smil) (smok) (smoo) (snac) (snak) (snap) (snif) (snow) (soap) (socc) (soci)
    (sock) (soda) (soft) (sola) (sold) (soli) (solu) (solv) (some) (song) (soon) (sorr) (sort) (soul) (soun) (soup)
    (sour) (sout) (spac) (spar) (spat) (spaw) (spea) (spec) (spee) (spel) (spen) (sphe) (spic) (spid) (spik) (spin)
    (spir) (spli) (spoi) (spon) (spoo) (spor) (spot) (spra) (spre) (spri) (spy ) (squa) (sque) (squi) (stab) (stad)
    (staf) (stag) (stai) (stam) (stan) (star) (stat) (stay) (stea) (stee) (stem) (step) (ster) (stic) (stil) (stin)
    (stoc) (stom) (ston) (stoo) (stor) (stov) (stra) (stre) (stri) (stro) (stru) (stud) (stuf) (stum) (styl) (subj)
    (subm) (subw) (succ) (such) (sudd) (suff) (suga) (sugg) (suit) (summ) (sun ) (sunn) (suns) (supe) (supp) (supr)
    (sure) (surf) (surg) (surp) (surr) (surv) (susp) (sust) (swal) (swam) (swap) (swar) (swea) (swee) (swif) (swim)
    (swin) (swit) (swor) (symb) (symp) (syru) (syst) (tabl) (tack) (tag ) (tail) (tale) (talk) (tank) (tape) (targ)
    (task) (tast) (tatt) (taxi) (teac) (team) (tell) (ten ) (tena) (tenn) (tent) (term) (test) (text) (than) (that)
    (them) (then) (theo) (ther) (they) (thin) (this) (thou) (thre) (thri) (thro) (thum) (thun) (tick) (tide) (tige)
    (tilt) (timb) (time) (tiny) (tip ) (tire) (tiss) (titl) (toas) (toba) (toda) (todd) (toe ) (toge) (toil) (toke)
    (toma) (tomo) (tone) (tong) (toni) (tool) (toot) (top ) (topi) (topp) (torc) (torn) (tort) (toss) (tota) (tour)
    (towa) (towe) (town) (toy ) (trac) (trad) (traf) (trag) (trai) (tran) (trap) (tras) (trav) (tray) (trea) (tree)
    (tren) (tria) (trib) (tric) (trig) (trim) (trip) (trop) (trou) (truc) (true) (trul) (trum) (trus) (trut) (try )
    (tube) (tuit) (tumb) (tuna) (tunn) (turk) (turn) (turt) (twel) (twen) (twic) (twin) (twis) (two ) (type) (typi)
    (ugly) (umbr) (unab) (unaw) (uncl) (unco) (unde) (undo) (unfa) (unfo) (unha) (unif) (uniq) (unit) (univ) (unkn)
    (unlo) (unti) (unus) (unve) (upda) (upgr) (upho) (upon) (uppe) (upse) (urba) (urge) (usag) (use ) (used) (usef)
    (usel) (usua) (util) (vaca) (vacu) (vagu) (vali) (vall) (valv) (van ) (vani) (vapo) (vari) (vast) (vaul) (vehi)
    (velv) (vend) (vent) (venu) (verb) (veri) (vers) (very) (vess) (vete) (viab) (vibr) (vici) (vict) (vide) (view)
    (vill) (vint) (viol) (virt) (viru) (visa) (visi) (visu) (vita) (vivi) (voca) (voic) (void) (volc) (volu) (vote)
    (voya) (wage) (wago) (wait) (walk) (wall) (waln) (want) (warf) (warm) (warr) (wash) (wasp) (wast) (wate) (wave)
    (way ) (weal) (weap) (wear) (weas) (weat) (web ) (wedd) (week) (weir) (welc) (west) (wet ) (whal) (what) (whea)
    (whee) (when) (wher) (whip) (whis) (wide) (widt) (wife) (wild) (will) (win ) (wind) (wine) (wing) (wink) (winn)
    (wint) (wire) (wisd) (wise) (wish) (witn) (wolf) (woma) (wond) (wood) (wool) (word) (work) (worl) (worr) (wort)
    (wrap) (wrec) (wres) (wris) (writ) (wron) (yard) (year) (yell) (you ) (youn) (yout) (zebr) (zero) (zone) (zoo )
] def

/showbinary39 {
    16 dict begin
    /num exch def

    bip39words num get show
    ( ) show

    /sc 1 def
    1 1 11 { pop /sc sc 2 mul def } for
    1 1 11 {
        /sc sc 2 idiv def
        num sc and 0 eq {(0)} {(1)} ifelse show
    } for

    end
} bind def

/showbinaries39 {
    /Courier findfont 8 scalefont setfont

    16 dict begin
    /swap exch def
    /offset exch def
    /xstart exch def

    0 1 63 {
        dup
        8 mul 60 add xstart exch moveto

        offset exch sub
        dup 256 mod 0 eq {
            /Courier-bold findfont 8 scalefont setfont
            showbinary39
            /Courier findfont 8 scalefont setfont
        } {
            showbinary39
        } ifelse
    } for

    end
} bind def

/box {
  10 dict begin
  { /width /beginred /n } {exch def} forall
  -1.2 -1.9 rmoveto
  0 14 rlineto
  arraySpace 0 rlineto
  0 -14 rlineto
  closepath
  width setlinewidth
  n beginred ge { gsave 1 0.9 0.9 setrgbcolor fill grestore } if
  stroke
  end
} bind def

%******************
%* Tables and Diagrams
%*
%* Tables, diagrams etc provided throughout the text which may be repeated

/drawDataFormat {
  10 dict begin
  {/y /x} {exch def} forall
  /boxW pgsize aload pop pop 144 sub 35 div def

  x y moveto
  % FIXME use russell's line font
  /Courier findfont 14 scalefont setfont
  % Draw left 13 boxes
  1 1 13 {
    pop
    gsave
      [] 0 setdash
      boxW 0 rlineto
      0 -14 rlineto
      boxW neg 0 rlineto
      closepath stroke
    grestore
    boxW 0 rmoveto
  } for
  % Draw dashed line
  boxW 2 div 0 rmoveto
  0 -7 rmoveto
  [1 2] 0 setdash
  boxW 4 mul 0
  gsave 2 copy rlineto stroke grestore
  rmoveto
  0 7 rmoveto
  boxW 2 div 0 rmoveto
  % Draw right 17 boxes
  1 1 17 {
    pop
    gsave
      [] 0 setdash
      boxW 0 rlineto
      0 -14 rlineto
      boxW neg 0 rlineto
      closepath stroke
    grestore
    boxW 0 rmoveto
  } for

  % Draw a brace, moving the current point to the right
  % by width many pts
  /drawBrace { % width height -> nil
    10 dict begin
    {/height /width} {exch def} forall
    gsave
      -2 height 2 div rmoveto
      [] 0 setdash
      height abs height rlineto
      width 4 add 2 height mul abs sub 0 rlineto
      height abs height neg rlineto
      stroke
    grestore
    width 0 rmoveto
    end
  } bind def

  x y moveto
  /braceH -3 def
  3 boxW mul 0 rmoveto
  [ 1 4 1 13 13 ] {
    0 5 braceH mul rmoveto
    boxW exch mul braceH drawBrace
    /braceH braceH neg store
  } forall

  % Draw example characters in boxes
  x y moveto
  2 -12 rmoveto % manually center characters in box
  /sampleString (MS12NAMEA79NT     9Y6AHQ829ZQZVEGNF) def
  0 1 sampleString length 1 sub {
    sampleString exch 1 getinterval gsave show grestore
    boxW 0 rmoveto
  } for

  % Draw headings above/below braces
  /Times findfont 12 scalefont setfont
  x y moveto
  3.5 boxW mul -32 rmoveto
  gsave
    gsave (recovery) centreshow grestore
    0 -12 rmoveto gsave (threshold) centreshow grestore
    0 -12 rmoveto gsave (\(k\)) centreshow grestore
  grestore

  2.5 boxW mul 40 rmoveto
  gsave
    gsave (ID) centreshow grestore
  grestore

  2.5 boxW mul -40 rmoveto
  gsave
    gsave (share) centreshow grestore
    0 -12 rmoveto gsave (index) centreshow grestore
  grestore

  6.5 boxW mul 40 rmoveto
  gsave (data \(26 chars for 128 bits\)) centreshow grestore

  13 boxW mul -40 rmoveto
  gsave (checksum \(13 chars\)) centreshow grestore

  end
} bind def

%************************************************************************
%************************************************************************
%*
%* Artwork
%*
%************************************************************************
%************************************************************************
/drawCover {
<?php include "cover.php.inc"; ?>
} bind def

% Lol, postscript can't handle too large a function apparently so we
% have to split this into two
/drawDragon1 {
% %%BoundingBox: 51 131 406 486
<?php include "dragon1.php.inc"; ?>
} bind def

/drawDragon2 {
<?php include "dragon2.php.inc"; ?>
} bind def

/drawDragon {
  drawDragon1
  drawDragon2
} bind def

/drawWheelLock {
<?php include "wheel-lock.php.inc"; ?>
} bind def

/drawPotion {
<?php include "potion.php.inc"; ?>
} bind def

/drawSun {
<?php include "sun.php.inc"; ?>
} bind def

%%EndSetup

%************************************************************************
%************************************************************************
%*
%* Section Three: Page Rendering
%*
%************************************************************************
%************************************************************************

%****************************************************************
%*
%* Title Page
%*
%****************************************************************
%%Page: (i) 1
%%BeginPageSetup
/pgsave save def
%%EndPageSetup

0.827451 0.772549 0.623529 setrgbcolor
0 0 moveto
pgsize aload pop pop 0 lineto
pgsize aload pop lineto
0 pgsize aload pop exch pop lineto
closepath fill

% %%PageBoundingBox: 22 7 436 589
1.30 1.30 scale
8.5 5 translate
drawCover
-20 -9 translate

pgsave restore
showpage

%****************************************************************
%*
%* License Information
%*
%****************************************************************
%%Page: (ii) 2
%%BeginPageSetup
/pgsave save def
%%EndPageSetup
/Courier findfont 10 scalefont setfont
40 750 moveto
MIT {gsave ((c)) search {show pop /copyright glyphshow} if show grestore 0 -12 rmoveto} forall
pgsave restore
showpage

%****************************************************************
%*
%* Arithmetic Tables
%*
%****************************************************************
%%Page: (iii) 3
%%BeginPageSetup
/pgsave save def
%%EndPageSetup

/Times-Bold findfont 20 scalefont setfont
pgsize aload pop 48 sub exch 2 div exch
moveto (Principal Tables) centreshow

pgsize aload pop
/tHeight exch 108 sub 2 div def
/tWidth exch 72 sub 2 div def

/drawTable {
  10 dict begin
  { /innerCode /topPerm /topCode /leftPerm /leftCode /title /binop /y /x } {exch def} forall

  % Top 16 pts are title
  x y moveto
  /Times findfont 14 scalefont setfont
  tWidth 2 div -12 rmoveto title centreshow

  % Remainder is split into the table (one extra row and column for heading)
  /cellH tHeight 16 sub leftPerm length 1 add div def
  /cellW tWidth topPerm length 1 add div def

  % Draw vertical background lines: one black one for the heading then
  % alternating 3-cell-height white/gray for the content background
  x y 16 sub moveto
  0 1 topPerm length {
    dup 0 eq { 0 0 0 } {
      3 add 6 mod 3 lt { 0.808 0.923 0.953 } { 1 1 1 } ifelse
    } ifelse setrgbcolor

    gsave
      0 tHeight 16 sub neg rlineto
      cellW 0 rlineto 0 tHeight 16 sub rlineto closepath fill
    grestore
    cellW 0 rmoveto
  } for
  % Draw horizontal background line for top heading
  0 setgray
  x y 16 sub moveto
  x tWidth add y 16 sub lineto
  0 cellH neg rlineto
  x y 16 cellH add sub lineto
  closepath fill
  % Draw vertical lines
  0.1 setlinewidth
  % Draw horizontal lines
  x y 16 sub moveto
  0 1 leftPerm length {
    0 cellH neg rmoveto
    3 mod 2 eq {
      gsave tWidth 0 rlineto stroke grestore
    } if
  } for

  1 setgray
  % Draw top title
  x cellW 2 div add y 16 sub cellH sub 2 add moveto
  0 1 topPerm length 1 sub {
    cellW 0 rmoveto
    topPerm exch get topCode exch get gsave 10 centrecodexshow grestore
  } for
  % Draw left title
  x cellW 2 div add y 16 sub cellH sub 2 add moveto
  0 1 leftPerm length 1 sub {
    0 cellH neg rmoveto
    leftPerm exch get leftCode exch get gsave 10 centrecodexshow grestore
  } for

  0 setgray
  % Draw content
  x cellW 2 div add y 16 sub cellH sub 2 add moveto
  0 1 topPerm length 1 sub { % x
    cellW 0 rmoveto
    gsave
    0 1 leftPerm length 1 sub { % y
      0 cellH neg rmoveto
      1 index
      /xpos exch topPerm exch get def
      /ypos exch leftPerm exch get def
      innerCode xpos ypos binop get
      gsave 10 centrecodexshow grestore
    } for
    pop
    grestore
  } for

  % Bounding box
  0.5 setlinewidth
  x y 16 sub moveto
  0 tHeight 16 sub neg rlineto
  tWidth 0 rlineto
  0 tHeight 16 sub rlineto
  closepath stroke

  end
} bind def

% top-left
28 tHeight tHeight 46 add add
{gf32add} (Addition) code perm code perm code drawTable
% top-right
tWidth 44 add tHeight tHeight 46 add add
{gf32mul} (Translation) code perm code2 permId 1 31 getinterval code drawTable
% bot-left
28 tHeight 38 add
{ 10 dict begin
  /in exch def
  /out exch def
  16 out [ in out ] lagrange
  dup 1 eq {pop 0} if % X out trying to recover a share with itself.
  end
}
(Recovery) code permS 1 31 getinterval code permS 1 31 getinterval code2 drawTable
% bot-right
tWidth 44 add tHeight 38 add
{gf32mul} (Multiplication) code2 permId 1 31 getinterval code2 permId 1 31 getinterval code2 drawTable

pgsave restore
showpage

%****************************************************************
%*
%* Reference Page
%*
%****************************************************************
%%Page: (iv) 4
%%BeginPageSetup
/pgsave save def
%%EndPageSetup

% Takes a position specified as percentages of page width/height (excluding
% margins) and computes the actual x/y coordinates in pts
/position { % x y -> x y
  10 dict begin
    /y exch def
    /x exch def
    pgsize aload pop
    /pageH exch def
    /pageW exch def
    pageW 144 sub x mul 72 add
    pageH 144 sub y mul 72 add
    neg pageH add % invert y so that "0" is at the top of the page
  end
} bind def

%
% Header/data format
%

/Times-Bold findfont 20 scalefont setfont
0.5 0 position moveto (Data Format) centreshow

0 0.05 position drawDataFormat

%
% bech32->binary chart
%
0.50 0.20 position moveto
/Times-Bold findfont 20 scalefont setfont
(Bech32 to Binary Conversion) centreshow
/Courier findfont 12 scalefont setfont

0.5 0.23 position moveto
25 string stringwidth pop neg 0 rmoveto % goofy centering logic
0 8 {
  gsave 4 {
    dup
    perm exch get
    code 1 index get glyphshow (: ) show
    32 5 { 2 idiv 2 copy and 0 eq {(0)} {(1)} ifelse show } repeat pop
    pop
    (      ) show 8 add 32 mod
  } repeat grestore
  0 -14 rmoveto
  1 add
} repeat pop

0.50 0.45 position moveto
/Times-Bold findfont 20 scalefont setfont
(Binary to Bech32 Conversion) centreshow
/Courier findfont 12 scalefont setfont

0.5 0.48 position moveto
25 string stringwidth pop neg 0 rmoveto % goofy centering logic
0 8 {
  gsave 4 {
    dup
    32 5 { 2 idiv 2 copy and 0 eq {(0)} {(1)} ifelse show } repeat pop
    (: ) show code 1 index get glyphshow
    pop
    (      ) show 8 add 32 mod
  } repeat grestore
  0 -14 rmoveto
  1 add
} repeat pop

%
% Symbol pronunciation
%
/Times-Bold findfont 20 scalefont setfont
0.5 0.72 position moveto
(Symbols) centreshow

/pronunciation <<
  /aleph       (Aleph)      /alpha    (Alpha)    /beta        (Beta)           /Gamma     (Gamma)
  /Delta       (Delta)      /epsilon  (Epsilon)  /eta         (Eta)            /Theta     (Theta)
  /Lambda      (Lambda)     /mu       (Mu)       /Xi          (Xi)             /Pi        (Pi)
  /rho         (Rho)        /Sigma    (Sigma)    /Phi         (Phi)            /Psi       (Psi)
  /Omega       (Omega)      /at       (At)       /numbersign  (Hash)           /percent   (Percent)
  /cent        (Cent)       /yen      (Yen)      /Euro        (Euro)           /currency  (Scarab)
  /circleplus  (Earth)      /dagger   (Dagger)   /daggerdbl   (Double-dagger)  /section   (Section)
  /paragraph   (Paragraph)  /diamond  (Diamond)  /heart       (Heart)
>> def

0.5 0.75 position moveto
4 string stringwidth pop 90 2 mul add neg 0 rmoveto % goofy centering logic
gsave
1 1 31 {
  dup dup
  code2 exch get
  12 codexshow ( ) show
  gsave
    /Times findfont 12 scalefont setfont
    code2 exch get pronunciation exch get show
  grestore
  90 0 rmoveto

  4 mod 0 eq {
    grestore 0 -20 rmoveto gsave
  } if
} for
grestore
pgsave restore
showpage

%****************************************************************
%*
%* Table of Contents
%*
%****************************************************************
%%Page: (v) 5
%%BeginPageSetup
/pgsave save def
%%EndPageSetup

/Times-Bold findfont 20 scalefont setfont
pgsize aload pop 72 sub exch 2 div exch
moveto (Table of Contents) centreshow

[1 4] 0 setdash
/Times findfont 16 scalefont setfont
/pagenum 1 def

<<
  /x 72 def
  /xnum pgsize aload pop pop 108 sub def
  /y pgsize aload pop exch pop 108 sub def
  /displaying false
  /tocOn true

  /stringtype {
    displaying tocOn and {
      % Section title
      x y moveto show
      % Horizontal line
      % For aligned dots we go out of our way to start the line on the right hand side.
      currentpoint xnum 5 sub y moveto lineto stroke
      % Page number
      xnum y moveto pagenum 2 string cvs show
      /y y 24 sub store
    } { pop } ifelse
  }
  /nametype {
    <<
      /section 1
      /endsection -1
      /subsection 2
      /endsubsection -2
      /subsubsection 3
      /endsubsubsection -3
    >> exch 2 copy known {
      get
      tocOn {
        % For top-level sections bump y down an extra space
        dup 1 eq { /y y 15 sub store } if
        % For all sections just adjust x accordingly
        /x 1 index 20 mul x add store
        /displaying exch 0 gt store
      } if
    } {
      dup
      /notoc eq { /tocOn false store } if
      /toc eq { /tocOn true store } if
      pop
    } ifelse
  }
>> begin

allPageContent { % forall pages
  { % forall symbols in page
    dup type exec
  } forall
  /pagenum pagenum 1 add store
} forall

end

%****************************************************************
%*
%* Main Content
%*
%****************************************************************
10 dict begin %% dummy
<?php
  end_page(); content_page();
  end_page(); content_page();
  end_page(); content_page();
  end_page(); content_page();
?>
216 156 moveto
/Times-Italic findfont 12 scalefont setfont (Keep it secret. Keep it safe.) show
306 140 moveto gsave 0 3.5 rmoveto 10 0 rlineto 0.2 setlinewidth stroke grestore 12 0 rmoveto
/Times findfont 12 scalefont setfont (Gandalf) show
<?php
  end_page(); content_page();
?>
72 310 drawDataFormat

<?php
  end_page(); content_page();
  end_page(); content_page();
?>

/mink 2 def
/maxk 3 def

/x 104 def
/y 450 def
/rowtitle 6 string def
mink 1 maxk {
  /k exch def

  0 1 k {
    /rowidx exch def
    x y moveto
    /Courier-Bold findfont 12 scalefont setfont
    rowidx 0 eq {
      % First row (heading)
      k (k =   ) rowtitle copy 4 2 getinterval cvs pop
      rowtitle show

      k mink sub { 12 0 rmoveto } repeat
      k 1 31 {
        perm exch get code exch get gsave glyphshow grestore
        12 0 rmoveto
      } for % horizontal loop
    } {
      % Symbol rows
      /xinterp rowidx 1 sub def % x coord to interpolate at
      (  ) show
      perm xinterp get code exch get glyphshow
      (   ) show

      k mink sub { 12 0 rmoveto } repeat
      k 1 31 {
        perm exch get  % x coord to evaluate at
        perm xinterp get % x coord to interpolate at
        perm 0 k getinterval % x coords to interpolate at
        lagrange % symbol
        code2 exch get gsave 12 codexshow grestore % print symbol
        12 0 rmoveto
      } for % horizontal loop
    } ifelse

    /y y 11 sub def
  } for % vertical loop
  /y y 20 sub def
} for

<?php end_page(); content_page(); ?>

%%% Random Character Worksheet
<?php end_page(); content_page(true, true); ?>

gsave
325 190 translate
%% Tree
10 dict begin
% tree
  /radius 0.705 72 mul 8.5 div def
  /spacing 60 def
  /coord { % i j -- x y
     1 index 2 exch exp exch 0.5 add mul 2 mul 1.1 radius mul mul
     exch 0.5 add spacing mul
  } bind def
  /trimedline { % x1 y1 x2 y2 --
  10 dict begin
    { /y2 /x2 /y1 /x1 } {exch def} forall
    /dx x2 x1 sub def
    /dy y2 y1 sub def
    /l dx dup mul dy dup mul add sqrt def
    x1 y1 moveto 0 dup dx mul exch dy mul rmoveto
    1 2 0 mul sub dup dx mul exch dy mul rlineto
  end
  } bind def
  1 1 5 {
    /i exch def
    0 1 2 5 i sub exp 1 sub {
      /j exch def
      /x 2 i exp j 0.5 add mul 2 mul 1.1 radius mul mul def
      i j coord moveto radius 5 div neg 0 rmoveto
      i j coord radius 5 div -180 180 arc
    } for
  } for
  thick line stroke
  0 1 4 {
    /i exch def
    0 1 2 5 i sub exp 1 sub {
      /j exch def
      /x 2 i exp j 0.5 add mul 2 mul 1.1 radius mul mul def
      i j coord i 1 add j 2 idiv coord trimedline
    } for
  } for
  thin line stroke
  /fontsz 16 def
  0 1 31 {
    /j exch def
    /x 1.1 radius mul 2 j mul 1 add mul def
    x spacing 2 div fontsz 0.3 mul sub 5 sub moveto
    code j get fontsz centrecodexshow
  } for
end
grestore

marginX1 200 translate
% Labels for the dice pad rows
/Helvetica-Bold findfont 18 scalefont setfont
0 0 moveto
(Die Tracks) show
newpath 0 -5 moveto marginW 0.75 mul -5 lineto stroke

/Helvetica findfont 14 scalefont setfont
0 -23 moveto
(Label) show
newpath 20 -40 32.5 140 220 arc -10 10 rlineto 10 -10 rmoveto -1 11 rlineto  stroke

160 -23 moveto
(Die Pads) show

440 -23 moveto
(Die Pads \(d7+\)) show

% Draw a single dice pad row at the bottom
0.2 setlinewidth
40 -105 moveto
drawDiceRow

<?php end_page(); content_page(true); ?>

0.2 setlinewidth
marginX1 40 add marginY1 65 sub moveto
4 { drawDiceRow 0 -135 rmoveto } repeat

<?php end_page(); content_page(true); ?>

/Helvetica-Bold findfont 10 scalefont setfont
centerX marginY1 moveto (MS32 Checksum Table) centreshow

/drawTable {
  10 dict begin
  { /startVal /tHeight /tWidth /y /x } {exch def} forall

  /cellH tHeight 32 div def
  /cellW tWidth 8 div def

  % Draw horizontal background lines: one black one for the heading then
  % alternating 4-cell-height white/gray for the content background
  x y moveto
  0 1 31 {
    dup 0 eq { 0.808 0.923 0.953 } {
      8 mod 4 lt { 0.808 0.923 0.953 } { 1 1 1 } ifelse
    } ifelse setrgbcolor

    gsave
      tWidth 0 rlineto
      0 cellH neg rlineto tWidth neg 0 rlineto closepath fill
    grestore
    0 cellH neg rmoveto
  } for

  % Draw vertical background lines: one double-wide black one per column
  x y moveto
  0 1 7 {
    1 setgray
    gsave
      0 tHeight neg rlineto
      cellW 26 div neg 0 rlineto 0 tHeight rlineto closepath fill
    grestore
    0 setgray
    gsave
      0 tHeight neg rlineto
      cellW 2 mul 13 div 0 rlineto 0 tHeight rlineto closepath fill
    grestore
    cellW 0 rmoveto
  } for

  % Draw content
  startVal 1 startVal 7 add {
    /xVal exch def
    x xVal startVal sub cellW mul add 2 add y 1.5 add moveto
    0 1 31 {
      /yVal exch def
      0 cellH neg rmoveto

      gsave
        /Courier-Bold findfont 8.5 scalefont setfont
        1 setgray
        code perm xVal get get glyphshow
        code perm yVal get get glyphshow
      grestore

      gsave
        cellW 2 mul 13 div 0 rmoveto
        perm xVal get perm yVal get polymodshift2 {
          code exch get glyphshow
          0.25 0 rmoveto
        } forall
      grestore
    } for
  } for

  % Bounding box
  0.5 setlinewidth
  x y moveto
  0 tHeight neg rlineto
  tWidth 0 rlineto
  0 tHeight rlineto
  closepath stroke

  end
} bind def

/Courier findfont 8.5 scalefont setfont
marginX1 marginY1 5 sub
marginW marginH 2 div 15 sub
0 drawTable

marginX1 marginY1 marginH 2 div sub
marginW marginH 2 div 15 sub
8 drawTable

<?php end_page(); content_page(true); ?>

/Helvetica-Bold findfont 10 scalefont setfont
centerX marginY1 moveto (MS32 Checksum Table) centreshow

/drawTable {
  10 dict begin
  { /startVal /tHeight /tWidth /y /x } {exch def} forall

  /cellH tHeight 32 div def
  /cellW tWidth 8 div def

  % Draw horizontal background lines: one black one for the heading then
  % alternating 4-cell-height white/gray for the content background
  x y moveto
  0 1 31 {
    dup 0 eq { 0.808 0.923 0.953 } {
%      8 mod 4 lt { 0.8 } { 1 } ifelse
      8 mod 4 lt { 0.808 0.923 0.953 } { 1 1 1 } ifelse
    } ifelse setrgbcolor

    gsave
      tWidth 0 rlineto
      0 cellH neg rlineto tWidth neg 0 rlineto closepath fill
    grestore
    0 cellH neg rmoveto
  } for

  % Draw vertical background lines: one double-wide black one per column
  x y moveto
  0 1 7 {
    1 setgray
    gsave
      0 tHeight neg rlineto
      cellW 26 div neg 0 rlineto 0 tHeight rlineto closepath fill
    grestore
    0 setgray
    gsave
      0 tHeight neg rlineto
      cellW 2 mul 13 div 0 rlineto 0 tHeight rlineto closepath fill
    grestore
    cellW 0 rmoveto
  } for

  % Draw content
  startVal 1 startVal 7 add {
    /xVal exch def
    x xVal startVal sub cellW mul add 2 add y 1.5 add moveto
    0 1 31 {
      /yVal exch def
      0 cellH neg rmoveto

      gsave
        /Courier-Bold findfont 8.5 scalefont setfont
        1 setgray
        code perm xVal get get glyphshow
        code perm yVal get get glyphshow
      grestore

      gsave
        cellW 2 mul 13 div 0 rmoveto
        perm xVal get perm yVal get polymodshift2 {
          code exch get glyphshow
          0.25 0 rmoveto
        } forall
      grestore
    } for
  } for

  % Bounding box
  0.5 setlinewidth
  x y moveto
  0 tHeight neg rlineto
  tWidth 0 rlineto
  0 tHeight rlineto
  closepath stroke

  end
} bind def

/Courier findfont 8.5 scalefont setfont
marginX1 marginY1 5 sub
marginW marginH 2 div 15 sub
16 drawTable

marginX1 marginY1 marginH 2 div sub
marginW marginH 2 div 15 sub
24 drawTable

<?php end_page(); content_page(true); ?>

gsave
48 300 translate 0.75 0.8 scale
exampleladder begin
 /Helvetica-Bold findfont 15 scalefont setfont
 firstrowlen hrplen add 0 offset 8 add exch 2 div exch moveto (1) centreshow

 drawgrid
 (2NAMES50PRDAK9GLSVNL067VQVEX0) true false false false true fillgrid
end
grestore

gsave
238 300 translate 0.75 0.8 scale
exampleladder begin
 /Helvetica-Bold findfont 15 scalefont setfont
 firstrowlen hrplen add 0 offset 8 add exch 2 div exch moveto (2 - 4) centreshow

 drawgrid
 (2NAMES50PRDAK9GLSVNL067VQVEX0) true false true true true fillgrid
end
grestore

gsave
428 300 translate 0.75 0.8 scale
exampleladder begin
 /Helvetica-Bold findfont 15 scalefont setfont
 firstrowlen hrplen add 0 offset 8 add exch 2 div exch moveto (3) centreshow

 drawgrid
 (2NAMES50PRDAK9GLSVNL067VQVEX0) true true true true true fillgrid
end
grestore

<?php end_page(); content_page(true); ?>

gsave
48 300 translate 0.75 0.8 scale
exampleladder begin
 /Helvetica-Bold findfont 15 scalefont setfont
 firstrowlen hrplen add 0 offset 8 add exch 2 div exch moveto (1) centreshow

 drawgrid
 (2NAMES50PRDAK9GLSVNL067VQVEX0) true true false false false fillgrid
end
grestore

gsave
238 300 translate 0.75 0.8 scale
exampleladder begin
 /Helvetica-Bold findfont 15 scalefont setfont
 firstrowlen hrplen add 0 offset 8 add exch 2 div exch moveto (2) centreshow

 drawgrid
 (2NAMES50PRDAK9GLSVNL067VQVEX0) true true false true false fillgrid
end
grestore

gsave
428 300 translate 0.75 0.8 scale
exampleladder begin
 /Helvetica-Bold findfont 15 scalefont setfont
 firstrowlen hrplen add 0 offset 8 add exch 2 div exch moveto (3) centreshow

 drawgrid
 (2NAMES50PRDAK9GLSVNL067VQVEX0) true true true true true fillgrid
end
grestore
<?php end_page(); content_page(true); ?>
/Times-Roman findfont 32 scalefont setfont
centerX marginY1 30 sub moveto (Checksum Worksheet) show % nb show, not centreshow, to offset

%% EDITME
%% This code can be used to compute and verify checksums, which will be rendered using
%% the example handwriting font. This can be used for debugging, sanity checking, or
%% (in principle) to use an airgapped Postscript printer as a sort of hardware wallet.
%%
%% To verify a checksum, replace the above all-spaces string with your actual share
%% data, in all caps.
%%
%% To compute a checksum, do the same, and add SECRETSHARE32 to the end of the data.
%% On the rendered worksheet, the correct checksum will appear in the final row (where
%% SECRETSHARE32 *would* appear on a hand-completed worksheet).
%%

gsave
48 555 translate
ladder begin
 drawgrid
 (                                                ) true false false false true fillgrid
end
grestore


<?php end_page(); content_page(true); ?>
0 -120 translate
/Times-Roman findfont 16 scalefont setfont
48 415 moveto (k=2 Example) show
48 280 moveto (k=3 Example) show

/Helvetica findfont 10 scalefont setfont
60 398 moveto (Share) centreshow
60 388 moveto (Index) centreshow

110 398 moveto (Translation) centreshow
110 388 moveto (Symbol) centreshow
thin line
newpath 60 385 moveto -5 -10 rlineto 6 5 rlineto -6 -5 rmoveto -1 5 rlineto stroke

newpath 110 385 moveto -28 -11 rlineto 6 0 rlineto -6 0 rmoveto 3 5 rlineto stroke

newpath 110 395 90 305 238 arcn 10 -2 rlineto -10 2 rmoveto 7 -7 rlineto  stroke

% 2-of-n
gsave
48 370 translate
ladder begin
  2 drawrow %(A) /at (ABCD) fillrow
end
grestore

% 3-of-n
gsave
48 270 translate
ladder begin
  3 drawrow %(A) /at (ABCD) fillrow
end
grestore

<?php end_page(); content_page(true); ?>
/Times-Roman findfont 14 scalefont setfont
marginX1 marginY1 moveto (Translation Worksheet \(k = 2\)) show

gsave
marginX1 pageH 51 sub translate

9 {
ladder begin
  2 drawrow
  0 ysize 4.1 mul translate
end
} repeat
grestore

<?php end_page(); content_page(true); ?>
/Times-Roman findfont 14 scalefont setfont
marginX1 marginY1 moveto (Translation Worksheet \(k = 3\)) show

gsave
marginX1 pageH 61 sub translate

5 {
ladder begin
  3 drawrow
  0 ysize 6.8 mul translate
end
} repeat
grestore

%% Volvelles
<?php end_page(); content_page(); ?>
{xor} (Addition) code dup perm drawBottomWheelPage

<?php end_page(); content_page(); ?>
   % Draw gray "handle" and white interior circle
   gsave
   pgsize aload pop 2 div exch 2 div exch translate
     0.8 setgray
     newpath 0 0 7.25 40 mul 140 40 arc clip fill
     1 setgray
     newpath 0 0 6 40 mul 0 360 arc fill
     0 setgray
     newpath 0 0 6 40 mul 0 360 arc stroke
   grestore

gsave
  % Original dragon fit into 0 0 354 354. Our inner circle has a 240 radius.
  % Original dragon had bbox 51 131 406 486 (355 355)
  pgsize aload pop 2 div exch 2 div exch translate
  -240 -242 translate
  240 176 div dup scale
  -52.5 -131 translate
  drawDragon
grestore
showTopWheelPage

<?php end_page(); content_page(); ?>

% gsave verythin line marginpath stroke grestore
recoveryDisc begin
% Draw assembly diagram
10 dict begin
/yscale 0.25 def
/pinoffset -55 def
gsave
  120 700 translate
  0.4 dup scale
    % pin size is the width of the cross
   0 pinoffset neg moveto 4.5 2 mul drawPin
  gsave
    0 pinoffset neg moveto 0 0 lineto
    [4.5 4.5] 4.5 1.5 mul setdash stroke
  grestore
  matrix currentmatrix
    1 yscale scale
    -90 rotate
    drawTopDisc
    newpath 0 0 innerRadius 360 0 arcn
  setmatrix
  0 -60 translate
  matrix currentmatrix
    1 yscale scale
    0 0 radius 2 mul 0 360 arc clip
    drawBottomDisc
  setmatrix
  gsave
    0 pinoffset neg moveto 0 0 lineto
    [4.5 4.5] 4.5 1.5 mul setdash stroke
  grestore
grestore
end
% Move cursor to center of page
pgsize aload pop 2 div exch 2 div exch translate
% angle the page
  /pageangle pgsize aload pop radius angleinbox def
  /buffer 2 def
  pageangle rotate
  gsave
    0 buffer innerRadius add neg translate
    drawBottomDisc
  grestore
  0 buffer radius add translate
  90 pageangle sub rotate
  drawTopDisc
end

<?php end_page(); content_page(); ?>

% special for this page: blank out page number as it overlaps disc
gsave
1 setgray
20 setlinewidth
centerX 5 sub marginY2 5 add 15 15 rectstroke
grestore

% gsave verythin line marginpath stroke grestore
% Draw assembly diagram
gsave
  60 700 translate
  0.4 dup scale
  0 0 70 90 180 5 copy 5 copy
  arc
  pop -10 arrowHeadPath
  exch pop 10 arrowHeadPath
  5 line stroke
  5 75 foldingBottomDiscs
grestore
gsave
  140 600 translate
  0.4 dup scale
  multiplicationDisc begin
    0 0 radius 2 mul 255 260 5 copy arc
    exch pop 10 arrowHeadPath 5 line stroke
    0 0 radius 2 mul 280 275 5 copy arcn
    exch pop -10 arrowHeadPath 5 line stroke
  end
  5 175 foldingBottomDiscs
grestore
/Helvetica findfont 14 scalefont setfont
20 740 moveto (1.) show
95 600 moveto (2.) show
% Move cursor to center of page
pgsize aload pop 2 div exch 2 div exch translate
% angle the page
multiplicationDisc begin
  pgsize aload pop bottomfoldline angleinbox rotate
gsave
   newpath
   radius 1.1 mul 0 moveto
   radius 1.1 mul neg 0 lineto
   radius 1.1 mul neg radius -2.2 mul lineto
   radius 1.1 mul radius -2.2 mul lineto
   closepath
   clip
   0 bottomfoldline neg translate
   drawBottomDisc
grestore
end
180 rotate
translationDisc begin
   newpath
   radius 1.1 mul 0 moveto
   radius 1.1 mul neg 0 lineto
   radius 1.1 mul neg radius -2.2 mul lineto
   radius 1.1 mul radius -2.2 mul lineto
   closepath
   clip
   0 bottomfoldline neg translate
   drawBottomDisc
end

<?php end_page(); content_page(); ?>
% gsave verythin line marginpath stroke grestore
% Draw assembly diagram
gsave
  60 700 translate
  0.4 dup scale
  0 0 70 90 180 5 copy 5 copy
  arc
  pop -10 arrowHeadPath
  exch pop 10 arrowHeadPath
  5 line stroke
  matrix currentmatrix
    75 foldprojection concat
    translationDisc begin
      0 topfoldline translate
      180 rotate
      drawTopDisc
    end
  dup setmatrix
    multiplicationDisc begin
      40 bottomfoldline topfoldline sub translate
    end
    1 179 foldingBottomDiscs
  setmatrix
  5 foldprojection concat
  multiplicationDisc begin
    0 topfoldline neg translate
    gsave
      newpath outlineTopDisc 1 setgray fill
    grestore
    drawTopDisc
  end
grestore
gsave
  170 600 translate
  0.4 dup scale
  multiplicationDisc begin
    0 0 radius 2 mul 255 260 5 copy arc
    exch pop 10 arrowHeadPath 5 line stroke
    0 0 radius 2 mul 280 275 5 copy arcn
    exch pop -10 arrowHeadPath 5 line stroke
  end
  matrix currentmatrix
    175 foldprojection concat
    translationDisc begin
      0 topfoldline translate
      180 rotate
      newpath outlineTopDisc verythin line resetstroke
    end
  dup setmatrix
    multiplicationDisc begin
      0 bottomfoldline topfoldline sub translate
    end
    1 179 foldingBottomDiscs
  setmatrix
  5 foldprojection concat
  multiplicationDisc begin
    0 topfoldline neg translate
    gsave
      newpath outlineTopDisc 1 setgray fill
    grestore
    drawTopDisc
  end
grestore
gsave
  500 230 translate
  0.4 dup scale
  matrix currentmatrix
  multiplicationDisc begin
    90 rotate
    matrix currentmatrix
      0 topfoldline translate [1 0 2 tan 1 0 0] concat 0 topfoldline neg translate
      0.25 1 scale
      newpath outlineTopDisc verythin line resetstroke
    setmatrix
    matrix currentmatrix
      0.25 1 scale
      gsave newpath outlineBottomDisc 1 setgray fill grestore
      drawBottomDisc
    setmatrix
    0 topfoldline translate [1 0 -1 tan 1 0 0] concat 0 topfoldline neg translate
    0.25 1 scale
    gsave newpath outlineTopDisc 1 setgray fill grestore
    drawTopDisc
    0 0 moveto
  end
  setmatrix
  0 55 lineto
  [4.5 4.5] 0 setdash stroke
  0 55 moveto 4.5 2 mul drawPin
grestore
gsave
  500 100 translate
  0.4 dup scale
  translationDisc begin
    drawBottomDisc
    gsave
      newpath outlineTopDisc 1 setgray fill
    grestore
    drawTopDisc
    90 rotate
    0 0 moveto 4.5 2 mul drawSplitPin
  end
grestore
/Helvetica findfont 14 scalefont setfont
20 740 moveto (3.) show
125 600 moveto (4.) show
410 260 moveto (5.) show
410 175 moveto (6.) show
% Move cursor to center of page
pgsize aload pop 2 div exch 2 div exch translate
% angle the page
multiplicationDisc begin
  pgsize aload pop topfoldline angleinbox rotate
gsave
  0 topfoldline neg translate
  drawTopDisc
grestore
180 rotate
translationDisc begin
  0 topfoldline neg translate
  drawTopDisc
end

<?php end_page(); content_page(); ?>

<?php end_page(); content_page(); ?>
29 24 13 25 showShareTablePage

<?php end_page(); content_page(); ?>
9 8 23 18 showShareTablePage

<?php end_page(); content_page(); ?>
22 31 27 19 showShareTablePage

<?php end_page(); content_page(); ?>
1 0 3 16 showShareTablePage

<?php end_page(); content_page(); ?>
11 28 12 14 showShareTablePage

<?php end_page(); content_page(); ?>
6 4 2 15 showShareTablePage

<?php end_page(); content_page(); ?>
10 17 21 20 showShareTablePage

<?php end_page(); content_page(); ?>
26 30 7 5 showShareTablePage

<?php end_page(); content_page(); ?>

% EDITME
% Edit these two values to draw tables for high k. For example, for k=9, set both
% mink and maxk to 9. (For values of 10+ you can only fit one table on the page
% at once, so you need to set mink == maxk).
%
% These are the A/C/D/... tables, not the S/A/C/D/... ones
/mink 4 def
/maxk 8 def

/x 104 def
/y 560 def
/rowtitle 6 string def
mink 1 maxk {
  /k exch def

  0 1 k {
    /rowidx exch def
    x y moveto
    /Courier-Bold findfont 12 scalefont setfont
    rowidx 0 eq {
      % First row (heading)
      k (k =   ) rowtitle copy 4 2 getinterval cvs pop
      rowtitle show

      k mink sub { 12 0 rmoveto } repeat
      k 1 31 {
        perm exch get code exch get gsave glyphshow grestore
        12 0 rmoveto
      } for % horizontal loop
    } {
      % Symbol rows
      /xinterp rowidx 1 sub def % x coord to interpolate at
      (  ) show
      perm xinterp get code exch get glyphshow
      (   ) show

      k mink sub { 12 0 rmoveto } repeat
      k 1 31 {
        perm exch get  % x coord to evaluate at
        perm xinterp get % x coord to interpolate at
        perm 0 k getinterval % x coords to interpolate at
        lagrange % symbol
        code2 exch get gsave 12 codexshow grestore % print symbol
        12 0 rmoveto
      } for % horizontal loop
    } ifelse

    /y y 11 sub def
  } for % vertical loop
  /y y 20 sub def
} for

<?php end_page(); content_page(); ?>

% EDITME
% Edit these two values to draw tables for high k. For example, for k=9, set both
% mink and maxk to 9. (For values of 10+ you can only fit one table on the page
% at once, so you need to set mink == maxk).
%
% These are the S/A/C/D/... tables, not the A/C/D/... ones.
/mink 2 def
/maxk 8 def

/x 104 def
/y 640 def
/rowtitle 6 string def
mink 1 maxk {
  /k exch def

  0 1 k {
    /rowidx exch def
    x y moveto
    /Courier-Bold findfont 12 scalefont setfont
    rowidx 0 eq {
      % First row (heading)
      k (k =   ) rowtitle copy 4 2 getinterval cvs pop
      rowtitle show

      k mink sub { 12 0 rmoveto } repeat
      k 1 31 {
        permS exch get code exch get gsave glyphshow grestore
        12 0 rmoveto
      } for % horizontal loop
    } {
      % Symbol rows
      /xinterp rowidx 1 sub def % x coord to interpolate at
      (  ) show
      permS xinterp get code exch get glyphshow
      (   ) show

      k mink sub { 12 0 rmoveto } repeat
      k 1 31 {
        permS exch get  % x coord to evaluate at
        permS xinterp get % x coord to interpolate at
        permS 0 k getinterval % x coords to interpolate at
        lagrange % symbol
        code2 exch get gsave 12 codexshow grestore % print symbol
        12 0 rmoveto
      } for % horizontal loop
    } ifelse

    /y y 11 sub def
  } for % vertical loop
  /y y 20 sub def
} for

% ** BIP 39 **

<?php end_page(); content_page(); ?>
<?php end_page(); content_page(); ?>
% FIXME will draw all this text using the general-purpose content drawing logic
/Times-Roman findfont 32 scalefont setfont
450 680 moveto (BIP39) show
410 650 moveto (12 words) show

gsave
48 630 translate
bip3912ladder begin
 drawgrid
% (                                                ) true false false false true fillgrid
end
grestore


<?php end_page(); content_page(); ?>
% FIXME will draw all this text using the general-purpose content drawing logic
/Times-Roman findfont 32 scalefont setfont
450 700 moveto (BIP39) show
410 670 moveto (24 words) show

gsave
48 750 translate
bip3924ladder begin
 drawgrid
% (                                                ) true false false false true fillgrid
end
grestore

<?php end_page(); content_page(true); ?>
/Times-Roman findfont 14 scalefont setfont
marginX1 marginY1 moveto (Translation Worksheet \(k = 2\)) show

gsave
marginX1 pageH 51 sub translate

4 {
bip3924ladder begin
  2 drawrow
  0 ysize 9.5 mul translate
end
} repeat
grestore

<?php end_page(); content_page(true); ?>
/Times-Roman findfont 14 scalefont setfont
marginX1 marginY1 moveto (Translation Worksheet \(k = 3\)) show

gsave
marginX1 pageH 51 sub translate

1 0.95 scale
3 {
bip3924ladder begin
  3 drawrow
  0 ysize 12.8 mul translate
end
} repeat
grestore

<?php end_page(); content_page(); ?>
/Helvetica-bold findfont 10 scalefont setfont
pgsize aload pop pop 2 div 740
moveto (BIP-39 Conversion Worksheet) centreshow

% Draw boxes
/thin 0.2 def
/thick 0.4 def
/box {
  10 dict begin
  { /width } {exch def} forall
  -1.2 -1.9 rmoveto
  0 14 rlineto
  arraySpace 0 rlineto
  0 -14 rlineto
  closepath
  width setlinewidth
  stroke
  end
} bind def

/labeledbox {
  10 dict begin
  { /start /n } {exch def} forall
  /n n start add def
  gsave 0.5 box grestore
  % Every 5, write a top-left value
  gsave
    0 9 rmoveto
    /Courier findfont 3 scalefont setfont
    n 5 mod 0 eq {
         n 5 idiv 16 add 2 string cvs show
    } if
  grestore
  % Every 11 write a bottom-left value
  gsave
    0 14 rmoveto
    /Courier-Bold findfont 6 scalefont setfont
    n 11 mod 10 eq {
         n 11 idiv 1 add 2 string cvs show
    } if
  grestore
  end
} bind def

/showBox {
  10 dict begin
  { /n /spaces /decoration } {exch def} forall
  spaces { gsave n decoration grestore
      0 rmoveto
      /n n 1 add def
    } forall
  end
} bind def

% Draw 53 boxes in blocks of 5 bits
1 1 8 {
    /i exch def
    72 i 45 mul 740 sub neg moveto
    { i 1 sub 30 mul labeledbox} [ 6 {arraySpace arraySpace arraySpace arraySpace gapSpace} repeat ] 10 showBox % 30 bits
} for
9
72 exch 45 mul 740 sub neg moveto
{ 240 labeledbox} [ 5 {arraySpace arraySpace arraySpace arraySpace gapSpace} repeat ] 10 showBox % 30 bits

% Stick a 0 in there
395 336 moveto (0) show

% Write A-Z binary conversion table
/Courier findfont 12 scalefont setfont
0 setgray

/showbinary {
    16 dict begin
    /swap exch def
    /num exch def

    swap {
        code num get glyphshow
        ( : ) show
    } if

    /sc 1 def
    1 1 5 { pop /sc sc 2 mul def } for
    1 1 5 {
        /sc sc 2 idiv def
        num sc and 0 eq {(0)} {(1)} ifelse show
    } for

    swap not {
        ( : ) show
        code num get glyphshow
    } if
    end
} bind def

/showbinaries {
    16 dict begin
    /swap exch def
    /offset exch def
    /xstart exch def

    0 1 15 {
        dup
        14 mul 72 add xstart exch moveto

        offset exch sub
        swap {perm exch get} if swap showbinary
    } for

    end
} bind def

100 15 true showbinaries
180 31 true showbinaries

350 15 false showbinaries
430 31 false showbinaries

<?php end_page(); content_page(true); ?>
1 1 8 {
    dup
    64 mul 1 sub exch
    92 mul 50 sub exch
    false showbinaries39
} for

<?php end_page(); content_page(true); ?>
1 1 8 {
    dup
    64 mul 511 add exch
    92 mul 50 sub exch
    false showbinaries39
} for

<?php end_page(); content_page(true); ?>
1 1 8 {
    dup
    64 mul 1023 add exch
    92 mul 50 sub exch
    false showbinaries39
} for

<?php end_page(); content_page(true); ?>
1 1 8 {
    dup
    64 mul 1535 add exch
    92 mul 50 sub exch
    false showbinaries39
} for

<?php end_page(); ?>

%%EOF
