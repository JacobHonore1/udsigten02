# Beslutningslog — Udsigten02

Kronologisk log over designvalg. Når et valg ændres eller forkastes, marker det som forladt — slet ikke historikken, så vi ikke genopfinder samme diskussion.

## 1. Projektet oprettet som parallel kopi (forladt udgangspunkt, ny start)

udsigten02 blev oprettet som en filkopi af udsigten01 for at genbruge infrastruktur (deploy-pipeline, mappestruktur). Men **designet i sig selv blev forkastet fra start** — kunden var utilfreds med udsigten01's udseende, og udsigten02 skulle være et helt nyt visuelt udtryk, ikke en justering.

## 2. Første redesign-forsøg: skovgrøn/guld tema — FORLADT

Tidlig version (før pitch-baseret retning) brugte:
- Mørk skovgrøn baggrund (`#0E1A14` / `#0a1f17`)
- Guld accent (`#C8A96E`)
- Libre Baskerville + DM Sans / Inter
- Inspireret af et andet site (virtoo.ai) for card-stil og glaseffekter

**Status: forladt.** Kunden ville have noget der matchede deres egen pitch-præsentation, ikke et generisk "premium dark mode" look.

## 3. Sand/beige tema — FORLADT

Mellemstadie hvor den mørke baggrund blev skiftet til en lys sandfarve (`#F2EAD8` / `#E8DCC8`). Stadig ikke det rigtige — for varmt/jordet i forhold til pitchens rene, hvide præsentationsstil.

**Status: forladt** til fordel for ren hvid baggrund.

## 4. Pitch-baseret redesign — AKTUEL RETNING

Beslutning: byg designet direkte ud fra kundens egen PDF-pitch (`Udsigten_Haderslev_2404 (2).pdf`) — samme rækkefølge af sektioner, samme tekstindhold, samme visuelle DNA (hvid baggrund, serif headlines, brun streg-detalje, store fotos).

Etableret herfra:
- Hvid baggrund (`#ffffff`), mørk tekst (`#1a1410`)
- Terracotta/brun streg (`#8B5E3C`) som generisk accent
- Playfair Display til headlines (senere skiftet, se punkt 7)
- Inter til body
- Sektionsstruktur: Hero → Vision → Sengetårnet → Funktioner → Boliger → Status → Kontakt

**Status: dette er fundamentet vi bygger videre på.**

## 5. Layout-fejl rettet: hero, spacing, bredde-konsistens

Tre runder af layout-fixes efter visuel gennemgang:

1. Hero fyldte kun halvdelen af skærmen med stort hvidt felt til højre, og tekst lå under billedet i stedet for ovenpå — rettet til fuld bredde, tekst absolut positioneret ovenpå billedet med gradient overlay.
2. Inkonsistent indholdsbredde — nav, hero og sektioner havde forskellig bredde. Rettet med en fælles `--content-width` variabel (~1300px) der bruges konsekvent overalt.
3. For meget vertikal luft mellem sektioner sammenlignet med ønsket "tæt som en avis" stil — spacing reduceret med ca. 50%.

**Status: implementeret, men kræver løbende visuelt tilsyn — disse typer fejl er nemme at reintroducere ved senere ændringer.**

## 6. 50/50 → 60/40 split på billede/tekst-sektioner

Oprindeligt var split-sektioner (billede ved siden af tekst) 50/50 (`1fr 1fr`). Besluttet at billeder skal dominere mere visuelt: **60% billede, 40% tekst** (`3fr 2fr` / `2fr 3fr` afhængig af side).

**Status: aktuel regel, gælder alle split-sektioner.**

## 7. Playfair Display → Palatino (custom TTF)

Brugeren uploadede en licenseret Palatino Roman TTF-fil (`palr45w.ttf`) og bad om at bruge den i stedet for Google Fonts Playfair Display til alle headlines.

**Status: Palatino er nu den primære display-font.** Indlæst via `@font-face` fra `fonts/palr45w.ttf`. Playfair Display-referencer (Google Fonts link + font-family) skal fjernes konsekvent når de findes.

## 8. Kategorifarver fra pitch-tværsnittet

Pitchens tværsnit-illustration af sengetårnet (side 5) bruger farvekodning: grøn til boliger, sand/beige til hotel, blå til spa/svømmehal. Disse præcise farver er overført til sitets sektionsoverskrifter som `border-left`-accent, så hver sektions overskrift visuelt matcher kundens egen materialefarvekode:

