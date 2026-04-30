<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('parts', function (Blueprint $table) {
        $table->id();
        $table->string('part_number')->unique(); // P/N
        $table->string('name');                  // Nombre de la parte
        $table->string('brand')->nullable();     // Marca/Fabricante
        $table->integer('stock')->default(0);    // Cantidad en almacén
        $table->string('category')->default('General'); // Motor, Bujías, etc.
        $table->text('tags')->nullable();        // Para poner "Cessna", "Piper", etc.
        $table->string('image')->nullable();     // Ruta de la foto
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
