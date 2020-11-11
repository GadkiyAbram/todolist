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
                    <div class="d-flex">
                        <label for="sort_by" class="col-14 col-form-label mr-4">Sort:</label>
                        <select class="sortby form-control" id="sort_by" name="sort_by">
                            <option value="alltasks">All My Tasks</option>
                            <option value="day">Day</option>
                            <option value="week">Week</option>
                            <option value="future">Future</option>
                            <option value="updated_at" selected>Updated</option>
                        </select>
                    </div>

                    <div class="dropdown mt-2">
                        <form action="{{ route('tasks.sortby') }}" method="post" enctype="multipart/form-data">
                            <div class="d-flex">
                                @if(Auth::user()->is_manager == true)
                                    <label for="responsible" class="col-14 col-form-label mr-4">Responsible:</label>
                                    <select class="sortby form-control" id="responsible" name="responsible">
                                        @foreach($usersToAssign as $employee)
                                            <option value={{ $employee->id }}>
                                                {{ $employee->first_name }} {{ $employee->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="col-sm-14 mt-2">
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
        <p class="lead text-center">Well done, nothing to do until you create one :)</p>
    @else
        @foreach($tasks as $task)
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex justify-content-between">
                        <h3>
                            <a href="#"
                               data-toggle="modal"
                               data-target="#applicantModal{{$task->id}}"
                               style="color:
                                    {{ $task->status == 'complete' ? 'green' : (Carbon\Carbon::parse($task->due_date)->format('yy-m-d') < Date('yy-m-d') ? 'red' : 'gray' )}}"
                                    >
                                    {{ $task->name }}
                            </a>
                        </h3>
                        <h5>Priority: {{ $task->priority }}</h5>
                        <h6>Created: {{ $task->created_at }}</h6>
                    </div>
                    <p>{{ $task->description }}</p>
                    <h4>Due Date: <small class="due_date">{{ \Carbon\Carbon::parse($task->due_date)->format('Y/m/d') }}</small></h4>
                    <h4>Responsible: <small>{{ $task->assigned_to === \Illuminate\Support\Facades\Auth::id() ? (($task->user->first_name. " ". $task->user->last_name). ' (You)') : ($task->user->first_name. " ". $task->user->last_name) }}
{{--                            {{ $task->user->first_name }} {{ $task->user->last_name }}--}}
                        </small></h4>
                    <h4>Status: <small class="status">{{ $task->status }}</small></h4>
                    <div class="d-flex justify-content-start">

                        <form action="tasks/delete/{{ $task->id }}" method="POST" enctype="multipart/form-data">
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                {{Auth::user()->is_manager == true ? '' : "disabled"}}
                            >Delete</button>
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            <hr>
        @endforeach
    @endif

    {{--   INCLUDE MODALS CREATE / UPDATE--}}
    @include('tasks.modal')
    @include('tasks.create')
        {{--END MODAL CREATE--}}

    {{--Store previous values for both select's (sort_by & responsible)--}}
    <script type="text/javascript">
        $('.sortby').change(function() {
            localStorage.setItem(this.id, this.value);
        }).val(function() {
            return localStorage.getItem(this.id)
        });

        var disable_responsinble = function () {
            if ($("#sort_by").val() === 'alltasks') {
                $('#responsible').prop('disabled', true);
            }
            else {
                $('#responsible').prop('disabled', false);
            }
        };
        $(disable_responsinble);
        $("#sort_by").change(disable_responsinble);


    </script>

@endsection


