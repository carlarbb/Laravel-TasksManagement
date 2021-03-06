@extends('layouts.app')

 @section('content')
    <button id="backButton" onclick="history.go(-1);">Back </button>
    <h1>Create new project</h1>
    <!-- store e functia care se apeleaza la submit -->
    {{-- enctype pt incarcare de fisiere --}}
    {!! Form::open(['action' => 'ProjectController@store', 'method' => 'POST']) !!} 
        <div class="form-group">
            {{ Form::label('title', 'Title') }}
            {{ Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Project title']) }}
        </div> 
        <div class="form-group">
                {{ Form::label('description', 'Short description') }}
                {{ Form::textarea('description', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Description']) }}
        </div> 
        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!} 

    @section('page_scripts')
        <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script> 
        <script>
            CKEDITOR.replace( 'article-ckeditor' );
        </script>
    @endsection
@endsection 