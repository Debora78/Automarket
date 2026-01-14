### 📘 Automarket – Documentazione del Progetto

Automarket è una piattaforma completa per la vendita, l’acquisto e il noleggio di automobili.
Include funzionalità avanzate come autenticazione, gestione annunci, revisione, carrello, ordini, checkout Stripe, notifiche e dashboard personalizzata

## 📂 Struttura iniziale del progetto (creazione tramite Bash)

Per creare la struttura base del progetto:

# Creazione progetto Laravel

laravel new automarket
cd automarket

# Creazione cartelle personalizzate

mkdir -p app/Http/Controllers/Admin
mkdir -p app/Http/Controllers/Reviewer
mkdir -p app/Models
mkdir -p app/Livewire
mkdir -p resources/views/cars
mkdir -p resources/views/dashboard
mkdir -p resources/views/notifications
mkdir -p resources/views/profile/partials
mkdir -p public/uploads/cars

# Creazione componenti Blade personalizzati

mkdir -p resources/views/components
touch resources/views/components/typewriter-title.blade.php
touch resources/views/components/footer.blade.php

### 🧩 Tecnologie utilizzate

## BACKEND

# Tecnologia # Descrizione

-   Laravel 12 | Framework principale
-   PHP 8.2 + | Versione minima consigliata
-   Laravel Jeststream | Autenticazione, profilo, sicurezza
-   Laravel Fortify | Gestione login, registrazione, reset password
-   Livewire 3 | Creazione annunci dinamica
-   Eloquent ORM | Gestione database
-   Laravel Notification | Notifiche utente
-   Stripe SDK | Pagamenti online

### FRONTEND

-   TailwindCSS 4 | Stile moderno e responsive
-   Alpine.js | Interattività leggera (typewriter, modali, transazioni)
-   Blade Components | Componenti riutilizzabili
-   Heroicons / Lucide | Icone

### DATABASE

## DBMS utilizzato

-   MySQL 8 (consigliato)
-   Compatibile anche con MariaDB o PostgreSQL

### TABELLE PRINCIPALI

## Tabella # Funzione

-   users | Utenti Registrati
-   cars | Annunci Auto
-   favorites | Auto Preferite
-   cart_items | Carrello
-   orders | Ordini
-   order_items | Articoli dell'ordine
-   notifications | Notifiche Laravel
-   reviewer_requests | Richieste ruolo revisione

### DIPENDENZE PRINCIPALI

## Composer

# Bash

composer require livewire/livewire
composer require laravel/jetstream
composer require laravel/fortify
composer require stripe/stripe-php
composer require barryvdh/laravel-dompdf

## NPM

# Bash

npm install
npm install tailwindcss @tailwindcss/forms
npm install alpinejs
npm run build

### SETUP DEL PROGETTO

## Clona il repositoryù

# Bash

composer install
npm install

## Configura l'ambiente

# Bash

cp .env.example .env
php artisan key:generate

## Configura il database

-   Nel .env:
    DB_DATABASE=automarket
    DB_USERNAME=root
    DB_PASSWORD=yourpassword

## Esegui le migrazioni

# Bash

php artisan migrate --seed

## Avvia il server

# Bash

php artisan serve
npm run dev

### FUNZIONALITA' PRINCIPALI

## 👤 Autenticazione completa

• Registrazione
• Login
• Reset password
• Verifica email
• Gestione profilo
• Eliminazione account

## 🚗 Gestione annunci

• Creazione annunci (Livewire)
• Filtri: nuove, usate, noleggio
• Dettaglio auto
• Preferit

## 🛒 Carrello e ordini

• Aggiunta/rimozione auto
• Checkout Stripe
• Storico ordini

## 🛡️ Revisione annunci

• Richiesta ruolo revisore
• Area revisore
• Approva / Rifiuta annunci

## 🔔 Notifiche

• Notifiche per ordini, revisione, richieste
• Segna come lette
• Elimina singola o tutte

## 🖥️ Dashboard utente

• Preferiti
• Accesso rapido alle categorie
• Richiesta revisore

### 📦 Struttura cartelle (principale)

app/
├── Http/
│ ├── Controllers/
│ │ ├── Admin/
│ │ ├── Reviewer/
│ │ ├── CarController.php
│ │ ├── CartController.php
│ │ ├── OrderController.php
│ │ └── ProfileController.php
│ └── Middleware/
├── Livewire/
│ └── CreateCar.php
└── Models/
resources/
├── views/
│ ├── cars/
│ ├── dashboard/
│ ├── notifications/
│ ├── profile/
│ └── components/
public/
└── uploads/cars/
routes/
├── web.php
└── auth.php

### 📄 Licenza

MIT License (o quella che preferisci).

### PER TEST PAGAMENTI

### 💳 1. La carta di test principale (pagamento riuscito)

Questa è la carta che Stripe usa per simulare un pagamento andato a buon fine:
VISA (successo garantito)
• Numero:
• Scadenza: qualsiasi data futura (es. )
• CVC: qualsiasi (es. )
• CAP: qualsiasi (es. )
👉 Questa carta funziona sempre e simula un pagamento reale.

## 💥 2. Carte per simulare errori (opzionale)

Se vuoi testare anche i casi negativi:

## ❌ Carta rifiutata

• 4000 0000 0000 0002

## ❌ Fondi insufficienti

• 4000 0000 0000 9995

## ❌ Carta scaduta

• 4000 0000 0000 0069

## ❌ Autenticazione 3D Secure richiesta

• 4000 0027 6000 3184
Tutte queste carte sono ufficiali Stripe.

## 🧪 3. Come testare il pagamento nel tuo sito

1.       Vai su http://localhost:8000/cart
2.       Aggiungi un’auto al carrello
3.       Clicca Procedi al pagamento
4.       Stripe ti porterà alla pagina checkout
5.       Inserisci la carta di test:
    4242 4242 4242 4242
    12/34
    123
6.       Conferma il pagamento
7.       Stripe ti reindirizzerà alla pagina:
    /checkout/success
8.       Il carrello verrà svuotato automaticamente

## 📊 4. Dove vedere il pagamento su Stripe

Vai nella tua dashboard Stripe:
👉 Payments → Test mode
Vedrai:
• lo stato del pagamento
• l’importo
• il nome del prodotto
• la data
• il metodo di pagamento
