@extends('layouts.app')

@section('content')
<h1 class="text-center p-5">Dashboard</h1>
<div class="row" id="search_for_task">
    @include('live_search_task');
</div>
<div class="row">
    <div class="col-md-6">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="card">
            <h2 class="card-header text-center">Created projects</h2>
            <div class="card-body">
                <a class="btn btn-primary btn-lg" href="{{ route('project.create') }}" role="button">Add new project</a>
                <br>
                @if(count($myProjects) >0)
                    <table class="table table striped">
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>No. of tasks</th>
                            <th></th>
                            <th></th>
                        </tr>
                        @foreach($myProjects as $proj)
                            <tr class="projRow" data-toggle="modal" data-target="#myModal">
                                <td class="projId">{{ $proj->id }}</td>
                                <td>{{ $proj->title }}</td>
                                <td>
                                    {{ App\Http\Controllers\ProjectController::count_tasks($proj->id) }}
                                </td>
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
        </div>        
    </div>   

    <!--Modal for project info at click-->
    <div class="modal fade" id="myModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Project Info</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6"> 
        <div class="card">
            <h2 class="card-header text-center">Created tasks</h2>
            <div class="card-body scrolladd1">
                <a class="btn btn-primary btn-lg" href="{{ route('task.create') }}?proj_set=".null role="button">Add new task</a>
                <br>
                @if(count($myTasks) > 0)
                    <table class="table table striped">
                        <tr>
                            <th>Title</th>
                            <th>Info</th>
                            <th></th>
                            <th></th>
                            <th>Completed</th>
                            <th>Forward to</th>
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
                                <td> 
                                    @if($task->completed)
                                        Yes
                                    @else
                                        No
                                    @endif
                                </td>
                                <td>
                                    @include('live_search_user')
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

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h2 class="card-header text-center">To do tasks</h2>
            <div class="card-body scrolladd1">
                @if(count($tasksForMe)>0)
                    {!! Form::open(['action' => 'TaskController@filter', 'method' => 'POST', 'id' => 'form']) !!}
                        <h3>Sort tasks by: </h3>
                        <label class="checkbox-inline"><input type="radio" name="radsort" value="1">Due date</label>
                        <label class="checkbox-inline"><input type="radio" name="radsort" value="2">Priority level</label>
                        <label class="checkbox-inline"><input type="radio" name="radsort" value="3">Project id</label>
                        <label class="checkbox-inline"><input type="radio" name="radsort" value="4">All</label>
                        <br>
                        {{ Form::submit('Sort') }}
                    {!! Form::close() !!}
                    
                    @if(session('sorted')) 
                    <?php $tasks = session('sorted'); ?>
                    @else
                        <?php $tasks=$tasksForMe ?>
                    @endif
                    <table class="table table striped">
                        <tr>
                            <th>Title</th>
                            <th>Due date</th>
                            <th>Priority level</th>
                            <th>Project title</th>
                            <th>Project id</th>
                            <th></th>
                            <th></th>
                            <th>Forward to</th>

                        </tr>
                        @if($tasks == null)
                            <td> No to-do tasks </td>
                        @endif
                        @foreach($tasks as $task)
                        
                            {{-- @if($task->due_date >= Carbon\Carbon::now()->toDateTimeString())  --}}
                            @if(!$task->completed)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->due_date }}</td>
                                <?php $pr = Config::get('priority'); ?> 
                                <td>{{ $pr[$task->priority_level] }}</td>
                                <?php $proj = App\Project::find($task->project_id); ?>
                                <td>{{ $proj->title }}</td>
                                <td>{{ $task->project_id }}</td>
                                <td><a class="btn btn-primary btn-sm" href="{{ route('task.show', $task->id) }}" role="button">Details</a></td>
                                <td><a class="btn btn-primary btn-sm" href="{{ route('task.edit', $task->id) }}" role="button">Edit</a></td> 
                                <td>
                                    @include('live_search_user')
                                </td>
                            </tr>
                            @endif 
                        @endforeach
                    </table>
                @else
                    <p>No to-do tasks</p>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
