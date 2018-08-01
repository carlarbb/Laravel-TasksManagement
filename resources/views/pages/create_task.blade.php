@extends('layouts.app')

@section('content')
    <h1 class="pt-3 pb-3">Create new task</h1>
    <!-- store e functia care se apeleaza la submit -->
    {{-- enctype pt incarcare de fisiere --}}
    {!! Form::open(['action' => 'TaskController@store', 'method' => 'POST', 'class' => 'mt-5 mb-5']) !!} 
        <div class="form-group">
            {{ Form::label('title', 'Title:') }}
            {{ Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Task title']) }}
        </div> 
        <div class="form-group">
            {{ Form::label('body', 'Body:') }}
            {{ Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Insert content']) }}
        </div> 

      
        <div class="form-group">
            {{ Form::label('project_id', 'Project Id:') }}
            {{ Form::select('project_id', $project_ids, '', ['class' => 'form-control']) }}
        </div>
       

        <div class="form-group">
            {{ Form::label('status', 'Task Status:') }}
            {{ Form::select('status', $status, '', ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('priority', 'Task Priority:') }}
            {{ Form::select('priority', $priority, '', ['class' => 'form-control']) }}
            </div>
        <div class="form-group">
            {{ Form::label('due_date', 'Due Date:') }}
            {{ Form::date('due_date', '', ['class' => 'form-control', 'id' => 'date']) }}
        </div>
        <div>
            {{ Form::label('receiver_id', 'For user:') }}
            {{ Form::select('receiver_id', $user_ids, '', ['class' => 'form-control']) }}
        </div>
        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!}  
@endsection

