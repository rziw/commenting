<a href="{{route('posts.show', ['post' => $post])}}">Back to post</a>
<form action="{{route('posts.update', ['post' => $post])}}" method="post">
    @method('put')
    @csrf
    <input type="hidden" name="category_id" value="{{$post->category->id}}">
    <div>
        title : <input type="text" name="title" value="{{$post->title}}">
    </div>

    <div>
        description : <input type="text" name="description" value="{{$post->description}}">
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
