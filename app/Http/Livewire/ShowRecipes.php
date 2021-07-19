<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Step;
use App\Models\CategoryRecipe;

class ShowRecipes extends Component
{
    public $modalRecipe;
    public $modalPhoto;
    public $modalDescription;
    public $showModal = false;

    // public $categories = [];
   
    public $ingredients = [];
    public $steps = [];


    protected $listeners = ['commentAdded'=>'$refresh'];

    public function showModal($id)
    {
        $currentRecipe = Recipe::find($id);
        $this->modalRecipe = $currentRecipe->recipe_name;
        $this->modalPhoto = $currentRecipe->image_path;
        $this->modalDescription = $currentRecipe->description;
        $this->ingredients = Ingredient::where('recipe_id',$id)->get();
        $this->steps = Step::where('recipe_id',$id)->orderBy('order','ASC')->get();
        // $this->categories = CategoryRecipe::where('recipe_id', $id)->get();
        
        $this->showModal = true;


    }

    public function render()
    {
        return view('livewire.show-recipes',[
            'recipes'=>Recipe::all()
        ]);
    }
}
