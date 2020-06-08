<form method="post" action="{{route('posts.store')}}">
    @csrf
    @method('pots')
    <div>
        Title : <input type="text" name="title">
    </div>
    <div>
        Description : <textarea name="description"></textarea>
    </div>
    <div>
        <input type="submit" value="submit">
    </div>
</form>
