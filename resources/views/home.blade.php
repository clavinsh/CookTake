@extends('layouts.main')
@section('header')
    @auth
        <h1>{{ __('messages.Suggested for you') }}</h1>
    @else
        <h1>{{ __('messages.Our top recipes') }}</h1>
    @endauth
@endsection
@include('components.recipe-results')
