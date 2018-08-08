<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LiveSearchController extends Controller
{
   public function action_user(Request $request){
       $name = $request->get('search');
       if($name != ''){
           $users = DB::table('users')->where('name', 'like', '%'.$name.'%')->get();
           $data =[];
           foreach($users as $user){
               array_push($data, [
                   'id' => $user->id,
                   'text' => $user->name,
                ]);
           }
           echo json_encode($data);
       }
   }
   public function action_task(Request $request){
       $name = $request->get('search');
       if($name != ''){
           $tasks = DB::table('tasks')->where('title', 'like', '%'.$name.'%')->get();
           $data = [];
           foreach($tasks as $task){
               array_push($data, [
                    'id' => $task->id,
                    'text' => $task->title,
               ]);
           }
           echo json_encode($data);
       }
   }
}