- Boliger: `#859B77` (RGB 133, 155, 119 — dæmpet sage-grøn)
- Hotel/Restaurant: `#B88360` (RGB 184, 131, 96 — varm orange-brun)
- Spa/Wellness/Svømmehal: `#8CD6F6` (RGB 140, 214, 246 — lys himmelblå)

De originale værdier (`#5B8A4A`, `#C4A882`, `#5BB8D4`) var visuelt estimerede og er nu rettet til farver målt direkte fra pitch-PDF'ens kildemateriale (side 5).

**Status: implementeret.** Generelle/ukategoriserede sektioner (Vision, Status, Kontakt) bruger fortsat den neutrale `#8B5E3C`.

## 9. Plantegninger fra pitchen indsat som sekundære billeder

Fire plantegninger eksporteret manuelt fra pitch-PDF'en og indsat i de matchende sektioner med `object-fit: contain` (ikke `cover`, da hele tegningen skal være synlig) og caption-tekst:

- Tværsnit (sengetårnet) → Sengetårnet-sektionen
- Lejlighedsplan → Boliger-sektionen
- Hotel-etageplan → Hotel-sektionen
- Svømmehal-situationsplan → Svømmehal-sektionen

**Status: implementeret for disse fire. Flere illustrationer fra pitchen er endnu ikke brugt — se TODO.**

Tværsnittet i sengetårnet-sektionen er desuden nu vist i et side-by-side layout med kategori-tekstblokke der er vandret alignet med de farvede lag i illustrationen (se punkt 13).

## 10. Vertikale farvestreger — strukturfejl rettet

Tidlig implementering satte kun `border-left` på selve `<h2>`-elementet, hvilket fik linjen til kun at være lige så høj som overskriften — ikke hele tekstblokken under. Dette så ud som om linjen "stak ud" eller var for kort i forhold til afsnittet.

**Rettet ved:** wrappe heading + alle paragraffer/lister i én container-div med `border-left`, så linjens højde automatisk følger hele indholdet. Samtidig fordoblet linjetykkelsen (4px → 8px) og sikret at venstrekanten af linjen aligner identisk på tværs af alle sektioner, uanset om teksten ligger til venstre eller højre i en split-sektion.

**Status: implementeret. Dette er et tilbagevendende risikopunkt — tjek visuelt efter enhver sektion-ombygning.**

## 11. Logo-størrelse

Logo først reduceret 30% (misforståelse), derefter rettet til en forøgelse på 30% i forhold til oprindelig størrelse.

**Status: logo er 30% større end basis-størrelsen, anvendt i både nav og footer.**

## 12. VISION-boks sektion tilføjet mellem hero og funktionssektion

Ny `<section class="vision-pitch">` indsat umiddelbart efter hero og før "EN NY BYDEL FOR ALLE"-sektionen. Indeholder præcis visionstekst fra pitchen, whitespace-logo øverst til højre, og centreret Palatino-overskrift "VISION".

Designvalg:
- Baggrundsfarve: `var(--accent)` (`#8B5E3C`) — genbruger eksisterende CSS-variabel, ingen hardcoded farve
- Bredde: spejler præcis `.hero`-sektionens tilgang — ydre `<section class="vision-pitch">` har samme `max-width: var(--content-width); margin: auto; padding: 0 var(--gutter)` som `.hero`. Et indre `.vision-pitch-box`-div med `width: 100%` giver præcis samme visuelle bredde som hero-billedet. Root cause for tidligere fejl: baggrund på fuld-viewport `<section>` uden max-width gav ikke hero-alignment; baggrund på `.container` gav bredde inkl. gutter i stedet for section-indhold.
- `margin-top: 35px` og `margin-bottom: 35px` (20px mobil) giver symmetrisk hvidt mellemrum til hero og næste sektion
- `border-radius: 14px` — bevidst undtagelse fra designsystemets ellers skarpe hjørner; gælder kun denne boks
- Kompakt højde: 35px top/bottom padding (24px mobil)
- Ingen `border-left` farvestreg på overskriften — denne sektion er centreret, ikke venstrestillet som de øvrige tekstblokke

**Status: implementeret — fuld bredde, kompakt, symmetrisk spacing.**

## 13. Kategori-tekstblokke alignet vandret med tværsnitsillustrationens farvelag

Tværsnitsillustrationen (`Tværsnit_colors.png`) erstatter det tidligere `plantegning-block` i Sengetårnet-sektionen med et side-by-side layout (40% tekst / 60% billede). Kategori-tekstblokkene er placeret i en CSS grid-kolonne med rækker der matcher de visuelt målte proportioner i billedet:

