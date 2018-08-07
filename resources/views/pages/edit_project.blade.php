@extends('layouts.app')

 @section('content')
    <h1>Edit project</h1>
    {!! Form::open(['action' => ['ProjectController@update', $project->id], 'method' => 'POST']) !!} 
        <div class="form-group">
            {{ Form::label('title', 'Title') }}
            {{ Form::text('title', $project->title, ['class' => 'form-control']) }}
        </div> 
        <div class="form-group">
                {{ Form::label('description', 'Short description') }}
                {{ Form::textarea('description', $project->description, ['id' => 'article-ckeditor', 'class' => 'form-control']) }}
        </div> 
        <!-- put for calling update function on submit -->
        {{ Form::hidden('_method', 'PUT') }}
        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!} 

    @section('page_scripts')
        <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script> 
        <script>
            CKEDITOR.replace( 'article-ckeditor' );
        </script>
    @endsection
@endsection 