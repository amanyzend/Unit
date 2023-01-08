<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'modifier',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_unit');
    }
}
