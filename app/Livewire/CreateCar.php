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
// Namespace dedicato ai componenti Livewire.

use App\Models\Car;
// Modello Car, necessario per creare il nuovo annuncio.

use App\Models\Image;
// Modello Image, usato per salvare i percorsi delle immagini.

use App\Models\Category;
// Modello Category, usato per popolare il select delle categorie.

use Livewire\Component;
// Classe base per i componenti Livewire.

use Livewire\WithFileUploads;
// Trait che abilita l’upload dei file in Livewire.

use Livewire\Attributes\Layout;
// Attributo per definire il layout in Livewire 3.

use Intervention\Image\ImageManager;
// Classe principale per manipolare immagini.

use Intervention\Image\Encoders\JpegEncoder;
// Encoder per convertire e comprimere immagini in JPG.

use Illuminate\Support\Facades\Storage;
// Facade per salvare file nello storage Laravel.

use Illuminate\Support\Facades\Auth;
// Facade per recuperare l’utente autenticato.

// Usa il layout principale dell'applicazione
#[Layout('layouts.layout')]

class CreateCar extends Component
// Componente Livewire che gestisce la creazione di un nuovo annuncio auto.
{
    use WithFileUploads;
    // Abilita l’upload multiplo delle immagini.

    public $images = [];
    // Array di immagini caricate dall’utente.

    public $title;
    public $description;
    public $price;
    public $category_id;
    public $brand;
    public $year;
    public $km;

    public $listing_type = 'sale_used';
    // Tipo annuncio predefinito: auto usata.

    public $color;
    public $selected_accessories = [];
    // Accessori selezionati (array salvato come JSON).

    public function mount()
    // Metodo eseguito alla creazione del componente.
    {
        if (!auth()->check()) {
            // Se l’utente non è autenticato, reindirizza al login.

            return redirect()->route('login');
        }
    }

    public function render()
    // Restituisce la vista del form di creazione.
    {
        return view('livewire.create-car', [
            'categories' => Category::all(),
            // Passa tutte le categorie alla vista.
        ]);
    }

    public function store()
    // Salva l’annuncio e processa le immagini.
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
            'accessories' => $this->selected_accessories,
            // Salvato come JSON grazie al cast nel modello Car.
        ]);

        // Inizializza ImageManager usando GD (compatibile con PHP 8.3)
        $manager = new ImageManager('gd');

        foreach ($this->images as $image) {

            // Nome file unico
            $filename = uniqid() . '.jpg';

            /*
            |--------------------------------------------------------------------------
            | 1. IMMAGINE PRINCIPALE
            |--------------------------------------------------------------------------
            | - Ridimensiona mantenendo proporzioni
            | - Evita distorsioni
            | - Applica watermark
            | - Converte in JPG qualità 80
            */

            $original = $manager->read($image->getRealPath())
                ->scaleDown(1920) // riduce mantenendo proporzioni
                ->place(public_path('img/watermark.png'), 'bottom-right', 20, 20)
                ->encode(new JpegEncoder(quality: 80));

            // Salva l'immagine principale
            Storage::put('public/cars/' . $filename, $original->toString());

            /*
            |--------------------------------------------------------------------------
            | 2. THUMBNAIL
            |--------------------------------------------------------------------------
            | - Ridimensiona max 400px
            | - Mantiene proporzioni
            | - Qualità 75
            */

            $thumb = $manager->read($image->getRealPath())
                ->scaleDown(400)
                ->encode(new JpegEncoder(quality: 75));

            // Salva la thumbnail
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

        // REINDIRIZZAMENTO ALLA HOMEPAGE
        return redirect()->route('homepage');
    }
}
