<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    // Esto es CRITICO. Si no están aquí, no se guardan.
    protected $fillable = [
    'registration', 
    'model', 
    'serial_number', 
    'image', // <--- ¡ASEGÚRATE DE QUE ESTO ESTÉ AQUÍ!
    'is_active'
    ];

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }

    public function documents()
    {
        return $this->hasMany(AircraftDocument::class);
    }
}