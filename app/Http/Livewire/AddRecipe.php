<?php

namespace App\Http\Livewire;
use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Step;

class AddRecipe extends Component
{
    use WithFileUploads;

    public $photo, $recipe, $description;
    public $ingredient, $quantity;
    public $order, $step;

    // for ingredients
    public $index = 1;
    public $inputs = [];

    public $addedIngredients=[];

    //for steps
    public $stepIndex = 1;
    public $stepInputs = [];

    public $addedSteps = [];

    public $modalId;
    public $modalPhoto; //for edit recipe

    public $recipeModal = false;
    
    public $addModal = false;

    

    //to add ingredients and steps
    public $recipeId;
    public $recipeName;

    public function add($index)
    {
        $index = $index + 1;
        $this->index = $index;
        array_push($this->inputs, $index);
    }

    public function addStep($stepIndex)
    {
        $stepIndex = $stepIndex + 1;
        $this->stepIndex = $stepIndex;
        array_push($this->stepInputs, $stepIndex);
    }

    public function cancelPhoto()
    {
        $this->photo = '';
    }

    
    public function delete($index)
    {
        unset($this->inputs[$index]);
    }

    public function deleteStep($stepIndex)
    {
        unset($this->stepInputs[$stepIndex]);
    }

    public function save(){
        // dd($this->photo->hashName());
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
            'recipe'=> 'required',
            'description'=> 'required',
     
        ]);

        $this->photo->store('photos','public');

        Recipe::create([
            'recipe_name'=>$this->recipe,
            'image_path'=>$this->photo->hashName(),
            'description'=>$this->description
        ]);
 
        $this->reset();
        $this->recipeModal = false;
    }


    public function editRecipe($id)
    {
        $currentRecipe = Recipe::find($id);
        $this->modalId = $id;
        $this->recipe = $currentRecipe->recipe_name;
        $this->modalPhoto = $currentRecipe->image_path;
        $this->description = $currentRecipe->description;
    
        $this->recipeModal = true;
    }


    public function updateRecipe()
    {
        $this->validate([
            'recipe'=> 'required',
            'description'=> 'required',
        ]);

        Recipe::find($this->modalId)->update([
            'recipe_name'=>$this->recipe,
            'description'=>$this->description,
        ]);

        $this->reset();
        $this->recipeModal = false;
    }

    public function deleteRecipe($id)
    {
        Recipe::find($id)->delete();
    }

    public function showRecipeModal(){
        $this->reset();
        $this->recipeModal = true;
    }

    public function addIngredientsAndSteps($id)
    {
        $this->reset();
        $this->inputs = [];
        $this->stepInputs = [];
        $this->recipeId = $id;
        $this->addModal = true;
        $this->recipeName = Recipe::find($id)->recipe_name;
        $this->addedIngredients = Ingredient::where('recipe_id', $this->recipeId)->get();
        $this->addedSteps = Step::where('recipe_id',$this->recipeId)->orderBy('order','ASC')->get();
    }

    public function saveIngredients()
    {
        $this->validate([
            'ingredient.0' => 'required',
            'quantity.0' => 'required',
            'ingredient.*' => 'required',
            'quantity.*' => 'required',
            
        ]);

        foreach($this->ingredient as $key=>$value){
            Ingredient::create([
                'recipe_id'=>$this->recipeId,
                'ingredient'=>$this->ingredient[$key],
                'quantity'=>$this->quantity[$key],
            ]);
        }

       

        $this->inputs = [];

        $this->reset();
        


    }

    public function saveSteps()
    {
        $this->validate([
            'order.0' => 'required',
            'step.0' => 'required',
            'order.*' => 'required',
            'step.*' => 'required',
        ]);

        foreach($this->step as $key=>$value){
            Step::create([
                'recipe_id'=>$this->recipeId,
                'order'=>$this->order[$key],
                'step'=>$this->step[$key]
            ]);
        }

        $this->stepInputs = [];

        $this->reset();


    }


    //delete added ingredients and steps

    public function deleteAddedIngredient($id)
    {
        Ingredient::find($id)->delete();
        $this->addedIngredients = Ingredient::where('recipe_id', $this->recipeId)->get();
    }

    public function deleteAddedStep($id)
    {
        Step::find($id)->delete();
        $this->addedSteps = Step::where('recipe_id',$this->recipeId)->orderBy('order','ASC')->get();
    }

    public function render()
    {
        return view('livewire.add-recipe',[
            'recipes'=>Recipe::all()
        ]);
    }
}
