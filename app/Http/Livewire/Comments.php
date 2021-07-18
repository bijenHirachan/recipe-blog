<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comment;

class Comments extends Component
{
    public $recipeId;
    public $comment;
    public $starSelected;


    public function selectStar($item)
    {
       if($item == 1)
       {
            $this->starSelected = 1;
       }else if($item == 2)
       {
            $this->starSelected = 2;
       }else if($item == 3)
       {
            $this->starSelected = 3;
       }else if($item == 4)
       {
            $this->starSelected = 4;
       }else if($item == 5)
       {
            $this->starSelected = 5;
       }
    }

    public function addComment()
    {
        $this->validate([
            'comment'=>'required'
        ]);
        
        Comment::create([
            'user_id'=>auth()->user()->id,
            'recipe_id'=>$this->recipeId,
            'stars'=>$this->starSelected == null || $this->starSelected == '' ? 0 : $this->starSelected,
            'comment_body'=>$this->comment
        ]);
        
        $this->reset();
        $this->emitUp('commentAdded');
    }

    public function render()
    {
        return view('livewire.comments',[
            'comments'=>Comment::where('recipe_id',$this->recipeId)->latest()->get()
        ]);
    }
}
