<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $appends = [
        'total_quantity',
        'image_path',
    ];

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'product_unit')->withPivot('amount');
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'o_id')->where('o_type','=','product');;
    }

    public function getTotalQuantityAttribute()
    {
        $totalQty=0;
        
        foreach ($this->units as $unit) {
            
            $totalQty= $totalQty+ ($unit->modifier * $unit->pivot->amount);
        }
    
        return $totalQty;
        
    }

    public function getImagePathAttribute()
    {
        if ($this->image != null) {
            return $this->image->path;
        } else {
            return null; 
        }   
    }

}
