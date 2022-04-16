$(document).ready(function () {
    getComments();
    function getComments() {
        $.ajax({
            type: "GET",
            url: "/comments",
            dataType: "json",
            success: function (response) {
                let lengthComments = response.comments.length;
                if (lengthComments > 0) {
                    $('#comments').html("");
                    $('.commentsCount').html("Comments count: " + lengthComments);

                    $.each(response.comments, function (key, item) {
                        if (key <= 2) {
                            key = "d-block";
                        } else {
                            key = "d-none";
                        }
                        $('#comments').append('<div class="comment-wrap ' + key + '">\
                            <button value="'+ item.id +'" class="btn btn-danger btn-sm delete-comment-btn" data-bs-toggle="modal" data-bs-target="#CommentDeleteModal">x</button>\
                            <div class="comment-text">' + item.comment + '</div>\
                            <div class="author-wrap">\
                                <div><b>Author:</b> ' + item.author + '</div>\
                                <div><b>Data: </b>' + new Date(item.updated_at).toLocaleString() + '</div>\
                            </div>\
                        </div>');
                    });

                    if (lengthComments > 3) {
                        $("#loadMore").text("Load more").removeClass("d-none").removeClass("noContent");
                    } else {
                        $("#loadMore").addClass('d-none');
                    }
                } else {
                    $('#comments').html("No comments!");
                    $('.commentsCount').html("");
                    $("#loadMore").addClass('d-none');
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


    $(document).on('click', '#loadMore', function (e){
        e.preventDefault();
        $(".comment-wrap:hidden").slice(0, 3).removeClass("d-none").slideDown();
        if($(".comment-wrap:hidden").length == 0) {
            $("#loadMore").addClass('d-none');
        }
    });
});
