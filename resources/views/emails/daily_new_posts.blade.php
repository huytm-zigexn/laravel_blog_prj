<h1>Today's new posts</h1>

<ul>
@foreach ($posts as $post)
    <li><a href="{{ url('/posts/' . $post->slug) }}">{{ $post->title }}</a></li>
@endforeach
</ul>

<p>Have a good day!</p>
