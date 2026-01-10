<?php
// Apertura del file PHP.

/**
 * Questo controller gestisce l’intero flusso di checkout dell’applicazione,
 * includendo pagamento con Stripe, creazione dell’ordine, generazione della
 * fattura in PDF, invio delle email di conferma e notifica ai venditori.
 *
 * Si occupa di:
 * - Creare una sessione di pagamento Stripe basata sul contenuto del carrello
 * - Validare che il carrello non sia vuoto
 * - Generare un ordine e i relativi articoli dopo il pagamento
 * - Notificare i venditori degli articoli acquistati
 * - Generare e salvare una fattura PDF
 * - Inviare email di conferma all’acquirente
 * - Svuotare il carrello dopo il completamento dell’ordine
 *
 * È uno dei componenti più critici dell’applicazione e integra pagamenti,
 * gestione ordini, notifiche e generazione documenti in un unico flusso.
 */

namespace App\Http\Controllers;
// Namespace che organizza i controller generici dell’applicazione.

use Stripe\Stripe;
// Importa la libreria Stripe per gestire i pagamenti.

use App\Models\CartItem;
// Modello che rappresenta un elemento del carrello.

use App\Models\OrderItem;
// Modello che rappresenta un articolo dell’ordine.

use App\Models\Order;
// Modello che rappresenta un ordine.

use Stripe\Checkout\Session;
// Classe Stripe per creare una sessione di pagamento.

use Barryvdh\DomPDF\Facade\Pdf;
// Facade per generare PDF tramite DomPDF.

use App\Mail\OrderConfirmationMail;
// Email inviata all’acquirente dopo l’ordine.

use Illuminate\Support\Facades\Mail;
// Facade per inviare email.

use App\Mail\VendorOrderNotificationMail;
// Email inviata al venditore per notificare la vendita.

use Illuminate\Support\Facades\Auth;
// Facade per verificare se l’utente è autenticato.

class CheckoutController extends Controller
// Controller che gestisce il flusso di checkout e pagamento.
{
    public function checkout()
    // Crea la sessione di pagamento Stripe e reindirizza l’utente al checkout.
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        // Imposta la chiave API di Stripe.

        $sessionId = session()->getId();
        // Recupera l’ID della sessione per identificare il carrello.

        $items = CartItem::with('car')
            // Eager loading della relazione con il modello Car.

            ->where('session_id', $sessionId)
            // Filtra gli articoli del carrello per sessione.

            ->get();
        // Recupera gli articoli.

        if ($items->isEmpty()) {
            // Se il carrello è vuoto:

            return redirect()->route('cart.index')->with('error', 'Il carrello è vuoto.');
            // Reindirizza con messaggio di errore.
        }

        $lineItems = [];
        // Array che conterrà gli articoli formattati per Stripe.

        foreach ($items as $item) {
            // Converte ogni articolo del carrello in un line item Stripe.

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    // Valuta del pagamento.

                    'product_data' => [
                        'name' => $item->car->brand . ' ' . $item->car->model,
                        // Nome del prodotto mostrato nel checkout Stripe.
                    ],
                    'unit_amount' => $item->car->price * 100,
                    // Prezzo in centesimi (Stripe richiede integer).
                ],
                'quantity' => $item->quantity,
                // Quantità dell’articolo.
            ];
        }

        $session = Session::create([
            // Crea la sessione di pagamento Stripe.

            'payment_method_types' => ['card'],
            // Accetta solo pagamenti con carta.

            'line_items' => $lineItems,
            // Articoli del carrello.

            'mode' => 'payment',
            // Modalità pagamento singolo.

            'success_url' => route('checkout.success'),
            // URL di successo.

            'cancel_url' => route('cart.index'),
            // URL di annullamento.
        ]);

        return redirect($session->url);
        // Reindirizza l’utente alla pagina di pagamento Stripe.
    }

    public function success()
    // Gestisce il post-pagamento: crea ordine, invia email, genera fattura.
    {
        $sessionId = session()->getId();
        // Recupera l’ID della sessione.

        $items = CartItem::with('car')
            ->where('session_id', $sessionId)
            ->get();
        // Recupera gli articoli del carrello.

        if ($items->isEmpty()) {
            // Se il carrello è già vuoto:

            return redirect()->route('cart.index')->with('error', 'Il carrello è già vuoto.');
        }

        $total = $items->sum(fn($i) => $i->car->price * $i->quantity);
        // Calcola il totale dell’ordine.

        // 👉 GENERA NUMERO ORDINE
        $orderNumber = 'ORD-' . strtoupper(uniqid());
        // Crea un numero ordine univoco.

        // 👉 CREA ORDINE NEL DATABASE
        $order = Order::create([
            'order_number' => $orderNumber,
            // Numero ordine.

            'user_id' => auth()->id(),
            // Utente che ha effettuato l’ordine.

            'session_id' => $sessionId,
            // Sessione associata.

            'total' => $total,
            // Totale dell’ordine.
        ]);

        // 👉 CREA GLI ARTICOLI DELL'ORDINE
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                // Associa l’articolo all’ordine.

                'car_id' => $item->car->id,
                // Auto acquistata.

                'price' => $item->car->price,
                // Prezzo dell’auto al momento dell’acquisto.
            ]);
        }

        // 👉 NOTIFICA AL VENDITORE
        foreach ($items as $item) {
            $vendor = $item->car->user;
            // Recupera il venditore dell’auto.

            Mail::to($vendor->email)
                ->send(new VendorOrderNotificationMail($order, $item->car));
            // Invia email al venditore.
        }

        // 👉 GENERA PDF FATTURA
        $invoiceName = 'invoice_' . time() . '.pdf';
        // Nome del file PDF.

        $pdf = Pdf::loadView('pdf.invoice', [
            'items' => $items,
            'total' => $total,
            'orderNumber' => $orderNumber,
        ]);
        // Genera il PDF usando la vista dedicata.

        $pdfPath = storage_path('app/invoices/' . $invoiceName);
        // Percorso di salvataggio.

        $pdf->save($pdfPath);
        // Salva il PDF su disco.

        $order->update([
            'invoice_name' => $invoiceName
        ]);
        // Salva il nome della fattura nell’ordine.

        // 👉 INVIA EMAIL ALL’ACQUIRENTE
        if (Auth::check()) {
            Mail::to(Auth::user()->email)
                ->send(new OrderConfirmationMail($items, $total, $invoiceName));
            // Invia email di conferma ordine.
        }

        // 👉 SVUOTA IL CARRELLO
        CartItem::where('session_id', $sessionId)->delete();
        // Rimuove tutti gli articoli del carrello.

        return view('checkout.success');
        // Mostra la pagina di successo.
    }
}
