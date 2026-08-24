# Abilities API e MCP

## Scopo

Definire il confine sicuro per le ability D11 e la loro eventuale esposizione MCP.

## Perimetro incluso

Ownership, namespace `d11/*`, input/output, read/write, permission callback, capability, idempotenza, audit, staging/produzione, allowlist MCP, ability D11 Sync ristrette alle bozze e dettagli differiti.

## Perimetro escluso

Catalogo completo inventato, shell o PHP arbitrario, workflow cliente, configurazione sito, page review, screenshot, Lighthouse e sviluppo interno di componenti esterni.

Sono inoltre esclusi generazione pagine, composizione editoriale, direzione creativa, configurazione di sito cliente, delivery progressiva, workflow di produzione contenuti e Design System come configuratore.

## Fonti autorevoli

[source-specification.md](source-specification.md); durante l'implementazione, documentazione ufficiale WordPress relativa all'API adottata.

## Indice proposto

1. Versione WordPress e stato API
2. Ownership e namespace
3. Schema input/output e permessi
4. Read, write, idempotenza e conferme
5. Adapter e allowlist MCP
6. Ambienti e audit
7. Ability D11 Sync per bozze
8. Decisioni tecniche differite

## Relazioni con gli altri documenti

Dipende da [security.md](security.md); i test sono definiti con [testing.md](testing.md), senza duplicarne la strategia.

## Stato del documento

Skeleton — content pending
