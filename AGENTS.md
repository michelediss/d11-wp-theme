# D11 Parent — router per agenti

## Scopo del repository

Questo repository contiene lo stack locale e il checkout operativo di D11 WordPress in `wordpress/wp-content`. Questa documentazione guida esclusivamente lo sviluppo e la manutenzione del **D11 Parent canonico** e dei suoi confini tecnici.

## Perimetro della documentazione

Copre Parent, Child, blocchi condivisi, content model, asset, funzionalità Parent, Abilities API, sicurezza, test e distribuzione. I plugin e MU-plugin esterni sono citati solo per definire il loro confine con il Parent.

## Gerarchia delle fonti

1. Decisioni esplicite aggiornate nelle note Nextcloud D11 Project.
2. Codice e configurazioni del repository per lo stato effettivo.
3. Test per il comportamento coperto.
4. Documentazione repository, solo dopo verifica.
5. Documentazione ufficiale WordPress per dettagli non decisi.

Le divergenze fra fonti sono registrate come Current rispetto a Target; non risolverle assumendo che il codice legacy sia autorevole.

## Stati normativi

- **Current**: verificato nel repository.
- **Target**: decisione architetturale approvata.
- **Constraint**: vincolo per il lavoro futuro.
- **Open decision**: scelta non formalizzata.
- **Legacy**: da sostituire o ricollocare.

## Lettura progressiva

Leggi sempre [source-specification.md](docs/codex/source-specification.md) per decisioni architetturali finché i documenti tematici sono `Skeleton — content pending`. Poi leggi solo il documento correlato al task e le sue dipendenze dirette.

| Task | Documento da leggere |
|---|---|
| Confini componenti o struttura | [architecture.md](docs/codex/architecture.md) |
| Estensioni o Child | [parent-child-contract.md](docs/codex/parent-child-contract.md) |
| PHP, JS, CSS trasversali | [coding-standards.md](docs/codex/coding-standards.md) |
| Blocchi, pattern, template, availability | [gutenberg-development.md](docs/codex/gutenberg-development.md) |
| CPT, tassonomie, meta e migrazioni | [content-model.md](docs/codex/content-model.md) |
| Build, token output e asset | [frontend-assets.md](docs/codex/frontend-assets.md) |
| SEO, maintenance, consenso | [feature-modules.md](docs/codex/feature-modules.md) |
| Abilities o MCP | [abilities-mcp.md](docs/codex/abilities-mcp.md) |
| Security review | [security.md](docs/codex/security.md) |
| Test o quality gate | [testing.md](docs/codex/testing.md) |
| Versioni, ZIP o white-label | [release.md](docs/codex/release.md) |

## Workflow prima di modificare codice

1. Classifica il task e leggi le fonti applicabili.
2. Seleziona Current, Target e Constraint rilevanti.
3. Verifica i path e il comportamento corrente nel checkout.
4. Se una scelta è Open decision, non inventarla: fermati o registra il bisogno di approvazione nel lavoro previsto.
5. Implementa nel componente proprietario e verifica in proporzione al rischio.

## Vincoli globali essenziali

- Mantieni separati Parent, Child, plugin, MU-plugin e tooling.
- Il Parent non contiene configuratori universali, sync o migrazioni.
- `d11-design-system` è tooling MU-plugin di sviluppo: il Parent consuma solo i suoi output contrattuali.
- D11 Sync è un feature module del Parent; D11 Migration non appartiene al Parent e il comportamento applicativo multilingua appartiene a `d11-multilingual`.
- Non introdurre API, hook, file o contratti non documentati.

## Verifiche minime

Verifica path e contratti coinvolti, lint/test/build disponibili e assenza di fatal. Per modifiche di release esegui anche i controlli di compatibilità e artefatto previsti da [release.md](docs/codex/release.md).

## Definition of Done provvisoria

Il cambiamento rispetta fonti e confini, dichiara gli impatti di compatibilità, supera le verifiche pertinenti e non estende il perimetro a workflow cliente.

## Esclusioni esplicite

Non includere generazione o composizione di pagine, direzione creativa, configurazione cliente, page review, screenshot, Lighthouse, delivery progressiva, workflow contenuti, uso del Design System come configuratore né sviluppo interno di componenti esterni.

## Stato del sistema documentale

I documenti in `docs/codex/` sono scheletri in revisione. Fino al completamento, [source-specification.md](docs/codex/source-specification.md) resta la fonte transitoria consolidata.
