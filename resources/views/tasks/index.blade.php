<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
</head>

@extends('layouts.main')

@section('title', 'Tasks Home')

@section('content')

    <div class="row justify-content-center mb-3">
        <div class="col-sm-4">
            <a class="mb-3" href="/">Go back HOME</a>
            <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#applicantModalCreateTask">
                Create Task
            </button>
            <div class="dropdown mt-2">
                <form action="{{ route('tasks.sortby') }}" method="post" enctype="multipart/form-data">
                    <select class="form-control" id="sort_by" name="sort_by">
                        <option value="day"
                                class="sort_by" id="sort_by">Day</option>
                        <option value="week"
                                class="sort_by" id="sort_by">Week</option>
                        <option value="future"
                                class="sort_by" id="sort_by">Future</option>
                        <option value="updated_at"
                                class="sort_by" id="sort_by" selected>Updated</option>
                    </select>
{{--                    <div class="col-sm-12">--}}
{{--                        <button class="btn btn-block btn-primary" type="submit">Refresh</button>--}}
{{--                    </div>--}}

                    <div class="dropdown mt-2">

                        <form action="{{ route('tasks.sortby') }}" method="post" enctype="multipart/form-data">
                            @if(Auth::user()->is_manager == true)
                                <select class="form-control" id="responsible" name="responsible">
                                    @foreach($usersToAssign as $employee)
                                        <option value={{ $employee->id }}
                                            class="sort_by" id="responsible"
                                        >{{ $employee->first_name }}</option>
                                    @endforeach
                                </select>
                            @endif
                            <div class="col-sm-12 mt-2">
                                <button class="btn btn-block btn-primary" type="submit">Refresh</button>
                            </div>
                            @csrf
                        </form>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-3">
        <div class="col-sm-4">
{{--            <div class="dropdown">--}}
{{--                <form action="{{ route('tasks.sortby') }}" method="post" enctype="multipart/form-data">--}}
{{--                    <select class="form-control" id="sort_by" name="sort_by">--}}
{{--                        @foreach($users as $user)--}}
{{--                            <option value="{{$user->id}}"--}}
{{--                                    class="sort_by" id="sort_by" >{{$user->first_name}}</option>--}}
{{--                        @endforeach--}}

{{--                    </select>--}}
{{--                    <div class="col-sm-12">--}}
{{--                        <button class="btn btn-block btn-primary" type="submit">Refresh</button>--}}
{{--                    </div>--}}
{{--                    @csrf--}}
{{--                </form>--}}
{{--            </div>--}}

        </div>
    </div>

    @if($tasks->count() == 0)
        <p class="lead text-center">Well done chops, nothing to do unless you create one :)</p>
    @else
        <div class="d-flex justify-content-around mb-3">


        </div>

        @foreach($tasks as $task)
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex justify-content-between">
                        <h3>
                            <a href="#" data-toggle="modal" data-target="#applicantModal{{$task->id}}" style="color: #1a202c">{{ $task->name }}</a>
{{--                            <a href="#" id="{{ $task->id }}" style="color: gray" class="taskName" data-toggle="modal" target="#applicantModal{{$task->id}}">--}}
{{--                                {{ $task->name }}--}}
{{--                            </a>--}}
{{--                            <a href="/tasks/{{ $task->id }}/edit" id="{{ $task->id }}" style="color: gray" class="taskName">--}}
{{--                                {{ $task->name }}--}}
{{--                            </a>--}}
                        </h3>
                        <h5>Priority: {{ $task->priority }}</h5>
                        <h6>Created: {{ $task->created_at }}</h6>
                    </div>
                    <p>{{ $task->description }}</p>
                    <h4>Due Date: <small class="due_date">{{ \Carbon\Carbon::parse($task->due_date)->format('Y/m/d') }}</small></h4>
                    <h4>Responsible: <small>{{ $task->user->first_name }} {{ $task->user->last_name }}</small></h4>
                    <h4>Status: <small class="status">{{ $task->status }}</small></h4>
                    <div class="d-flex justify-content-start">

                        <form action="tasks/delete/{{ $task->id }}" method="POST" enctype="multipart/form-data">
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            <hr>
        @endforeach

    @endif

    {{--    MODAL CREATE--}}
{{--    @include('tasks.modal', ['usersToAssign' => $usersToAssign])--}}
    @include('tasks.modal')
    @include('tasks.create')

        {{--END MODAL CREATE--}}

@endsection
