$(document).ready(function () {
    getComments();
    function getComments()
    {
        $.ajax({
            type: "GET",
            url: "/comments",
            dataType: "json",
            success: function (response) {

                if (response.comments.length > 0) {
                    $('#comments').html("");
                    $.each(response.comments, function (key, item) {
                        $('#comments').append('<div class="comment-wrap">\
                    <button value="'+ item.id +'" class="btn btn-danger btn-sm delete-comment-btn" data-bs-toggle="modal" data-bs-target="#CommentDeleteModal">x</button>\
                            <div class="comment-text">' + item.comment + '</div>\
                            <div class="author-wrap">\
                                <div><b>Author:</b> ' + item.author + '</div>\
                                <div><b>Data: </b>' + new Date(item.updated_at).toLocaleString() + '</div>\
                            </div>\
                        </div>');
                    });
                } else {
                    $('#comments').html("No comments!");
                }
            }
        });
    }

    $(document).on('click', '.add-comment', function (e) {
        e.preventDefault();

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
                    $('#save_msgList').html("").addClass('alert alert-danger');
                    $.each(response.errors, function (key, err_value) {
                        $('#save_msgList').append('<li>' + err_value + '</li>');
                    });
                } else {
                    $('#save_msgList').html("").removeClass('alert alert-danger');
                    $('#success_message').addClass('alert alert-success')
                        .text(response.message).delay(3000).fadeOut(350);
                    $('#addCommentForm').find('input').val('');
                    $('#addCommentForm').find('textarea').val('');
                    getComments();
                }
            }
        });
    });

    $(document).on('click', '.delete-comment-btn', function () {
        let comment_id = $(this).val();
        $('#modal-delete-comment-id').val(comment_id);
    });

    $(document).on('click', '.delete-comment-confirm', function (e) {
        e.preventDefault();

        var id = $('#modal-delete-comment-id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "DELETE",
            url: "/comments/" + id,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 404) {

                } else {
                    $('#CommentDeleteModal').modal('hide');
                    getComments();
                }
            }
        });
    });
});
