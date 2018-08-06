<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LiveSearchController extends Controller
{
    public function action(Request $request){
        $query = $request->get('query');
        if($query != ''){
            $data = DB::table('users')->where('name', 'like', '%'.$query.'%')->where('id', 'not like', '%'.session('currentTaskReceiver').'%')->get();
        }
        else{
            $data = DB::table('users')->get();
        }  
        $row_number = $data->count();
        $output ='';
        if( $row_number > 0){
            foreach($data as $user){
                $output .= '<a class="dropdown-item" href="'.route("task.change_receiver",[session('currentTaskId'), $user->id]).'">'.'dkfjdks</a>';
            }
        }
        $data=[
            'text' => $output,
        ];
        echo json_encode($data);
    }
}
