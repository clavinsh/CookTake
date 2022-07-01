@extends('layouts.main')
@section('pagestyle')
    <style>
        .error {
            color: red;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <h1>Edit Recipe</h1>
        <form method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label" for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="{{ old('title', $recipe->title) }}" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="description">Description</label>
                <textarea class="form-control" name="description" id="description">{{ old('description', $recipe->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label" for="thumbnail"></label>
                <input class="form-control" type="file" name="thumbnail" id="thumbnail" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="tags">Tags</label>
                <select class="form-select" size="3" name="tags[]" multiple="multiple">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
            @if (count($errors) > 0)
                <div class="form-text">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="error">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <input class="btn btn-light" type="submit" value="Submit">
        </form>
    </div>
@endsection
