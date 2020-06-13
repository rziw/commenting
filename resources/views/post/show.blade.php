<div>
    <h1>{{$post->title}}</h1>
    <p>{{$post->description}}</p>
    @can('update', $post)
        <a href="{{route('posts.edit', ['post' => $post])}}">edit</a>
    @endcan
</div>
<div>
    @foreach($post->comments as $comment)
        @can('update', $comment)
            <div>
                <form action="{{route('comment.update', ['post' => $post, 'comment' => $comment])}}" method="post">
                    @method('put')
                    @csrf
                    <div>
                        <textarea name="description">{!! $comment->description !!}</textarea>
                    </div>
                    <button type="submit">update</button>
                </form>

                <form action="{{route('comment.delete', ['post' => $post, 'comment' => $comment])}}" method="post">
                    @method('delete')
                    @csrf
                    <button type="submit">delete</button>
                </form>
            </div>
        @else
            <div>
                {{$comment->description}}
            </div>
        @endcan
    @endforeach
</div>
<div>
    Please Log in to leave a response
</div>
@if(auth()->check())
    <div>
        <h1>Write a comment</h1>
        <form method="post" action="{{route('comment.store', ['post' => $post])}}">
            @method('post')
            @csrf
            <div>
                description<textarea name="description"></textarea>
            </div>
            <div>
                <input type="submit" name="submit" value="submit">
            </div>
        </form>
        <div class="show-errors">
            @if($errors->any())
                {{ implode('', $errors->all(':message')) }}
            @endif
        </div>
    </div>
@endif
