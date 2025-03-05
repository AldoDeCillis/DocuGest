# DocuGest

**DocuGest** è un'applicazione web gestionale documentale costruita con Laravel. È progettata per semplificare e ottimizzare la gestione dei documenti aziendali, permettendo agli utenti di archiviare, organizzare e recuperare documenti in modo rapido e sicuro.

## Caratteristiche principali

- **Gestione Documentale**: Organizza i tuoi documenti in categorie, carica nuovi file e gestisci facilmente quelli esistenti.
- **Ricerca Avanzata**: Trova rapidamente i documenti tramite parole chiave, metadati e categorie.
- **Interfaccia Intuitiva**: Un'interfaccia utente semplice e pulita per migliorare l'esperienza dell'utente.
- **Sicurezza**: Autenticazione utente e autorizzazioni per proteggere i dati sensibili.
- **Scalabilità**: Progettato per crescere con le esigenze aziendali, supportando una gestione di documenti sempre più complessa.

## Tecnologie utilizzate

- **Laravel**: Framework PHP per lo sviluppo backend.
- **MySQL**: Database relazionale per la gestione dei dati.
- **Tailwind CSS**: Framework CSS per la creazione di interfacce utente reattive e personalizzabili.
- **Livewire**: Framework per la creazione di componenti interattivi in tempo reale senza dover scrivere JavaScript.
- **Alpine.js**: Biblioteca JavaScript leggera per aggiungere interattività all'interfaccia.
- **JavaScript Personalizzato**: Codice JS personalizzato per funzioni avanzate e logiche di interazione.

## Requisiti

- PHP >= 8.0
- Laravel >= 8.x
- MySQL
- Composer
- Node.js (per la gestione delle dipendenze front-end)

## Installazione

1. Clona il repository:
   ```bash
   git clone https://github.com/tuo-utente/docugest.git
   ```
2. Vai nella cartella del progetto:
   ```bash
   cd docugest
   ```
3. Installa le dipendenze PHP:
   ```bash
   composer install
   ```
4. Crea il file `.env` copiando dal `.env.example`:
   ```bash
   cp .env.example .env
   ```
5. Genera la chiave dell'app:
   ```bash
   php artisan key:generate
   ```
6. Configura il database nel file `.env` (MySQL).
7. Esegui le migrazioni:
   ```bash
   php artisan migrate
   ```
8. Compila gli asset front-end:
   ```bash
   npm install && npm run dev
   ```
9. Avvia il server di sviluppo:
   ```bash
   php artisan serve
   ```

## Contribuire

Contribuisci al progetto aprendo una *pull request* o segnalando bug e miglioramenti. Assicurati di seguire le linee guida di stile e di testare le modifiche prima di inviarle.
