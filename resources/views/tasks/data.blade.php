<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

@foreach($tasks as $task)

    <div class="row">
        <div class="col-sm-12">
            <div class="d-flex justify-content-between">
{{--                <h3 style="color: {{ $task->status == 'complete' ? 'green' : 'grey'}}">{{ $task->name }}</h3>--}}
{{--                <h3 style="color: {{ ($task->due_date < date('M j, Y'))--}}
{{--                                                            ? 'red'--}}
{{--                                                            : $task->status == 'complete' ? 'green' : 'grey' }}">{{ $task->name }}</h3>--}}
                <h3>{{ $task->name }}</h3>
                <h6>Created: {{ $task->created_at }}</h6>
            </div>
            <p>{{ $task->description }}</p>
            <h4>Due Date: <small>{{ $task->due_date }}</small></h4>
            <h4>Created By: <small>{{ $task->creator->first_name }} {{ $task->creator->last_name }}</small></h4>
            <h4>Assign To: <small>{{ $task->user->first_name }} {{ $task->user->last_name }}</small></h4>
            <a href="/tasks/{{ $task->id }}/edit" class="btn btn-sm btn-primary">Edit</a>

            <form action="tasks/delete/{{ $task->id }}" method="POST" enctype="multipart/form-data">
                @method('DELETE')
                {{--                <a href="tasks/edit/{{ $task->id }}}" class="btn btn-sm btn-primary">Edit</a>--}}
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                @csrf
            </form>

            {{--            {!! Form::open(['route' => ['tasks.destroy', $task->id], 'method' => 'DELETE']) !!}--}}
            {{--            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary">Edit</a>--}}
            {{--            <button type="submit" class="btn btn-sm btn-danger">Delete</button>--}}
            {{--            {!! Form::close() !!}--}}
        </div>
    </div>
    <hr>
@endforeach

{{--<div class="row justify-content-center">--}}
{{--    <div class="col-sm-6 text-center">--}}
{{--        {{ $tasks->links() }}--}}
{{--    </div>--}}
{{--</div>--}}


</body>
</html>


