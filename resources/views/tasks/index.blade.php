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
            <button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#exampleModal">
                Create Task
            </button>
        </div>
    </div>

    @if($tasks->count() == 0)
        <p class="lead text-center">Well done chops, nothing to do unless you create one :)</p>
    @else
        <div class="d-flex justify-content-around mb-3">
                <div class="dropdown">
                    <select class="form-control" id="sort_by">
                        <option value="day" name="sort_by" class="sort_by" id="sort_by" >Day</option>
                        <option value="week" name="sort_by" class="sort_by" id="sort_by">Week</option>
                        <option value="future" name="sort_by" class="sort_by" id="sort_by">Future</option>
                        <option value="updated_at" name="sort_by" class="sort_by" id="sort_by" selected>Updated</option>
                        @if(Auth::user()->is_manager == true)
                        <option value="assigned_to" name="sort_by" class="sort_by" id="sort_by">Employees</option>
                        @endif
                    </select>
                </div>
        </div>

        <p class="ml-3 mr-3" id="output">

        </p>

    @endif

    {{--    MODAL CREATE--}}
    @include('tasks.modal')
    {{--END MODAL CREATE--}}


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
                success: function(data){
                    $('#output').html(data);
                },
            });
        }

        $(document).ready(function () {

            var currentItem = $('select').val();
            loadData(currentItem);

            $('select').change(function (e) {
                var item = $('select').val();
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('tasks.sortby') }}",
                    data: { item: item
                    },
                    success: function(data){
                        $('#output').html(data);
                    }
                });
            })
        });
    </script>

@endsection


