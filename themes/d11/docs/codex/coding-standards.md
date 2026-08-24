# Standard di sviluppo D11 Parent

## Scopo

Questo documento definisce gli standard generali per PHP, WordPress, JavaScript, CSS, naming, i18n, error handling, logging, dipendenze, qualità e manutenibilità del D11 Parent. Le regole specifiche di blocchi e Gutenberg sono in [gutenberg-development.md](gutenberg-development.md).

## Fonti e stati

[source-specification.md](source-specification.md) è la fonte transitoria consolidata. **Current** descrive il legacy verificato; **Target** e **Constraint** sono prescrittivi; **Legacy** non è una convenzione da copiare; **Decisione differita** non autorizza supposizioni.

## Principi generali

- Ridurre il cambiamento al perimetro necessario e assegnare una responsabilità per modulo.
- Preferire API WordPress native; non duplicare capacità core né modificare WordPress core.
- Il Parent non dipende implicitamente dal Child e non contiene configurazione cliente.
- Rispettare identità tecnica D11, API pubbliche documentate e implementazioni interne separate.
- Aggiornare in modo coordinato codice, test e documento contrattuale interessato.
- Non introdurre astrazioni speculative, dipendenze o extension point senza caso d'uso reale e approvato.

## Versioni target

**Target** — Il requisito minimo WordPress del Parent è `6.9`. Le API usate devono essere compatibili con tale minimo; polyfill o compatibilità aggiuntiva richiedono decisione esplicita.

**Current** — [themes/d11/style.css](../../style.css) dichiara `Requires at least: 6.6`; il core locale è `7.1` in [../wp-includes/version.php](../../../../../wp-includes/version.php). Metadati, CI, test e packaging devono convergere sul requisito Target.

**Current** — [themes/d11/style.css](../../style.css) dichiara PHP `8.1`. **Decisione differita** — il requisito PHP Target e la support matrix definitiva non sono ancora approvati. [themes/d11/package.json](../../package.json) verifica Vite `7.1.3`, Tailwind `3.4.17` e toolchain Node, ma non fissa una versione Node Target.

## PHP e WordPress

**Constraint** — Applicare WordPress Coding Standards, type declaration compatibili con il requisito PHP approvato, visibilità minima necessaria e API WordPress prima di global state o SQL diretto. Le API procedurali pubbliche usano il prefix tecnico D11 immutabile; namespace, autoloading e directory Target non sono ancora definiti.

**Current** — [themes/d11/functions.php](../../functions.php) e [themes/d11/inc/blocks.php](../../inc/blocks.php) usano guardia `ABSPATH`, funzioni `d11_` e `declare(strict_types=1)`. **Decisione differita** — mantenere `strict_types` come requisito Target richiede la decisione sul requisito PHP e sulla codebase Parent.

- Bootstrap esplicito, ordinato e testabile; nessun side effect non documentato all'import.
- Separare dominio, infrastruttura e integrazione WordPress senza inventare una nuova architettura di directory.
- Callback WordPress devono avere firma e ritorno previsti dall'hook; non esporre callback interne come API.
- Non modificare core, non accedere direttamente a global state o database quando l'API WordPress è sufficiente.

## Hook, filter e API

**Constraint** — Hook e filter pubblici hanno naming tecnico D11 immutabile, argomenti e tipi documentati, test contrattuali e priorità esplicita quando significativa. Un extension point pubblico non usa callback anonime non rimovibili.

Distinguere hook interni da pubblici; documentare solo i secondi come contratto. Deprecare un hook prima della sua rimozione incompatibile e applicare il major bump previsto da [parent-child-contract.md](parent-child-contract.md). Nessuna compatibilità implicita deriva dall'uso di un simbolo interno.

## Input, validazione ed output

L'ordine obbligatorio è: **autorizzazione → nonce quando applicabile → normalizzazione → sanitizzazione → validazione → elaborazione → escaping nel contesto di output**.

| Dato | Regola |
|---|---|
| HTML | Consentire solo markup previsto e fare escaping/output con API WordPress appropriate |
| Attributo HTML | Escaping contestuale, mai concatenazione non controllata |
| URL | Sanitizzare/validare come URL e fare escaping in output |
| JavaScript/JSON | Serializzare con API WordPress/PHP, non interpolare stringhe |
| SQL | API WordPress; `$wpdb->prepare()` per SQL dinamico |
| REST e metadata | Permission, sanitizzazione e validazione schema prima della persistenza |

Threat model e policy complete sono in [security.md](security.md).

## Accesso ai dati

- Usare API WordPress per post, meta, option, query e registrazioni prima di query manuali.
- Ogni SQL dinamico usa `$wpdb->prepare()`; vietata l'interpolazione di input.
- Usare transazioni solo quando supportate e necessarie; cache e invalidazione sono esplicite.
- Option e meta key rispettano l'identità tecnica D11; configurazioni di sviluppo non sono storage runtime di produzione.
- Migrazioni incompatibili appartengono al componente proprietario; il content model è in [content-model.md](content-model.md).

