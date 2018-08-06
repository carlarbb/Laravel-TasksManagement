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

});


$(".dateInput").datepicker({
    changeMonth: true,
    changeYear: true,
    autoClose: true,
    dateFormat: 'yy-mm-dd',
});


$("#userList").select2({
    placeholder: "Select user name",
    allowClear: true,
    ajax: {
        url:urlLive,
        dataType: 'json',
        data: function(params){
            var query= {
                search: params.term,
                type: 'public'
            }
            return query;
        },
        processResults: function(data){
            return{
                results:data
            };
        }
     }
});