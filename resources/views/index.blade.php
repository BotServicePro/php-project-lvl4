@extends('layouts.app')

@section('title', 'Main page')

@section('content')
    <h1>Main page</h1>
    @if (Auth::check())
        {{ Auth::user()->name }}
    @endif
@endsection
