# D11 Maintenance

`d11-maintenance` e il plugin che gestisce una modalita manutenzione coerente con il sito, usando il contenuto Gutenberg della pagina di manutenzione invece di una schermata tecnica separata.

## Idea

Anche durante la manutenzione, D11 evita di uscire dal proprio modello compositivo.

Invece di mostrare una pagina esterna e scollegata dal tema:

- usa una normale pagina WordPress
- ne riutilizza il contenuto Gutenberg
- mantiene coerenza visiva e strutturale con il resto del sito

## Cosa fa

- attiva una risposta di manutenzione site-wide
- mostra il contenuto della pagina con slug `maintenance`
- restituisce HTTP `503` per le richieste pubbliche
- permette l'accesso amministrativo e un bypass controllato

## Quando usarlo

E utile quando vuoi:

- mettere il sito in manutenzione senza rompere l'identita visiva
- far gestire il messaggio di manutenzione a chi lavora in Gutenberg
- evitare template ad hoc separati dalla struttura del progetto

## In linea con D11

In D11 anche una pagina di manutenzione e vista come una manifestazione del sistema:

- blocchi
- contenuti
- struttura
- composizione

Non una schermata tecnica scollegata, ma una parte coerente dell'universo osservabile del sito.
