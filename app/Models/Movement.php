<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movement extends Model
{
    protected $fillable = [
    'part_id', 
    'aircraft_id', 
    'aircraft_registration', 
    'quantity', 
    'user_id', 
    'notes'
    ];

    public function part()
    {
        return $this->belongsTo(Part::class);
    }

    public function aircraft()
    {
        return $this->belongsTo(Aircraft::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}