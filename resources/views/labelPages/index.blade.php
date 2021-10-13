@extends('layouts.app')

@section('title', __('interface.labelLink'))

@include('flash::message')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@section('content')
    <main class="container py-4">
        <h2>{{ __('interface.labels') }}</h2>
        <br>
        @if(Auth::check())
            <a href="{{ route('labels.create') }}" class="btn btn-primary">{{ __('interface.createLabel') }}</a>
        @endif
        <table class="table mt-2">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('interface.name') }}</th>
                <th>{{ __('interface.description') }}</th>
                <th>{{ __('interface.createDate') }}</th>
                @if(Auth::check())
                    <th>{{ __('interface.settings') }}</th>
                @endif
            </tr>
            </thead>

            <tbody>
            @foreach ($labels as $label)
                <tr>
                    <td>{{ $label['id'] }}</td>
                    <td>{{ $label['name'] }}</td>
                    <td>{{ $label['description'] }}</td>
                    <td>{{ $label['created_at'] }}</td>
                    @if(Auth::check())
                        <td>
                            <form action="{{ route('labels.destroy', $label['id']) }}" method="POST" data-confirm="Точно удалить?" rel="nofollow">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-outline-danger" data-confirm="Точно удалить?" rel="nofollow">{{ __('interface.delete') }}</button>
                            </form> |
                            <a href="/labels/{{ $label['id'] }}/edit">{{ __('interface.edit') }}</a></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $labels->links() }}
    </main>
@endsection
