@extends('layouts.app')

@section('title', __('interface.login') )

@section('content')
<div class="card">
    <div class="card-header">{{ __('interface.login') }}</div>
    <div class="card-body align-content-center ">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-end">{{ __('Email') }}</label>
                <div class="col-md-6 mb-3">
                    <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus />
                </div>
            </div>

            <div class="form-group row mb-2">
                <label for="password" class="col-md-4 col-form-label text-end">{{ __('interface.password') }}</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control " name="password" required="" autocomplete="current-password">
                </div>
            </div>

            <div class="form-group row mb-3">
                <div class="col-md-6 offset-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">{{ __('interface.rememberMe') }}</label>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">{{ __('interface.authLogin') }}</button>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">{{ __('interface.forgotPassword') }}</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
