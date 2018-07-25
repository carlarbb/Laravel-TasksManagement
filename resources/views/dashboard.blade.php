@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                   <div>
                        <h2>Created projects</h2>
                        <hr>
                        <a class="btn btn-primary btn-lg" href="{{ route('project.create') }}" role="button">Add new project</a>
                        <br>
                        @if(count($myProjects) >0)
                            <table class="table table striped">
                                <tr>
                                    <th>Title</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                @foreach($myProjects as $proj)
                                    <tr>
                                        <td>{{ $proj->title }}</td>
                                        <td><a class="btn btn-primary btn-sm" href="{{ route('project.edit', $proj->id) }}" role="button">Edit</a></td> 
                                        <td>
                                            {!! Form::open(['action' => ['ProjectController@destroy', $proj->id], 'method' => 'POST']) !!}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                {{ Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) }}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                 @endforeach
                            </table>
                        @else
                            <p>You have no projects</p>
                        @endif
                   </div>
                   
                    <br><br>
                    <div>
                        <h2>Created tasks</h2>
                        <hr>
                        <a class="btn btn-primary btn-lg" href="{{ route('task.create') }}" role="button">Add new task</a>
                        <br>
                        @if(count($myTasks) > 0)
                            <table class="table table striped">
                                <tr>
                                    <th>Title</th>
                                    <th>Info</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                @foreach($myTasks as $task)
                                    <tr>
                                        <td>{{ $task->title }}</td>
                                        <td><a class="btn btn-primary btn-sm" href="{{ route('task.show', $task->id) }}" role="button">Info</a></td>
                                        <td><a class="btn btn-primary btn-sm" href="{{ route('task.edit', $task->id) }}" role="button">Edit</a></td> 
                                        <td>
                                            {!! Form::open(['action' => ['TaskController@destroy', $task->id], 'method' => 'POST']) !!}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                {{ Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) }}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <p>You have no tasks</p>
                        @endif
                    </div>

                    <div>
                        <h2>To do tasks</h2>
                        <hr>
                        {!! Form::model(['route' => ['task.filter', 'dasdasda'], 'method' => 'POST']) !!}
                            <h3>Sort tasks by: </h3>
                            <label class="checkbox-inline"><input type="radio" name="radsort" value="1">Due date</label>
                            <label class="checkbox-inline"><input type="radio" name="radsort" value="2">Priority level</label>
                            <label class="checkbox-inline"><input type="radio" name="radsort" value="3">Project id</label>
                            <label class="checkbox-inline"><input type="radio" name="radsort" value="4">All</label>
                            <br>
                            {{ Form::hidden('_method', 'PUT') }}
                            {{ Form::submit('Sort') }}
                        {!! Form::close() !!}

                        @if(count($myTasks) > 0)
                            <table class="table table striped">
                                <tr>
                                    <th>Title</th>
                                    <th>Info</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                @foreach($myTasks as $task)
                                    <tr>
                                        <td>{{ $task->title }}</td>
                                        <td><a class="btn btn-primary btn-sm" href="{{ route('task.show', $task->id) }}" role="button">Info</a></td>
                                        <td><a class="btn btn-primary btn-sm" href="{{ route('task.edit', $task->id) }}" role="button">Edit</a></td> 
                                        <td>
                                            {!! Form::open(['action' => ['TaskController@destroy', $task->id], 'method' => 'POST']) !!}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                {{ Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) }}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <p>You have no tasks</p>
                        @endif
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection