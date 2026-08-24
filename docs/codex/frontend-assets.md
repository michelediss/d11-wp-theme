# Frontend e asset

## Scopo

Definire build e consumo degli asset del D11 Parent e degli output visuali validati.

## Perimetro incluso

Vite, Tailwind, source/compilati, integrazione Parent, output di `d11-design-system`, contratto token, CSS custom properties, `theme.json`, progressive enhancement, caching, versionamento e sviluppo/produzione.

## Perimetro escluso

Sviluppo interno di `d11-design-system`, palette o tipografia cliente, configuratore visuale, page review, screenshot, Lighthouse, composizione pagine e workflow contenuti.

Sono inoltre esclusi generazione pagine, direzione creativa, configurazione di sito cliente, delivery progressiva, workflow di produzione contenuti e Design System come configuratore.

## Fonti autorevoli

[source-specification.md](source-specification.md); Current: [Vite config](../../themes/d11/vite.config.js), [asset loader](../../themes/d11/inc/assets.php) e [theme.json](../../themes/d11/theme.json).

## Indice proposto

1. Input e output della build
2. Contratto token e `d11-design-system`
3. Vite, Tailwind e asset
4. `theme.json` e CSS custom properties
5. Integrazione runtime Parent
6. Development, production, cache e fallback

## Relazioni con gli altri documenti

Dipende da [architecture.md](architecture.md); serve [gutenberg-development.md](gutenberg-development.md) e [release.md](release.md).

## Stato del documento

Skeleton — content pending
