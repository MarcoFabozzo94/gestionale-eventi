# Gestionale Eventi - MVP e Design System

## Obiettivo

Creare un gestionale interno per un'azienda che organizza eventi. La prima versione deve essere usabile dagli admin dopo il login e deve permettere di gestire eventi, personale, ruoli, compensi e riepiloghi economici.

L'esperienza deve essere funzionale, moderna e squadrata: una dashboard operativa, non una landing page. La direzione visiva e' scura, tecnica e pulita, con accenti fluo usati per orientare l'utente e mettere in evidenza stati, azioni e numeri importanti.

## Scope MVP

Il gestionale include:

- dashboard interna con riepiloghi operativi ed economici;
- elenco, creazione, modifica e dettaglio eventi;
- elenco, creazione, modifica e profilo membri del personale;
- elenco ruoli gestibili dall'admin;
- assegnazione del personale agli eventi con ruolo e compenso;
- calcolo costo totale staff, venduto al cliente e margine evento;
- storico eventi per ogni membro del personale.

Il gestionale non include nella prima versione:

- accesso separato per membri dello staff;
- fatture, contratti o documenti;
- gestione pagamenti incassati/pagati;
- permessi multi-ruolo oltre all'admin interno;
- calendario avanzato drag-and-drop.

## Utenti

L'unico utente operativo previsto nell'MVP e' l'admin interno. Il personale e' un'anagrafica consultabile dall'admin, non un account che accede al sistema.

## Modello Dati

### Eventi

Campi principali:

- titolo;
- data evento;
- luogo;
- cliente, opzionale;
- prezzo venduto al cliente;
- note operative.

Relazioni:

- un evento ha molte assegnazioni staff;
- un evento usa molti membri del personale tramite le assegnazioni;
- un evento usa molti ruoli tramite le assegnazioni.

### Personale

Campi principali:

- nome;
- cognome;
- email, opzionale;
- telefono, opzionale;
- stato attivo/non attivo;
- note interne.

Relazioni:

- un membro del personale ha molte assegnazioni evento;
- lo storico del profilo si ricava dalle assegnazioni.

### Ruoli

Campi principali:

- nome ruolo;
- descrizione opzionale;
- stato attivo/non attivo.

Esempi:

- steward;
- hostess;
- tecnico audio;
- fotografo;
- coordinatore;
- sicurezza;
- promoter.

### Assegnazioni Evento

Campi principali:

- evento;
- membro del personale;
- ruolo nell'evento;
- compenso pattuito;
- note opzionali.

Questa tabella e' il cuore operativo: permette allo stesso membro di avere ruoli diversi in eventi diversi e di calcolare costi e guadagni in modo preciso.

## Calcoli

Per ogni evento:

- costo staff totale = somma dei compensi delle assegnazioni;
- margine evento = prezzo venduto al cliente - costo staff totale.

Per ogni membro del personale:

- eventi fatti = numero di assegnazioni;
- totale guadagnato = somma dei compensi;
- storico = lista eventi con data, luogo, ruolo e compenso.

Gli importi vanno salvati in centesimi nel database e mostrati in euro nell'interfaccia.

## Schermate

### Dashboard

La dashboard deve essere la schermata operativa principale. Deve mostrare:

- prossimi eventi;
- eventi totali;
- venduto totale;
- costo staff totale;
- margine totale;
- lista sintetica degli ultimi eventi.

La dashboard deve privilegiare lettura rapida e azioni immediate, non elementi decorativi.

### Eventi

La sezione eventi include:

- lista eventi con ricerca semplice;
- pulsante per creare un nuovo evento;
- dettaglio evento con informazioni generali;
- tabella staff assegnato;
- riepilogo economico dell'evento;
- azioni per aggiungere, modificare o rimuovere assegnazioni staff.

### Personale

La sezione personale include:

- lista membri con stato, numero eventi e totale guadagnato;
- creazione e modifica membro;
- profilo membro con dati anagrafici;
- storico eventi del membro;
- riepilogo ruoli svolti e compensi.

