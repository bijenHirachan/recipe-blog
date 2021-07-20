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

    public $avgStarsList = [  ];

    protected $listeners = ['commentAdded'=>'$refresh'];

    // public function mount()
    // {
    //     $this->avgStarsForEachRecipe();
    // }

    public function showModal($id)
    {
        $currentRecipe = Recipe::find($id);
        $this->calculateAvgStars($id);
        $this->modalRecipeForCategories = Recipe::find($id)->categories;
        $this->modalRecipe = $currentRecipe->recipe_name;
        $this->modalPhoto = $currentRecipe->image_path;
        $this->modalDescription = $currentRecipe->description;
        $this->ingredients = Ingredient::where('recipe_id',$id)->get();
        $this->steps = Step::where('recipe_id',$id)->orderBy('order','ASC')->get();
        
        $this->showModal = true;


    }

    public function calculateAvgStars($id)
    {
        $comments = Comment::where('recipe_id',$id)->get();
        $total = 0;
        foreach($comments as $comment)
        {
            $total = $total + $comment->stars ;
        }

        $averageStars = $total / count($comments);
        return $averageStars;


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
            'recipes'=>Recipe::all(),
            'avgStars'=>$this->avgStarsForEachRecipe()
        ]);
    }
}
