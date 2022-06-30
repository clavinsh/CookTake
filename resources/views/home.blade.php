@extends('layouts.main')
@section('header')
    @auth
        <h1>Suggested for you</h1>
    @else
        <h1>Our top recipes</h1>
    @endauth
@endsection
@include('components.recipe-results')
