@extends('layouts.main')
@section('pagestyle')
@endsection
@section('content')
    <div class="container">
        @foreach ($suggestedRecipes as $recipe)
            <div class="row justify-content-md-center">
                <div class="card mb-3" style="max-width: 1300px;">
                    <div class="row g-0">
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $recipe->title }}</h5>
                                <p class="card-text">{{ $recipe->description }}</p>
                                <p class="card-text">
                                    <small class="text-muted">Last updated 3 mins ago</small>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="pe-3">
                                @if ($recipe->image_path != null)
                                    <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="Recipe thumbnail"
                                        class="img-fluid rounded-end float-end" width="200px" />
                                @else
                                    <img src="{{ asset('placeholder.png') }}" alt="Recipe thumbnail"
                                        class="img-fluid rounded-end float-end" width="200px" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
