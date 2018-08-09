@extends('layouts.app')

@section('content')
<button id="backButton" onclick="history.go(-1);">Back </button>
@if($history != [])
<table class="table">
    <tbody>
        <tr>
            <th>Task id</th>
            <th>Created by</th>
            <th>Moved from user</th>
            <th>Moved to user</th>
            <th>Date and time</th>
        </tr>
        @foreach($history as $update)
        <?php 
        $creator_ob =  DB::table('users')->where('id', $update->creator_id)->first();
        $receiver1_ob = DB::table('users')->where('id', $update->from_user_id)->first();
        $receiver2_ob = DB::table('users')->where('id', $update->to_user_id)->first();    
        ?>
        <tr>
            <td>{{ $update->task_id }}</td>
            <td>{{ $creator_ob->name }} - id: {{ $update->creator_id }}</td>
            <td>{{ $receiver1_ob->name }} - id: {{ $update->from_user_id }}</td>
            <td>{{ $receiver2_ob->name }} - id: {{ $update->to_user_id }}</td>
            <td>{{ $update->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else 
    <p>No tasks to show</p>
@endif
@endsection