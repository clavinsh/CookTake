@extends('layouts.main')
@section('header')
    <h1>{{ __('messages.Recipes with the tag:') }} <strong>{{ $tag->name }}</strong></h1>
    @auth
        @if ($tag->users->contains('id', Auth::user()->id))
            <form method="POST" action="{{ action([App\Http\Controllers\TagController::class, 'unfollowTag'], $tag->id) }}">
                @csrf <input type="submit" class="btn btn-secondary" value="{{ __('messages.Unfollow') }}">
            </form>
        @else
            <form method="POST" action="{{ action([App\Http\Controllers\TagController::class, 'followTag'], $tag->id) }}">
                @csrf <input type="submit" class="btn btn-primary" value="{{ __('messages.Follow') }}">
            </form>
        @endif
    @endauth
@endsection
@include('components.recipe-results')
