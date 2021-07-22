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
    public $recipeId;
    public $selectedCategories = [];
    public $selectedCatIds = [];

    protected $listeners = ['catRecipeUpdated'=>'render'];

    public function addCategory()
    {
        $this->validate([
            'name'=>'required|unique:categories,category'
        ]);

        Category::create([
            'category'=>$this->name
        ]);
        $this->emit('catRecipeUpdated');

        $this->reset();
    }


    public function deleteCategory($id)
    {
        Category::find($id)->delete();
        $this->emit('catRecipeUpdated');
    }

    public function selectRecipe($id)
    {
        $this->recipeId = $id;
        $this->selectedRecipe = Recipe::find($id);
       
        
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
            if(!$this->checkCategories()[0])
            {
                $index = array_search($this->checkCategories()[1], $this->selectedCatIds);
                session()->flash('catExist', $this->selectedCategories[$index].' already exist for this recipe!');
                return;
            }

            foreach($this->selectedCatIds as $id)
            {
                CategoryRecipe::create([
                    'recipe_id'=>$this->recipeId,
                    'category_id'=>$id
                ]);
            }
            $this->emit('catRecipeUpdated');

            session()->flash('success','Categorieën toegevoegd aan het recept.');

        }
        else{
            session()->flash('failure','Recept en categorieën moeten worden geselecteerd.');
        }

        $this->selectedCategories = [];
        $this->selectedCatIds = [];
        // $this->reset();
    }


    public function deleteCategoryFromRecipe($recipeId, $catId)
    {
        CategoryRecipe::where('recipe_id',$recipeId)
            ->where('category_id', $catId)
            ->delete();

        $this->emit('catRecipeUpdated');
    }

    public function checkCategories()
    {
        $categories = CategoryRecipe::where('recipe_id', $this->recipeId)->get();
        
        foreach($categories as $category)
        {
            foreach($this->selectedCatIds as $catId)
            {
                // dd($catId, $category->category_id);
                if($category->category_id == $catId)
                {
                    return [false,$catId];
                }
            }
        }
        return [true];
    }

    public function render()
    {
        return view('livewire.category-component',[
            'categories'=>Category::all(),
            'recipes'=>Recipe::all()
        ]);
    }
}
