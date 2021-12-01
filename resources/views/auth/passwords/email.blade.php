@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">{{ __('interface.password') }}</div>

    <div class="card-body">

        <form method="POST" action="https://php-l4-task-manager.herokuapp.com/password/email">
            @csrf
            <div class="form-group row mb-3">
                <label for="email" class="col-md-4 col-form-label text-end">{{ __('E-Mail') }}</label>
                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">{{ __('interface.passwordReset2') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
