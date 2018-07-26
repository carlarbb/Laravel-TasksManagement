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
        $pr->count = 0;
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
    public function show($id)
    {
        //
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

        $project->delete();
        return redirect()->route('dashboard')->with('success', 'Project Removed');
    }
}
