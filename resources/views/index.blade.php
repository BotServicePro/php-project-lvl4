@extends('layouts.app')

@section('title', 'Main page')

@section('content')
    <main class="container py-4">
        <div class="container">
            <div class="jumbotron">
                <h1 class="display-4">{{ __('interface.H1MainIndex') }}</h1>
                <p class="lead">{{ __('interface.LeadMainIndex') }}</p>
                <hr class="my-4">
                <a class="btn btn-primary btn-lg" href="https://hexlet.io" role="button">{{ __('interface.linkButtonMainIndex') }}</a>
            </div>
        </div>
    </main>
@endsection
