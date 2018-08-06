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

    $(".dateInput").datepicker({
        changeMonth: true,
        changeYear: true,
        autoClose: true,
        dateFormat: 'yy-mm-dd',
    });

    function fetch_users(query = '') {
        $.ajax({
            url: urlLive,
            method: 'GET',
            data: { query: query },
            dataType: 'json'
        }).done(function(data) {
            alert(data.text);
            $('.forwardMenu').html(data.text);
        });
    }

    $(document).on('keyup', '#search', function() {
        var query = $(this).val();
        fetch_users(query);
    });
});