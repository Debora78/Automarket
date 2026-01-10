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

1.      Vai su http://localhost:8000/cart
2.      Aggiungi un’auto al carrello
3.      Clicca Procedi al pagamento
4.      Stripe ti porterà alla pagina checkout
5.      Inserisci la carta di test:
    4242 4242 4242 4242
    12/34
    123
6.      Conferma il pagamento
7.      Stripe ti reindirizzerà alla pagina:
    /checkout/success
8.      Il carrello verrà svuotato automaticamente

## 📊 4. Dove vedere il pagamento su Stripe

Vai nella tua dashboard Stripe:
👉 Payments → Test mode
Vedrai:
• lo stato del pagamento
• l’importo
• il nome del prodotto
• la data
• il metodo di pagamento
