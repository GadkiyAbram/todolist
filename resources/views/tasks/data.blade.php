<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
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
                    <a href="/tasks/{{ $task->id }}/edit" style="color: gray">{{ $task->name }}</a></h3>
                <h5>Priority: {{ $task->priority }}</h5>
                <h6>Created: {{ $task->created_at }}</h6>
            </div>
            <p id="taskdescription">{{ $task->description }}</p>
            <h4>Due Date: <small>{{ $task->due_date }}</small></h4>
            <h4>Responsible: <small>{{ $task->user->first_name }} {{ $task->user->last_name }}</small></h4>
            <h4>Status: <small>{{ $task->status }}</small></h4>
            <div class="d-flex justify-content-start">

                <form action="tasks/delete/{{ $task->id }}" method="POST" enctype="multipart/form-data">
                    @method('DELETE')
{{--                    <a href="/tasks/{{ $task->id }}/edit" class="btn btn-sm btn-primary mr-2">Edit</a>--}}
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
