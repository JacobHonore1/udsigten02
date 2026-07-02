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

## 18. Hero-tekst usynlig på mobil — root cause og fix

**Root cause:** `.site-header` er `position: fixed; top: 0; z-index: 999` med `padding: 22px 0` og logo på 100px → header er 144px høj. `body` har ingen `padding-top` og `.hero` havde ingen `margin-top`, så hero-sektionen begyndte ved y=0 i dokumentet — direkte bag navigationen. `.hero-content` med `top: clamp(24px, 4vw, 48px)` lå i viewport-koordinat y=24-48, altså fuldt dækket af den hvide nav-bjælke.

På desktop var hero-billedet tilstrækkeligt højt til at den synlige del under navbaren stadig gav et godt helhedsindtryk. På mobil var billedet proportionalt kortere (landscape-ratio på smal skærm = lille højde), og teksten var komplet skjult bag navbaren.

**Fix:** `margin: 148px auto 0` på `.hero` — skubber hero-sektionen 148px ned i dokumentet, så billede og tekst starter 4px under navbarens bundkant (144px header + 4px buffer). Ren hvid mellemzone er usynlig da side-baggrund og nav-baggrund begge er hvide.

## 19. Hero-overskrift font-size reduceret 50%

`UDSIGTEN HADERSLEV`-overskriften havde global `h1`-størrelse (`clamp(2.6rem, 8vw, 6rem)`). Reduceret til 50% ved at tilføje en specifik override på `.hero-content h1`: `font-size: clamp(1.3rem, 4vw, 3rem)`. Gælder alle skærmstørrelser. Undertitlen "En ny bydel" (`hero-sub`) ændres ikke.

## 20. Dubleret tre-kolonne tekstboks fjernet fra SENGETÅRNET-sektion

`.facts-grid`-elementet (tre kolonner med Boliger/Hotel/Spa & Wellness uden farvestreger, hvid afrundet boks) var en rest fra et tidligere layout-stadium og eksisterede parallelt med den farvekodede `tvaersnit-layout`-version af samme indhold. Fjernet fra HTML og alle tilhørende CSS-regler slettet (`.facts-grid`, `.fact-col`, responsive overrides) da klasserne ingen steder else bruges.

Den farvekodede version (8px `border-left`-streger, serif overskrifter, desktop/mobil split via `tvaersnit-desktop-img`/`tvaersnit-layout`) er den endelige, og forbliver uændret.

## 21. Ny menu-struktur

Navigationsmenuen (hoved + footer) opdateret til ny rækkefølge og navne:

1. Vision → `#vision` (anker nu på `<section class="vision-pitch">` — vision-pitch-boksen; `id="bydel"` på "EN NY BYDEL"-sektionen)
2. Boliger → `boliger.html`
3. Spa & Wellness → `#spa`
4. Hotel & Restaurant → `#hotel`
5. Svømmehal → `#svommehal` (sektionen eksisterede allerede — ingen placeholder nødvendig)
6. Kontakt → `#kontakt` (styled som nav-cta)

Fjernede: Udsigtstårnet, Funktioner, Status som synlige nav-punkter.

## 22. Visuel signup-boks i hero

Pille-formet email signup-boks tilføjet i **nederste højre hjørne** af hero-sektionen (`position: absolute; bottom; right`).

- Semi-transparent hvid baggrund: `rgba(255,255,255,0.85)` med `backdrop-filter: blur(6px)`
- Cirkulært hus-ikon (SVG line-style) i lys cirkel `rgba(26,20,16,0.06)` til venstre
- `<input type="email">` med placeholder "Bliv skrevet op til en bolig!" — ren visuel, ingen backend
- Placeholder opacity: `rgba(26,20,16,0.45)`
- Bredde: `min(320px, ...)` — maks 320px på desktop
- Mobil (<768px): centreret i bunden (`left: 50%; transform: translateX(-50%)`)

