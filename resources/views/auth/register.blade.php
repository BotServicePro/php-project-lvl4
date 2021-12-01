@extends('layouts.app')

@section('title', __('interface.register') )

@section('content')
<div class="card">
    <div class="card-header">{{ __('interface.register') }}</div>

    <div class="card-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group row mb-3">
                <label for="name" class="col-md-4 col-form-label text-end">{{ __('interface.name') }}</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control " name="name" :value="old('name')" autocomplete="name" required autofocus />
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="email" class="col-md-4 col-form-label text-end">{{ __('Email') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" autocomplete="email" :value="old('email')" required />
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="password" class="col-md-4 col-form-label text-end">{{ __('interface.password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control " name="password" required autocomplete="new-password" />
                </div>
            </div>

            <div class="form-group row mb-3">
                <label for="password-confirm" class="col-md-4 col-form-label text-end">{{ __('interface.confirmPassword') }}</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" autocomplete="new-password" name="password_confirmation" required />
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">{{ __('interface.registerTo') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection


