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
        $project_ids = [];
        //You must create a project before you create any tasks
        $p= DB::table('projects')->get();
        if($p->isEmpty()){
            $message = 'Action not allowed! First, you must create a project!';
            return redirect()->route('project.create')->with('problem1', $message);
            //sau return redirect()->route('project.create')->with('error', $message)	
        }else{
            $p->sortBy('count')->reverse(); //sort projects by count field in descending order
            foreach($p as $project){
                $arrayProj = [$project->id => $project->id];
                $project_ids = $project_ids + $arrayProj;
            }
    
            $user_ids = [];
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
        //You are not allowed to set tasks for yourself
        if($request->receiver_id == auth()->user()->id){
            $message = 'You are not allowed to set tasks for yourself';
            return redirect()->route('task.create')->with('problem2', $message);
        }else{
            $task = new Task;
            $task->title = $request->title;
            $task->content = $request->body;
            $task->created_by_id = $request->user()->id;
            $date = $request->due_date;
            $task->due_date = $date;

            $task->status = $request->status;
            $task->priority_level = $request->priority;
            $task->project_id = $request->project_id;
            $proj = Project::find($task->project_id);
            $proj->count++;
            $task->receiver_id = $request->receiver_id;
            print_r($request->due_date);    
            $task->save();

            //set a success message when redirect
            return redirect()->route('task.create')->with('success', 'Task Created');
        }
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

    public function filter(){
        $tasksForMe = auth()->user()->received_tasks;
        $value = $_POST['radsort'];
        if($value == '1'){
            $sorted = $tasksForMe->sortBy('due_date');
        }
        else if($value == '2'){
            $sorted = $tasksForMe->sortBy('priority_level');
        }
        else if($value == '3'){
            $sorted = $tasksForMe->sortBy('project_id');
        }
        else {
            $sorted = $tasksForMe->sortBy('due_date')->sortBy('priority_level')->sortBy('project_id');
        }

        return redirect()->route('dashboard')->with('sorted', $sorted);
    }
}
