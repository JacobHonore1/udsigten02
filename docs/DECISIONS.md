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

- Boliger: `#5B8A4A`
- Hotel/Restaurant: `#C4A882`
- Spa/Wellness/Svømmehal: `#5BB8D4`

**Status: implementeret.** Generelle/ukategoriserede sektioner (Vision, Status, Kontakt) bruger fortsat den neutrale `#8B5E3C`.

## 9. Plantegninger fra pitchen indsat som sekundære billeder

Fire plantegninger eksporteret manuelt fra pitch-PDF'en og indsat i de matchende sektioner med `object-fit: contain` (ikke `cover`, da hele tegningen skal være synlig) og caption-tekst:

- Tværsnit (sengetårnet) → Sengetårnet-sektionen
- Lejlighedsplan → Boliger-sektionen
- Hotel-etageplan → Hotel-sektionen
- Svømmehal-situationsplan → Svømmehal-sektionen

**Status: implementeret for disse fire. Flere illustrationer fra pitchen er endnu ikke brugt — se TODO.**

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
- Bredde: baggrund og padding er placeret på `.container`-div'en (`.vision-pitch-inner`), ikke på den ydre `<section>` — så boksen følger nøjagtigt samme max-width og sidemargin som øvrigt indhold, med hvid baggrund synlig på begge sider
- `margin-top: 70px` på ydre section (40px mobil) giver synligt hvidt mellemrum til hero-billedet
- `border-radius: 14px` — bevidst undtagelse fra designsystemets ellers skarpe hjørner; gælder kun denne boks
- Kompakt højde: 70px top/bottom padding (48px på mobil) — ikke et dominerende hero-afsnit
- Ingen `border-left` farvestreg på overskriften — denne sektion er centreret, ikke venstrestillet som de øvrige tekstblokke

**Status: implementeret og justeret (margin, runde hjørner, spacing).**
