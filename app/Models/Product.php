<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price', 'entry_date','category_id', 'quantity',   'status', 'image', 'additional_images','description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function colors()
    {
        return $this->belongsToMany(Color::class, 'color_product');
    }
    public function reviews()  {
        return $this->hasMany(Review::class);
    }
}
