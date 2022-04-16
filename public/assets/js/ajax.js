$(document).ready(function () {
    getComments();
    function getComments()
    {
        $.ajax({
            type: "GET",
            url: "/comments",
            dataType: "json",
            success: function (response) {
                $('#comments').html("");
                $.each(response.comments, function (key, item) {
                    $('#comments').append('<div class="comment-wrap">\
                            <div class="comment-text">' + item.comment + '</div>\
                            <div class="author-wrap">\
                                <div><b>Author:</b> ' + item.author + '</div>\
                                <div style="min-width: 180px"><b>Data: </b>' + item.updated_at + '</div>\
                            </div>\
                        </div>');
                });
            }
        });
    }

    $(document).on('click', '.add-comment', function (e) {
        e.preventDefault();
        // $(this).text('Sending..');
        var data = {
            'author': $('.author').val(),
            'comment': $('.comment').val(),
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/comments",
            data: data,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 400) {
                    $('#save_msgList').html("");
                    $('#save_msgList').addClass('alert alert-danger');
                    $.each(response.errors, function (key, err_value) {
                        $('#save_msgList').append('<li>' + err_value + '</li>');
                    });
                } else {
                    $('#save_msgList').html("");
                    $('#save_msgList').removeClass('alert alert-danger');
                    $('#success_message').addClass('alert alert-success');
                    $('#success_message').text(response.message);
                    $('#addCommentForm').find('input').val('');
                    $('#addCommentForm').find('textarea').val('');
                    getComments();
                }
            }
        });
    });
});
