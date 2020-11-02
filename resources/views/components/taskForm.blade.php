{!! Form::open(['route' => 'task.store', 'method' => 'POST']) !!}

    {{ Form::label('name', 'Task Name', ['class' => 'control-label']) }}
    {{ Form::text('name', null, ['class' => 'form-control form-control-lg', 'placeholder' => 'Task Name']) }}

    {{ Form::label('description', 'Description', ['class' => 'control-label mt-3']) }}
    {{ Form::textarea('description', null, ['class' => 'form-control form-control-lg', 'placeholder' => 'Task Description']) }}

    {{ Form::label('due_date', 'Due Date', ['class' => 'control-label mt-3']) }}
    {{ Form::date('due_date', \Carbon\Carbon::now()), ['class' => 'form-controls'] }}

    <div class="row justify-content-center mt-3">
        <div class="col-sm-6">
            <button class="btn btn-block btn-success" type="submit">Create Task</button>
        </div>
    </div>

{!! Form::close() !!}
