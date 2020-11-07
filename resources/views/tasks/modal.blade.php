{{--CREATE MODAL--}}
<div class="modal fade edit" id="applicantModalCreateTask" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                {{--MODAL BODY--}}
                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <div class="align-content-center">
                                <h1>Create Task</h1>
                            </div>

                        </div>

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
                                <label for="name" class="col-sm-6 col-form-label">Task Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="name" placeholder="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-6 col-form-label">Description</label>
                                <div class="col-sm-12">
                                    <textarea type="text" class="form-control" name="description">
                                    </textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="due_date" class="col-sm-6 col-form-label">Due Date</label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control" name="due_date" value={{\Carbon\Carbon::now()}}>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="assigned_to" class="col-6 col-form-label">Assign to</label>
                                <div class="col-6">
                                    <select name="assigned_to" id="assigned_to" class="form-control">
                                        @foreach($usersToAssign as $user)
                                            <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row justify-content-center mt-3">
                                <div class="col-sm-4">
                                    <button data-dismiss="modal" class="btn btn-block btn-secondary">Close</button>
                                </div>
                                <div class="col-sm-4">
                                    <button class="btn btn-block btn-primary" type="submit">Save Task</button>
                                </div>
                            </div>
                            @csrf
                        </form>
                    </div>
                </div>
                {{--END MODAL BODY--}}
            </div>
        </div>
    </div>
</div>

<!--Edit Modal -->
@foreach($tasks as $task)

<div class="modal fade edit" id="applicantModal{{$task->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                {{--MODAL BODY--}}
                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <div class="align-content-center">
                                <h1>Edit Task</h1>
                            </div>

                        </div>

                        <form action="{{ route('tasks.update', $task->id) }}" method="post" enctype="multipart/form-data">
                            @method('PATCH')
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons" readonly="{{ $task->created_by == \Illuminate\Support\Facades\Auth::id() }}">
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
                                <label for="name" class="col-sm-6 col-form-label">Task Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="name"
                                        {{\Illuminate\Support\Facades\Auth::id() ? '' : 'readonly'}}"
                                          value={{$task->name}} >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-6 col-form-label">Description</label>
                                <div class="col-sm-12">
                                    <textarea type="text" class="form-control" name="description"
                                        {{\Illuminate\Support\Facades\Auth::id() ? '' : 'readonly'}}>
                                        {{ $task->description }}
                                    </textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="due_date" class="col-sm-6 col-form-label">Due Date</label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control" name="due_date" value={{\Carbon\Carbon::now()}}
                                        {{\Illuminate\Support\Facades\Auth::id() ? '' : 'readonly'}}>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="assigned_to" class="col-6 col-form-label">Assign to</label>
                                <div class="col-6">
                                    <select name="assigned_to" id="assigned_to" class="form-control"
                                        {{\Illuminate\Support\Facades\Auth::id() ? '' : 'disabled'}}>
                                        @foreach($usersToAssign as $user)
                                            <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row justify-content-center mt-3">
                                <div class="col-sm-4">
                                    <button data-dismiss="modal" class="btn btn-block btn-secondary">Close</button>
                                </div>
                                <div class="col-sm-4">
                                    <button class="btn btn-block btn-primary" type="submit">Save Task</button>
                                </div>
                            </div>
                            @csrf
                        </form>
                    </div>
                </div>
                {{--END MODAL BODY--}}
            </div>
        </div>
    </div>
</div>
@endforeach
{{--END MODAL--}}
