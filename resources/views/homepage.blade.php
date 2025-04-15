@extends('app')

@section('title', 'Homepage')

@section('content')
    <!-- banner section start --> 
    <div class="container-fluid">
        <div class="banner_section d-flex justify-content-center align-items-center home-banner">
            <h1 class="banner_taital" style="">welcome <br>our blog</h1>
        </div>
    </div>
    <!-- banner section end --> 

    <div class="container">
        <h1 style="font-weight: bold; font-size: 40px; margin-bottom: 40px">Most views posts</h1>
        @foreach ($posts as $post)
            @if ($post == $posts->first())
                <div class="row" style="margin-bottom: 40px">
                    <div class="col-lg-7 col-sm-12" style="display: flex; justify-content: center; flex-direction: column">
                        <div class="about_img"><img src="{{ $post->medias()->first()->file_path }}"></div>
                        <form style="margin: auto" action="{{ route('likes.store', $post->slug) }}" method="POST">
                            @csrf
                            @php 
                                $hasLiked =  \App\Models\Like::where('post_id', $post->id) 
                                    ->where('user_id', Auth::id())->exists();
                            @endphp
                            <button
                                class="{{ $hasLiked ? 'liked' : '' }}"
                                style="border-radius: 20px; padding: 8px 10px; margin-top: 10px;"
                            >
                                <i style="font-size: 30px" class="fa-solid fa-heart"></i>
                            </button>
                        </form>
                        <div>
                            <p class="post_text">Post By: {{ $post->published_at }}</p>
                            <h2 class="most_text">{{ $post->title }}</h2>
                            
                            <p class="lorem_text">{{ Str::limit($post->content, 200, '...') }}</p>
                            <div class="social_icon_main">
                                <div class="social_icon">
                                    <ul>
                                        <li><a href="#"><img src="images/fb-icon.png"></a></li>
                                        <li><a href="#"><img src="images/twitter-icon.png"></a></li>
                                        <li><a href="#"><img src="images/instagram-icon.png"></a></li>
                                    </ul>
                                </div>
                                <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-outline-primary" style="padding: 20px; margin-right: 30px">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="newsletter_main">
                            <h1 class="recent_taital">Recent post</h1>
                            <div class="recent_box">
                                <div class="recent_left">
                                    <div class="image_6"><img src="images/img-6.png"></div>
                                </div>
                                <div class="recent_right">
                                    <h3 class="consectetur_text">Consectetur adipiscing</h3>
                                    <p class="dolor_text">ipsum dolor sit amet, consectetur adipiscing </p>
                                </div>
                            </div>
                            <div class="recent_box">
                                <div class="recent_left">
                                    <div class="image_6"><img src="images/img-7.png"></div>
                                </div>
                                <div class="recent_right">
                                    <h3 class="consectetur_text">Consectetur adipiscing</h3>
                                    <p class="dolor_text">ipsum dolor sit amet, consectetur adipiscing </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row" style="margin-bottom: 40px">
                    <div class="col-lg-7 col-sm-12" style="display: flex; justify-content: center; flex-direction: column">
                        <div class="about_img"><img src="{{ $post->medias()->first()->file_path }}"></div>
                        <form style="margin: auto" action="{{ route('likes.store', $post->slug) }}" method="POST">
                            @csrf
                            @php 
                                $hasLiked =  \App\Models\Like::where('post_id', $post->id) 
                                    ->where('user_id', Auth::id())->exists();
                            @endphp
                            <button
                                class="{{ $hasLiked ? 'liked' : '' }}"
                                style="border-radius: 20px; padding: 8px 10px; margin-top: 10px;"
                            >
                                <i style="font-size: 30px" class="fa-solid fa-heart"></i>
                            </button>
                        </form>
                        <div>
                            <p class="post_text">Post By : {{ $post->published_at }}</p>
                            <h2 class="most_text">{{ $post->title }}</h2>
                            
                            <p class="lorem_text">{{ Str::limit($post->content, 200, '...') }}</p>
                            <div class="social_icon_main">
                                <div class="social_icon">
                                    <ul>
                                        <li><a href="#"><img src="images/fb-icon.png"></a></li>
                                        <li><a href="#"><img src="images/twitter-icon.png"></a></li>
                                        <li><a href="#"><img src="images/instagram-icon.png"></a></li>
                                    </ul>
                                </div>
                                <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-outline-primary" style="padding: 20px; margin-right: 30px">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    
    <!-- tag section start -->
    <div class="tag_section layout_padding">
        <div class="container">
            <h1 class="tag_taital">Tag</h1>
            <div class="tag_bt">
                <ul>
                    <li class="active"><a href="#">Ectetur</a></li>
                    <li><a href="#">Onsectetur</a></li>
                    <li><a href="#">Consectetur</a></li>
                    <li><a href="#">Consectetur</a></li>
                    <li><a href="#">Consectetur</a></li>
                </ul>
            </div>
            <div class="tag_bt_2">
                <ul>
                    <li><a href="#">Tetur</a></li>
                    <li><a href="#">Conse</a></li>
                    <li><a href="#">Nsectetur</a></li>
                    <li><a href="#">Sectetur</a></li>
                    <li><a href="#">Consectetur</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- tag section end -->
    <!-- contact section start -->
    <div class="contact_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active" style="text-indent: 0; border: none; color: #000; font-size: 18px; text-align: center;">1</li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"style="text-indent: 0; border: none; color: #000; font-size: 18px; text-align: center;">2</li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"style="text-indent: 0; border: none; color: #000; font-size: 18px; text-align: center;">3</li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="3"style="text-indent: 0; border: none; color: #000; font-size: 18px; text-align: center;">4</li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="contact_img"></div>
                            </div>
                            <div class="carousel-item">
                                <div class="contact_img"></div>
                            </div>
                            <div class="carousel-item">
                                <div class="contact_img"></div>
                            </div>
                            <div class="carousel-item">
                                <div class="contact_img"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mail_section">
                        <h1 class="contact_taital">Contact us</h1>
                        <input type="" class="email_text" placeholder="Name" name="Name">
                        <input type="" class="email_text" placeholder="Phone" name="Phone">
                        <input type="" class="email_text" placeholder="Email" name="Email">
                        <textarea class="massage_text" placeholder="Message" rows="5" id="comment" name="Message"></textarea>
                        <div class="send_bt"><a href="#">send</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact section end -->
    
    <!-- copyright section start -->
    <div class="copyright_section">
        <div class="container">
            <p class="copyright_text">Copyright 2020 All Right Reserved By.<a href="https://html.design"> Free  html Templates</a></p>
        </div>
    </div>
    <!-- copyright section end -->
@endsection