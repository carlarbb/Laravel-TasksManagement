<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Project;
use Illuminate\Database\Query\Builder;
use App\Task;
use Illuminate\Support\Facades\Config;
use App\User;
use App\History;

session_start();
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
    public static function getProjectIds(){
        $project_ids = [];
        //You must create a project before you create any tasks
        $p= DB::table('projects')->get();
        if($p->isEmpty()){
            $message = 'Action not allowed! First, you must create a project!';
            return redirect()->route('project.create')->with('problem1', $message);
            //sau return redirect()->route('project.create')->with('error', $message)	
        }else{
            //sort projects by count field in descending order 
            $p = $p->sortByDesc('count'); 
            foreach($p as $project){
                $arrayProj = [$project->id => $project->title];
                $project_ids = $project_ids + $arrayProj;
            }
        }
        return $project_ids;
    }

    public static function getUserIds(){
        $user_ids = [];
        $u = DB::table('users')->get();
        //sort users by count field in descending order 
        $u = $u->sortByDesc('count');
        foreach($u as $user){
            $arrayUser = [$user->id => $user->name];
            $user_ids = $user_ids + $arrayUser; //concatenate arrays
        }
        return $user_ids;
    }
    public function create()
    {
        $project_ids = self::getProjectIds();
        $user_ids = self::getUserIds();
        $_SESSION['proj_set'] = $_GET['proj_set'];


        return view('pages.create_task')->with('project_ids', $project_ids) 
                                        ->with('status', Config::get('status'))
                                        ->with('priority', Config::get('priority'))
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
        //You are not allowed to set tasks for yourself
        if($request->receiver_id == auth()->user()->id){
            $message = 'You are not allowed to set tasks for yourself';
            return redirect()->route('task.create', ['proj_set' => $_SESSION['proj_set']])->with('problem1', $message);
        }else{
            $task = new Task;
            $task->title = $request->title;
            $task->content = $request->body;
            $task->created_by_id = $request->user()->id;
            $date = $request->due_date;
            $task->due_date = $date;
            $task->status = $request->status;
            $task->priority_level = $request->priority;
            if($_SESSION['proj_set']){
                $task->project_id = $_SESSION['proj_set'];
            }
            else{
                $task->project_id = $request->project_id;
            }
            //use count attribute for displaying the users and projects selects ordered by last choices 
            $proj = Project::find($task->project_id);
            $proj->count++;
            $task->receiver_id = $request->receiver_id;
            $user = User::find($task->receiver_id);
            $user->count++;
            $proj->save();
            $user->save();  
            $task->save();
            //set a success message when redirect
            return redirect()->route('task.create', ['proj_set' => $_SESSION['proj_set']])->with('success', 'Task Created');
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
        $proj = Project::find($task->project_id);
        return view('pages.show_task')->with('task', $task)
                                      ->with('uname', $userc->name)
                                      ->with('rname', $receiver->name)
                                      ->with('project', $proj);
    }

    public function history(Request $request){
        $history = DB::table('history')->get();
        return view('pages.show_task_history')->with('history', $history);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project_ids = self::getProjectIds();
        $user_ids = self::getUserIds();
        $task = Task::find($id);
        //Check for correct user
        if(auth()->user()->id != $task->created_by_id){
           $readonly = true;
        }
        else{
            $readonly = false;
        }
    
        return view('pages.edit_task')->with('task', $task)
                                      ->with('readonly', $readonly)
                                      ->with('project_ids', $project_ids) 
                                      ->with('user_ids', $user_ids) 
                                      ->with('status', Config::get('status'))
                                      ->with('priority', Config::get('priority'));
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
        $task = Task::find($id);
        
        if(auth()->user()->id == $task->created_by_id){
            $this->validate($request, [
                'title' => 'required',
                'body' => 'required',
                'due_date' => 'required'
            ]);
            if($request->receiver_id == auth()->user()->id){
                $message = 'You are not allowed to set tasks for yourself';
                return redirect()->route('task.edit', $task->id)->with('problem1', $message);
            }
            else{
                if($request->receiver_id != $task->receiver_id){ //update history table
                    $hist = new History;
                    $hist->task_id = $task->id;
                    $hist->creator_id = $task->created_by_id;
                    $hist->from_user_id = $task->receiver_id; 
                    $hist->to_user_id = $request->receiver_id;
                    $hist->save();
                }
                $task->receiver_id = $request->receiver_id;
                $task->title = $request->title;
                $task->content = $request->body;
                $task->status = $request->status;
                $task->priority_level = $request->priority;
                $task->project_id = $request->project_id;
            }
        }
        else{
            $c = count(Config::get('status'));
            if($request->status == $c)
            {
                $task->completed = 1;
                $task->save();
                return redirect()->route('dashboard')->with('success', 'Completed task');
            }
            else
            {
                if($request->receiver_id != $task->created_by_id){
                    $task->receiver_id = $request->receiver_id;
                }else{
                    $message = 'You are not allowed to set tasks for yourself';
                    return redirect()->route('task.edit', $task->id)->with('problem1', $message);
                }
                $task->status = $request->status;
            }
        }
        $task->save();
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
        $project = Project::find($task->project_id);
        $project->count--;
        if(auth()->user()->id !== $task->created_by_id){
            return redirect()->route('dashboard')->with('error', 'Unauthorized Page');
        }

        $task->delete();
        return redirect()->route('dashboard')->with('success', 'Task Removed');
    }

    public function filter(){
        $tasksForMe = auth()->user()->received_tasks;
        //take off completed tasks from array $tasksForMe
        //use array_filter instead for non-associative array 
        $tasksForMe = $tasksForMe->reject(function ($value, $key) {
            return $value->completed==1;
        });
        
    
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
