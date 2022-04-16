@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="modal fade" id="CommentDeleteModal" tabindex="-1" aria-labelledby="CommentDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Delete comment?</p>
                        <input type="hidden" id="modal-delete-comment-id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger delete-comment-confirm">DELETE</button>
                    </div>
                </div>
            </div>
        </div>


{{--        костыль на время разработки удалять комменты--}}
        @if(Auth::user())
            <style>
                .delete-comment-btn {
                    display: inline-block;
                    text-align: right;
                }
            </style>
        @else
            <style>
                .delete-comment-btn {
                    display: none;
                }
            </style>
        @endif


        <h1>Comments page</h1>
        <div id="success_message"></div>
        <div>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla id suscipit purus. Quisque luctus at magna
            ut consequat. In finibus dapibus enim nec ornare. Morbi in purus facilisis, rutrum urna sit amet, ultricies
            felis. Sed vel odio mauris. Donec vel nisi ut turpis dictum iaculis sit amet sed nunc. Nam vulputate nec
            quam eget tempor. Curabitur id rhoncus leo, quis lobortis diam. Phasellus at diam sit amet dolor venenatis
            eleifend. Phasellus quis erat sagittis, lobortis mi non, volutpat eros. Fusce nec molestie metus, ut maximus
            lorem. Sed maximus neque sapien, et bibendum diam dictum eget. Etiam cursus nec ex eget varius.

            Praesent nisl nulla, porta ut vulputate sodales, feugiat vel magna. Orci varius natoque penatibus et magnis
            dis parturient montes, nascetur ridiculus mus. Quisque sollicitudin nunc sed ullamcorper placerat. Maecenas
            vel neque ligula. Nullam ut tellus mauris. Donec a sem nec turpis efficitur pretium ut a lorem. In dignissim
            mauris nec laoreet consectetur.
        </div>
        <hr>
        <h3>Comments</h3>
        <form action="{{ route("comments.store") }}" method="POST" id="addCommentForm">
            @csrf
            <ul id="save_msgList"></ul>
            <div class="mb-3">
                <label for="nameField" class="form-label">Author</label>
                <input type="text" name="author" class="form-control author" id="nameField" placeholder="enter you name">
            </div>
            <div class="mb-3">
                <label for="textareaField" class="form-label">Comment</label>
                <textarea name="comment" class="form-control comment" id="textareaField" rows="3" placeholder="enter you comment"></textarea>
            </div>
            <button type="submit" class="btn btn-primary add-comment">Submit</button>
        </form>
        <hr>
        <div class="comments-main-wrap" id="comments">

        </div>
    </div>
@endsection
