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
{{--            <a class="mb-3" href="/">Go back HOME</a>--}}
            <button class="btn btn-block btn-primary"><a href="/" style="color: #ffffff">HOME</a></button>
            <button type="button"
                    class="btn btn-block btn-success"
                    data-toggle="modal"
                    data-target="#applicantModalCreateTask"
                {{Auth::user()->is_manager == true ? '' : "disabled"}}>
                Create Task
            </button>
            <div class="dropdown mt-2">
                <form action="{{ route('tasks.sortby') }}" method="post" enctype="multipart/form-data">
                    <select class="sortby form-control" id="sort_by" name="sort_by">
                        <option value="alltasks">All Tasks</option>
                        <option value="day">Day</option>
                        <option value="week">Week</option>
                        <option value="future">Future</option>
                        <option value="updated_at" selected>Updated</option>
                    </select>
{{--                    <div class="col-sm-12">--}}
{{--                        <button class="btn btn-block btn-primary" type="submit">Refresh</button>--}}
{{--                    </div>--}}

                    <div class="dropdown mt-2">

                        <form action="{{ route('tasks.sortby') }}" method="post" enctype="multipart/form-data">
                            @if(Auth::user()->is_manager == true)
                                <select class="sortby form-control" id="responsible" name="responsible">
                                    @foreach($usersToAssign as $employee)
                                        <option value={{ $employee->id }}>
                                            {{ $employee->first_name }}
                                        </option>
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
                            <a href="#"
                               data-toggle="modal"
                               data-target="#applicantModal{{$task->id}}"
                               style="color:
                                    {{ (Carbon\Carbon::parse($task->due_date)->format('yy-m-d') < Date('yy-m-d') ? 'red' : ($task->status == 'complete' ? 'green' : 'gray'))}}"
                                    >
                                    {{ $task->name }}
                            </a>
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
{{--        <p class="ml-3 mr-3" id="output">--}}
{{--            @include('tasks.data');--}}
{{--        </p>--}}

    @endif

    {{--    MODAL CREATE--}}
{{--    @include('tasks.modal', ['usersToAssign' => $usersToAssign])--}}
    @include('tasks.modal')
    @include('tasks.create')

        {{--END MODAL CREATE--}}
    <script type="text/javascript">
        // On change store the value
        // $('#sort_by_time').on('change', function(){
        //     var sort_by_time = $(this).val();
        //     localStorage.setItem('sortbyfilter', sort_by_time );
        // });
        //
        // $('#responsible').on('change', function(){
        //     var responsible = $(this).val();
        //     localStorage.setItem('responsible', responsible );
        // });
        //
        // $(document).ready(function() {
        //     // On refresh check if there are values selected
        //     if (localStorage.sort_by_time) {
        //         // Select the value stored
        //         $('#sort_by_time').val( localStorage.sort_by_time );
        //     }
        //     if (localStorage.responsible) {
        //         // Select the value stored
        //         $('#responsible').val( localStorage.responsible );
        //     }
        // });
        $('.sortby').change(function() {
            localStorage.setItem(this.id, this.value);
        }).val(function() {
            return localStorage.getItem(this.id)
        });
    </script>

@endsection


