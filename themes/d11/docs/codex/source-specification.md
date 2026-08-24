# Specifica sorgente — D11 Parent canonico

## 1. Scopo

Questa specifica consolidata è la sorgente per la successiva documentazione agentica di Codex dedicata allo sviluppo e alla manutenzione del prodotto **D11 Parent**. Definisce il confine tecnico del prodotto, non il workflow di configurazione o delivery di un sito cliente.

Le etichette di stato usate nel documento sono:

- **Current** — comportamento verificato nel checkout corrente.
- **Target** — decisione stabilita nelle note Nextcloud.
- **Constraint** — vincolo per implementazioni future.
- **Open decision** — scelta non ancora formalizzata.
- **Legacy** — materiale o implementazione corrente da sostituire o ricollocare.

## 2. Perimetro

**Target** — Il prodotto comprende il D11 Parent canonico, la sua distribuzione white-label, il contratto con child theme, blocchi condivisi, contratto degli output del design system, SEO, maintenance con bypass firmato, cookie/consenso, block availability, registry dichiarativo di contenuti strutturati, D11 Sync, integrazione Abilities API e packaging. [Decisione architetturale approvata]

Comprende inoltre i confini con plugin custom, in particolare `d11-multilingual`, e con il MU-plugin `d11-migration`. D11 Sync è invece un feature module interno del Parent, non un componente distribuibile indipendentemente. [Decisione architetturale approvata]

## 3. Esclusioni

Sono esclusi da questa specifica e dalla futura documentazione Codex del Parent:

- generazione, composizione, review o ottimizzazione di pagine cliente;
- scelta di blocchi per sezioni editoriali, direzione creativa, palette, font o contenuti di un singolo cliente;
- screenshot, page review, Lighthouse e workflow di delivery progressiva;
- sincronizzazione delle skill globali;
- procedure di provisioning, deploy di un singolo sito e consegna editoriale.

**Constraint** — La documentazione di configurazione/delivery potrà riferirsi al contratto del Parent, ma resterà distinta da questa documentazione di sviluppo prodotto.

## 4. Fonti e gerarchia di autorità

1. **Target:** decisioni esplicite e aggiornate nelle note Nextcloud, con priorità alla nota più recente in caso di conflitto.
2. **Current:** codice e configurazioni verificati nel repository.
3. **Current:** test disponibili, per il comportamento effettivamente coperto.
4. **Legacy:** documentazione del repository, da usare solo dopo verifica nel codice.
5. Best practice ufficiali WordPress, esclusivamente per dettagli non determinati dalle fonti precedenti.

Quando note e repository divergono, le note definiscono il Target e il repository è descritto come Current; il passaggio è riportato nella sezione 24. Nessun documento legacy prevale sulle note o sul runtime verificato.

## 5. Stato corrente del repository

**Current** — Il checkout Git operativo è `wordpress/wp-content`; il solo tema D11 custom è `wordpress/wp-content/themes/d11`. Il tema è un block theme con `theme.json`, `templates/`, `parts/`, `patterns/`, bootstrap in `functions.php` e versione `0.1.1` (`style.css`).

**Current** — Il bootstrap carica asset, blocchi, content sync, SEO, Contact Form 7 sync, maintenance, privacy, block availability e strumenti admin dal tema (`themes/d11/functions.php`). Di conseguenza queste responsabilità sono oggi accoppiate al tema legacy.

**Current** — Sono presenti due blocchi dinamici theme-owned, `custom/breadcrumbs` e `custom/social-share`, registrati da discovery di `blocks/*/block.json` in `themes/d11/inc/blocks.php`. I relativi metadata usano `block.json`; gli entrypoint condivisi sono `src/js/blocks/editor.js`, `src/js/blocks/view.js` e `src/css/blocks.css`.

**Current** — Il sistema `inc/block-availability/` costruisce un catalogo runtime e restituisce una allowlist con `allowed_block_types_all`; persiste impostazioni WordPress e genera export in `themes/d11/docs/block/`. Non è ancora per post type/contesto né ha provenienza regole, override child o verifica SemVer Parent–Child.

**Current** — `inc/content-sync/` sincronizza JSON di pagine e Contact Form 7 dal tema, con comandi WP-CLI e conflict policy. È una funzione theme-owned legacy da ricondurre a un feature module del Parent con contratto esplicito.

