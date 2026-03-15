# D11 CF7 Sync

`cf7-sync` e il plugin che permette di trattare i form di Contact Form 7 come configurazione versionata, invece che come contenuto mantenuto solo nel pannello WordPress.

## A cosa serve

Questo plugin e utile quando vuoi:

- mantenere i form nel progetto
- sincronizzarli in modo ripetibile tra ambienti
- evitare modifiche manuali non tracciate
- lavorare con un tema compositivo dove anche i form fanno parte del sistema

In D11 i form non sono un elemento isolato: fanno parte della struttura osservabile del sito e devono restare coerenti con il modello del tema.

## Come funziona

Il plugin legge manifest JSON versionati e li sincronizza con Contact Form 7 tramite WP-CLI.

Flusso tipico:

1. definisci o aggiorni un manifest JSON
2. esegui il comando di sync
3. il plugin crea o aggiorna il form corrispondente
4. se non ci sono differenze, non tocca nulla

## Comando disponibile

```bash
wp cf7 sync
```

Opzioni principali:

- `--dir=<path>` per indicare la directory dei manifest
- `--slug=<slug>` per sincronizzare un solo form
- `--dry-run` per vedere cosa cambierebbe senza scrivere nel database

Esempi:

```bash
wp cf7 sync --dir=wp-content/themes/d11/cf7-forms
wp cf7 sync --slug=contatti --dry-run
```

Se non specifichi `--dir`, il plugin usa per default:

```text
wp-content/themes/d11/cf7-forms
```

## Perche e utile in D11

D11 tratta il sito come un sistema emergente composto da strutture fondamentali combinabili. Anche i form, in questo approccio, devono poter essere:

- descritti
- versionati
- sincronizzati
- riutilizzati

`cf7-sync` rende questa parte del sistema piu affidabile e piu adatta a workflow compositivi e AI-assisted.
