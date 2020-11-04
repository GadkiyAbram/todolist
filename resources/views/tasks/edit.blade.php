<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
</head>

@extends('layouts.main')

@section('title', 'Edit Task')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between align-items-lg-baseline">
                <h1>Edit Task</h1>
                <h5>Task Priority: {{ $task->priority }}</h5>
                <h5>Task Status: {{ $task->status }}</h5>
            </div>

            <form action="{{ route('tasks.update', $task->id) }}" method="post" enctype="multipart/form-data">
                @method('PATCH')
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-danger active">
                                <input type="radio" name="priority" value="High" checked {{ $disabled }}> High
                            </label>
                            <label class="btn btn-warning">
                                <input type="radio" name="priority" value="Medium" {{ $disabled }}> Medium
                            </label>
                            <label class="btn btn-success">
                                <input type="radio" name="priority" value="Low" {{ $disabled }}> Low
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
                        <input type="text" class="form-control"
                               name="name" placeholder="Task Name"
                               value="{{ $task->name }}" {{ $disabled }}>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-8">
                        <textarea  type="text" class="form-control"
                                   name="description"
                                   placeholder="Description"
                                    {{ $disabled }}>{{ $task->description }}"
                        </textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="due_date" class="col-sm-2 col-form-label">Due Date</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control"
                               name="due_date" value="{{ $task->due_date }}" placeholder="Due Date" {{ $disabled }}>
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

        </div>
    </div>

@endsection