### Ruoli

La sezione ruoli include:

- lista ruoli;
- creazione e modifica ruolo;
- stato attivo/non attivo.

## Direzione Visiva

### Personalita'

Il prodotto deve sembrare:

- interno e professionale;
- moderno ma non rumoroso;
- squadrato, denso, leggibile;
- adatto a un'azienda che deve organizzare lavoro reale;
- energico grazie agli accenti fluo, ma non "gaming".

Il prodotto non deve sembrare:

- una landing page;
- una dashboard crypto;
- un template generico;
- una UI morbida, pastello o troppo arrotondata;
- una pagina marketing con hero, illustrazioni o sezioni decorative.

### Palette

Usare una base scura con accenti fluo funzionali.

Colori principali:

- nero base: `#050505`;
- nero superficie: `#0B0D0E`;
- antracite pannelli: `#111417`;
- bordo scuro: `#252A2E`;
- testo primario: `#F5F7FA`;
- testo secondario: `#9CA3AF`;
- testo debole: `#6B7280`.

Accenti fluo:

- verde fluo principale: `#B6FF00`;
- cyan fluo: `#00E5FF`;
- magenta fluo: `#FF2BD6`;
- giallo warning: `#FACC15`;
- rosso errore: `#FF3B3B`.

Uso degli accenti:

- verde fluo per azioni principali, margine positivo e stato confermato;
- cyan fluo per link attivi, focus, informazioni e navigazione selezionata;
- magenta fluo solo per evidenze rare o badge speciali;
- giallo per warning o dati incompleti;
- rosso per errori, eliminazioni e margine negativo.

Regola: non usare piu' di due accenti fluo nella stessa area visiva, salvo grafici o riepiloghi molto piccoli.

### Tema Chiaro

L'MVP deve privilegiare il tema scuro. Se resta disponibile il tema chiaro dell'app, deve funzionare, ma le nuove schermate gestionali devono essere progettate prima per il tema scuro.

### Forma e Spaziatura

La UI deve essere squadrata:

- radius massimo standard: `8px`;
- radius consigliato per pannelli e card: `6px`;
- radius per input e bottoni: `6px`;
- evitare pill e card molto arrotondate;
- bordi sottili e visibili;
- ombre leggere o assenti, preferire bordi e contrasto.

Spaziatura:

- layout pagina: `24px` desktop, `16px` mobile;
- gap tra sezioni: `20px` o `24px`;
- gap dentro card/pannelli: `12px` o `16px`;
- altezza controlli: `36px` o `40px`.

### Tipografia

Usare il font gia' presente nel progetto.

Gerarchia:

- titolo pagina: 24-28px, semibold;
- titolo sezione: 18-20px, semibold;
- label e intestazioni tabella: 12-13px, uppercase solo quando serve;
- corpo testo: 14px;
- dati numerici importanti: 20-28px, semibold, tabular numbers.

Regole:

- niente letter-spacing negativo;
- evitare titoli enormi nelle sezioni operative;
- usare numeri allineati e leggibili nei riepiloghi economici.

## Componenti UI

### Layout

Usare la sidebar esistente come navigazione principale. Le voci gestionali previste:

- Dashboard;
- Eventi;
- Personale;
- Ruoli.

La pagina deve avere:

- header compatto con breadcrumb;
- contenuto a larghezza piena;
- griglie dense e leggibili;
- nessuna sezione hero.

### Card e Pannelli

Usare card solo per:

- metriche dashboard;
- riepiloghi economici;
- blocchi informativi nel dettaglio;
- profili staff.

Non annidare card dentro altre card. Le sezioni principali devono restare layout o pannelli, non scatole decorative multiple.

Stile card:

- sfondo `#111417`;
- bordo `#252A2E`;
- radius `6px`;
- padding `16px`;
- hover solo quando la card e' cliccabile.

### Tabelle

Le tabelle sono centrali nel gestionale.

Regole:

