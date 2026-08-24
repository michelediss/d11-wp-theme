# Sistema documentale Codex — D11 Parent

## Scopo

Indice e router della documentazione agentica per lo sviluppo del D11 Parent canonico. Non è documentazione di configurazione o delivery di un sito cliente.

## Ordine di autorità

1. Decisioni Nextcloud aggiornate; 2. repository e configurazioni per Current; 3. test; 4. documentazione legacy verificata; 5. documentazione ufficiale WordPress per dettagli non decisi. [source-specification.md](source-specification.md) consolida transitoriamente queste fonti.

## Mappa dei documenti

| Documento | Responsabilità esclusiva | Dipende da | Stato |
|---|---|---|---|
| [architecture.md](architecture.md) | Confini e struttura D11 | source specification | Canonical |
| [parent-child-contract.md](parent-child-contract.md) | Contratto Parent–Child | architecture | Canonical |
| [coding-standards.md](coding-standards.md) | Qualità implementativa trasversale | source specification | Skeleton — content pending |
| [gutenberg-development.md](gutenberg-development.md) | Blocchi e sviluppo Gutenberg | parent-child contract | Skeleton — content pending |
| [content-model.md](content-model.md) | Registry e schema contenuti | architecture | Skeleton — content pending |
| [frontend-assets.md](frontend-assets.md) | Asset e output visuali | architecture | Skeleton — content pending |
| [feature-modules.md](feature-modules.md) | Feature condivise Parent | architecture, security | Skeleton — content pending |
| [abilities-mcp.md](abilities-mcp.md) | Ability e confine MCP | security | Skeleton — content pending |
| [security.md](security.md) | Threat boundary e controlli | source specification | Skeleton — content pending |
| [testing.md](testing.md) | Test e quality gate | contratti tematici | Skeleton — content pending |
| [release.md](release.md) | Versioni e distribuzione | parent-child contract, testing | Skeleton — content pending |

## Se devi fare X, leggi Y

| Attività | Lettura minima |
|---|---|
| Decidere dove collocare codice | [architecture.md](architecture.md) |
| Modificare un extension point | [parent-child-contract.md](parent-child-contract.md) |
| Sviluppare un blocco | [gutenberg-development.md](gutenberg-development.md) |
| Modellare dati strutturati | [content-model.md](content-model.md) |
| Modificare build o token output | [frontend-assets.md](frontend-assets.md) |
| Intervenire su funzionalità condivise | [feature-modules.md](feature-modules.md) |
| Esporre azioni agentiche | [abilities-mcp.md](abilities-mcp.md) |
| Rilasciare un artefatto | [release.md](release.md) e [testing.md](testing.md) |

## Dipendenze e non duplicazione

Ogni regola vive in un solo documento: i documenti correlati la collegano senza copiarla. [source-specification.md](source-specification.md) rimane la fonte transitoria finché tutti gli scheletri non saranno completati e revisionati.

## Separazione dalla delivery

Questa mappa copre sviluppo prodotto. La futura documentazione di configurazione/delivery coprirà, separatamente, pagine cliente, composizione editoriale, direzione creativa e produzione contenuti.

Sono esclusi da questo sistema: generazione pagine, composizione editoriale, direzione creativa, configurazione di sito cliente, page review, screenshot, Lighthouse, delivery progressiva, workflow di produzione contenuti, Design System come configuratore e sviluppo interno di plugin o MU-plugin separati.

## Stato del documento

Canonical
