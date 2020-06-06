<form action="{{route('posts.update', ['post' => $post])}}">
    @method('put')
    @csrf
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