**Current** — SEO, maintenance e privacy sono implementazioni locali rispettivamente in `inc/seo/`, `inc/maintenance/` e `inc/privacy/`. Privacy espone una route `d11/privacy/v1/consent`; non sono state trovate Abilities API, `d11-multilingual`, MU-plugin D11, parent/child separati, schema registry CPT/tassonomie/meta, `d11-child.json`, manifest `d11-distribution.json` o pipeline ZIP.

**Current** — Il controllo prodotto disponibile è solo lo smoke E2E `tests/e2e/smoke.spec.js` (home, login, errori console). Non risultano PHPUnit, PHPStan, test di unità/integration del tema, test del build artefact o test di packaging.

## 6. Architettura target D11 WordPress

**Target** — Ogni distribuzione usa un parent WordPress-native canonico, un child per progetto, plugin custom indipendenti e un MU-plugin per le migrazioni. D11 Sync è incluso nel Parent come modulo di prodotto, non come plugin o MU-plugin autonomo. [Decisione architetturale approvata]

```text
wp-content/
├── themes/
│   ├── d11-parent/             # Parent canonico o suo involucro white-label
│   └── <project-child>/        # configurazione e override del progetto
├── plugins/
│   └── d11-multilingual/       # dati e comportamento multilingua
└── mu-plugins/
    ├── d11-design-system.php + d11-design-system/ # sviluppo/configurazione, non distribuito
    └── d11-migration.php + d11-migration/
```

**Constraint** — Rendering e contratto visuale comune appartengono al Parent; dati o funzioni che sopravvivono al cambio tema appartengono a plugin; migrazioni richieste prima del normale caricamento plugin appartengono a MU-plugin; il child contiene esclusivamente specificità di progetto. D11 Sync è l'eccezione deliberata: è un workflow del pacchetto D11, disponibile solo con il Parent, mentre post, meta e CF7 restano dati WordPress nel database.

## 7. Matrice delle responsabilità

Legenda: **P** proprietario; **E** estende/configura entro contratto; **—** non responsabile; **OD** open decision.

| Funzione | Parent | Child | Plugin | MU-plugin | Tooling |
|---|---:|---:|---:|---:|---:|
| Runtime visuale | P | E | — | — | — |
| Design token | P (contratto output/fallback tecnici) | P (artefatti progetto) | — | P (`d11-design-system`, authoring/validazione/merge) | E (build) |
| Override di progetto | — | P | — | — | E |
| Blocchi condivisi | P (baseline/vincoli) | P (restringe e specializza) | — | — | E |
| Blocchi esclusivi | — | P | OD (se applicativi) | — | E |
| CPT, tassonomie e custom field | P (schema/registry condivisi) | P (dichiarazioni progetto) | E solo extension point controllati | — | P (generazione/validazione) |
| SEO | P | E | OD (integrazioni indipendenti) | — | — |
| Maintenance | P | E | — | — | — |
| Cookie consent | P | E | — | — | — |
| Multilingua | E (presentazione) | E | P (`d11-multilingual`) | — | — |
| Content sync | P (`d11-sync`) | E (dichiarazioni progetto) | — | — | E |
| CF7 sync | P (`d11-sync`) | E (dichiarazioni progetto) | — | — | E |
| Migration | — | — | — | P (`d11-migration`) | E |
| Scaffolding | — | — | — | — | P |
| Packaging | E (artefatto sorgente) | E (metadati di progetto) | E | E solo MU-plugin runtime; `d11-design-system` — | P |
| Configurazione del singolo progetto | E (contratto D11 Sync) | P | E per il proprio dominio | E per migration | E |

**Target** — Il comportamento applicativo multilingua è attribuito a `d11-multilingual` e D11 Migration non è attribuito al Parent. La precedente assegnazione di D11 Sync a MU-plugin, indicata in *D11 WordPress* (ID 236), è sostituita dalla decisione approvata di includerlo come feature module del Parent.

## 8. Responsabilità del D11 Parent

**Target** — Il Parent possiede il rendering comune, asset compilati, componenti/template e blocchi condivisi, contratto visuale Parent–Child, registry dichiarativo, SEO, maintenance, consenso, disponibilità blocchi e il feature module D11 Sync. [Decisione architetturale approvata]

