$(document).ready(function() {
    var $result = $('#search_box-result');

    $('#search').on('keyup', function(){
        var search = $(this).val();
        if ((search != '') && (search.length > 2)){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "/ajax-search",
                data: {'search': search},
                success: function(response){
                    $result.html(response.html);
                    if(response.html != ''){
                        $result.fadeIn();
                    } else {
                        $result.fadeOut(100);
                    }
                }
            });
        } else {
            $result.html('');
            $result.fadeOut(100);
        }
    });

    $(document).on('click', function(e){
        if (!$(e.target).closest('.search_box').length){
            $result.html('');
            $result.fadeOut(100);
        }
    });

    $(document).on('click', '.search_result-name a', function(){
        $('#search').val($(this).text());
        $result.fadeOut(100);
        return false;
    });

    $(document).on('click', '#searchSubmit', function (e) {
        e.preventDefault();

        var data = {
            'search': $('#search').val(),
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/search",
            data: data,
            dataType: "json",
            success: function (response) {
                // console.log(response.html);
                if (response.status == 400) {
                    console.log("test error");

                } else {
                    $('#comments').html("");
                    $('#comments').append(response.html);
                    $('#search_form').find('input').val('');
                    $('#search_box-result').fadeOut(100);
                    $('#searchSubmit').val('submit');
                    $('#load-more').hide();
                    $('.clear-filter').removeClass("d-none");
                }
            }
        });
    });


});
