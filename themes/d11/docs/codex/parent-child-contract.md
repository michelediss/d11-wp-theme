# Contratto Parent–Child

## Scopo e autorità

Questo documento definisce le superfici pubbliche fra D11 Parent e Child: relazione WordPress, extension point, compatibilità SemVer, manifest `d11-child.json`, failure mode, deprecazioni, diagnostica e test contrattuali.

[source-specification.md](source-specification.md) è la fonte transitoria consolidata. **Target** e **Constraint** qui descritti sono prescrittivi; **Current** è soltanto il checkout osservato. I dettagli non fissati sono **Decisione differita**.

## Relazione WordPress

**Constraint** — Un Child usa il meccanismo WordPress-native: il suo header `style.css` dichiara `Template` con la directory del Parent. Il Parent deve essere installato e attivo come dipendenza effettiva per rendere disponibili template, asset e extension point.

**Target** — Il Semantic Versioning del Parent è la versione del contratto pubblico Parent–Child. Gli extension point pubblici fanno parte del contratto: una loro modifica incompatibile richiede un major bump del Parent.

Non esiste `childApi`, né un secondo identificatore equivalente di compatibilità. Il range SemVer dichiarato dal Child è l'unico requisito di compatibilità Parent–Child previsto dalla prima architettura.

## Superfici del contratto

Le sole superfici estendibili sono quelle documentate dal Parent:

- template e template part override consentiti;
- pattern e blocchi esclusivi del progetto;
- output visuali e configurazione ammessa del Child;
- dichiarazioni project-specific del content model;
- policy di block availability entro vincoli Parent;
- hook, filter e contratti esplicitamente pubblicati.

**Constraint** — Il Child non copia bootstrap, servizi, asset o blocchi condivisi del Parent e non accede a implementazioni interne come se fossero API pubbliche. Il dettaglio di blocchi è in [gutenberg-development.md](gutenberg-development.md); content model e asset sono nei rispettivi documenti specialistici.

## `d11-child.json`

**Target** — Ogni Child contiene `d11-child.json` come dichiarazione versionabile della propria identità e dei requisiti di compatibilità. La pipeline lo verifica prima di build e packaging; il runtime può usarlo solo per diagnostica.

I campi concettuali sono:

- `schemaVersion` per la struttura del manifest;
- `productId` del tipo di artefatto Child;
- `projectId` stabile del progetto;
- `requires.parent` come range SemVer Parent;
- requisiti di altri schema solo quando realmente applicabili, ad esempio content model.

Esempio non normativo: non definisce lo schema JSON finale né il percorso definitivo del file.

```json
{
  "schemaVersion": 1,
  "productId": "d11-child",
  "projectId": "example-project",
  "requires": {
    "parent": ">=1.0.0 <2.0.0",
    "contentModelSchema": "^1.0"
  }
}
```

## Compatibilità e verifica

**Constraint** — Build e packaging falliscono in modo esplicito quando il range `requires.parent` non include la versione Parent da distribuire. I test contrattuali verificano almeno un Child compatibile, uno incompatibile e la gestione delle deprecazioni.

**Target** — Nel runtime un'incompatibilità non causa fatal sul frontend. Il Parent espone diagnostica e, in area amministrativa quando appropriato, una notice; gli extension point incompatibili non vengono applicati.

Compatibilità non significa permissività: il Child può estendere soltanto i punti dichiarati dal Parent e resta soggetto a capability, sicurezza e vincoli tecnici.

## Override consentiti e limiti

| Area | Child può | Child non può |
|---|---|---|
| Template e parti | Applicare override pubblicati | Sostituire bootstrap o API interne |
| Pattern e blocchi | Aggiungere quelli esclusivi | Duplicare blocchi condivisi come fork impliciti |
| Design output | Fornire artefatti progetto conformi | Introdurre authoring/configuratore runtime |
| Content model | Dichiarare risorse progetto valide | Bypassare registry, validazione o migrazioni |
| Block availability | Restringere baseline e specializzare contesti | Riabilitare blocchi vietati o rimuovere obbligatori |

## Failure mode e diagnostica

**Constraint** — Errori del manifest, range non soddisfatto o configurazioni Child non valide producono diagnostica identificabile e non fatal frontend. Le parti incompatibili non vengono applicate in modo parziale o silenzioso.

La diagnostica deve distinguere almeno identità Child, versione/range Parent osservato, origine dell'errore e extension point escluso. Il formato, la collocazione e la retention dei log sono definiti in [security.md](security.md).

## Deprecazioni e rimozioni

**Constraint** — Ogni extension point deprecato dichiara alternativa, versione di introduzione della deprecazione e versione prevista di rimozione. La rimozione incompatibile richiede major bump del Parent e aggiornamento dei test contrattuali.

**Decisione differita** — La forma concreta delle annotazioni, del registro deprecazioni e della support matrix è da stabilire senza creare un secondo contratto di versione.

## Test contrattuali

La suite prodotto, definita in [testing.md](testing.md), deve coprire:

- validazione del manifest Child;
- soddisfacimento e rifiuto dei range SemVer;
- override consentiti e rifiuto di quelli non pubblici;
- fallback frontend senza fatal;
- diagnostica di incompatibilità;
- deprecazioni e rimozioni nel major appropriato.

## Stato Current e transizione

**Current** — Il repository contiene solo [themes/d11/](../../), il cui [style.css](../../style.css) non dichiara `Template`; non esistono Parent–Child target né `d11-child.json` verificati.

**Legacy** — Il tema attuale è un singolo block theme e non è prova di un contratto Child riusabile.

**Target** — La transizione introduce Parent e Child distinti, senza trasferire automaticamente API, directory o impostazioni legacy. Il Child fixture minimo, il percorso definitivo del manifest e la semantica completa dei range restano decisioni differite.

## Documenti correlati

- [architecture.md](architecture.md)
- [gutenberg-development.md](gutenberg-development.md)
- [content-model.md](content-model.md)
- [frontend-assets.md](frontend-assets.md)
- [testing.md](testing.md)
- [release.md](release.md)

## Stato del documento

Canonical
