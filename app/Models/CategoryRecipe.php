<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryRecipe extends Model
{
    use HasFactory;

    public $table = 'category_recipe';

    protected $fillable = ['recipe_id', 'category_id'];
}
