# Åbne opgaver — Udsigten02

Opdater denne liste når opgaver løses eller nye opstår. Streg ikke bare over — flyt løste punkter til en "Løst"-sektion nederst så historikken bevares.

## Boliger-underside (boliger.html)

- [ ] Live-integration med OneDrive/Excel — der er et fallback med 3 hardkodede eksempel-lejligheder, men selve OneDrive CSV-fetch er ikke testet med et rigtigt share-link endnu. Kunden skal levere det faktiske OneDrive-link.
- [ ] Image Map Pro-integration (interaktiv plantegning hvor man klikker på lejligheder for at se data) — der er kun en placeholder-container med id `imagemap-container` klar til embed. Selve Image Map Pro-opsætningen er ikke startet.
- [ ] Lejlighedskort skal vise status (ledig/reserveret/solgt) med farveindikator — implementeret i fallback-data, men skal valideres mod rigtig data når Excel-integrationen er live.

## Visuelt indhold fra pitchen, ikke brugt endnu

Følgende illustrationer findes i `Udsigten_Haderslev_2404 (2).pdf` men er ikke eksporteret/indsat på sitet:

- [ ] Situationsplan/fugleperspektiv af hele området (side 3) — kunne bruges i Vision-sektionen eller en ny "Beliggenhed"-sektion
- [ ] Lokalplankort med E45, afstand til centrum, Haderslev population (side 34) — relevant til Vision eller Status
- [ ] Town houses snittegning (side 24) — hvis Town Houses får sin egen undersektion
- [ ] Arkitektskitse/håndtegnet facade (side 8, "Mere end en svømmehal") — kunne give Status-sektionen mere visuel substans
- [ ] Træmodel-fotos af hele bydelen (side 32-33) — stærkt visuelt materiale, ikke brugt endnu

## Designsystem — løbende tilsyn

- [ ] De vertikale farvestreger (border-left) er strukturelt rettet (se DECISIONS.md punkt 10), men skal tjekkes visuelt efter enhver ny sektion eller indholdsændring — let at få linjen til at "smutte" igen ved fremtidige redigeringer
- [ ] Ingen formel "design QA"-runde er kørt endnu for mobilversionen — alt arbejde indtil videre er vurderet på desktop-bredde

## Infrastruktur

- [ ] Ingen custom domæne sat op specifikt for udsigten02 — kører på `zaxis.dk/udsigten02` via Simply mappestruktur, hvilket virker, men er ikke et "rigtigt" eget domæne
- [ ] Ingen 404-side eller fejlhåndtering testet

## Indhold der mangler endelig godkendelse fra kunden

- [ ] Nyhedstekster på forsiden er stadig eksempeltekst (Vinterlys på Udsigten, Camp West åbner dørene, Svømmehallen vender tilbage) — skal erstattes med rigtige nyheder når/hvis kunden leverer dem
- [ ] Kontaktoplysninger (email, CVR, Instagram) skal verificeres som korrekte og aktuelle

---

## Løst

- [x] Hero fyldte kun halvdelen af skærmen, tekst lå under billedet i stedet for ovenpå — rettet
- [x] Inkonsistent bredde mellem nav og indhold — rettet med fælles content-width
- [x] For meget vertikal spacing mellem sektioner — reduceret ~50%
- [x] 50/50 split ændret til 60/40 (billede/tekst)
- [x] Playfair Display udskiftet med custom Palatino TTF
- [x] Logo-størrelse justeret (+30%)
- [x] Kategorifarver fra pitch-tværsnit implementeret (boliger/hotel/spa)
- [x] Fire plantegninger fra pitchen indsat i matchende sektioner
- [x] GitHub Actions auto-deploy til Simply sat op og verificeret virkende