**Constraint** — Non deve possedere contenuti cliente, dati applicativi di dominio, configurazioni esclusivamente cliente o migrazioni. D11 Sync non rende il Parent proprietario dei contenuti: esegue solo export/import espliciti, con conflitti dichiarati e senza scritture implicite nel frontend. Il Parent non è un configuratore universale.

## 9. Contratto Parent–Child

**Target** — Il Parent usa Semantic Versioning; gli extension point pubblici fanno parte del suo contratto SemVer. Il child dichiara token, pattern, template override, variazioni e blocchi realmente esclusivi; non duplica il runtime comune. [Nextcloud: *D11 WordPress*, ID 236]

**Constraint** — Il Child contiene `d11-child.json` e dichiara il range SemVer Parent compatibile, oltre ai requisiti di schema applicabili. La pipeline verifica il contratto prima di build e packaging. Il child può specializzare block availability e configurazioni ma non rimuovere protezioni Parent.

La struttura iniziale è concettualmente:

```json
{
  "schemaVersion": 1,
  "productId": "d11-child",
  "projectId": "<project-id>",
  "requires": {
    "parent": ">=1.0.0 <2.0.0",
    "contentModelSchema": "^1.0"
  }
}
```

Questo esempio non costituisce ancora lo schema JSON definitivo.

**Constraint** — Incompatibilità Parent–Child produce diagnostica e admin notice, non fatal frontend; gli extension point incompatibili non sono applicati. Deprecazioni e rimozioni sono documentate e i test contrattuali verificano la compatibilità.

**Open decision** — Formalizzare lo schema definitivo, il percorso e la semantica dei range di `d11-child.json`, inclusa la fixture minima del child.

## 10. Identità tecnica e white-label

**Target** — White-label intermedio: directory del parent, `Theme Name`, descrizione, autore, screenshot, URL e manifest possono variare; namespace PHP, prefix, text domain, hook/filter, option/meta key, block name, REST namespace, capability, struttura applicativa, product ID e versione canonica restano invariati. [Nextcloud: *D11 WordPress*, ID 236]

**Target** — Ogni distribuzione contiene `d11-distribution.json`; la pipeline compila/testa il parent canonico, applica solo una allowlist di differenze esterne, crea ZIP/checksum e confronta byte-a-byte i file applicativi. Il manifest registra il requisito SemVer `compatibility.parent`; gli update usano il product ID canonico e verificano `distributionId` e `projectId`. [Nextcloud: *D11 WordPress*, ID 236]

**Constraint** — `compatibility.parent` esprime un range SemVer Parent; il manifest non contiene un contratto di compatibilità distinto per il Child.

**Open decision** — Formalizzare JSON Schema del manifest, manifest di integrità interna, firma crittografica, protocollo del server di aggiornamento, policy di retention degli artefatti e lista definitiva delle differenze ammesse.

## 11. Organizzazione del codice

**Target** — Separare codice del Parent, child, plugin e MU-plugin secondo la sezione 6; ogni componente espone bootstrap, versione, compatibilità, documentazione e upgrade/rollback. [Nextcloud: *D11 WordPress*, ID 236]

**Current** — Il tema legacy organizza il bootstrap in `functions.php`, servizi in `inc/`, blocchi in `blocks/`, pattern PHP in `patterns/`, template/parti HTML in `templates/` e `parts/`, sorgenti in `src/` e bundle in `assets/`.

**Constraint** — Conservare questa separazione dove riusabile, ma non trasferire directory o API legacy senza un contratto Target esplicito.

## 12. Standard PHP e WordPress

**Current** — Il codice PHP del tema usa `declare(strict_types=1)`, guardia `ABSPATH`, funzioni `d11_` e escaping contestuale; i blocchi sono scoperti tramite `block.json` e registrati con `register_block_type()`. Vedi `themes/d11/functions.php`, `inc/blocks.php` e i render callback in `blocks/`.

**Constraint** — PHP deve restare WordPress-native: capability prima di scritture amministrative, nonce per form/azioni, sanitizzazione in ingresso, validazione rispetto allo schema e escaping nel contesto di output. Usare API WordPress per CPT, tassonomie e meta; non introdurre endpoint, hook o chiavi non documentati.

