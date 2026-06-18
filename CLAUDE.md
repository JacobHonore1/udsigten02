# Udsigten02 — Projektkontekst for Claude Code

Dette er kontekstfilen Claude Code læser automatisk når den starter i dette repo. Hold den opdateret — den er "hukommelsen" mellem sessioner.

## Hvad er dette projekt?

Udsigten Haderslev er et ejendomsudviklingsprojekt: det gamle sygehus i Haderslev omdannes til en ny bydel med boliger, hotel, restaurant, spa, svømmehal og erhverv. `udsigten02` er en **parallel, uafhængig redesign** af det originale site (`udsigten01`), bygget fordi kunden ikke var tilfreds med det første design.

`udsigten01` og `udsigten02` deler ingen kode, intet repo og ingen deploy-pipeline. De er 100% separate projekter ved siden af hinanden. Rør aldrig udsigten01 fra dette repo.

## Designkilde

Designet er bygget direkte på kundens egen pitch-præsentation (`Udsigten_Haderslev_2404 (2).pdf`), ikke på fri kreativ fortolkning. Sektionsrækkefølge, tekstindhold, farvekodning og plantegninger er alle hentet derfra. Hvis der er tvivl om indhold eller struktur — tjek pitchen først.

## Designsystem

**Farver — base:**
- Baggrund: `#ffffff` (ren hvid)
- Tekst: `#1a1410` (næsten sort)
- Sekundær tekst: `#6b6560` (grå)
- Generel accent/streg: `#8B5E3C` (terracotta/brun)

**Farver — kategorispecifikke** (fra tværsnitdiagrammet i pitchen, side 5):
- Boliger: `#859B77` (dæmpet sage-grøn, målt fra pitch-PDF)
- Hotel & Café/Restaurant: `#B88360` (varm orange-brun, målt fra pitch-PDF)
- Spa & Wellness, Svømmehal: `#8CD6F6` (lys himmelblå, målt fra pitch-PDF)
- Vision og generelle sektioner uden kategori: behold `#8B5E3C`

Disse farver bruges som `border-left` på de vertikale streger ved overskrifter i de relevante sektioner — ikke vilkårligt, kun hvor indholdet faktisk hører til den kategori.

**Typografi:**
- Headlines (h1, h2, h3): **Palatino** (custom TTF, `fonts/palr45w.ttf`, indlæst via `@font-face`) — ikke Google Fonts Playfair Display, det blev udfaset
- Body: **Inter** (Google Fonts)
- Ingen anden font må introduceres uden eksplicit godkendelse

**Layout-regler:**
- Max content-width: ca. 1300px, centreret
- Alt indhold (nav, hero, sektioner, billeder) skal have samme bredde — intet må være bredere end navigationen
- Split-sektioner (billede + tekst side om side): **60/40** — billede 60% (`3fr`), tekst 40% (`2fr`) — ikke 50/50
- Vertikal sektion-spacing skal være kompakt — ikke luftig "arkitekt-PDF" spacing, men tæt som en avis
- Vertikale farvede streger ved overskrifter skal:
  - Wrappe HELE tekstblokken (heading + paragraffer + lister) i en container med `border-left`, ikke kun headingen — så linjen automatisk bliver lige så høj som indholdet
  - Være 8px tykke (dobbelt af det oprindelige)
  - Align horisontalt 100% konsekvent mellem alle sektioner, venstre og højre side
- Hero-billede: ingen cropping/maske — `object-fit: contain`, fylder fuld bredde, ingen forvrængning
- Ingen kort/cards går kant-til-kant uden padding — der skal altid være luft til skærmkanten

**Hvad vi har forladt undervejs (gør IKKE dette):**
- Mørk skovgrøn/guld tema — forladt, kunden ville have lyst/hvidt design baseret på pitchen
- Sand/beige baggrund — forladt for ren hvid
- Playfair Display — udfaset til fordel for Palatino
- 50/50 billede/tekst split — ændret til 60/40
- Store luftige sektioner (arkitekt-PDF stil) — ændret til kompakt spacing

