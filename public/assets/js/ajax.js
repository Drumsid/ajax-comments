$(document).ready(function () {

    var paginate = 1;
    loadMoreData(paginate);

    $('#load-more').click(function() {
        let page = $(this).data('paginate');
        loadMoreData(page);
        $(this).data('paginate', page + 1);
    });

    function refreshPaginate() {
        $("#load-more").data('paginate', 2);
        $('#comments').html("");
        loadMoreData(1);
    }

    function loadMoreData(paginate) {
        $.ajax({
            url: '/comments/?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#load-more').text('Loading...');
            }
        })
            .done(function(data) {
                $('.commentsCount').html("All comments: " + data.allCommentsCount); // тестирую чтоб понимать сколько всего в бд
                if(data.count < 3) {
                    $('.no-more-comments').removeClass('invisible');
                    $('#load-more').hide();
                } else {
                    $('.no-more-comments').addClass('invisible');
                    $('#load-more').show().text('Load more...');
                }
                $('#comments').append(data.html);
            })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Something went wrong.');
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

                    refreshPaginate();
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
                if (response.status == 404) {

                } else {
                    $('#CommentDeleteModal').modal('hide');

                    refreshPaginate();

                }
            }
        });
    });
});
