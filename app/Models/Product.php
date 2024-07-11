<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price', 'entry_date','category_id', 'quantity',   'status', 'image', 'additional_images','type'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'type');
    }
}
