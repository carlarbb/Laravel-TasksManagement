@extends('layouts.app')

 @section('content')
    <h1>Edit task</h1>
    {!! Form::open(['action' => ['TaskController@update', $task->id], 'method' => 'POST']) !!} 
        <div class="form-group">
            {{ Form::label('title', 'Title') }}
            {{ Form::text('title', $task->title, ['class' => 'form-control']) }}
        </div> 
        <div class="form-group">
                {{ Form::label('body', 'Body') }}
                {{ Form::textarea('body', $task->content, ['id' => 'article-ckeditor', 'class' => 'form-control']) }}
        </div> 
        <!-- put for calling update function on submit -->
        {{ Form::hidden('_method', 'PUT') }}
        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!} 
@endsection 