<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB;
use Illuminate\Support\Facades\Storage;
use App\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public static function count_tasks($project_id){
        $tasks = DB::table('tasks')->where('project_id', $project_id)->get();
        return count($tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.create_project');
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
            'description' => 'required'
        ]);

        $pr = new Project;
        $pr->title = $request->title;
        $pr->description = $request->description;
        $pr->created_by_id = $request->user()->id;
        $pr->save();

        //set a success message when redirect
        return redirect()->route('dashboard')->with('success', 'Project Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $proj_id = $_GET['proj_id'];
        $project = Project::find($proj_id);
        $proj_tasks = DB::table('tasks')->where('project_id', $proj_id)->get();
        return view('pages.show_project')->with('project', $project)
                                         ->with('proj_tasks', $proj_tasks);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
         //Check for correct user
        if(auth()->user()->id !== $project->created_by_id){
            return redirect()->route('dashboard')->with('error', 'Unauthorized Page');
        }
        return view('pages.edit_project')->with('project', $project);
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
            'description' => 'required'
        ]);
        
        $pr = Project::find($id);
        $pr->title = $request->title;
        $pr->description = $request->description;
        $pr->created_by_id = $request->user()->id;
        $pr->save();

        //set a success message when redirect
        return redirect()->route('dashboard')->with('success', 'Project Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        //Check for correct user
        if(auth()->user()->id !== $project->created_by_id){
            return redirect()->route('dashboard')->with('error', 'Unauthorized Page');
        }

        $proj_tasks = DB::table('tasks')->where('project_id', $id)->get();
        if($proj_tasks->isEmpty()){
            $project->delete();
        }
        else{
            foreach($proj_tasks as $task){
                $task_object = DB::table('tasks')->where('id', $task->id);
                $task_object->delete();
            }
            $project->delete();
        }
        
        return redirect()->route('dashboard')->with('success', 'Project Removed');
    }
}
