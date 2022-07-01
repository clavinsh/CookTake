@extends('layouts.main')
@section('header')
    <h1>Admin dashboard</h1>
@endsection
@section('content')
    <div class="container">
        <p>
            <a class="btn btn-light" data-bs-toggle="collapse" href="#recipes" role="button" aria-expanded="false"
                aria-controls="collapseExample">
                Manage recipes
            </a>
        </p>
        <div class="collapse" id="recipes">
            <div class="card card-body">
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Creation date</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        @foreach ($recipes as $recipe)
                            <tr>
                                <td>{{ $recipe->id }}</td>
                                <td><a href="{{ route('recipe', $recipe->id) }}">{{ $recipe->title }}</a></td>
                                <td>{{ $recipe->user->username }}</td>
                                <td>{{ $recipe->created_at }}</td>
                                <td>
                                    <div class="pb-3">
                                        <a class="btn btn-warning" href="{{ route('recipeedit', $recipe->id) }}">Edit</a>
                                    </div>
                                </td>
                                <td>
                                    <form method="POST"
                                        action="{{ action([App\Http\Controllers\RecipeController::class, 'destroy'], $recipe->id) }}">
                                        @csrf @method('DELETE')<input class="btn btn-danger" type="submit" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <p>
            <a class="btn btn-light" data-bs-toggle="collapse" href="#tags" role="button" aria-expanded="false"
                aria-controls="collapseExample">
                Manage tags
            </a>
        </p>
        <div class="collapse" id="tags">
            <div class="card card-body">
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Created at</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        @foreach ($tags as $tag)
                            <tr>
                                <td>{{ $tag->id }}</td>
                                <td>{{ $tag->name }}</td>
                                <td>{{ $tag->created_at }}</td>
                                <td>
                                    <form method="POST"
                                        action="{{ action([App\Http\Controllers\TagController::class, 'destroy'], $recipe->id) }}">
                                        @csrf @method('DELETE')<input class="btn btn-danger" type="submit" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>



    </div>
@endsection
