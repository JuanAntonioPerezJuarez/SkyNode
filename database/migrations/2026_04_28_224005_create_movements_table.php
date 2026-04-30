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
        Schema::create('movements', function (Blueprint $table) {
        $table->id();
        $table->foreignId('part_id')->constrained()->onDelete('cascade');
        $table->string('aircraft_registration'); // Matrícula (Ej: XB-RJS)
        $table->integer('quantity');             // Cantidad retirada
        $table->foreignId('user_id')->constrained(); // Quién autorizó
        $table->text('notes')->nullable();       // Por si quieren anotar "Falla en alternador"
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
