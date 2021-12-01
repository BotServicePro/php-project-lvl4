@extends('layouts.app')

@section('title', __('interface.register') )

@section('content')
    <div class="card-header">{{ __('interface.register') }}</div>
    <br>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label for="name">{{ __('interface.name') }}</label>
            <input id="name" class="block mt-1 w-full rounded" type="text" name="name" :value="old('name')" required autofocus />
        </div>
        <div class="mt-4">
            <label>{{ __('Email') }}</label>
            <input id="email" class="block mt-1 w-full rounded" type="email" name="email" :value="old('email')" required />
        </div>
        <div class="mt-4">
            <label>{{ __('interface.password') }}</label>
            <input id="password" class="block mt-1 w-full rounded"
                   type="password"
                   name="password"
                   required autocomplete="new-password" />
        </div>

        <div class="mt-4">
            <label for="password_confirmation">{{ __('interface.confirmPassword') }}</label>
            <input id="password_confirmation" class="block mt-1 w-full rounded"
                   type="password"
                   name="password_confirmation" required />
        </div>
        <div class="flex items-center justify-end mt-4 rounded">
            <button class="ml-3 btn btn-primary">
                {{ __('interface.registerTo') }}
            </button>
        </div>
    </form>
@endsection


