<table class="table">
    <tbody>
        <tr>
            <th>Id</th>
            <td>{{ $project->id }}</td>
        </tr>
        <tr>
            <th>Title</th>
            <td>{{ $project->title }}</td>
        </tr>
        <tr>
            <th>Task list</th>
            <td>
                {{-- cand se adauga un task din modal, trimit un parametru GET project_set=1, pt a nu mai afisa
                     select de project_id in pagina create_task --}}
                     
                <a class="btn btn-primary btn-lg" href="{{ route('task.create') }}?proj_set={{ $project->id }}" role="button">Add new task</a>
                <ul class="list-group scrolladd2">
                    @foreach($proj_tasks as $task)
                        <li class="list-group-item">{{ $task->title }}
                            <a class="btn btn-primary btn-sm d-inline float-right" href="{{ route('task.edit', $task->id) }}" role="button">Edit</a> 
                            {!! Form::open(['action' => ['TaskController@destroy', $task->id], 'class' => 'd-inline float-right', 'method' => 'POST']) !!}
                                {{ Form::hidden('_method', 'DELETE') }}
                                {{ Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) }}
                            {!! Form::close() !!}
                        </li>
                    @endforeach
                </ul>
             </td>
        </tr>
    </tbody>
</table>