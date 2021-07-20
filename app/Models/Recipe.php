<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ['recipe_name','image_path', 'description','avg_stars'];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
    public function steps()
    {
        return $this->hasMany(Step::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_recipe');
    }
}