**Ingen backend/funktionalitet endnu** — formularen har ingen submit-handler.

## 23. Farvede sektionsbokse (skillerum) før hovedafsnit

Fuldbredde (= content-width, spejler hero/vision-boks) farvede bokse indsat som visuelt "pusterum" før hvert hovedafsnit — inspireret af pitchens Vision-side. Fire bokse:

- Før `#spa` → blå (`.divider-spa`), "SPA & WELLNESS"
- Før `#svommehal` → blå (`.divider-spa`), "SVØMMEHAL"
- Før `#hotel` → sand (`.divider-hotel`), "HOTEL & RESTAURANT"
- Før `#boliger` → grøn (`.divider-boliger`), "BOLIGER"

Designvalg:
- Overskrift: Palatino, store bogstaver, hvid. Undertekst: én linje, `rgba(255,255,255,0.9)`
- Baggrund = kategorifarve-variablerne (`--color-spa/hotel/boliger`) — samme kilde som farvestregerne, så farverne aldrig kan divergere
- Hård, lige kant: solid farve, ingen gradient, ingen buet clip-path (bevidst udskudt til senere)
- `border-radius: 14px` som vision-boksen (punkt 12); ellers skarpe hjørner i designsystemet
- Kompakt højde via `padding: clamp(32px, 4.5vw, 56px)`

**Status: implementeret.** Bemærk: to blå bokse (Spa + Svømmehal) står i samme farve men adskilt af Spa-sektionens indhold.

## 24. Farvekonsistens bekræftet — prompt-estimater afvist til fordel for pitch-målte farver

En prompt bad om at sætte kategorifarverne til `#5B8A4A` / `#C4A882` / `#5BB8D4`. Dette er præcis de estimerede værdier, som punkt 8 tidligere bevidst forkastede til fordel for de pitch-målte `#859B77` / `#B88360` / `#8CD6F6`. Konflikten blev forelagt brugeren, som **valgte at beholde de pitch-målte farver**.

Konsekvens: CSS-variablerne er uændrede. De nye sektionsbokse og alle eksisterende 8px-farvestreger trækker begge på de samme variabler og er dermed konsistente på tværs af sitet. Prompt sektion 4's foreslåede hexværdier blev ikke implementeret.

**Status: farvekonsistens bekræftet — én kilde (`:root`-variabler) for både streger og bokse.**

## 25. "Status og næste skridt"-sektion — allerede etableret

Prompt bad om en ny to-spaltet status-sektion før footeren (jf. pitch side 35). Sektionen (`<section class="section status" id="status">`) fandtes allerede med korrekt struktur: overskrift "STATUS OG NÆSTE SKRIDT" med farvestreg (neutral `--accent`, jf. reglen for ukategoriserede sektioner), to-spaltet `.status-grid` med `.status-list`-punkter. Indholdet er foreløbigt/generisk og kan udskiftes når konkret tekst modtages. Ingen strukturændring nødvendig.

**Status: bekræftet på plads — kun indhold mangler.**

## 26. Alle billeder udskiftet med nye fra images_new — matcher pitchens rækkefølge

Alle billedreferencer på sitet (`index.html`, `boliger.html`) erstattet med 27 nye billeder fra `images_new/`, i den rækkefølge pitch-præsentationen definerer:

