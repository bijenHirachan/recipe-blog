<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Step;
use App\Models\CategoryRecipe;
use App\Models\Comment;


class ShowRecipes extends Component
{
    public $modalRecipe;
    public $modalPhoto;
    public $modalDescription;
    public $showModal = false;

    public $modalRecipeForCategories=[];
   
    public $ingredients = [];
    public $steps = [];

    //search
    public $search;

    protected $listeners = ['commentUpdated'=>'render'];
    
    public function showModal($id)
    {
        $currentRecipe = Recipe::find($id);
        $this->modalRecipeForCategories = Recipe::find($id)->categories;
        $this->modalRecipe = $currentRecipe->recipe_name;
        $this->modalPhoto = $currentRecipe->image_path;
        $this->modalDescription = $currentRecipe->description;
        $this->ingredients = Ingredient::where('recipe_id',$id)->get();
        $this->steps = Step::where('recipe_id',$id)->orderBy('order','ASC')->get();
        
        $this->showModal = true;


    }

    public function getRecipes()
    {
        if($this->search == '' && $this->search == null){
            return Recipe::all();
        }else{
            return Recipe::where('recipe_name','like',"%$this->search%")
                        ->orWhere('description','like',"%$this->search%")
                        ->get();
        }
    }



    public function avgStarsForEachRecipe()
    {
        foreach(Recipe::all() as $recipe)
        {
            $this->avgStarsList[$recipe->id] = round($this->calculateAvgStars($recipe->id));
        }
        return $this->avgStarsList;
    }

    

    public function render()
    {
        return view('livewire.show-recipes',[
            'recipes'=>$this->getRecipes(),
        ]);
    }

    
}