**Target** — WordPress `6.9` è la versione minima dell’architettura D11 Parent, necessaria per Abilities API. Il requisito PHP definitivo resta nella support matrix. I dettagli dipendenti dall’API WordPress adottata sono verificati contro documentazione ufficiale durante l’implementazione.

**Constraint** — Ogni nuova option, meta key, route REST, capability, block name o contratto child entra nella documentazione del componente prima dell’implementazione.

## 13. Pipeline frontend e asset

**Current** — `themes/d11/vite.config.js` produce manifest e bundle in `assets/`; `inc/assets.php` seleziona Vite dev server non-production oppure risolve il manifest. `package.json` definisce build Vite, PostCSS/Tailwind e task i18n. `theme.json` limita l’editor e `tailwind.config.js` contiene token visuali dell’installazione corrente.

**Constraint** — Gli asset distribuiti devono essere già compilati; il runtime hosting non dipende da Node/Vite. L’esperienza resta utilizzabile senza JavaScript, con progressive enhancement e fallback verificato. [Nextcloud: *D11 WordPress*, ID 236]

**Legacy** — Le palette, font, token Tailwind e direzione della homepage attuali sono specifici dell’installazione e non passano al prodotto canonico.

**Open decision** — Stabilire formato definitivo degli artefatti token del Child, regole di build riproducibile e policy di inclusione/esclusione bundle negli ZIP. D11 Design System non è una funzione runtime del Parent.

## 14. Sviluppo Gutenberg

**Current** — `block.json` è la fonte dei metadata; `blocks/<slug>/render.php` segnala rendering dinamico; gli entrypoint condivisi Vite separano editor, view e CSS. Questo è verificato in `themes/d11/inc/blocks.php`, `blocks/breadcrumbs/`, `blocks/social-share/` e `src/js/blocks/`.

**Constraint** — I blocchi condivisi risiedono nel Parent; blocchi esclusivi risiedono nel child. Attributi devono descrivere contenuto/comportamento, non controlli visuali arbitrari. Blocchi statici usano il flusso WordPress previsto; quelli dinamici dichiarano `render.php`/callback e hanno preview editor adeguata.

**Target** — I primi blocchi condivisi da valutare sono Fullpage menu, Icon, Button, Privacy & cookies e griglia progetto; la nota non stabilisce che siano già implementati. [Nextcloud: *D11 WordPress*, ID 236]

## 15. Architettura della block availability

**Target** — Il Parent possiede registry/classificazione canonica, baseline ammessa, blocchi obbligatori o protetti, blocchi vietati, vincoli di sicurezza/compatibilità, punti di estensione, contratto configurazione e diagnostica base. Il catalogo runtime osserva i blocchi realmente registrati. [Decisione architetturale approvata]

**Target** — Il Child può restringere la baseline, selezionare il sottoinsieme disponibile, specializzare per post type e contesto editoriale, registrare/dichiarare blocchi propri e consentire esplicitamente plugin block approvati. Non può riabilitare blocchi vietati, rimuovere blocchi obbligatori, aggirare vincoli Parent né abilitare implicitamente tutti i blocchi di un plugin.

**Constraint** — Una regola riferita a un blocco non registrato non abilita nulla, produce diagnostica `missing-registration` o equivalente e non causa fatal. La diagnostica mostra origine regole, baseline Parent, contributo Child, vincoli applicati, catalogo registrato, policy effettiva e incompatibilità SemVer Parent–Child.

**Current** — L’implementazione legacy distingue catalogo runtime, setting normalizzati e allowlist effettiva, con categorie `core`, `blog`, `woocommerce`, `third_party`, `custom` (`themes/d11/inc/block-availability/runtime.php`). Gli export in `docs/block/` sono derivati e non autorevoli per il runtime.

**Legacy** — La whitelist corrente e `block-registry.json` sono fotografie dell’installazione, non dati da trasferire.

**Constraint** — Restano differiti, senza riaprire il modello approvato, elenco iniziale dei contesti, tassonomia definitiva delle categorie, formato completo della configurazione ed eventuali blocchi obbligatori iniziali.

## 16. Content model dichiarativo

**Target** — Il D11 Parent include un registry WordPress-native, dichiarativo e versionato per CPT, tassonomie, custom field/field group, opzioni WordPress, editor, REST, template, autorizzazione, validazione e sanitizzazione. Il registry è integrato nel Parent e non diventa un framework generico indipendente dal tema. [Decisione architetturale approvata]

