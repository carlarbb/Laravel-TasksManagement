<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Project;
use Illuminate\Database\Query\Builder;
use App\Task;
use Illuminate\Support\Facades\Config;
use App\User;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $project_ids = array();
        $p= DB::table('projects')->get();
        foreach($p as $project){
            $arrayProj = [$project->id => $project->id];
            $project_ids = $project_ids + $arrayProj;
        }

        $user_ids = array();
        $u = DB::table('users')->get();
        foreach($u as $user){
            $arrayUser = [$user->id => $user->id];
            $user_ids = $user_ids + $arrayUser; //concatenate arrays
        }
       
        return view('pages.create_task')->with('project_ids', $project_ids) 
                                        ->with('status', Config::get('status.status'))
                                        ->with('priority', Config::get('priority.priority'))
                                        ->with('user_ids', $user_ids);
    }

    /** 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'due_date' => 'required' 
        ]);

        $task = new Task;
        $task->title = $request->title;
        $task->content = $request->body;
        $task->created_by_id = $request->user()->id;

        $date = $request->due_date;
        $task->due_date = $date;

        $task->status = $request->status;
        $task->priority_level = $request->priority;
        $task->project_id = $request->project_id;
        $task->receiver_id = $request->receiver_id;
        print_r($request->due_date);    
        $task->save();

        //set a success message when redirect
        return redirect()->route('task.create')->with('success', 'Task Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        $userc = User::find($task->created_by_id);
        $receiver = User::find($task->receiver_id);
        return view('pages.show_task')->with('task', $task)
                                      ->with('uname', $userc->name)
                                      ->with('rname', $receiver->name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        //Check for correct user
        if(auth()->user()->id !== $task->created_by_id){
           return redirect()->route('dashboard')->with('error', 'Unauthorized Page');
        }
        return view('pages.edit_task')->with('task', $task);
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
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
        
        $task = Task::find($id);
        $task->title = $request->title;
        $task->content = $request->body;
        $task->created_by_id = $request->user()->id;
        $task->save();

        //set a success message when redirect
        return redirect()->route('dashboard')->with('success', 'Task Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        //Check for correct user
        if(auth()->user()->id !== $task->created_by_id){
            return redirect()->route('dashboard')->with('error', 'Unauthorized Page');
        }

        $task->delete();
        return redirect()->route('dashboard')->with('success', 'Task Removed');
    }

    public function filter($myTasks){
        print_r($myTasks);
        // $val_radio = $_POST['radsort']; //find which radio button wad checked in form 
        // if($val_radio == '1'){
        //     $key = 'due_date';
        // }
        // else if($val_radio == '2'){
        //     $key = 'priority_level';
        // }
        //     else if($val_radio == '3'){
        //         $key = 'project_id';
        //           }
        //         else {
        //         $key = 'due_date, priority_level, project_id';
        //         }
        // $sorted = $myTasks->sortBy($key);
        // $sorted->values()->all();
    }
}