- intestazioni compatte;
- righe alte 44-52px;
- numeri allineati a destra;
- azioni a destra con icone;
- badge per stati e ruoli;
- riga hover con sfondo leggermente piu' chiaro;
- su mobile, usare layout a lista compatta se la tabella diventa troppo stretta.

### Form

I form devono essere rapidi da compilare.

Regole:

- label sempre visibile;
- input con bordo chiaro su superficie scura;
- focus cyan fluo;
- errori rossi sotto il campo;
- azione primaria verde fluo;
- azione secondaria neutra;
- eliminazione rossa e separata dalle azioni normali.

### Badge

Usare badge piccoli e leggibili:

- ruolo: bordo cyan o testo cyan;
- attivo/confermato: verde fluo;
- inattivo/bozza: grigio;
- warning: giallo;
- negativo/errore: rosso.

I badge devono avere radius massimo `6px`, non pill eccessivamente tonde.

### Bottoni

Tipi:

- primario: verde fluo su nero, per creare/salvare;
- secondario: antracite con bordo;
- ghost: solo testo/icona per azioni leggere;
- danger: rosso per eliminazioni.

I bottoni devono usare icone lucide quando disponibili, soprattutto per:

- aggiungere;
- modificare;
- eliminare;
- cercare;
- filtrare;
- tornare indietro.

## Regole Per Coerenza

Ogni nuova schermata gestionale deve rispettare queste regole:

1. usare il layout interno autenticato;
2. partire da contenuto operativo, non da testo descrittivo;
3. usare nero/antracite come base;
4. usare verde fluo solo per azioni principali e dati positivi;
5. usare cyan per focus, navigazione attiva e informazioni;
6. evitare gradienti decorativi;
7. evitare illustrazioni decorative;
8. evitare card annidate;
9. mantenere radius massimo a `8px`;
10. mostrare riepiloghi numerici in alto quando aiutano la decisione;
11. usare tabelle o liste dense per dati gestionali;
12. mantenere mobile leggibile senza sovrapposizioni.

## Stati Vuoti

Gli stati vuoti devono essere pratici:

- titolo breve;
- frase di contesto;
- azione primaria;
- nessuna grande illustrazione.

Esempio: nella lista eventi vuota, mostrare un pannello compatto con bottone "Crea evento".

## Validazione ed Errori

Validazioni principali:

- evento: titolo, data e luogo obbligatori;
- prezzo venduto: numerico, minimo zero;
- personale: nome e cognome obbligatori;
- ruolo: nome obbligatorio e unico;
- assegnazione: evento, personale, ruolo e compenso obbligatori;
- compenso: numerico, minimo zero.

Errori:

- messaggi chiari sotto i campi;
- alert sintetico in cima al form se necessario;
- nessun errore tecnico mostrato all'admin.

## Test MVP

Test minimi da coprire:

- un admin autenticato vede la dashboard;
- un evento puo' essere creato e modificato;
- un membro del personale puo' essere creato e modificato;
- un ruolo puo' essere creato e modificato;
- un membro puo' essere assegnato a un evento con ruolo e compenso;
- il costo staff di un evento viene calcolato correttamente;
- il margine evento viene calcolato correttamente;
- il profilo staff mostra storico eventi e totale guadagnato.

## Note Tecniche

Seguire le convenzioni Laravel/Inertia gia' presenti nel progetto:

- backend Laravel con controller dedicati;
- pagine in `resources/js/pages`;
- navigazione tramite Wayfinder quando il frontend chiama rotte backend;
- componenti UI esistenti dove possibile;
- Pest per i test;
- importi salvati in centesimi;
- query con eager loading per evitare N+1 in liste e profili.

## Decisioni Approvate

- Il gestionale e' solo per admin interni.
- Il personale non accede con account proprio nell'MVP.
- I ruoli sono gestiti per singola assegnazione evento.
- La parte economica include prezzo venduto al cliente e compenso per ogni membro assegnato.
- L'MVP deve essere funzionale, moderno, squadrato, scuro e con accenti fluo.
