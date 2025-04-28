<div class="post-wrapper">
    @if(Auth::check() && notReader(Auth::user()) && isYourPost(Auth::user(), $post))
        <a class="postED" style="position: absolute; top: 2%; right: 5%; z-index: 999" href="#">
            <i style="font-size: 34px; color:aliceblue" class="fa-solid fa-ellipsis-vertical"></i>
        </a>
        <ul class="postED-container shadow-lg" style="display: none; position: absolute; z-index: 9999; top: 7%; right: 5%; background-color: #fff; padding: 30px 30px; border-radius: 10px;">
            <li style="margin-bottom: 20px; background-color: green; padding: 10px; border-radius: 10px" class="nav-item">
                    <a style="color: #fff; font-weight: 500" href="{{ 'posts.edit', $post->slug }}">Update post</a>
            </li>
            <li style="background-color: red; padding: 10px; border-radius: 10px" class="nav-item">
                <form action="{{ 'posts.delete', $post->slug }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input style="font-weight: 500; background-color: red; border: none; color: #fff" type="submit" value="Delete post">
                </form>
            </li>
        </ul>
    @endif
    <div style="position: relative;">
        <div class="d-flex align-items-center justify-content-center" style="flex-direction: column">
            @if ($post->thumbnail)
                <img src="{{ asset($post->thumbnail) }}" class="card-img-top" alt="{{ $post->title }}">
            @endif
            <form style="margin: auto" action="{{ route('likes.store', $post->slug) }}" method="POST">
                @csrf
                <button
                    class="{{ hasLiked($post) ? 'liked' : '' }}"
                    style="border-radius: 20px; padding: 8px 10px; margin-top: 10px;"
                >
                    <i style="font-size: 30px" class="fa-solid fa-heart"></i>
                </button>
            </form>
        </div>
        <div class="card-body">
            <p style="margin: 0">Published at: {{ $post->published_at }}</p>
            <h2 class="card-title" style="font-weight: 500; color: #000">{{ $post->title }}</h2>
        </div>
        <div class="card-footer d-flex justify-content-between align-items-center bg-white border-0">
            <div class="social_icon d-flex gap-2" style="padding: 20px 0">
                <a href="#"><img src="images/fb-icon.png" width="28" height="28" /></a>
                <a href="#"><img src="images/twitter-icon.png" width="28" height="28" /></a>
                <a href="#"><img src="images/instagram-icon.png" width="28" height="28" /></a>
            </div>
            <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill">Read More</a>
        </div>
    </div>
</div>