Tre confini obbligatori:

1. **Tooling di sviluppo:** genera/modifica dichiarazioni, esegue validazione completa e prepara migrazioni; è distinto dal runtime.
2. **Schema dichiarativi:** documenti JSON versionati, deterministici e revisionabili; ciascuno usa proprietà concettualmente distinte `id`, `kind` e slug WordPress. L’identificatore stabile non è per ora vincolato al formato `d11:<kind>:<id>`.
3. **Runtime Parent:** contiene schema, registry e definizioni condivise; ripete controlli essenziali, registra soltanto dichiarazioni valide e non offre UI/configuratore universale equivalente ad ACF.

**Target** — In sviluppo, JSON Schema Draft 2020-12 con profilo D11 esegue validazione completa. Dichiarazioni progetto risiedono nel Child; componenti D11 proprietari di un dominio contribuiscono solo tramite extension point controllati dal Parent. Il runtime usa `register_post_type()`, `register_taxonomy()` e `register_post_meta()` e rifiuta atomicamente dichiarazioni invalide: non registra risorse parziali.

**Constraint** — Ogni modifica schema ha versione, compatibilità dati o migrazione esplicita, diagnostica e test. Evoluzioni incompatibili usano migration declaration versionate e migrazioni idempotenti di D11 Migration. Schemi di dominio che devono sopravvivere a un cambio tema vanno in un plugin custom, non nel registry visuale del Parent.

**Constraint** — Restano differiti, senza riaprire il modello approvato, struttura JSON completa, tassonomia dei `kind`, directory definitive, regole precise di composizione/estensione e formato delle migration declaration.

## 17. Contratto del design system

**Target** — `d11-design-system` è un MU-plugin di sviluppo/configurazione, non una funzione runtime del Parent. Possiede schema authoring, generazione/modifica token, validazione completa, merge fra fondazioni D11 e configurazione progetto, diagnostica di sviluppo, eventuali comandi WP-CLI/ability di sviluppo e generazione degli input della build. [Decisione architetturale approvata]

**Target** — Il flusso è: il MU-plugin genera token JSON progetto; il Child li conserva come artefatto versionabile; la build li valida/normalizza; Tailwind genera classi e CSS; la build genera anche `theme.json`, CSS custom properties e altri artefatti runtime necessari. Il pacchetto di produzione include solo Parent, Child e output runtime richiesti.

**Constraint** — Il Parent definisce solo contratto degli output: nomi e semantica token condivisi, requisiti delle CSS custom properties, aspettative componenti, struttura minima `theme.json`, versione formato accettato e fallback tecnici necessari. Non contiene authoring, generatore completo, configuratore, merge dinamico generale o UI di modifica token.

**Target** — Token e scale usano ruoli colore semantici, tipografia, spacing, radius, border, elevation e layout; i valori finali usano ruoli e scale, non valori liberi. La gerarchia rimane Page Canvas → Section Wrapper → Layout Container → Content Node, con Local Surface opzionale. [Nextcloud: *D11 Design System*, ID 156]

**Open decision** — Formalizzare lo schema authoring dei token, il formato dell’artefatto normalizzato del Child e le regole responsive. Se il runtime non richiede JSON token, il JSON non viene distribuito né letto in produzione.

## 18. Abilities API e confine MCP

**Target** — Ogni ability è registrata dal componente proprietario del dominio, usa namespace tecnico immutabile `d11/*`, input/output tipizzati e permission callback obbligatoria. Le write usano capability dedicate; read e write sono distinti esplicitamente. [Decisione architetturale approvata]

**Constraint** — MCP serve azioni immediate, circoscritte e osservabili sul singolo sito; D11 MCP/Temporal coordinano processi multi-sistema e durevoli. L’allowlist MCP è separata per ambiente: staging è più permissivo, produzione è limitata alle operazioni esplicitamente autorizzate. Nessuna shell generica, PHP arbitrario, installazione plugin o gestione utenti via MCP. Write richiede capability, audit, idempotenza quando applicabile e conferma per publish, delete o altro alto impatto.

**Target** — Non esiste esposizione generalizzata delle ability: il WordPress MCP Adapter, quando adottato, espone esclusivamente l’allowlist D11. [Nextcloud: *D11 WordPress*, ID 236; *D11 MCP tools*, ID 179]

