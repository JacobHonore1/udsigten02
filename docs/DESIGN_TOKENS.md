# Design Tokens — udsigten02

Kilde til sandhed for alle farver og spacing-værdier. Defineres som CSS-variabler i `:root` i `style.css` —
opdatér ÉT sted (variablen), ikke hardcoded hex-værdier spredt i kodebasen.

## Farver

| Token | Hex / Værdi | RGB | Anvendelse |
|---|---|---|---|
| `--bg` | `#ffffff` | 255,255,255 | Baggrund, generelt |
| `--bg-light` | `#f8f6f3` | 248,246,243 | Let baggrund (plantegning-blokke, input-felter) |
| `--text` | `#1a1410` | 26,20,16 | Primær tekst |
| `--muted` | `#6b6560` | 107,101,96 | Sekundær tekst, billedtekster |
| `--accent` | `#8B5E3C` | 139,94,60 | Generel accent (Vision-boks, neutrale sektioner) |
| `--color-boliger` | `#859B77` | 133,155,119 | Boliger-kategori (sage green) |
| `--color-hotel` | `#B88360` | 184,131,96 | Hotel/Restaurant-kategori (warm terracotta) |
| `--color-spa` | `#8CD6F6` | 140,214,246 | Spa & Wellness/Svømmehal-kategori (sky aqua) |
| `--line` | `rgba(26,20,16,0.10)` | — | Separator-linjer, border-farve |

**Note:** kategorifarverne (`--color-boliger`, `--color-hotel`, `--color-spa`) blev oprindeligt visuelt
estimeret fra pitch-PDF'en og er siden korrigeret til faktisk målte hex-værdier (se DECISIONS.md punkt 8).
Hvis disse værdier skal ændres igen, mål dem direkte fra kildematerialet (PDF/billede) — estimér ikke visuelt.

## Spacing

| Token | Værdi | Anvendelse |
|---|---|---|
| `--content-width` | `1300px` | Max-bredde for alt indhold (nav, hero, sektioner) |
| `--gutter` | `clamp(24px, 4vw, 60px)` | Horisontal padding på sektioner og containere |
| `--section-pad` | `clamp(16px, 2.5vw, 30px)` | Vertikal padding på sektioner |

**Hardcoded spacing-værdier** (ikke CSS-variabler, men konsekvent brugt):

| Kontekst | Værdi | Sted |
|---|---|---|
| `section-block` border-venstre | `8px solid` | Alle kategori-farvestreger ved overskrifter |
| `section-block` padding-venstre | `24px` | Indrykning fra farvestreg til tekst |
| Split-layout | `3fr 2fr` (60/40) | Billede/tekst side om side |
| Split-layout gap | `clamp(24px, 4vw, 60px)` | Mellemrum i split-sektioner |
| Split-text padding | `clamp(40px,6vw,100px)` | Indvendig padding i tekstkolonne |
| Vision-boks margin | `35px auto` | Top/bund afstand til hero og næste sektion |
| Vision-boks radius | `14px` | Eneste sted der bruges border-radius på en boks |

## Typografi

| Element | Værdi | Kilde |
|---|---|---|
| Headlines (`h1`, `h2`, `h3`) | Palatino, `font-weight: normal` | `fonts/palr45w.ttf` via `@font-face` |
| Body | Inter 300–700 | Google Fonts |
| `h1` størrelse | `clamp(2.6rem, 8vw, 6rem)` | — |
| `h2` størrelse | `clamp(2rem, 4.6vw, 3.6rem)` | — |
| `h3` størrelse | `clamp(1.2rem, 1.8vw, 1.5rem)` | — |
| Body størrelse | `clamp(0.95rem, 1.1vw, 1.05rem)` | — |

**Advarsel:** Tilføj ikke nye font-weights til headlines uden at deklarere dem i `@font-face`.
`palr45w.ttf` er kun Roman (normal weight) — browser-syntetisering af fed skaber rendering-artefakter.
