
{!! Form::open(['action' => ['TaskController@show', ':id'], 'method' => 'GET', 'id' => 'formId']) !!}
    <select class="form-control" id="taskList" name="taskList"></select>
    <input type="submit" id="submitButton">
{!! Form::close() !!}

<script>
    var urlLiveTask = "{{ route('live_search.action_task') }}";
    var urlShowTask = "{{ route('task.show', ['id' => ':id']) }}";

$("#taskList").select2({
    theme:  "classic",
    placeholder: "Search for a task",
    allowClear: true,
    ajax: {
        url: urlLiveTask,
        dataType: 'json',
        data: function(params) {
            var query = {
                search: params.term,
                type: 'public'
            }
            return query;
        },
        processResults: function(data) {
            return {
                results: data
            };
        }
    }
}).on('select2:select', function (e) {
    var value = $('.taskList').val();
    var newAction = $('#formId').prop("action").replace(':id', value);
    $('#formId').attr('action', newAction);
    $('#formId').submit();

   $.ajax({
            type: "GET",
            url: urlShowTask,
            dataType: 'html',
        }).done(function(data) {

        });
});

</script>