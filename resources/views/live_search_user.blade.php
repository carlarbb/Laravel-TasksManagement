
<select class="userList form-control" data-id={{$task->id}} name="userList"></select>
<script>
        var urlLive = "{{ route('live_search.action') }}";
        var urlchange = "{{ route('task.change_receiver', ['id_task' => ':id1', 'id_user' => ':id2']) }}"; 

    $(".userList").select2({
        placeholder: "Select user name",
        allowClear: true,
        ajax: {
            url: urlLive,
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
    });

</script>