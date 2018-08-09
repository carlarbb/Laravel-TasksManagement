$(document).ready(function() {
    $(".projRow").click(function() {
        var proj_id = $(this).find(".projId").text();
        //find method gets a descendent with class="projId"
        //retrieves the text within id td
        // $("#test").html(proj_id);

        $.ajax({
            type: "GET",
            url: './show_project',
            dataType: "html", //expect html to be returned        
            data: { proj_id: proj_id },
            success: function(response) {
                $("#modalBody").html(response);
            }
        });
    });

    $(".userList").change(function() {
        var val = this.value;
        var task_id = $(this).data('id');
        urlchange = urlchange.replace(':id1', task_id);
        urlchange = urlchange.replace(':id2', val);
        $.ajax({
            type: "GET",
            url: urlchange,
            dataType: 'html',
            data: {
                id_task: task_id,
                id_user: val
            },
        }).done(function(data) {
            window.location.reload(true);

        });
    });
});


$(".dateInput").datepicker({
    changeMonth: true,
    changeYear: true,
    autoClose: true,
    dateFormat: 'yy-mm-dd',
});