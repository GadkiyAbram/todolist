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
                <h3>
                    <a href="/tasks/{{ $task->id }}/edit" id="{{ $task->id }}" style="color: gray">
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
</body>
</html>
