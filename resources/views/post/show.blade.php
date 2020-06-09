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
