<div>
    <h1>{{$post->title}}</h1>
    <p>{{$post->description}}</p>
</div>
<div>
    @foreach($post->comments as $comment)
        <div>
            {{$comment->description}}
        </div>
    @endforeach
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