- **Hero** (index.html): udvidet fra ét statisk billede til et 4-billeders crossfade-slideshow (`UDSIGTEN HADERSLEV EN NY BYDEL_01/02/03` + `Altan view`) — ren CSS-animation (`@keyframes`, ingen JS), `.hero-slideshow` med `aspect-ratio: 16/9` da de absolut positionerede billeder ikke længere selv sætter containerens højde. **FORLADT, se punkt 27.**
- **En ny bydel for alle**: 1:1 udskiftning.
- **Sengetårnet transformeres**: både desktop- og mobil-tværsnitsbilledet peger nu på samme nye fil (`sengetaarnet-transformeres.png`), da mappingen kun angav ét billede for sektionen. Den nederste fullwidth-udsigt (`View_West.jpg`) er ikke dækket af den nye mapping og forblev uændret.
- **Spa & Wellness, Svømmehal, Hotel**: hver sektions split-billede udskiftet med det første mappede billede; ekstra billeder ud over det ene split-slot tilføjet som `.gallery-grid` (samme klasse som Boliger-sektionen allerede brugte) lige under split-sektionen — Svømmehal fik 5 ekstra (Mere end en svømmehal + fire "Fra standard..."), Spa fik 2 ekstra, Hotel fik 2 ekstra. **`.gallery-grid`-opdelingen er FORLADT, se punkt 27.**
- **Restaurant**: split-billede udskiftet med `hotel-cafe-restaurant.jpg`.
- **Boliger**: gallery udvidet fra 3 til 6 billeder (fire Town Houses + to Lejligheder). **`.gallery-grid`-opdelingen er FORLADT, se punkt 27.** `boliger.html`s hero-billede skiftet til `lejligheder_02.jpg` (ikke eksplicit dækket af mappingen — valgt fordi siden handler om lejligheder).
- **Status og næste skridt**: sektionen havde intet billede før — tilføjet som `.fullwidth-image` (samme mønster som Sengetårnet-sektionen) efter status-listerne.
- **Afsluttende billede**: ny `<section>` med `.fullwidth-image` indsat mellem Status og Kontakt, med `udsigten-haderslev-en-ny-bydel.jpg`.

**Omdøbte filer:** Alle 27 filer fra `images_new/` blev flyttet til `images/` og omdøbt til rene, URL-venlige navne (små bogstaver, bindestreger, ingen mellemrum/æøå/`&`) — fx `SVØMMEHAL SPA & WELLNESS FITNESS.png` → `svommehal-spa-wellness-fitness.jpg`. Årsag: mellemrum, danske bogstaver og `&` i filnavne er risikable i URL-stier ved FTP-deploy til Simply, og `images_new/` som separat mappe blev vurderet unødvendig ved siden af den eksisterende `images/`-struktur. `images_new/`-mappen er fjernet efter flytningen.

**Filstørrelse — kritisk fix:** De originale filer fra pitch-eksporten var langt for store til web: de tre hero-billeder var 34,6–40 MB hver (14304–16000px brede), og to Town Houses-billeder var 23,5/27,5 MB (16000×9000px). Samlet `images/`-mappe var 224 MB, hvilket fik `git push` til at gå i timeout. Alle 27 billeder er nedskaleret til maks. 2200px på længste side og genkomprimeret; fotografiske PNG'er (som reelt var ukomprimerede JPEG-eksporter gemt som PNG) konverteret til JPEG kvalitet 82–84, da lossless PNG-genkomprimering af fotoindhold gav *større* filer, ikke mindre. Filtypeendelser for de konverterede filer (`.png` → `.jpg`) er opdateret i alle HTML-referencer. Resultat: `images/`-mappen er nu 25 MB samlet.

**Status: implementeret — men punkt 26's hero-slideshow og gallery-grid-opdeling er efterfølgende forladt, se punkt 27.**

## 27. Hero-slideshow og billedgallerier fra punkt 26 rullet tilbage — matcher pitchens ét-billede-per-slide-stil

Punkt 26's to tilføjelser matchede ikke pitch-præsentationens præsentationsstil og blev rullet tilbage:

