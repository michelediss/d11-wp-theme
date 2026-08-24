# Sviluppo Gutenberg D11 Parent

## Scopo

Questo documento governa lo sviluppo tecnico di blocchi condivisi, metadata, registrazione, editor, rendering frontend, asset, pattern/template/parti, block availability, compatibilità, migrazioni e test. Non è una guida per comporre pagine cliente.

## Fonti e stati

[source-specification.md](source-specification.md), [architecture.md](architecture.md) e [parent-child-contract.md](parent-child-contract.md) prevalgono. **Current** è verificato nel tema legacy; **Target** e **Constraint** guidano il Parent; **Legacy** non si trasferisce automaticamente; **Decisione differita** richiede approvazione.

## Confini di ownership

| Artefatto | Owner | Quando usarlo | Quando non usarlo |
|---|---|---|---|
| Blocco condiviso | Parent | Runtime/contratto visivo riusabile | Per esigenza esclusiva progetto o dominio applicativo |
| Blocco esclusivo | Child | Configurazione o funzionalità solo progetto | Per capacità comune D11 |
| Blocco applicativo | Plugin proprietario | Dati/comportamento del plugin | Per sola presentazione Parent |
| Plugin block terza parte | Plugin + policy Child | Solo allowlist esplicita | Come disponibilità implicita |
| Pattern condiviso | Parent | Struttura tecnica riusabile | Per copy/struttura cliente |
| Pattern progetto | Child | Specificità progetto | Per sostituire componenti comuni |

## Struttura di un blocco condiviso

**Current** — [themes/d11/inc/blocks.php](../../themes/d11/inc/blocks.php) scopre `themes/d11/blocks/*/block.json`, registra metadata con `register_block_type()` e associa `render.php` quando presente. Usa asset Vite condivisi `src/js/blocks/editor.js`, `src/js/blocks/view.js` e `src/css/blocks.css`.

**Legacy** — La struttura legacy suggerisce `blocks/<slug>/block.json`, `render.php` dinamico e sorgenti per blocco nei tree `src/js/blocks/` e `src/css/blocks/`. È riusabile come evidenza, non come struttura Target obbligatoria.

**Constraint** — Ogni blocco contiene solo file necessari: metadata sempre; `render.php`/render callback solo per rendering dinamico; codice editor, view script e CSS solo se giustificati. Gli asset build sono prodotti dalla pipeline, non runtime source.

## `block.json` e naming

**Target** — `block.json` è fonte canonica di metadata; PHP e JavaScript non duplicano metadata divergenti. Il file definisce, se applicabili, name, versione API, title/category/description traducibili, attributes, supports, script/style, render, dipendenze e compatibilità.

**Constraint** — Il block name è identificatore stabile e non viene rinominato senza percorso di compatibilità. Namespace, slug, handle, classi CSS e text domain rispettano l'identità tecnica D11. I blocchi legacy usano `custom/breadcrumbs` e `custom/social-share`; il namespace Target dei nuovi blocchi condivisi non è ancora approvato tra `d11/*` e `custom/*`.

**Current** — I metadata verificati in [themes/d11/blocks/breadcrumbs/block.json](../../themes/d11/blocks/breadcrumbs/block.json) e [themes/d11/blocks/social-share/block.json](../../themes/d11/blocks/social-share/block.json) usano `apiVersion: 3`, `textdomain: d11`, handle Vite condivisi e metadata come fonte di registrazione.

## Statico o dinamico

| Requisito | Statico | Dinamico |
|---|---|---|
| Markup/contenuto stabile nel post | Preferire | Evitare se non necessario |
| Dati WordPress correnti o query | Evitare | Preferire |
| Markup evolutivo senza riscrivere contenuti | Limitato | Preferire |
| Caching | Contenuto già serializzato | Progettare cache quando pertinente |
| Fallback | Markup salvato | Render sicuro senza fatal |
| Rendering server-side necessario | No | `render.php` o callback |

**Constraint** — La scelta è motivata dal requisito; `render.php`/callback non è la scelta predefinita. Blocchi dinamici hanno preview editor adeguata, anche con `ServerSideRender` quando appropriato.

## Attributi, contenuto e editor

- Attributi descrivono contenuto o comportamento, non controlli visuali arbitrari; hanno schema e default espliciti.
- La serializzazione resta compatibile; modifiche di attributi o markup richiedono deprecation/migrazione.
- Design token restano separati dai content data.
- Editor e frontend sono coerenti: preview rappresentativa, stati loading/empty/error traducibili e controlli accessibili.
- Dati o plugin opzionali assenti producono fallback, non fatal.
- Nessuna dipendenza dall'MU-plugin `d11-design-system` o configuratore universale nell'editor/runtime.

## Rendering, JavaScript e CSS

**Constraint** — Rendering usa HTML semantico, escaping contestuale, accessibilità, classi circoscritte e output utile senza JavaScript quando possibile. Non legge configurazioni build-time dal database e consuma output visuali già compilati.

- Codice editor e frontend sono separati; `viewScript`/`viewScriptModule` esiste solo con comportamento frontend necessario.
- Inizializzazione idempotente, lifecycle/cleanup, eventi non fragili, reduced motion, traduzioni e nessun bundle frontend per blocchi statici.
- CSS namespaced/isolate, output Tailwind compilato e CSS custom properties del contratto visuale; niente valori progetto nel Parent, preset arbitrari in conflitto o dipendenza runtime da `d11-design-system`.

