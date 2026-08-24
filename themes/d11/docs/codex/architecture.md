# Architettura D11 WordPress

## Scopo

Questo documento governa l'architettura del prodotto D11 WordPress: responsabilità dei componenti, collocazione del codice, separazione fra runtime e tooling e transizione dal repository legacy al D11 Parent canonico. È prescrittivo per i confini; i dettagli dei singoli contratti restano nei documenti specialistici.

## Fonti e stati

La fonte transitoria consolidata è [source-specification.md](source-specification.md). Usare **Current** per evidenza repository, **Target** per architettura approvata, **Constraint** per vincoli non derogabili, **Legacy** per materiale da sostituire e **Decisione differita** per dettagli non ancora fissati.

## Gerarchia dei componenti

| Componente | Responsabilità | Presente in produzione | Repository/ciclo di vita |
|---|---|---:|---|
| D11 Parent canonico | Runtime visuale e contratti condivisi | Sì | Prodotto canonico, SemVer proprio |
| Distribuzione white-label | Involucro esterno del Parent | Sì | Artefatto derivato, `distributionRevision` |
| Child di progetto | Specificità e dichiarazioni progetto | Sì | Versionato con il progetto; dipende dal Parent |
| Plugin custom | Dominio applicativo autonomo | Se richiesto | Ciclo di vita indipendente; es. `d11-multilingual` |
| MU-plugin | Operatività obbligatoria non visuale | Se richiesto | Caricato fuori dal normale ciclo plugin; es. Sync e Migration |
| Tooling esterno | Generazione, build, test, packaging | No | Ambiente di sviluppo/CI |
| WordPress core | Piattaforma e API native | Sì | Dipendenza della distribuzione |
| Plugin di terze parti | Capacità esterne approvate | Se richiesto | Non sono parte del Parent salvo integrazione esplicita |

## Matrice delle responsabilità

Legenda: **P** proprietario; **E** estende/configura entro contratto; **—** non responsabile.

| Funzione | Parent | Child | Plugin custom | MU-plugin | Tooling |
|---|---:|---:|---:|---:|---:|
| Runtime visuale, template e asset condivisi | P | E | — | — | E |
| Componenti condivisi | P | E | — | — | E |
| Output del Design System | P (contratto/consumo) | P (artefatti progetto) | — | P (`d11-design-system`, sviluppo) | E |
| Configurazione specifica progetto | — | P | E per dominio | E per policy | E |
| Blocchi condivisi | P | E/restringe | — | — | E |
| Blocchi esclusivi | — | P | E se applicativi | — | E |
| Content model | P (registry/schema) | P (dichiarazioni) | E solo extension point | — | E |
| SEO | P | E | E se dominio autonomo | — | — |
| Maintenance | P | E | — | — | — |
| Cookie consent | P | E | — | — | — |
| Block availability | P (baseline/vincoli) | P (restringe/policy) | E approvata | — | E |
| Multilingua | E (presentazione) | E | P (`d11-multilingual`) | — | — |
| Content sync | — | E (dichiarazioni) | — | P (D11 Sync) | E |
| Contact Form 7 sync | — | E (dichiarazioni) | — | P (D11 Sync) | E |
| Migrazione | — | — | — | P (D11 Migration) | E |
| D11 Design System | — | E (input/output) | — | P, solo sviluppo | E |
| Scaffolding e generatori | — | — | — | — | P |
| Packaging | E (sorgente) | E (metadati) | E | E se runtime | P |
| Abilities | P per i propri domini | E entro contratto | P per il proprio dominio | P per il proprio dominio | E |

**Target** — D11 Sync e D11 Migration sono MU-plugin; `d11-design-system` è un MU-plugin esclusivamente di sviluppo/configurazione e non è distribuito al cliente. Questa attribuzione prevale per il Lotto 1; l'allineamento della fonte transitoria consolidata è esterno al perimetro di questa modifica.

## D11 Parent canonico

**Target** — Il Parent possiede rendering comune, template e asset condivisi, componenti e blocchi comuni, registry content model, SEO, maintenance, consenso, block availability, extension point e contratti Parent–Child.

**Constraint** — Namespace PHP, prefix, text domain, hook/filter pubblici, option/meta key, block name, REST namespace, capability, product ID e versione canonica sono identità tecnica immutabile. Il white-label cambia solo metadati esterni consentiti.

**Constraint** — Il Parent dipende da WordPress e da integrazioni esplicitamente approvate; non dipende da Child, tooling di sviluppo o configuratori runtime. Il Child dipende dal Parent tramite WordPress e dal suo contratto SemVer.

Il Parent non contiene configuratore universale, authoring o generatori di token, workflow di produzione pagine, D11 Sync, D11 Migration né comportamento applicativo multilingua.

## Distribuzione white-label

**Target** — Il prodotto canonico è il Parent con identità tecnica invariata. L'involucro white-label è un artefatto derivato che può variare directory, metadati del tema, screenshot e altre differenze espressamente ammesse. Il progetto è l'insieme Parent, Child e componenti approvati per una singola installazione; non ridefinisce il codice applicativo canonico.

Il trattamento di pipeline, manifest, checksum e `allowedDifferences` è definito in [release.md](release.md), non qui.

## Child di progetto

