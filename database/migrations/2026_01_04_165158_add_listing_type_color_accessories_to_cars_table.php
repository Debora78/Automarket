<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            // tipo di annuncio: nuova, usata, noleggio
            $table->enum('listing_type', ['sale_new', 'sale_used', 'rental'])->default('sale_used');

            // colore esterno dell'auto
            $table->string('color')->nullable();

            // accessori come JSON (array)
            $table->json('accessories')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['listing_type', 'color', 'accessories']);
        });
    }
};
