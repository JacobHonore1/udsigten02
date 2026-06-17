# Arbejdsgang — Udsigten02

Sådan fungerer samarbejdet mellem dig, Claude (i chat) og Claude Code (i VS Code), fra idé til live ændring på sitet.

## De tre lag

1. **Claude (denne chat)** — tænker, planlægger, skriver præcise prompts. Ser ikke selve koden direkte, men har kontekst fra screenshots, uploadede filer og denne dokumentation. Laver `prompt.md` filer du kan downloade og copy-paste.
2. **Claude Code (i VS Code, terminalen)** — udfører de faktiske kodeændringer i `udsigten02`-mappen. Læser `CLAUDE.md` automatisk ved start for kontekst om projektet.
3. **Git / GitHub / Simply** — versionering og automatisk deploy. Et push til `main` udløser et GitHub Action workflow der FTP'er filerne til Simply.

## Den typiske cyklus

1. Du beskriver hvad du vil ændre (eller viser et screenshot/markerer et problem)
2. Claude (chat) skriver en præcis, selvstændig prompt — gemt som `prompt.md` og delt via `present_files` så du kan trykke og kopiere
3. Du indsætter prompten direkte i Claude Code-terminalen i VS Code (åbnet i `udsigten02`-mappen)
4. Claude Code udfører ændringerne, committer med den angivne commit-besked, og (hvis instrueret) pusher
5. GitHub Action kører automatisk → Simply opdateres → siden er live på `zaxis.dk/udsigten02`
6. Du tager et screenshot af resultatet og sender det tilbage til Claude (chat) for verifikation
7. Hvis noget er forkert → ny prompt, gentag

## Hvorfor denne arbejdsdeling

Du arbejder ikke selv med kode. Al kodearbejde går gennem Claude Code, styret af prompts. Claude (chat) fungerer som "projektleder" der:
- Holder overblik over designsystem og tidligere beslutninger (så vi ikke gentager fejl eller modsiger os selv)
- Omsætter dine observationer ("det ser forkert ud her") til konkrete, eksekverbare instruktioner
- Tjekker resultater via screenshots i stedet for at læse kode direkte

## Praktiske detaljer

**Auto-godkendelse i VS Code:** Indstillet under Settings → "claude auto approve" så Claude Code ikke spørger om bekræftelse for hver fil-edit eller terminal-kommando i dette projekt. Kun relevant for egne, betroede projekter — ikke en generel sikkerhedsanbefaling.

**Git/GitHub Desktop:** Brugeren har både VS Code's indbyggede terminal og GitHub Desktop tilgængelig. Sørg for at det rigtige repo er valgt (`udsigten02`, ikke `udsigten01`) før commit/push i GitHub Desktop — det er sket før at det stod på det forkerte repo.

**FTP-deploy:** `.github/workflows/deploy.yml` indeholder server, brugernavn og en `server-dir` der peger på `/public_html/udsigten02/`. Passwordet ligger som GitHub Secret (`FTP_PASSWORD`), ikke i koden. Hvis deploy fejler med "Input required and not supplied: password" — secret'en er sandsynligvis ikke sat endnu, eller blev sat efter et tidligere failed run (kør `git commit --allow-empty` + push for at trigge et nyt forsøg).

**Billeder fra pitchen:** Når en illustration fra PDF-pitchen skal bruges på sitet, eksporterer brugeren den manuelt som billedfil og lægger den i `images/`-mappen med et beskrivende filnavn, før Claude Code-prompten der refererer til den køres. Claude (chat) kan ikke selv hente billeder ud af en PDF og ind i projektmappen — det er et manuelt mellemled.

## Skabelon for gode prompts til Claude Code

En god prompt fra denne chat til Claude Code er:
- **Selvstændig** — kræver ikke at Claude Code har set tidligere beskeder i denne chat
- **Konkret** — nævner præcise filnavne, farvekoder, CSS-værdier, ikke vage beskrivelser
- **Afgrænset** — løser 1-3 klart definerede ting, ikke et åbent "gør det bedre"
- **Afsluttet med en commit-besked** — så Claude Code ved præcis hvad den skal skrive i `git commit -m`

## Hvad denne dokumentation IKKE er

Den erstatter ikke visuel verifikation. CSS-ændringer kan se korrekte ud i kode og stadig fejle visuelt (forkert beregnet bredde, overlap, forkert specificitet). Skærmbilleder efter hver større ændring er stadig nødvendige — dokumentationen reducerer kun risikoen for at gentage allerede afviste retninger eller løse samme problem to gange.
