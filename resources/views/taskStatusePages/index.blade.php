@extends('layouts.app')

@section('title', __('interface.statuses'))

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
        <h2>{{ __('interface.statuses') }}</h2>
        @if(Auth::check())
            <a href="{{ route('task_statuses.create') }}" class="btn btn-primary">{{ __('interface.createStatus') }}</a>
            <br>
        @endif
        <br>
        <table class="table table-bordered border-radius">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('interface.name') }}</th>
                <th>{{ __('interface.createDate') }}</th>
                @if(Auth::check())
                    <th>{{ __('interface.settings') }}</th>
                @endif
            </tr>
            </thead>

            <tbody>
            @foreach ($taskStatus as $status)
                <tr>
                    <td><b>{{ $status->id }}</b></td>
                    <td>{{ $status->name }}</td>
                    <td>{{ $status->created_at }}</td>
                    @if(Auth::check())
                        <td>
                            {{-- реализация через ссылку --}}
{{--                            <form action="{{ route('task_statuses.destroy', $status->id) }}" method="POST" style="display: inline;">--}}
{{--                                @csrf--}}
{{--                                @method('delete')--}}
{{--                                <a href="{{ route('task_statuses.destroy', $status->id) }}" class="text-danger" data-confirm="{{ __('interface.checkDelete') }}" data-method="delete" rel="nofollow">{{ __('interface.delete') }}</a>--}}
{{--                            </form>--}}
                            {{-- реализация через кнопку--}}
                            <form action="{{ route('task_statuses.destroy', $status->id) }}" method="POST" data-confirm="{{ __('interface.checkDelete') }}" rel="nofollow" style="display: inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="text-danger" rel="nofollow">{{ __('interface.delete') }}</button>
                            </form>

                            | <a href="{{ route('task_statuses.edit', ['task_status' => $status->id]) }}">{{ __('interface.edit') }}</a>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $taskStatus->links() }}
    </main>
@endsection
