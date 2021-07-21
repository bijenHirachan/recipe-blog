<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Step;
use PDF;

class DownloadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('download.index', [
            'recipes'=> Recipe::all()
        ]);
    }

       /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('download.show',[
            'recipe' => Recipe::find($id),
            'ingredients'=> Ingredient::where('recipe_id', $id)->get(),
            'steps' => Step::where('recipe_id', $id)
                            ->orderBy('order','ASC')
                            ->get()
        ]);
    }

    public function downloadPdf($id)
    {
        $recipe = Recipe::find($id);
        $ingredients = Ingredient::where('recipe_id', $id)->get();
        $steps = Step::where('recipe_id',$id)->orderBy('order','ASC')->get();
        $pdf = PDF::loadView('download.show', compact('recipe','ingredients','steps'))->setOptions(['defaultFont' => 'sans']);

        return $pdf->download('recipe-'.$recipe->recipe_name.'.pdf');
    }


}
