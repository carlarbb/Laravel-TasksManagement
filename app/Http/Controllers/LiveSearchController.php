<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LiveSearchController extends Controller
{
   public function action(Request $request){
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
}
