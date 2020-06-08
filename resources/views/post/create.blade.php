<form method="post" action="{{route('posts.store')}}">
    @csrf
    @method('post')
    <div>
        <select name="category_id" id="categories">
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->title}}</option>
            @endforeach
        </select>
    </div>
    <div>
        Title : <input type="text" name="title">
    </div>
    <div>
        Description : <textarea name="description"></textarea>
    </div>
    <div>
        <input type="submit" value="submit">
    </div>

    <div>
        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif
    </div>
</form>
