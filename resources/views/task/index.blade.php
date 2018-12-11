@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center"> Daftar Task </h4>
                    <div class="list-group list-group-flush">
                        @if ($tasks->count() > 0)
                            @foreach ($tasks as $tasks)

                            <li class="list-group-item">
                                <div>
                                    <a href="{{ route('task.edit', $tasks->id) }}">
                                        {{ $tasks->name }}
                                    </a>
                                    <a href="{{ route('task.destroy', $tasks->id) }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('delete-form-{{ $tasks->id }}').submit();"
                                        class="float-right delete-todo">
                                        {{ __('Delete') }}
                                    </a>
                                </div>
                            </li>

                            <form id="delete-form-{{ $tasks->id }}" action="{{ route('task.destroy', $tasks->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('delete')
                            </form>
                            @endforeach
                        @else
                            <li class="list-group-item text-center">
                                Belum ada Task
                            </li>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-1">
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center">Tambah Task</h4>
                    @if (Request::url() == route('task.index'))
                    <form class="mb-3" action="{{ route('task.store') }}" method="POST">
                    @else
                    <form class="mb-3" action="{{ route('task.update', $task->id) }}" method="POST">
                    @method('PUT')
                    @endif
                        @csrf
                        <div class="input-group">
                            <input type="text" name="task"
                                class="form-control{{ $errors->has('task') ? ' is-invalid' : '' }}"
                                placeholder="Create new task"
                                value="{{ Request::url() == route('task.index') ? old('task') : $task->name }}"
                                autofocus>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Submit Task</button>
                            </div>
                            @if ($errors->has('task'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('task') }}</strong>
                                </span>
                            @endif
                        </div>
                    </form>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection