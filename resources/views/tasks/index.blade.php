@extends('layouts.main')

@section('title', 'Tasks Home')

@section('content')

    <div class="row justify-content-center mb-3">
        <div class="col-sm-4">
            <a href="{{ route('tasks.create') }}" class="btn btn-block btn-success">Create Task</a>
        </div>
    </div>

    @if($tasks->count() == 0)
        <p class="lead text-center">Well done chops, nothing to do unless you create one :)</p>
    @else

        @foreach($tasks as $task)

            <div class="row">
                <div class="col-sm-12">
                    <h3>
                        {{ $task->name }}
                        <small>Created: {{ $task->created_at }}</small>
                    </h3>
                    <p>{{ $task->description }}</p>
                    <h4>Due Date: <small>{{ $task->due_date }}</small></h4>
                    <h4>Assign To: <small>{{ $task->user->first_name }} {{ $task->user->last_name }}</small></h4>
                    {!! Form::open(['route' => ['tasks.destroy', $task->id], 'method' => 'DELETE']) !!}
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    {!! Form::close() !!}
                </div>
            </div>
            <hr>

        @endforeach

    @endif

    <div class="row justify-content-center">
        <div class="col-sm-6 text-center">
            {{ $tasks->links() }}
        </div>
    </div>

@endsection
