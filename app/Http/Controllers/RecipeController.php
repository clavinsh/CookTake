<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view('recipe.new', ['tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $recipe = new Recipe();
        $recipe->title = $request->title;
        $recipe->description = $request->description;
        $recipe->image_path = $request->image_path;
        $recipe->user_id = Auth::user()->id;

        if ($request->hasFile('thumbnail')) {
            $imageFile = $request->file('thumbnail');
            $filePath = Storage::disk('public')->put('images', $imageFile);
            $recipe->image_path = $filePath;
        }

        // foreach ($request->tags as $tag) {
        //     $recipe->tags()-
        // }


        //dd(asset('storage/' . $filePath));


        $recipe->save();
        $recipe->tags()->attach($request->tags);
        return redirect('recipe/' . $recipe->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipe = Recipe::where('id', '=', $id)->first();
        return view('recipe.recipe', ['recipe' => $recipe]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recipe = Recipe::find($id);
        return view('recipe.edit', compact('recipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $recipe = Recipe::find($id);
        $recipe->title = $request->title;
        $recipe->description =  $request->description;
        if ($request->hasFile('thumbnail')) {
            //delete old
            //dd($request->file('thumbnail'));
            Storage::disk('public')->delete($recipe->image_path);
            //put new
            $recipe->image_path = Storage::disk('public')->put('images', $request->file('thumbnail'));
        }
        $recipe->save();
        return redirect('recipe/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        Recipe::findOrFail($id)->delete();
        //return home view (?)
    }

    //main view of the app
    public function home()
    {
        $suggestedRecipes = Recipe::orderByDesc('created_at')->orderByDesc('updated_at')->take(10)->with('user')->get();

        //dd($suggestedRecipes);
        return view('home', ['suggestedRecipes' => $suggestedRecipes]);
    }
}
