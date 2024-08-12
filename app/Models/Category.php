<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Size;
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
 
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function sizes()
    {
        return $this->hasMany(Size::class, 'category_id');
    }
}
