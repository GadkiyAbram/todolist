@extends('layouts.main')

@section('title', 'Create Task')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="align-content-center">
                    <h1>Create Task</h1>
                </div>

            </div>

{{--            <form action="{{ route('tasks.store') }}" method="post" enctype="multipart/form-data">--}}
            <form action="{{ route('tasks.store') }}" method="post" enctype="multipart/form-data">

                <div class="d-flex justify-content-between">
                    <div>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-danger active">
                                <input type="radio" name="priority" value="High" checked> High
                            </label>
                            <label class="btn btn-warning">
                                <input type="radio" name="priority" value="Medium"> Medium
                            </label>
                            <label class="btn btn-success">
                                <input type="radio" name="priority" value="Low"> Low
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <select name="status" class="custom-select" id="status">
                            <option value="onstart" selected>on start</option>
                            <option value="ongoing">ongoing</option>
                            <option value="complete">complete</option>
                            <option value="cancelled">cancelled</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Task Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="name" placeholder="Task Name">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <textarea type="text" class="form-control" name="description" placeholder="Description"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="due_date" class="col-sm-2 col-form-label">Due Date</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" name="due_date" placeholder="Due Date">
                    </div>
                </div>

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
                @csrf
            </form>

{{--            {!! Form::open(['route' => 'tasks.store', 'method' => 'POST']) !!}--}}

{{--            @component('components.taskForm')--}}
{{--            @endcomponent--}}
{{--            <div class="d-flex justify-content-between">--}}
{{--                <div>--}}
{{--                    <div class="btn-group btn-group-toggle" data-toggle="buttons">--}}
{{--                        <label class="btn btn-danger active">--}}
{{--                            <input type="radio" name="priority" value="High" checked> High--}}
{{--                        </label>--}}
{{--                        <label class="btn btn-warning">--}}
{{--                            <input type="radio" name="priority" value="Medium"> Medium--}}
{{--                        </label>--}}
{{--                        <label class="btn btn-success">--}}
{{--                            <input type="radio" name="priority" value="Low"> Low--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="mb-3">--}}
{{--                    <div class="input-group-prepend">--}}
{{--                        <label class="input-group-text" for="inputGroupSelect01">Task Status</label>--}}
{{--                    </div>--}}
{{--                    <select name="status" class="custom-select" id="status">--}}
{{--                        <option value="onstart" selected>on start</option>--}}
{{--                        <option value="ongoing">ongoing</option>--}}
{{--                        <option value="complete">complete</option>--}}
{{--                        <option value="cancelled">cancelled</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--            </div>--}}


{{--            {{ Form::label('name', 'Task Name', ['class' => 'control-label']) }}--}}
{{--            {{ Form::text('name', null, ['class' => 'form-control form-control-lg', 'placeholder' => 'Task Name']) }}--}}

{{--            {{ Form::label('description', 'Description', ['class' => 'control-label mt-3']) }}--}}
{{--            {{ Form::textarea('description', null, ['class' => 'form-control form-control-lg', 'placeholder' => 'Task Description']) }}--}}

{{--            {{ Form::label('due_date', 'Due Date', ['class' => 'control-label mt-3']) }}--}}
{{--            {{ Form::date('due_date', null, ['class' => 'form-control']) }}--}}

{{--            <div class="form-group row">--}}
{{--                <label for="assigned_to" class="col-4 col-form-label">Assign to</label>--}}
{{--                <div class="col-4">--}}
{{--                    <select name="assigned_to" id="assigned_to" class="form-control">--}}
{{--                        @foreach($usersToAssign as $user)--}}
{{--                            <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="row justify-content-center mt-3">--}}
{{--                <div class="col-sm-4">--}}
{{--                    <a href="{{ route('tasks.index') }}" class="btn btn-block btn-secondary">Go Back</a>--}}
{{--                </div>--}}
{{--                <div class="col-sm-4">--}}
{{--                    <button class="btn btn-block btn-primary" type="submit">Save Task</button>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            {!! Form::close() !!}--}}
        </div>
    </div>

@endsection
