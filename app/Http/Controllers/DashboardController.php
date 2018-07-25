<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $myProjects = DB::table('projects')->where('created_by_id', Auth::user()->id)->get();
        $myTasks = DB::table('tasks')->where('created_by_id', Auth::user()->id)->get();
        return view('dashboard')->with('user', $user)
                                ->with('myProjects', $myProjects)
                                ->with('myTasks', $myTasks);
    }
}