**Target** — Il Child è la sede della configurazione versionata del progetto: dichiarazioni content model, output visuali prodotti nello sviluppo, pattern, template override, blocchi esclusivi e policy project-specific di block availability.

**Constraint** — Non duplica runtime Parent. Dichiara in `d11-child.json` il range SemVer Parent compatibile, può restringere la baseline dei blocchi e non può riabilitare blocchi vietati, rimuovere blocchi obbligatori o aggirare vincoli Parent. Il contratto completo è in [parent-child-contract.md](parent-child-contract.md).

## Plugin e MU-plugin

- **`d11-multilingual` — Target:** plugin applicativo separato che possiede dati e comportamento multilingua; Parent e Child ne usano solo i contratti di presentazione.
- **D11 Sync — Target:** MU-plugin per sincronizzazione controllata fra dichiarazioni/contenuti versionati e stato WordPress, compresi contenuti pagina e Contact Form 7. Non è rendering del Parent.
- **D11 Migration — Target:** MU-plugin per migrazioni idempotenti e riportabili; non è eseguito implicitamente nel frontend.
- **`d11-design-system` — Target:** MU-plugin di sviluppo/configurazione, produttore di token JSON e input/output della build. È escluso dalla distribuzione cliente e avrà documentazione agentica autonoma.

Questi confini non documentano l'implementazione interna dei componenti esterni.

## Tooling di sviluppo

**Target** — Scaffolding, Docker, generatori, build, packaging, test e diagnostica di sviluppo sono dominio separato dal runtime. Il tooling può produrre artefatti versionabili o compilati, ma il sito in produzione non dipende da Node, Vite, generatori o `d11-design-system`.

Sono esclusi generazione pagine, composizione editoriale, review visuale, screenshot, Lighthouse e delivery del sito cliente.

## Criteri di collocazione

| Domanda | Se sì | Destinazione probabile |
|---|---|---|
| È parte del rendering o del contratto visuale comune? | Sì | Parent (template, blocchi condivisi, asset) |
| Possiede dati o comportamento applicativo che sopravvive al tema? | Sì | Plugin custom (`d11-multilingual`) |
| Serve sync/migrazione operativa prima del normale ciclo plugin? | Sì | MU-plugin (D11 Sync o D11 Migration) |
| È esclusivo di un progetto? | Sì | Child (pattern, override, dichiarazioni) |
| È necessario in produzione? | No | Tooling o MU-plugin solo sviluppo (`d11-design-system`) |
| Genera o valida artefatti di sviluppo? | Sì | Tooling o `d11-design-system` |
| È riusabile fra progetti come contratto visuale? | Sì | Parent |

## Stato Current

**Current** — Il tema monolitico è [themes/d11/](../../). Il bootstrap [themes/d11/functions.php](../../functions.php) carica asset, blocchi, content sync/CF7 sync, SEO, maintenance, privacy e block availability dal tema. [themes/d11/inc/content-sync/](../../inc/content-sync/) è il sync legacy.

**Current** — Non esistono Parent–Child target, `d11-multilingual`, MU-plugin D11, registry dichiarativo, manifest di distribuzione o pipeline di packaging. Tooling, asset Vite/Tailwind e documentazione legacy sono oggi inclusi nel tema.

**Current** — [themes/d11/style.css](../../style.css) dichiara WordPress `6.6`; il core locale è `7.1` in [../wp-includes/version.php](../../../../../wp-includes/version.php). Il Target architetturale richiede almeno WordPress `6.9` per Abilities API.

## Target e migrazione

| Area Current | Target | Vincolo durante la migrazione |
|---|---|---|
| Tema unico `d11` | Parent canonico + Child | Non duplicare runtime nel Child |
| Servizi in `inc/` theme-owned | Confini Parent/plugin/MU-plugin | Conservare comportamento verificato finché non coperto da test |
| Content sync e CF7 sync nel tema | D11 Sync MU-plugin | Nessuna sincronizzazione implicita nel frontend |
| Token/theme config nel tema | Output Child + build; Design System sviluppo | Non distribuire configuratore o generatori |
| Allowlist legacy globale | Block availability Parent–Child | Child può solo restringere la baseline |

## Invarianti architetturali

- Parent, Child, plugin, MU-plugin e tooling restano componenti separati.
- Il Parent non possiede dati applicativi di dominio o workflow di delivery cliente.
- Il Child non aggira contratti, vincoli di sicurezza o SemVer Parent.
- `d11-multilingual` possiede il comportamento applicativo multilingua.
- D11 Sync e D11 Migration non appartengono al Parent.
- `d11-design-system` non è runtime né distribuito al cliente.
- Runtime e build non dipendono da tool di sviluppo.
- Le differenze white-label non cambiano identità tecnica o codice applicativo canonico.

## Decisioni differite

- Support matrix completa WordPress/PHP/Parent/Child/schema/plugin.
- Elenco e formato definitivo degli extension point Parent.
- Struttura target delle directory dei singoli componenti.
- Catalogo iniziale di plugin runtime approvati.

## Documenti correlati

- [parent-child-contract.md](parent-child-contract.md)
- [content-model.md](content-model.md)
- [gutenberg-development.md](gutenberg-development.md)
- [frontend-assets.md](frontend-assets.md)
- [feature-modules.md](feature-modules.md)
- [release.md](release.md)

## Stato del documento

Canonical
