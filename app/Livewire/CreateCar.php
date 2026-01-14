<?php
// Apertura del file PHP.

/**
 * Questo componente Livewire gestisce la creazione di un nuovo annuncio auto.
 *
 * Si occupa di:
 * - Validare i dati inseriti dall’utente
 * - Salvare l’annuncio nel database
 * - Gestire l’upload delle immagini tramite WithFileUploads
 * - Processare le immagini con Intervention Image (resize, watermark, compressione)
 * - Salvare sia l’immagine principale che la thumbnail
 * - Collegare le immagini all’auto tramite il modello Image
 * - Applicare il layout principale dell’app tramite l’attributo #[Layout]
 *
 * È uno dei componenti più avanzati del progetto, integrando Livewire,
 * upload multipli, manipolazione immagini e salvataggio strutturato.
 */

namespace App\Livewire;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder; // Encoder JPG.
use Livewire\WithFileUploads; // Trait che abilita l’upload dei file.
use Livewire\Component;      // Classe base per i componenti Livewire.
use Illuminate\Support\Facades\Storage; // Facade per salvare file nello storage.
use Intervention\Image\ImageManager; // Classe principale per manipolare immagini.
use Livewire\Attributes\Layout; // Attributo per definire il layout in Livewire 3.
use App\Models\Car;          // Modello Car, necessario per creare il nuovo annuncio.
use Illuminate\Support\Facades\Auth;    // Facade per recuperare l’utente autenticato.
use App\Models\Image;        // Modello Image, usato per salvare i percorsi delle immagini.
use App\Models\Category;     // Modello Category, usato per popolare il select delle categorie.

// Usa il layout principale dell'applicazione
#[Layout('components.layout')]

class CreateCar extends Component
{
    use WithFileUploads; // Abilita l’upload multiplo delle immagini.

    // ----------------------------------------------------------------------
    // PROPRIETÀ PUBBLICHE (campi del form)
    // ----------------------------------------------------------------------

    public $images = []; // Array di immagini caricate dall’utente.

    public $title;
    public $description;
    public $price;
    public $category_id;
    public $brand;
    public $year;
    public $km;

    public $listing_type = 'sale_used'; // Tipo annuncio predefinito.

    public $color;
    public $selected_accessories = []; // Accessori selezionati (JSON).

    // ----------------------------------------------------------------------
    // MOUNT: eseguito alla creazione del componente
    // ----------------------------------------------------------------------
    public function mount()
    {
        if (!auth()->check()) {
            // Se l’utente non è autenticato, reindirizza al login.
            return redirect()->route('login');
        }
    }

    // ----------------------------------------------------------------------
    // RENDER: restituisce la vista del form di creazione
    // ----------------------------------------------------------------------
    public function render()
    {
        return view('livewire.create-car', [
            'categories' => Category::all(), // Passa tutte le categorie alla vista.
        ]);
    }

    // ----------------------------------------------------------------------
    // STORE: salva l’annuncio e processa le immagini
    // ----------------------------------------------------------------------
    public function store()
    {
        // VALIDAZIONE DEI DATI INSERITI DALL'UTENTE
        $this->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:10',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|max:2048', // ogni immagine max 2MB
            'brand' => 'required|min:2',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'km' => 'required|integer|min:0',
            'listing_type' => 'required|in:sale_new,sale_used,rental',
            'color' => 'nullable|string|max:50',
            'selected_accessories' => 'nullable|array',
            'selected_accessories.*' => 'string|max:100',
        ]);

        // CREA L'AUTO E SALVA L'ID PER COLLEGARE LE IMMAGINI
        $car = Car::create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'user_id' => Auth::id(),
            'brand' => $this->brand,
            'year' => $this->year,
            'km' => $this->km,
            'listing_type' => $this->listing_type,
            'color' => $this->color,
            'accessories' => $this->selected_accessories, // JSON
        ]);

        // Inizializza ImageManager usando GD (compatibile con PHP 8.3)
        $manager = new ImageManager(new Driver());



        foreach ($this->images as $image) {

            // Nome file unico
            $filename = uniqid() . '.jpg';

            /*
            |--------------------------------------------------------------------------
            | 1. IMMAGINE PRINCIPALE
            |--------------------------------------------------------------------------
            */
            $watermark = public_path('img/watermark.png');

            $original = $manager->read($image->getRealPath())
                ->scaleDown(1920);

            // Applica il watermark solo se esiste
            if (file_exists($watermark)) {
                $original->place($watermark, 'bottom-right', 20, 20);
            }

            $original = $original->encode(new JpegEncoder(quality: 80));

            Storage::put('public/cars/' . $filename, $original->toString());
            /*
            |--------------------------------------------------------------------------
            | 2. THUMBNAIL (Miniatura)
            |--------------------------------------------------------------------------
            | La thumbnail è una versione ridotta dell’immagine principale.
            | Serve per:
            | - velocizzare il caricamento delle pagine (liste annunci, ricerche)
            | - ridurre il peso complessivo del sito
            | - migliorare la UX mostrando immagini leggere nelle anteprime
            |
            | L’immagine viene ridimensionata a max 400px mantenendo le proporzioni
            | e compressa per ottenere un file molto più leggero rispetto all’originale.
            | La versione grande viene usata solo nella pagina del singolo annuncio.
            */
            $thumb = $manager->read($image->getRealPath())
                ->scaleDown(400)
                ->encode(new JpegEncoder(quality: 75));

            Storage::put('public/cars/thumb_' . $filename, $thumb->toString());

            /*
            |--------------------------------------------------------------------------
            | 3. SALVATAGGIO NEL DATABASE
            |--------------------------------------------------------------------------
            */
            Image::create([
                'path' => 'cars/' . $filename,
                'thumbnail' => 'cars/thumb_' . $filename,
                'car_id' => $car->id,
            ]);
        }

        // MESSAGGIO DI SUCCESSO
        session()->flash('success', 'Annuncio creato con successo!');

        // RESETTA IL FORM
        $this->reset(); // Resetta il form
    }
}