**Constraint** — Le ability di D11 Sync destinate al cliente, se approvate nel catalogo futuro, possono creare o aggiornare soltanto bozze nei post type consentiti dal Child. Non pubblicano automaticamente, non modificano la repository e producono audit; publish, delete o altra operazione ad alto impatto richiedono conferma.

**Open decision** — Restano differiti catalogo completo delle ability, versione/package MCP Adapter, mapping capability, annotazioni e dettagli dipendenti dall’API WordPress adottata e schema preciso dei log. Questi dettagli devono essere verificati contro documentazione WordPress ufficiale durante l’implementazione.

## 19. Sicurezza

**Constraint** — Applicare least privilege, capability dedicate, sanitizzazione, validazione, escaping contestuale, nonce, controllo di integrità degli artefatti e audit essenziale.

**Target** — Maintenance usa token imprevedibile, scadenza, revoca, conservazione sicura, capability dedicata, audit e diagnostica; il bypass permette solo frontend, mai backend. Non inserire token in URL permanenti, Git, log non sanitizzati o screenshot. [Nextcloud: *D11 WordPress*, ID 236]

**Target** — Cookie/consenso include blocco preventivo degli script, categorie, preferenze modificabili, registry dei servizi, tabella cookie e API/eventi; i test dimostrano che script soggetti a consenso non partono prima della categoria corretta. [Nextcloud: *D11 WordPress*, ID 236]

**Current** — Nel legacy esistono controlli puntuali di nonce/capability e sanitizzazione in `inc/privacy/`, SEO meta REST in `inc/seo/core.php` e setting block availability, ma non costituiscono ancora il contratto di sicurezza Target.

## 20. Strategia di testing del prodotto

**Target** — Ogni componente è pronto solo con bootstrap/versione/compatibilità dichiarati, capability/sanitizzazione, test di attivazione senza fatal, integrazione Parent–Child o plugin–tema, percorso upgrade/rollback, build riproducibile e artefatto privo di dati runtime. [Nextcloud: *D11 WordPress*, ID 236]

**Constraint** — La suite prodotto deve coprire almeno: unit e integration PHP del registry/schema, registrazione CPT/tassonomie/meta, validazione/migrazione schema, rendering e compatibilità SemVer Parent–Child, blocchi statici/dinamici, block availability per contesto, SEO, maintenance/bypass, consenso prima/dopo opt-in, D11 Sync (dry-run, diff, conflitti e idempotenza), Abilities/capability incluse eventuali creazioni di bozze, build degli output D11 Design System e clean-install dello ZIP. Test E2E sono complementari, non sostitutivi.

**Current** — È disponibile soltanto `tests/e2e/smoke.spec.js`; i suoi screenshot/report sono artefatti tecnici del test e non un workflow di review visuale incluso nel presente sistema.

## 21. Versionamento e compatibilità

**Target** — D11 Parent usa Semantic Versioning; plugin custom e MU-plugin usano SemVer indipendente. Le breaking change degli extension point Parent–Child richiedono major bump del Parent. Le coordinate cambiano insieme solo per una dipendenza effettiva.

**Target** — Il content-model schema usa major/minor; `d11-child.json` e `d11-distribution.json` usano `schemaVersion`; ogni build ha `buildId` univoco. La distribuzione white-label usa `distributionRevision` incrementale, non un secondo SemVer completo. Il manifest registra Parent canonico, componenti presenti, rispettive versioni e requisiti di compatibilità.

**Target** — Per ogni sito Git usa normalmente il solo branch `main`; i tag identificano release consegnate; staging è l’unico ambiente di sviluppo e produzione non viene modificata direttamente. [Nextcloud: *D11 Git*, ID 285]

**Constraint** — Restano differiti, senza riaprire il versionamento approvato, support matrix WordPress/PHP/Parent/Child/schema/plugin e policy per deprecazioni/security release.

## 22. Build, packaging e distribuzione

**Target** — Ogni distribuzione usa `d11-distribution.json`, validato contro schema versionato. I campi concettualmente obbligatori sono `schemaVersion`, `productId`, `distributionId`, `projectId`, `parentVersion`, `distributionRevision`, `buildId`, `compatibility.parent`, `components` e `allowedDifferences`. `compatibility.parent` è un range SemVer Parent; `components` contiene solo componenti realmente presenti con rispettive versioni.