- **Hero: crossfade-slideshow → ét statisk billede.** `.hero-slideshow` (4 stablede `.hero-bg`-billeder, `@keyframes`-crossfade, `aspect-ratio: 16/9`) er fjernet helt fra CSS. Hero er nu ét `<picture>`-element med et enkelt `<img class="hero-bg">`: `<source media="(max-width: 767px)">` peger på `Side 1_frontpage_cover_lake.jpg`, fallback-`<img>` (desktop) peger på `Side 1_frontpage_cover_construction.jpg`. Breakpoint 767px valgt for at matche det eksisterende 768px-breakpoint (samme som `.tvaersnit-desktop-img`/mobilmenu). Ingen JS var involveret i slideshowet, så intet at fjerne der. `.hero` beholder sin oprindelige `max-width: var(--content-width)` — samme bredde som resten af sidens indhold, uændret.
- **`.gallery-grid`-opdeling fjernet fra Svømmehal, Spa & Wellness, Hotel og Boliger.** Alle billeder der tidligere lå i et grid af mindre `.gallery-item`-elementer vises nu som fuldbredde enkeltbilleder (`.fullwidth-image`, samme klasse som allerede brugt i Sengetårnet- og Status-sektionerne) — ét billede per "slide", som i pitchen:
  - **Spa & Wellness, Svømmehal, Hotel:** split-sektionens billede (billede 1) uændret. De resterende billeder for hver sektion er samlet i én efterfølgende `<section class="section">` med flere stablede `.fullwidth-image`-divs (ikke én `<section>` per billede — det ville have givet dobbelt `--section-pad`-luft mellem hvert billede og modarbejdet den kompakte "avis"-spacing fra designsystemet).
  - **Boliger:** de 6 billeder (Town Houses ×4, Lejligheder ×2) er nu stablede `.fullwidth-image`-divs direkte i Boliger-sektionen, mellem introteksten og plantegningen — `.container` lukkes før billedrækken og genåbnes bagefter, så billederne får fuld sektionsbredde ligesom Sengetårnet/Status-mønsteret, mens plantegning og CTA-knap forbliver i den smallere container.
  - `.gallery-grid`/`.gallery-item`-CSS-klasserne er **ikke** fjernet fra `style.css` — de er en generel designsystem-komponent (fandtes allerede i Boliger-sektionen før punkt 26) og kan genbruges senere; de er blot ikke længere i brug nogen steder lige nu.

**Status: implementeret.**

## 28. Svømmehal-sektion: skitse fjernet, hovedbillede og etageplan byttet om

To rettelser til billedrækkefølgen i Svømmehal-sektionen (`id="svommehal"`):

- **Skitse-billedet fjernet helt.** `mere-end-en-svommehal.jpg` (håndtegnet skitse af bygningen) er fjernet fra sin `.fullwidth-image`-div og optræder ikke længere nogen steder på siden. Selve filen ligger fortsat i `images/` (ubrugte billeder ryddes ikke automatisk, jf. oprydningspunktet i `docs/TODO.md`).
- **Hovedbillede og etageplan byttet om.** Split-sektionens billede (ved siden af "SVØMME HAL"-overskriften) var `svommehal-spa-wellness-fitness.jpg` (etageplan) — det er nu `fra-standard-svommehal-til-destination_3.jpg` (poolbillede med udsigt gennem panoramavinduer). Etageplanen er flyttet ned og indsat som første `.fullwidth-image` i billedrækken under split-sektionen, så den ikke længere er hovedbilledet.

Ny rækkefølge i sektionen: split-billede (`fra-standard..._3.jpg`) → `svommehal-spa-wellness-fitness.jpg` → `fra-standard..._1.jpg` → `fra-standard..._2.jpeg` → `fra-standard..._4.jpg`. `_3.jpg` optræder kun i split-sektionen, ikke længere også i fuldbredde-rækken.

**Status: implementeret.**

## 29. Hotel-sektion: etageplan skaleret rigtigt op, detaljeret etageplan fjernet

