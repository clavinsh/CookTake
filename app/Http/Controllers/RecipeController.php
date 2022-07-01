<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;

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

        $rules = array(
            'title' => 'required|string|min:3',
            'description' => 'string',
            'user_id' => 'exists:users,id',
            'thumbnail' => 'image|max:5000'
        );

        $this->validate($request, $rules);

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
        $recipe = Recipe::findOrFail($id); //->with('user')->with('tags');

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

        $recipe = Recipe::findOrFail($id);
        if (auth()->user()->cannot('update', $recipe)) {
            abort(403);
        }

        $tags = Tag::all();
        return view('recipe.edit', ['recipe' => $recipe, 'tags' => $tags]);
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
        $recipe = Recipe::findOrFail($id);
        if (auth()->user()->cannot('update', $recipe)) {
            abort(403);
        }

        $rules = array(
            'title' => 'required|string|min:3',
            'description' => 'string',
            'user_id' => 'exists:users,id',
            'thumbnail' => 'image|max:5000'
        );
        $this->validate($request, $rules);

        $recipe->title = $request->title;
        $recipe->description =  $request->description;
        if ($request->hasFile('thumbnail')) {
            if ($recipe->image_path != null) {
                Storage::disk('public')->delete($recipe->image_path);
            }
            $recipe->image_path = Storage::disk('public')->put('images', $request->file('thumbnail'));
        }
        if ($request->tags != null) {
            $recipe->tags()->detach($recipe->tags);
            $recipe->tags()->attach($request->tags);
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
        $recipe = Recipe::findOrFail($id);
        if (auth()->user()->cannot('update', $recipe)) {
            abort(403);
        }
        $recipe->tags()->detach();
        $recipe->delete();
        return redirect('home');
    }

    //shows top recipies for guests and suggested recipes for users
    public function home()
    {
        $suggestedRecipes = '';
        if (Auth::check()) {
            //recipes get ranked by how much they correspond with the users followed tags
            $suggestedRecipes = Recipe::orderByDesc('created_at')->orderByDesc('updated_at')->take(10)->with('user')->with('tags')->get();
        } else {

            $suggestedRecipes = Recipe::orderByDesc('created_at')->orderByDesc('updated_at')->take(10)->with('user')->with('tags')->get();
        }

        //dd($suggestedRecipes);
        return view('home', ['recipes' => $suggestedRecipes]);
    }

    public function showSearch()
    {
        $tags = Tag::all();
        return view('recipe.search', ['tags' => $tags]);
    }

    public function search(Request $request)
    {
        $rules = '';
        if ($request->date_from != null) {
            $date_from = $request->date_from;
            $rules = array(
                'name' => 'nullable|string|min:2|max:100|',
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date|after_or_equal:' . $date_from
            );
        } else {
            $rules = array(
                'name' => 'nullable|string|min:2|max:100|',
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date'
            );
        }

        $this->validate($request, $rules);

        $data = Recipe::select('recipes.*');


        if ($request->tags != null) {
            //matches against each tag, returns recipes with all queried tags
            foreach ($request->tags as $tag) {
                $data = $data->whereHas('tags', function ($query) use ($tag) {
                    return $query->where('id', $tag);
                });
            }
            //dd($data->get());
        }

        if ($request->date_from != null) {
            $data = $data->where('recipes.created_at', '>=', $request->date_from);
        }

        if ($request->date_to != null) {
            $data = $data->where('recipes.created_at', '<=', $request->date_to);
        }

        if ($request->title != null) {
            $data = $data->where('recipes.title', 'LIKE', '%' . $request->title . '%');
        }

        // if ($request->author != null) {
        //     $data = $data->where('recipes.created_at', '>=', $request->date_to);
        // }
        $data = $data->with('tags')->with('user')->get();
        return view('recipe.results', ['recipes' => $data]);
    }

    public function adminPage()
    {
        $recipes = Recipe::all();
        $tags = Tag::all();

        return view('admin_dashboard', ['recipes' => $recipes, 'tags' => $tags]);
    }
}
