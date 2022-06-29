<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All tags') }}
        </h2>
    </x-slot>

    <h1>{{$recipe->title}}</h1>
    <p>{{$recipe->description}}</p>
    <div>
        <img src="{{asset('storage/'.$recipe->image_path)}}">
    </div>
    <div>
        @foreach($recipe->tags as $tag)
        {{$tag->name}}
        @endforeach
    </div>
    @auth
    @if(Auth::user()->id === $recipe->user_id)
    @if(count($recipe->tags) == 0)
    <p>You haven't added any tags to this recipe yet! You can dod that <a href="">here</a>!</p>
    @endif
    <p><input type="button" value="Edit" onclick="editRecipe({{$recipe->id}})"></p>

    <form method="POST" action="{{action([App\Http\Controllers\RecipeController::class,'destroy'],$recipe->id)}}">
        @csrf @method('DELETE')<input type="submit" value="Delete">
    </form>
    @endif
    @endauth
</x-guest-layout>