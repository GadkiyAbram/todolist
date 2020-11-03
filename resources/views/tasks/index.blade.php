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
{{--            <a href="{{ route('tasks.create') }}" class="btn btn-block btn-success">Create Task</a>--}}
            <a href="{{ route('tasks.create') }}" class="btn btn-block btn-success">Create Task</a>
        </div>
    </div>

    @if($tasks->count() == 0)
        <p class="lead text-center">Well done chops, nothing to do unless you create one :)</p>
    @else
        <div class="d-flex justify-content-around">
                <div class="dropdown">
                    <select class="form-control" id="sort_by">
                        <option value="day" name="sort_by" class="sort_by" id="sort_by" >Day</option>
                        <option value="week" name="sort_by" class="sort_by" id="sort_by">Week</option>
                        <option value="future" name="sort_by" class="sort_by" id="sort_by">Future</option>
                        <option value="updated_at" name="sort_by" class="sort_by" id="sort_by" selected>Updated</option>
                        @if(Auth::user()->isManager == true)
                        <option value="assigned_to" name="sort_by" class="sort_by" id="sort_by">Employees</option>
                        @endif
                    </select>
                </div>
        </div>

        <p class="ml-3 mr-3" id="output">
{{--            @include('tasks.data')--}}
        </p>

    @endif

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function loadData(current){
            $.ajax({
                type: 'POST',
                url: "{{ route('tasks.sortby') }}",
                data: {
                    item: current,
                },
                success: function($data){
                    console.log($data);
                    $('#output').html($data);
                },
            });
        }

        $(document).ready(function () {

            var currentItem = $('select').val();
            loadData(currentItem);

            $('select').change(function (e) {
                var item = $('select').val();
                console.log(item);
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('tasks.sortby') }}",
                    data: { item: item
                    },
                    success: function($data){
                        $('#output').html($data);
                    }
                });
            })
        });
    </script>

@endsection


