@foreach($posts as $post)
    <h1>{{$post->title}}</h1>
    <p>$post->description</p>
@endforeach