**Constraint** — Il manifest non contiene segreti, credenziali, token, URL privati, runtime state, upload o dati cliente non necessari. Il checksum ZIP è esterno, in un file `.sha256`; un eventuale manifest di integrità dei file interni è distinto da `d11-distribution.json`. La firma crittografica è differita.

**Target** — La pipeline: compila e testa Parent canonico, incluso D11 Sync; crea una copia; applica solo differenze white-label consentite; aggiunge manifest; genera ZIP e checksum esterno; confronta file applicativi con Parent; verifica `allowedDifferences`; installa in WordPress pulito; esegue smoke test e controlli SemVer Parent–Child. L’artefatto contiene solo temi/plugin/MU-plugin runtime e asset compilati necessari, mai core WordPress, database, upload, cache, backup, segreti o `d11-design-system`. D11 Sync non è un componente separato nel manifest.

**Current** — Il tema legacy ha `npm run build` ma nessuno script di packaging/ZIP/checksum/clean-install. Lo stack root dispone di Docker Compose, WP-CLI, Composer, Node e Playwright; il layout corrente differisce dallo stack standard Target documentato in *D11 WordPress Docker Stack* (ID 302).

**Constraint** — Restano differiti, senza riaprire il manifest approvato, JSON Schema completo del manifest, formato del manifest di integrità interna, firma crittografica e protocollo del server di aggiornamento.

## 23. Architettura della documentazione Codex

**Target** — Il sistema definitivo deve avere un documento per argomento, registrare contratti e decisioni prima del codice e separare documentazione canonica, skill/workflow wrapper e artefatti derivati. [Nextcloud: *D11 WordPress*, ID 236; *D11 Agent architecture*, ID 149]

**Constraint** — Codex usa fonti live per stato corrente e fonti versionate per contratti; MCP espone strumenti specifici read/write minimi, non accesso indiscriminato. Le skill future rimanderanno alla documentazione canonica e non ne duplicheranno le regole.

**Legacy** — `themes/d11/docs/` mescola architettura, workflow di pagine, screenshot, Lighthouse, skill sync, whitelist generate e configurazione dell’installazione; va recuperato selettivamente, non promosso in blocco.

## 24. Gap fra stato corrente e target

| Area | Current verificato | Target / lavoro necessario |
|---|---|---|
| Identità prodotto | tema unico `d11` | Parent canonico + child fixture + contratto SemVer Parent–Child (`d11-child.json`) |
| Moduli | SEO/privacy/maintenance/content sync nel tema | estrarre e contrattualizzare feature module Parent, creare `d11-multilingual` e D11 Migration; D11 Sync resta nel Parent |
| Content model | nessun registry CPT/tassonomie/field dichiarativo | JSON Draft 2020-12, registry Parent, dichiarazioni Child e migrazioni D11 Migration |
| Design system | Tailwind/theme.json con valori installazione | MU-plugin di sviluppo, token versione Child e output build controllati |
| Block availability | catalogo/allowlist runtime globale legacy | registry Parent, baseline restringibile dal Child, contesto e diagnostica |
| Abilities/MCP | nessuna ability verificata | principi approvati; catalogo/adapter/capability map da finalizzare |
| Packaging | solo build Vite | manifest versionato, ZIP, checksum `.sha256` esterno, clean-install e compatibilità |
| Test | smoke Playwright | suite prodotto stratificata e test artefatti |
| Documentazione | guide legacy miste | sistema Codex per sviluppo Parent, separato dalla delivery |

## 25. Decisioni aperte

1. Contratto formale e compatibilità SemVer Parent–Child tramite `d11-child.json`.
2. Support matrix WordPress/PHP/Parent/Child/schema/plugin e policy deprecazioni/security release.
3. Struttura JSON, `kind`, directory, composizione/estensione e migration declaration del content model.
4. Confine esatto CPT/theme-bound vs CPT/plugin-owned.
5. Schema authoring token, artefatti Child generati e regole responsive di D11 Design System.
6. Contesti, categorie, formato configurazione e blocchi obbligatori iniziali della block availability.
7. Catalogo ability, MCP Adapter, capability map, annotazioni e schema log.
8. JSON Schema manifest, integrità interna, firma e protocollo update.
9. Strategia test concreta, runner e soglie di release, incluse fixture e policy conflitti D11 Sync.
10. Lista di plugin runtime eventualmente distribuiti col prodotto: le note indicano alcuni plugin come decisioni di progetto, non dipendenze del Parent.

