<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function index()
    {
        $currentUserId = Auth::id();
        $usersToAssign = DB::table('users')
            ->where('manager_id', $currentUserId)
            ->where('id', '!=', $currentUserId)
            ->get()
            ->toArray();

        $tasks = Task::from('tasks')
            ->where(function ($q) {
                $q->where('created_by', Auth::id())
                    ->orWhere('assigned_to', Auth::id());
            })->get();


//        dd($tasks, $currentUserId);

        $users = DB::table('users')
            ->where(['manager_id' => Auth::id()])
            ->get()
            ->toArray();
        return view('tasks.index', compact('tasks', 'usersToAssign', 'users'));
    }

    public function getTasksForCreatorsAndResponsible($responsible){

        $tasks = Task::from('tasks')
            ->where(function ($q){
                $q->where('created_by', Auth::id())
                    ->orWhere('assigned_to', Auth::id());
            });
        if ($responsible != null){
            $tasks = $tasks->where('assigned_to', $responsible);
        }

        return $tasks;
    }

    public function sortBy(Request $request){

        $responsible = $request->responsible;
//        dd($responsible);

        $currentUserId = Auth::id();
        $usersToAssign = DB::table('users')
            ->where('manager_id', $currentUserId)
            ->where('id', '!=', $currentUserId)
            ->get()
            ->toArray();

        $sort_by = $request->sort_by;

        $tasks = $this->getTasksForCreatorsAndResponsible($responsible);

        if($sort_by == 'day'){
            $tasks = $tasks
                ->where('due_date', date('yy-m-d'))
                ->get();
        }else if ($sort_by == 'updated_at'){
            $tasks = $tasks->orderBy($sort_by, 'desc')->get();

        }else if ($sort_by == 'week'){
            $tasks = $tasks
                ->where('due_date', '<', Date('yy-m-d', strtotime('+7 days')))
                ->get();

        }else if ($sort_by == 'future'){
            $tasks
                ->where('due_date', '>', Date('yy-m-d', strtotime('+7 days')))
                ->get();
        }else if ($sort_by == 'assigned_to'){
            $tasks = $tasks
                ->where('created_by', Auth::id())
                ->orderBy('assigned_to', 'asc')
                ->get();
        }

        $users = DB::table('users')->where(['manager_id' => Auth::id()])
            ->get();

        return view('tasks.index', compact('tasks', 'usersToAssign', 'users'));
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
//        dd($usersToAssign);
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