## Error handling e logging

| Situazione | Comportamento |
|---|---|
| Errore di programmazione | Correggere; non silenziare né degradare deliberatamente |
| Input/configurazione invalida | Rifiutare con errore diagnostico, senza stato parziale |
| Dipendenza opzionale assente | Fail-safe senza fatal frontend, con diagnostica |
| Incompatibilità Parent–Child | Non applicare l'extension point; notice/diagnostica come da contratto |
| Errore operativo recuperabile | Restituire `WP_Error` al confine WordPress appropriato |

Le eccezioni restano nei livelli dove sono gestite; build e sviluppo falliscono presto, runtime degrada in modo sicuro quando possibile. Logging strutturato, quando disponibile, include componente, operazione e severità; correlation ID quando utile. Non registrare segreti, token, contenuto personale completo o input integrale non necessario. Separare diagnostica sviluppo da logging produzione. Vedi [security.md](security.md) e [abilities-mcp.md](abilities-mcp.md).

## Internazionalizzazione

**Constraint** — Text domain tecnico interno immutabile, funzioni i18n WordPress, escaping delle stringhe tradotte, placeholder numerati dove necessario, translator comment per contesto non ovvio e API plurali per quantità.

Le stringhe JavaScript usano le traduzioni associate con `wp_set_script_translations()` quando richiesto. Nessun copy cliente hardcoded vive in componenti condivisi. **Current** — [themes/d11/package.json](../../package.json) definisce gli script `i18n:*` e [themes/d11/inc/blocks.php](../../inc/blocks.php) collega traduzioni degli script; aggiornare gli artefatti quando una modifica lo richiede.

## JavaScript

- Progressive enhancement: il contenuto utile resta disponibile senza JavaScript quando possibile.
- Moduli con responsabilità circoscritta, lifecycle esplicito e nessuna dipendenza globale accidentale.
- Event listener rimovibili quando il lifecycle lo richiede; inizializzazioni idempotenti.
- Non basare il DOM su struttura accidentale; rispettare `prefers-reduced-motion`, i18n ed error handling.
- Nessuno stato persistente client nel Parent senza responsabilità esplicita.
- Usare API WordPress quando il codice opera nell'editor; rispettare la pipeline Vite senza documentarla qui.

## CSS

**Target** — Tailwind è parte della pipeline Target; CSS custom properties generate sono contratto visuale. Stili condivisi Parent e output progetto Child restano separati.

- Classi circoscritte e namespaced per componente/blocco; prevenire leakage.
- Nessun valore cliente hardcoded nel Parent, Bootstrap o utility legacy nei nuovi componenti.
- Nessuna dipendenza runtime da `d11-design-system`; focus, contrasto e reduced motion sono requisiti tecnici.
- `!important` è eccezione motivata, non strumento di precedence ordinaria.

Build e token output sono in [frontend-assets.md](frontend-assets.md).

## Dipendenze

Una dipendenza richiede necessità verificata, owner/manutenzione, licenza, sicurezza, dimensione, compatibilità, impatto runtime, aggiornabilità e valutazione dell'alternativa WordPress-native. Classificarla come runtime, development, build o opzionale. Un cambiamento architetturale richiede approvazione; è vietato aggiungere librerie per problemi piccoli senza valutazione.

## Documentazione del codice

Usare PHPDoc per API pubbliche e logica non ovvia, JSDoc quando chiarisce un contratto e commenti sul perché, non sulla sintassi. Cambiando un contratto, aggiornare il documento canonico. Non descrivere Target come Current e non lasciare TODO privi di contesto o tracking.

## Pratiche vietate

- modifica del core WordPress, segreti nel repository, SQL non preparato;
- input non validato o output non escaped;
- dipendenza da simboli interni Child, copy cliente nel Parent o configuratori sviluppo runtime;
- API pubbliche accidentali, breaking change senza major, quality gate disabilitati per far passare una modifica.

## Checklist Codex

Prima: classificare ownership e stato normativo, leggere il contratto pertinente, verificare API/versione e path Current. Dopo: applicare autorizzazione/validazione/escaping, aggiornare test e documentazione contrattuale, eseguire quality gate disponibile e riportare gap o decisioni differite.

## Stato Current e gap

**Current** — Il legacy usa funzioni `d11_`, `strict_types`, Vite/Tailwind e script i18n, ma non presenta un Parent separato, support matrix, static analysis o quality gate PHP verificati. I dettagli visuali in [themes/d11/tailwind.config.js](../../tailwind.config.js) sono **Legacy** e non definiscono token del prodotto.

## Decisioni differite

- requisito PHP Target e support matrix completa;
- namespace/autoloading Parent e policy completa di static analysis;
- formatter, linter e tool definitivi non già presenti.

## Documenti correlati

- [architecture.md](architecture.md)
- [parent-child-contract.md](parent-child-contract.md)
- [gutenberg-development.md](gutenberg-development.md)
- [security.md](security.md)
- [frontend-assets.md](frontend-assets.md)
- [testing.md](testing.md)

## Stato del documento

Canonical
