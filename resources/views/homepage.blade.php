@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Comments page</h1>
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
        <form>
            <div class="mb-3">
                <label for="nameField" class="form-label">Name</label>
                <input type="text" class="form-control" id="nameField" placeholder="enter you name">
            </div>
            <div class="mb-3">
                <label for="textareaField" class="form-label">Comment</label>
                <textarea class="form-control" id="textareaField" rows="3" placeholder="enter you comment"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <hr>
        <div class="comments-wrap">

        </div>
    </div>
@endsection
