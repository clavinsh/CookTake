@extends('layouts.main')
@section('pagestyle')
    <style>
        a {
            color: inherit;
            text-decoration: none;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-7">
                <h1 class="pb-0 mb-0">{{ $recipe->title }}</h1>
                <small class="text-muted">{{ $recipe->user->display_name }}
                    /{{ $recipe->user->username }} Last updated:
                    {{ $recipe->updated_at }} Created: {{ $recipe->created_at }}
                </small>
                <div class="pt-2">
                    @foreach ($recipe->tags as $tag)
                        <a href="{{ route('tagrecipes', $tag->id) }}"
                            class="btn btn-secondary btn-sm">{{ $tag->name }}</a>
                    @endforeach
                </div>
                <p class="pt-3">{{ $recipe->description }}</p>
            </div>
            <div class="col-5">
                <div>
                    <img src="{{ asset('storage/' . $recipe->image_path) }}" class="img-fluid">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                {{-- @auth
                    @if (Auth::user()->id === $recipe->user_id)
                        @if (count($recipe->tags) == 0)
                            <p>You haven't added any tags to this recipe yet! You can dod that <a href="">here</a>!</p>
                        @endif
                        <p><input type="button" value="Edit" onclick="editRecipe({{ $recipe->id }})"></p>

                        <form method="POST"
                            action="{{ action([App\Http\Controllers\RecipeController::class, 'destroy'], $recipe->id) }}">
                            @csrf @method('DELETE')<input type="submit" value="Delete">
                        </form>
                    @endif
                @endauth --}}
                @can('update', $recipe)
                    <a class="btn btn-light" href="{{ route('recipeedit', $recipe->id) }}">Edit</a>
                @endcan
                @can('delete', $recipe)
                    <form method="POST"
                        action="{{ action([App\Http\Controllers\RecipeController::class, 'destroy'], $recipe->id) }}">
                        @csrf @method('DELETE')<input type="submit" value="Delete">
                    </form>
                @endcan

            </div>
        </div>
    </div>
@endsection

{{-- <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('All tags') }}
    </h2>
</x-slot> --}}
