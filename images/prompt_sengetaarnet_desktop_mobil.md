# udsigten02 — SENGETÅRNET-sektion: nyt billede på desktop, eksisterende på mobil

Sektionen "SENGETÅRNET TRANSFORMERES" skal have to forskellige billed-tilstande for desktop vs. mobil.

## Forberedelse
Et nyt billede `Tvaersnit_med_tekst.png` er leveret separat (delt sammen med denne prompt — placér det i `images/` mappen i repoet). Dette billede indeholder selve bygningstegningen MED tekst og farvestreger (BOLIGER/HOTEL/SPA & WELLNESS) allerede indbygget i billedet.

## Desktop (≥768px)
- Under overskriften "SENGETÅRNET TRANSFORMERES" vises KUN `images/Tvaersnit_med_tekst.png`, intet andet.
- Fjern/skjul den separate HTML-tekstblok med Boliger/Hotel/Spa & Wellness-kategorier og farvestreger, som er blevet tilføjet i tidligere opgaver — den skal IKKE vises på desktop.
- Ingen yderligere tekst, ingen ekstra overskrifter ud over den eksisterende sektions-h2. Billedet skal stå for sig selv, centreret eller i passende bredde i sektionen.

## Mobil (<768px)
- Behold den NUVÆRENDE opsætning som allerede er implementeret: det oprindelige `images/Tværsnit_colors.png` (UDEN indbygget tekst — kun selve bygningstegningen) vises øverst.
- Under billedet vises HTML-tekstblokken med de tre kategorier og deres 8px farvestreger (Boliger/Hotel/Spa & Wellness), som allerede er bygget i en tidligere opgave. Denne del ændres ikke — den fungerer allerede korrekt på mobil.
- Sørg for at farverne i denne tekstblok matcher de korrigerede hex-værdier (Boliger `#859B77`, Hotel `#B88360`, Spa & Wellness `#8CD6F6`), hvis det ikke allerede er opdateret af tidligere prompt.

## Implementering
Brug CSS media queries til at skifte hvilket billede/hvilken markup vises — enten ved at have begge elementer i HTML'en og styre synlighed med `display: none`/`display: block` via media query, eller ved at bruge `<picture>`-tagget med `<source media="...">` hvis det passer bedre ind i den eksisterende kodestruktur. Vælg den metode der er mest konsistent med hvordan responsivt indhold allerede håndteres andre steder på sitet.

## Dokumentation
Opdater `docs/DECISIONS.md`: SENGETÅRNET-sektion bruger nu `Tvaersnit_med_tekst.png` (billede med indbygget tekst) på desktop, og det oprindelige `Tværsnit_colors.png` + separat HTML-tekstblok på mobil.

---

**Commit summary:** `feat: separat desktop/mobil billedvisning i SENGETÅRNET-sektion`
