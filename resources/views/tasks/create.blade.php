@extends('layouts.main')

@section('title', 'Create Task')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <h1>Create Task</h1>
            {!! Form::open(['route' => 'tasks.store', 'method' => 'POST']) !!}

{{--            @component('components.taskForm')--}}
{{--            @endcomponent--}}

            {{ Form::label('name', 'Task Name', ['class' => 'control-label']) }}
            {{ Form::text('name', null, ['class' => 'form-control form-control-lg', 'placeholder' => 'Task Name']) }}

            {{ Form::label('description', 'Description', ['class' => 'control-label mt-3']) }}
            {{ Form::textarea('description', null, ['class' => 'form-control form-control-lg', 'placeholder' => 'Task Description']) }}

            {{ Form::label('due_date', 'Due Date', ['class' => 'control-label mt-3']) }}
            {{ Form::date('due_date', null, ['class' => 'form-control']) }}

            <div class="form-group row">
                <label for="assigned_to" class="col-4 col-form-label">Assign to</label>
                <div class="col-4">
                    <select name="assigned_to" id="assigned_to" class="form-control">
                        @foreach($usersToAssign as $user)
                            <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row justify-content-center mt-3">
                <div class="col-sm-4">
                    <a href="{{ route('tasks.index') }}" class="btn btn-block btn-secondary">Go Back</a>
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-block btn-primary" type="submit">Save Task</button>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>

@endsection
