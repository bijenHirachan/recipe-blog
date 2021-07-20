<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Recipe;
use App\Models\CategoryRecipe;


class CategoryComponent extends Component
{

    public $name;
    public $selectedRecipe;
    // public $selectedRecipeCategories = [];
    public $recipeId;
    public $selectedCategories = [];
    public $selectedCatIds = [];

    public function addCategory()
    {
        $this->validate([
            'name'=>'required|unique:categories,category'
        ]);

        Category::create([
            'category'=>$this->name
        ]);

        $this->reset();
    }


    public function deleteCategory($id)
    {
        Category::find($id)->delete();
    }

    public function selectRecipe($id)
    {
        $this->recipeId = $id;
        $this->selectedRecipe = Recipe::find($id);
        // $this->selectedRecipeCategories = Categories::find($id)->
        
    }

    public function addToList($id)
    {
        $category = Category::find($id)->category;
        array_push($this->selectedCategories, $category);
        array_push($this->selectedCatIds, $id);
    }

    public function removeFromList($key)
    {
        unset($this->selectedCategories[$key]);
        unset($this->selectedCatIds[$key]);
    }


    public function addCategoriesToRecipe()
    {
        if(count($this->selectedCategories) > 0 && $this->recipeId){
            foreach($this->selectedCatIds as $id)
            {
                CategoryRecipe::create([
                    'recipe_id'=>$this->recipeId,
                    'category_id'=>$id
                ]);
            }
            session()->flash('success','Categorieën toegevoegd aan het recept.');

        }
        else{
            session()->flash('failure','Recept en categorieën moeten worden geselecteerd.');
        }

        $this->selectedCategories = [];
        $this->selectedCatIds = [];
        $this->reset();
    }

    public function render()
    {
        return view('livewire.category-component',[
            'categories'=>Category::all(),
            'recipes'=>Recipe::all()
        ]);
    }
}