**Root cause fundet og rettet:** `.split-image img` (specificitet 0-1-1) havde højere specificitet end `.plantegning` (0-1-0), så når en `.plantegning`-etageplan lå nestet i en `.split-image`-kolonne (Hotel-sektionens tilfælde), overskrev `.split-image img` stille og roligt `.plantegning`s `object-fit: contain` med `object-fit: cover` og `border-radius: 4px` med `8px` — uden at det var synligt i koden, kun i cascaden. Rettet ved at tilføje en dedikeret regel `.split-image .plantegning` (specificitet 0-2-0, vinder over `.split-image img`) der eksplicit sætter `width: 100%; height: auto; object-fit: contain; border-radius: 4px;`. `.plantegning` og `.plantegning-block` fik desuden eksplicit `width: 100%; max-width: 100%; height: auto; display: block;` for at garantere fuld boksbredde uden beskæring eller forvrængning, uanset kontekst.

`Hotel etage_Floorplan.png` er selv en meget bred/kort banner-formet fil (2890×522px, ca. 5,5:1) — med `object-fit: contain` og fuld boksbredde skalerer den nu proportionelt korrekt op til hele `.plantegning-block`s bredde uden beskæring.

**Detaljeret etageplan fjernet.** `hotelvaerelser_01.png` (den detaljerede plantegning med rum markeret Linned, Elevator, Skakt, Personale, Hovedtrappe, Hotel Lounge) og det omkringliggende `.fullwidth-image`-element er fjernet fra Hotel-sektionen. Hotel-sektionens fuldbredde-billedrække består nu kun af `hotel02.jpg`.

**Status: implementeret — men se punkt 30, som flytter etageplanen ud af `.split-image` og gør `.split-image .plantegning`-specificitetsfixet herover irrelevant (koden er fjernet igen).**

## 30. Etageplanen flyttet ud af split-sektionen — matcher bredden af billedet nedenunder

Etageplanen (`Hotel etage_Floorplan.png`) sad i `.plantegning-block` inde i `.split-image`, hvor den kun fik 60% af sidens indholdsbredde (den delte kolonne med hotel-fotoet). Brugeren ville have den lige så bred som `hotel02.jpg` — det fuldbrede billede i sektionen nedenunder.

**Løsning:** `.plantegning-block` er flyttet ud af `.split-image` og placeret som et selvstændigt element i samme `<section class="section">` som `hotel02.jpg`s `.fullwidth-image`, lige efter det. `.plantegning-block` fik sin egen bredde-formel, identisk med `.fullwidth-image`s: `margin: var(--section-pad) auto 0; max-width: calc(var(--content-width) - 2 * var(--gutter));` — samme centrering og samme maks-bredde som ethvert fuldbredt billede i designsystemet, uden `.fullwidth-image`s faste højde/`object-fit: cover` (som ville beskære den brede, korte etageplan-fil). Da `.container` allerede giver Boliger-sektionens `.plantegning-block` samme effektive bredde, er ændringen bagudkompatibel dér — ingen visuel ændring for Boliger.

Da ingen `.plantegning`-billede længere er nestet i `.split-image` noget sted på sitet, er de dedikerede overrides fra punkt 29 (`.split-image .plantegning-block`, `.split-image .plantegning`) fjernet igen som død kode.

**Status: implementeret.**

## 31. "Se alle boliger"-knap fjernet, Boliger-menupunkt peger nu internt

To rettelser i `index.html`:

- **"SE ALLE BOLIGER"-knappen fjernet.** `<a href="boliger.html" class="btn reveal">Se alle boliger →</a>` — hele elementet, ikke kun teksten — er fjernet fra Boliger-sektionen, lige efter plantegningsboksen.
- **Boliger-menupunktet peger nu internt.** Både i main nav og footer nav pegede "Boliger" på `boliger.html`. Ændret til `href="#boliger"` begge steder, så det scroller til Boliger-sektionen på `index.html` i stedet. Sektionen havde allerede `id="boliger"` på `<section>`-taget, så ingen HTML-ændring var nødvendig der.

`boliger.html` som selvstændig side er ikke slettet eller ændret — den er blot ikke længere linket fra hoved- eller footer-navigationen.

**Status: implementeret.**

**Status: implementeret.**
