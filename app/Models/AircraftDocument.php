<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AircraftDocument extends Model
{
    protected $fillable = ['aircraft_id', 'name', 'path', 'user_id'];

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
