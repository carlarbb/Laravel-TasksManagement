@extends('layouts.app')

@section('content') 
    <h1 class="pt-3 pb-3">Edit task</h1>
    <!-- store e functia care se apeleaza la submit -->
    {{-- enctype pt incarcare de fisiere --}}
    {!! Form::open(['action' => ['TaskController@update', $task->id], 'method' => 'POST', 'class' => 'mt-5 mb-5']) !!} 
        <div class="form-group">
            {{ Form::label('title', 'Title:') }}
            {{ Form::text('title', $task->title, ['class' => 'form-control', 'readonly' => $readonly, 'placeholder' => 'Task title']) }}
        </div> 
        <div class="form-group">
            {{ Form::label('body', 'Body:') }}
            {{ Form::textarea('body', $task->content, ['id' => 'article-ckeditor', 'class' => 'form-control', 'readonly' => $readonly, 'placeholder' => 'Insert content']) }}
        </div> 
        <div class="form-group">
            {{ Form::label('project_id', 'Project Id:') }}
            {{ Form::select('project_id', $project_ids, $task->project_id, ['class' => 'form-control', 'disabled' => $readonly]) }}
        </div>
        <div class="form-group">
            {{ Form::label('status', 'Task Status:') }}
            {{ Form::select('status', $status, $task->status, ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('priority', 'Task Priority:') }}
            {{ Form::select('priority', $priority, $task->priority_level, ['class' => 'form-control', 'disabled' => $readonly]) }}
            </div>
        <div class="form-group">
            {{ Form::label('due_date', 'Due Date:') }}
            {{ Form::date('due_date', $task->due_date, ['class' => 'form-control', 'id' => 'date', 'readonly' => $readonly]) }}
        </div>
        <div>
            {{ Form::label('receiver_id', 'For user:') }}
            {{ Form::select('receiver_id', $user_ids, $task->receiver_id, ['class' => 'form-control']) }}
        </div>
        {{ Form::hidden('_method', 'PUT') }}
        {{ Form::submit('Save', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!}  
@endsection

