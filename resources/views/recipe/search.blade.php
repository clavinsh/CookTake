@extends('layouts.main')
@section('pagestyle')
    <style>
        .error {
            color: red;
        }
    </style>
@endsection
@section('header')
    <h1>Search recipes by:</h1>
@endsection
@section('content')
    <div class="container">
        <form method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="tags">Tags</label>
                <select class="form-select" size="3" name="tags[]" multiple="multiple">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>

            <p>
                <a class="btn btn-light" data-bs-toggle="collapse" href="#collapseExample" role="button"
                    aria-expanded="false" aria-controls="collapseExample">
                    Advanced
                </a>
            </p>
            <div class="collapse" id="collapseExample">
                <div class="card card-body">
                    <div class="row">
                        <div class="col">
                            <label for="date_from" class="form-label">Date from</label>
                            <input type="date" class="form-control" name="date_from" id="date_from">
                        </div>
                        <div class="col">
                            <label for="date_to" class="form-label">Date to</label>
                            <input type="date" class="form-control" name="date_to" id="date_to">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label" for="title">Title</label>
                            <input class="form-control" type="text" name="title" id="title" class="form-control" />

                        </div>
                    </div>
                </div>
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
            <input class="btn btn-light" type="submit" value="Search">
        </form>
    </div>
@endsection
