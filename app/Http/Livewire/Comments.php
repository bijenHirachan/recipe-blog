<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comment;
use App\Models\Recipe;

class Comments extends Component
{
    public $recipeId;
    public $comment;
    public $starSelected;

    public $editCommentId;

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
        
        $this->updateAvgStars();

        $this->emit('commentUpdated');
        $this->comment = '';
        $this->starSelected = '';
    }


    public function updateAvgStars()
    {
        foreach(Recipe::all() as $recipe)
        {
            $sum = (int)Comment::where('recipe_id', $recipe->id)->sum('stars');
            $totalComments = (int)count(Comment::where('recipe_id', $recipe->id)->get());
            
            $avgStars = (int)round($totalComments != 0 ? $sum/$totalComments : 0);
 
            $recipe->update([
                'avg_stars'=> $avgStars
            ]);
 
     
        }
    }

    public function updateComment()
    {
        $this->validate([
            'comment'=>'required'
        ]);
        
        Comment::find($this->editCommentId)->update([
            'stars'=>$this->starSelected == null || $this->starSelected == '' ? 0 : $this->starSelected,
            'comment_body'=>$this->comment
        ]);
        
        $this->updateAvgStars();

        $this->emit('commentUpdated');
        $this->editCommentId = '';
        $this->comment = '';
        $this->starSelected = '';
    }

    public function editComment($id)
    {
    // dd($id);
        $this->editCommentId = $id;
        $currentComment = Comment::find($id);
        $this->comment = $currentComment->comment_body;
        $this->starSelected = $currentComment->stars;
    }

    public function deleteComment($id)
    {
        Comment::find($id)->delete();

        $this->updateAvgStars();

        $this->emit('commentUpdated');
    }

    public function render()
    {
        return view('livewire.comments',[
            'comments'=>Comment::where('recipe_id',$this->recipeId)->latest()->get()
        ]);
    }
}
