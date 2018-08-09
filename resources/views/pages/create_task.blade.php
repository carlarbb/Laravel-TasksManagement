@extends('layouts.app')

@section('content')
    <button id="backButton" onclick="history.go(-1);">Back </button>
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

        @if($_SESSION['proj_set'] == null)
        <div class="form-group">
            {{ Form::label('project_id', 'Project Id:') }}
            {{ Form::select('project_id', $project_ids, '', ['class' => 'form-control']) }}
        </div>
        @endif
        
        <div class="form-group">
            {{ Form::label('status', 'Task Status:') }}
            {{ Form::select('status', $status, '', ['class' => 'form-control']) }}
        </div>
        <div class="form-group">
            {{ Form::label('priority', 'Task Priority:') }}
            {{ Form::select('priority', $priority, '2', ['class' => 'form-control']) }}
            </div>
        <div class="form-group">
            {{ Form::label('due_date', 'Due Date:') }}
            {{ Form::text('due_date', '', ['class' => 'form-control dateInput', 'tabindex' => '-1']) }}
        </div>
        <div>
            {{ Form::label('receiver_id', 'For user:') }}
            {{ Form::select('receiver_id', $user_ids, '', ['class' => 'form-control']) }}
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

