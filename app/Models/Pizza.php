<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;

    protected $table = 'pizzas';

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'image',
    ];

    // Relazione molti a molti con Ingredient
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredient_pizza');
    }

    // Relazione uno a uno con Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
