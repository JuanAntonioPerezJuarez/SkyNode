<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('aircraft', function (Blueprint $table) {
        $table->id();
        $table->string('registration')->unique(); // La matrícula (XB-RJS)
        $table->string('model');                 // Ejemplo: Cessna 172
        $table->string('serial_number')->nullable(); // Número de serie
        $table->integer('year')->nullable();      // Año de fabricación
        $table->text('notes')->nullable();       // "Propiedad de Don Juan", etc.
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aircraft');
    }
};