- `grid-template-rows: 7fr 37fr 20fr 10fr 26fr`
  - 7fr: hvid sky/top
  - 37fr: grønt lag (Boliger) — center ~25.5% fra top
  - 20fr: beige lag (Hotel) — center ~54% fra top
  - 10fr: blåt lag (Spa & Wellness) — center ~69% fra top
  - 26fr: podium/fundament
- Hver tekstblok centreres vertikalt inden for sin række (`align-items: center`)
- Farvede `border-left: 8px solid` bruger eksisterende kategorifarver (--color-boliger, --color-hotel, --color-spa)
- Mobilresponsivt: ved ≤980px falder layoutet til lodret stak (billede øverst, tekstblokke nedenunder i normal rækkefølge)

**Status: implementeret.**

## 14. Hero-tekst: sort + øverste venstre hjørne

Hero-teksten ("UDSIGTEN HADERSLEV" + "En ny bydel") flyttes fra bunden til øverste venstre hjørne af billedet, og farven ændres fra hvid til mørk tekst (`var(--text)` / `var(--muted)`).

Årsag: billedets øverste del er lyseblå himmel med hvide skyer — mørkere tekst er mere læsbar og matcher pitchens stil bedre end hvid tekst foran lys baggrund. `right`-constraint fjernes så teksten er venstrestillet uden kunstig bredde-begrænsning.

CSS: `.hero-content` bruger nu `top: clamp(24px, 4vw, 48px)` i stedet for `bottom`, `color: var(--text)`. Ingen tekst-skygge nødvendig.

**Status: implementeret.**

## 15. "G"-rendering-fejl rettet: font-weight normal

`h1, h2, h3` brugte `font-weight: 800`, men `palr45w.ttf` er kun indlæst som `font-weight: normal`. Browseren syntetiserede fed ved at tegne glyphen dobbelt med en kunstig streg, hvilket gav en synlig ring/outline rundt om "G" i "SENGETÅRNET".

Fix: `font-weight: 800` → `font-weight: normal` på `h1, h2, h3`. Palatino Regular har allerede de rigtige serif-detaljer uden syntetisering.

**Status: implementeret. Husk: tilføjes der nye font-weights, skal de også deklareres i `@font-face`.**

## 16. Tværsnit-sektion: billede kun på desktop, split på mobil

Desktop viser udelukkende tværsnitsillustration — `.tvaersnit-text` er skjult (`display: none`) og `.tvaersnit-layout` er `display: block`. Tekst-kolonnens indhold (Boliger/Hotel/Spa) gentages allerede i fact-grid ovenfor, så der er ingen informationstab.

Mobil (≤980px): layout skifter til flex-kolonne, billede vises øverst (`order: -1` på image-col), derefter tekstblokke med farvede kategoristreger nedenunder. Spacers er skjult.

**Status: implementeret — se punkt 17 for opdateret implementering.**

## 17. SENGETÅRNET tværsnit: separat desktop- og mobilbillede

Desktop (≥768px): viser `Tvaersnit_med_tekst.png` — bygningstegning med tekst og farvestreger allerede indlejret i billedet. `.tvaersnit-layout`-containeren (med HTML-tekstblokke) er skjult.

Mobil (<768px): viser det originale `Tværsnit_colors.png` (uden tekst) øverst, derefter HTML-tekstblokke med Boliger/Hotel/Spa & Wellness og 8px farvede `border-left`-streger nedenunder. Breakpoint er 768px (ikke 980px som de øvrige responsive regler).

Implementeret med to separate HTML-elementer (`.tvaersnit-desktop-img` og `.tvaersnit-layout`) og CSS `display: none/flex` via media query.

**Status: implementeret.**

## Pitch-PDF side-mapping

Reference: `docs/reference/Udsigten_Haderslev_2404.pdf`

| PDF side | Indhold | Brugt på sitet |
|---|---|---|
| 1 | Hero-billede + titel | Hero-sektion (index.html) |
| 2 | Vision-tekst | Vision-boks-sektion |
| 3 | "En ny bydel for alle" + funktionsliste | Funktioner-sektion |
| 5 | Tværsnit sengetårn med kategori-farver | SENGETÅRNET-sektion (desktop: Tvaersnit_med_tekst.png) |
| 7 | Etageplan svømmehal/fitness/erhverv | Ikke brugt endnu |
| 17-22 | Hotel | Hotel-sektion |
| 23-30 | Boliger/Town Houses/Lejligheder | Boliger-sektion |
| 34 | Lokalplankort, E45, afstande | Ikke brugt endnu |
| 35 | Status og næste skridt | Status-sektion |

(Udfyld resterende sider efter behov når nyt indhold fra pitchen tages i brug.)