Regole generali JS/CSS: [coding-standards.md](coding-standards.md). Build/token: [frontend-assets.md](frontend-assets.md).

## Pattern, template e parti

**Target** — Parent possiede struttura condivisa; Child pattern, override e copy specifici entro contratto. Template restano sottili e compatibili con `post-content`, traducono solo copy condiviso e prevedono fallback tecnici. Non descrivere qui direzione creativa o composizione editoriale.

## Block availability

**Target** — Il Parent possiede registry/classificazione canonica, baseline, blocchi obbligatori/protetti e vietati, vincoli di sicurezza/compatibilità, extension point e diagnostica base. Il catalogo osserva blocchi realmente registrati.

**Constraint** — Il Child può restringere la baseline, scegliere un sottoinsieme, specializzare per post type/contesto, dichiarare blocchi propri e consentire plugin block approvati. Non può riabilitare vietati, rimuovere obbligatori, aggirare vincoli o abilitare implicitamente tutti i blocchi di un plugin.

| Concetto | Significato |
|---|---|
| Registry | Classificazione e vincoli canonici Parent |
| Catalogo runtime | Blocchi effettivamente registrati osservati |
| Policy dichiarata | Baseline Parent + contributo Child + vincoli |
| Allowlist effettiva | Risultato applicato nel contesto |

Una configurazione di blocco non registrato non abilita nulla, produce `missing-registration` o equivalente e non causa fatal. La diagnostica deve rendere visibili origine regole, baseline, contributo Child, vincoli, catalogo e policy effettiva.

**Current** — [themes/d11/inc/block-availability/runtime.php](../../themes/d11/inc/block-availability/runtime.php) distingue catalogo, setting normalizzati e allowlist tramite `allowed_block_types_all`; categorie ed export in `themes/d11/docs/block/` sono **Legacy**, non whitelist Target.

## Plugin block, compatibilità e migrazioni

Plugin block sono rilevati a runtime e richiedono allowlist esplicita; plugin assente produce diagnostica/fallback senza fatal o registrazione duplicata. Il plugin resta proprietario di dati e markup applicativo.

**Constraint** — Cambi incompatibili di attributi, markup, save o rendering seguono deprecation path, trasformazione e SemVer Parent. Le deprecation client-side sono distinte da migrazioni di contenuto persistente: queste ultime appartengono a D11 Migration, sono idempotenti e usano dry-run quando applicabile. Per manipolare block content usare parsing/serializzazione WordPress, non regex primaria su `post_content`.

## I18n, accessibilità e sicurezza

- Metadata, editor, render PHP e frontend JS usano text domain tecnico e script translations; nessun copy cliente nei blocchi condivisi.
- Semantic HTML, tastiera, focus, label, stato, contrasto e reduced motion sono verificati; ARIA solo quando necessaria.
- Sanitizzare attributi, fare escaping nel render, verificare permission per dati protetti, validare query/URL e limitare markup consentito. Policy completa: [security.md](security.md).

## Test tecnici

La suite in [testing.md](testing.md) deve coprire metadata/registrazione, inserter, editor senza errori, rendering, attributi, deprecazioni, frontend senza JS, view script, isolamento CSS, availability, plugin opzionali, compatibilità Child e build. Sono esclusi screenshot, page review, Lighthouse e qualità editoriale cliente.

## Workflow per un blocco condiviso

1. Verificare ownership e leggere contratti pertinenti.
2. Scegliere statico/dinamico e creare solo file necessari.
3. Definire metadata in `block.json` e registrare il blocco.
4. Aggiungere asset strettamente necessari e aggiornare availability/documentazione contrattuale.
5. Coprire test, build e quality gate; riportare limiti o decisioni differite.

È una procedura tecnica derivata selettivamente dalla skill legacy, non una skill né un vincolo “un blocco per reasoning pass”.

## Pratiche vietate

- blocco nel componente sbagliato, metadata divergenti o namespace non approvato;
- controlli visuali arbitrari, valori/copy cliente nel Parent, bundle frontend inutile;
- plugin block impliciti, cambi attributi non versionati o regex primaria su `post_content`;
- dipendenza runtime dal Design System MU-plugin.

## Stato Current e gap

**Current** — Il legacy ha due blocchi dynamic theme-owned in [themes/d11/blocks/](../../themes/d11/blocks/), registration discovery e asset condivisi; `custom/*` convive con blocchi privacy `d11/*` in [themes/d11/inc/privacy/blocks/](../../themes/d11/inc/privacy/blocks/). Non esistono Parent/Child target, policy per contesto, provenienza regole o diagnostica Target.

## Decisioni differite

- namespace definitivo dei blocchi condivisi;
- struttura directory Target e `apiVersion` Target formalizzata;
- categorie, contesti, formato policy e blocchi obbligatori iniziali della block availability.

## Checklist Codex

Prima: ownership, namespace/metadata, statico-dinamico, compatibilità e availability. Dopo: registrazione/asset/render, attributi/deprecation, fallback/accessibilità/i18n, test/build e aggiornamento del contratto se cambia una superficie pubblica.

## Documenti correlati

- [architecture.md](architecture.md)
- [parent-child-contract.md](parent-child-contract.md)
- [coding-standards.md](coding-standards.md)
- [frontend-assets.md](frontend-assets.md)
- [security.md](security.md)
- [testing.md](testing.md)

## Stato del documento

Canonical
