<a href="{{route('posts.create')}}">Create new post</a>
<table>
    @foreach($posts as $post)
        <tr>
            <th>{{$post->title}}</th>
            <td>{{$post->description}}</td>
        </tr>
    @endforeach
</table>

