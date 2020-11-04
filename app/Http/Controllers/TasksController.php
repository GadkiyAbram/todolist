<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $currentUserId = Auth::id();
        $usersToAssign = DB::table('users')
            ->where('manager_id', $currentUserId)
            ->where('id', '!=', $currentUserId)
            ->get()
            ->toArray();
        $tasks = Task::orderBy('due_date', 'asc')->paginate(5);
        return view('tasks.index', compact('tasks', 'usersToAssign'));
    }

    public function getTasksForCreatorsAndResponsible(){
        return Task::from('tasks')
            ->where(function ($q){
                $q->where('created_by', Auth::id())
                    ->orWhere('assigned_to', Auth::id());
            });
    }

    public function sortBy(Request $request){

        $item = $request->item;

        $tasks = $this->getTasksForCreatorsAndResponsible();

        if($item == 'day'){
            $tasks = $tasks->where('due_date', date('yy-m-d'))->get();
        }else if ($item == 'updated_at'){
            $tasks = $tasks->orderBy($item, 'desc')->get();

        }else if ($item == 'week'){
            $tasks = $tasks->where('due_date', '<', Date('yy-m-d', strtotime('+7 days')))->get();

        }else if ($item == 'future'){
                $tasks = $tasks->where('due_date', '>', Date('yy-m-d', strtotime('+7 days')))
                ->get();
        }else if ($item == 'assigned_to'){
            $tasks = $tasks
                ->where('created_by', Auth::id())
                ->orderBy('assigned_to', 'asc')
                ->get();
        }

        return view('tasks.data', compact('tasks'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $currentUserId = Auth::id();
        $usersToAssign = DB::table('users')
            ->where('manager_id', $currentUserId)
            ->where('id', '!=', $currentUserId)
            ->get()
            ->toArray();
        return view('tasks.create', compact('usersToAssign'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the Data
        $this->validate($request, [
           'name' => 'required|string|max:255|min:3',
           'description' => 'required|string|max:10000|min:10',
           'due_date' => 'required|date',
        ]);

        // create a new task
        $task = new Task;

        // assign the task data from our request
        $task->name = $request->name;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->created_by = Auth::id();
        $task->assigned_to = $request->assigned_to;
        $task->priority = $request->priority;
        $task->status = $request->status;
//        dd($task->status);

        // save the task
        $task->save();

        // flash Session message with Success
        Session::flash('success', 'Created Task Successfully');

        // Return a Redirect
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the Task by id
        // Return a view show.blade.php
        // pass the variable to view
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $disabled = 'disabled';
        $selected = 'selected';
        $task = Task::find($id);
        if ($task->created_by == Auth::id()){ $disabled = ''; }
//        dd($task->due_date < date('M j, Y'), $task->due_date, date('M j, Y'));

//        $task->dueDateFormatting = false;
        return view('tasks.edit', compact('task', 'disabled', 'selected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find a related task
        $task = Task::find($id);

        if(Auth::id() == $task->created_by){
            // validate the Data
            $this->validate($request, [
                'name' => 'required|string|max:255|min:3',
                'description' => 'required|string|max:10000|min:10',
                'due_date' => 'required|date',
            ]);

            // assign the task data from our request
            $task->name = $request->name;
            $task->description = $request->description;
            $task->due_date = $request->due_date;
            $task->priority = $request->priority;
            $task->status = $request->status;
        }else{
            $task->status = $request->status;
        }

        // save the task
        $task->save();

        // flash Session message with Success
        Session::flash('success', 'Saved The Task Successfully');

        // Return a Redirect
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // finding the specific task by id
        $task = Task::find($id);
        // deleting the task
        $task->delete();
        // flashing the ssession message
        Session::flash('success', 'Task deleted successfully');
        // In the end we return & redirect
        return redirect()->route('tasks.index');
    }
}
