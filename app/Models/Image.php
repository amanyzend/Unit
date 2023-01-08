<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'description',
        'o_id',
        'o_type'
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'o_id')->where('o_type','=','user');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'o_id')->where('o_type','=','product');
    }
}