## Plantegninger og illustrationer fra pitchen

Disse er placeret i `images/` og indsat i de relevante sektioner (ikke som hovedbilleder, men som supplerende fuldbred billeder med caption, `object-fit: contain`, lys baggrund `#f8f8f8`):

- `Tværsnit_colors.png` → Sengetårnet-sektionen
- `Boliger_2d_floorplan_lejligheder.png` → Boliger-sektionen
- `Hotel_etage_Floorplan.png` → Hotel-sektionen
- `Snit_Svømmehal_2d_Alternativ.png` → Svømmehal-sektionen

Der er flere illustrationer i pitchen (situationsplan, arkitektskitser, town house-snit, lokalplankort) som endnu ikke er indsat — se `docs/TODO.md`.

## Sider i projektet

- `index.html` — forsiden, alle hovedsektioner
- `boliger.html` — boligunderside med dynamiske lejlighedskort, planlagt live-data fra OneDrive/Excel og fremtidig Image Map Pro-integration
- `style.css` — al styling, ingen inline styles ud over undtagelser markeret i koden
- `fonts/palr45w.ttf` — Palatino custom font

## Infrastruktur og deploy

- **Repo:** `github.com/JacobHonore1/udsigten02`
- **Hosting:** Simply.com, mappe `/public_html/udsigten02/`
- **Deploy:** GitHub Actions (`.github/workflows/deploy.yml`) — push til `main` trigger automatisk FTP-deploy til Simply
- **Secret:** `FTP_PASSWORD` er sat i repo Settings → Secrets → Actions
- **Live URL:** `zaxis.dk/udsigten02`

Se `docs/WORKFLOW.md` for den fulde arbejdsgang fra prompt til live site.

## Vigtigt for Claude Code at vide

- Brugeren arbejder ikke selv med kode — al kommunikation sker via prompts skrevet af en anden Claude-instans (i en chat-app) og indsat direkte i denne terminal. Forklar derfor ikke "hvorfor" i lange baner; udfør ændringerne præcist som beskrevet i promptet.
- Terminal-kommandoer og fil-edits er sat til auto-approve i VS Code settings — du behøver ikke spørge om bekræftelse for almindelige redigeringer i dette repo.
- Når en prompt beder om en "Commit summary" i bunden — brug præcis den tekst som git commit-besked.
- Skriv ALDRIG til `udsigten01`. Hvis du nogensinde ser referencer til den mappe, eller bliver bedt om at "gøre det samme som udsigten01" — det betyder kopiér adfærden, ikke filerne.

## Filer at holde opdateret

- `docs/DECISIONS.md` — log nye designvalg her når de bliver truffet, særligt hvis de ændrer eller overskriver tidligere valg
- `docs/TODO.md` — opdater når opgaver løses eller nye opstår
- `docs/DESIGN_TOKENS.md` — opdater hvis CSS-variabler ændres i `:root`
- Denne fil (`CLAUDE.md`) — opdater designsystem-sektionen hvis farver, fonte eller layout-regler ændres permanent

## Definition of done — visuelle/layout-ændringer

Efter ENHVER ændring der påvirker bredde, margin, padding, spacing eller positionering:

1. Angiv i dit svar de konkrete numeriske værdier du har sat (i px eller %), ikke kun "justeret bredden".
   Eksempel: "Sektionen har nu max-width: 1200px, margin: 0 auto, padding: 80px 0" — ikke "gjort smallere".
2. Hvis ændringen skal matche et andet element på siden (f.eks. "samme bredde som hero"), bekræft
   eksplicit at du har sammenlignet de faktiske CSS-værdier for begge elementer, ikke kun antaget det.
3. Ved tvivl om hvad "bredde" eller "afstand" refererer til (fuld viewport-bredde vs. indholds-max-width
   vs. afstand mellem elementer), stop og spørg om præcisering i stedet for at gætte.
4. Vis den ændrede CSS-regel direkte i dit svar (kort code snippet), ikke kun en bekræftelse at det er gjort.
