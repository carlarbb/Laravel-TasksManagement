@extends('layouts.app')

 @section('content')
 <button id="backButton" onclick="history.go(-1);">Back </button>
 <table class="table table-dark mt-5">
    <thead>TASK DETAILS</thead>
    <tbody>
        <tr>
            <th scope="row">Id</th>
            <td>{{ $task->id }}</td>
        </tr>
        <tr>
            <th scope="row">Title</th>
            <td>{{ $task->title }}</td>
        </tr>
        <tr>
            <th scope="row">Due date</th>
            <td>{{ $task->due_date }}</td>
        </tr>
        <tr>
            <th scope="row">Status</th>
            <?php $st = Config::get('status'); ?>
            <td>{{ $st[$task->status] }}</td>
        </tr>
        <tr>
            <th scope="row">Priority level</th>
            <?php $pr = Config::get('priority'); ?> 
            <td>{{ $pr[$task->priority_level] }}</td>
        </tr>
        <tr>
            <th scope="row">Body</th>
            <td>{!! $task->content !!}</td>
        </tr>
        <tr>
            <th scope="row">From project</th>
            <td>{{ $project->title }}</td>
        </tr>
        <tr>
            <th scope="row">Created by user</th>
            <td>{{ $uname }}-with id {{ $task->created_by_id }}</td>
        </tr>
        <tr>
            <th scope="row">For user</th>
            <td>{{ $rname }}-with id {{ $task->receiver_id }}</td>
        </tr>
    </tbody>
  </table>
@endsection 