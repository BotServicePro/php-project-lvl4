@extends('layouts.auth')

@section('title', __('interface.login') )

@section('content')
    <div class="card-header">{{ __('interface.login') }}</div>
    <br>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label>{{ __('Email') }}</label>
            <input id="email" class="block mt-1 w-full rounded" type="email" name="email" :value="old('email')" required autofocus />
        </div>
        <div class="mt-4">
            <label>{{ __('interface.password') }}</label>
            <input id="password" class="block mt-1 w-full rounded"
                   type="password"
                   name="password"
                   required autocomplete="current-password" />
        </div>
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('interface.rememberMe') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('interface.forgotPassword') }}
                </a>
            @endif
            <button class="ml-3 btn btn-primary">
                {{ __('interface.authLogin') }}
            </button>
        </div>
    </form>
@endsection
