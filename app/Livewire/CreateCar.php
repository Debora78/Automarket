<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\Image;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image as ImageProcessor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CreateCar extends Component

{

    use WithFileUploads;
    public $images = [];
    public $title;
    public $description;
    public $price;
    public $category_id;
    public $brand;
    public $year;
    public $km;
    public $listing_type = 'sale_used'; // default auto usata

    public $color;
    public $selected_accessories = []; // array di accessori selezionati

    public function render()
    {
        return view('livewire.create-car', [
            'categories' => Category::all(),
        ]);
    }

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
            'accessories' => $this->selected_accessories, // grazie al cast array->json in Car.php
        ]);

        // CICLO SU OGNI IMMAGINE CARICATA
        foreach ($this->images as $image) {

            // CREA UN NOME FILE UNICO
            $filename = uniqid() . '.jpg';

            /*
        |--------------------------------------------------------------------------
        | 1. CREA L'IMMAGINE PRINCIPALE OTTIMIZZATA
        |--------------------------------------------------------------------------
        | - Ridimensiona max 1920px mantenendo proporzioni
        | - Evita di ingrandire immagini piccole (upsize)
        | - Converte in JPG qualità 80%
        */
            $original = ImageProcessor::make($image->getRealPath());

            // Resize
            $original->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Watermark (insert modifica l'immagine originale)
            $original->insert(public_path('img/watermark.png'), 'bottom-right', 20, 20);

            // Compressione JPG (encode coverte e comprime)
            $original->encode('jpg', 80);





            // SALVA L'IMMAGINE PRINCIPALE NELLO STORAGE
            Storage::put('public/cars/' . $filename, $original->stream());

            /*
        |--------------------------------------------------------------------------
        | 2. CREA LA THUMBNAIL (VERSIONE LEGGERA)
        |--------------------------------------------------------------------------
        | - Ridimensiona max 400px
        | - Mantiene proporzioni
        | - Qualità 75%
        */
            $thumb = ImageProcessor::make($image->getRealPath())
                ->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode('jpg', 75);

            // SALVA LA THUMBNAIL
            Storage::put('public/cars/thumb_' . $filename, $thumb->stream());

            /*
        |--------------------------------------------------------------------------
        | 3. SALVA I PERCORSI NEL DATABASE
        |--------------------------------------------------------------------------
        | - path = immagine principale
        | - thumbnail = versione ridotta
        | - car_id = collegamento all'annuncio
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
