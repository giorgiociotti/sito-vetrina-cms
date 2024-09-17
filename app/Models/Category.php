<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function pizzas()
    {
        return $this->hasMany(Pizza::class);
    }
}
