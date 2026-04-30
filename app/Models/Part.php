<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $fillable = ['part_number', 'name', 'brand', 'stock', 'category', 'tags', 'image'];

    public function movements()
{
    return $this->hasMany(Movement::class);
}
}

