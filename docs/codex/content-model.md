# Content model dichiarativo

## Scopo

Definire il registry integrato nel Parent per contenuti strutturati dichiarativi.

## Perimetro incluso

Registry Parent, CPT, tassonomie, custom field, JSON, JSON Schema, ID/slug, extension point, validazione runtime, API WordPress-native, migrazioni D11 Migration e confine generator/runtime.

## Perimetro escluso

Sincronizzazione contenuti, UI ACF-like, configurazione cliente, page review, screenshot, Lighthouse, delivery editoriale e sviluppo interno di componenti esterni.

Sono inoltre esclusi generazione pagine, composizione editoriale, direzione creativa, configurazione di sito cliente, delivery progressiva, workflow di produzione contenuti e Design System come configuratore.

## Fonti autorevoli

[source-specification.md](source-specification.md); Current: [content sync legacy](../../themes/d11/inc/content-sync/).

## Indice proposto

1. Ownership e confini
2. Modello dei documenti JSON
3. JSON Schema e profilo D11
4. Registry e registrazione WordPress
5. ID, kind e slug
6. Validazione, errore e atomicità
7. Extension point e migrazioni
8. Tooling e runtime

## Relazioni con gli altri documenti

Dipende da [architecture.md](architecture.md); coordina migrazioni e qualità con [testing.md](testing.md) e [security.md](security.md).

## Stato del documento

Skeleton — content pending