## 26. Mappa proposta dei documenti definitivi

| Documento futuro | Contenuto |
|---|---|
| `architecture.md` | componenti, confini e responsabilità |
| `parent-child-contract.md` | range SemVer Parent, `d11-child.json`, extension point e compatibilità |
| `design-output-contract.md` | output accettati dal Parent, asset generati, compatibilità e assenza del configuratore runtime |
| `content-model.md` | schemi, registry, field, REST, migrazioni |
| `gutenberg.md` | blocchi, metadata, asset, statico/dinamico |
| `block-availability.md` | registry/catalogo/allowlist e diagnostica |
| `feature-modules.md` | SEO, maintenance, cookie/consenso, D11 Sync e ownership generale block availability |
| `architecture.md` | confini con `d11-multilingual` e D11 Migration |
| `abilities-mcp.md` | Abilities, capability, adapter, audit, ambienti |
| `security.md` | requisiti trasversali e threat boundaries |
| `testing.md` | piramide test e criteri release |
| `release.md` | versioni, build, white-label, package e distribuzione |
| `repository-current-state.md` | evidenza Current e piano di transizione |

Nessuno di questi documenti deve includere workflow di composizione, review visiva o delivery di pagine cliente.

## 27. Registro delle fonti consultate

### Note Nextcloud — categoria `D11 Project`

| Titolo | Note ID | `modified` | Motivo d’uso |
|---|---:|---:|---|
| D11 WordPress | 236 | 1787600203 | Fonte primaria per Parent, child, plugin, MU-plugin, registry, white-label, sicurezza, test e packaging. |
| D11 Develop workflow | 146 | 1787600207 | Delimita esplicitamente i workflow delivery da escludere e il confine con `wordpress_engineer`. |
| D11 Agent architecture | 149 | 1784671868 | Ruoli agentici, Temporal, RAG e separazione tra capacità, workflow e MCP. |
| D11 Design System | 156 | 1787600205 | Contratto Target di token, gerarchia, accessibilità, resolver e Gutenberg. |
| D11 Git | 285 | 1784774295 | Branch, tag e policy staging/produzione. |
| D11 WordPress Docker Stack | 302 | 1785306401 | Distinzione runtime, tooling e verifiche di stack Target. |
| D11 MCP tools | 179 | 1784855400 | Confine provider/MCP D11, WordPress MCP, sicurezza e ambienti. |
| D11 Compartimentazione | 295 | 1785290542 | Vincoli repository/runtime/segreti e natura transitoria degli stack progetto. |
| D11 Infrastructure | 238 | 1784667599 | Contesto infrastrutturale rilevante per servizi D11, senza attribuirlo al Parent. |
| D11 Environment | 143 | 1786288013 | Confini scaffolding, provider e gestione dei segreti. |
| D11 CLI | 154 | 1784667601 | Separazione CLI/MCP e processi durevoli. |

### Repository e configurazioni verificate

- Stack e controlli root: `compose.yaml`, `Makefile`, `scripts/verify.sh`, `tests/`.
- Checkout Git: `wordpress/wp-content`, inclusi `themes/`, `plugins/`, `mu-plugins/`.
- Tema legacy: `wordpress/wp-content/themes/d11/`, con PHP, template, parti, pattern, blocchi, asset, Vite/Tailwind, i18n e documentazione.
- Funzionalità condivise correnti: `inc/assets.php`, `inc/blocks.php`, `inc/block-availability/`, `inc/content-sync/`, `inc/seo/`, `inc/maintenance/`, `inc/privacy/` e `inc/theme-admin/`.
- Documentazione legacy valutata: `themes/d11/docs/theme-overview.md`, `docs/ai-workflows.md`, `docs/content-sync.md`, `docs/block/custom-blocks.md` e `docs/block/block-availability-system.md`.
- Skill locale valutata: `themes/d11/.agents/skills/d11-create-custom-block/SKILL.md`.

Le note Nextcloud non sono state modificate. Nessuna fonte rilevante elencata sopra è risultata illeggibile.
