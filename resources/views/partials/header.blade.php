<div class="header_section">
    <div class="container-fluid header_main">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="logo" href="{{ route('app') }}"><img src="{{ asset('/images/logo.png') }}"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul style="display: flex; align-items: center" class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('posts.index') }}">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact Us</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('user.like', Auth::id()) }}" class="nav-link">Favorite Posts</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.show', Auth::id()) }}" class="nav-link">
                                <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href={{ route('getRegister') }}>Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href={{ route('getLogin') }}>Login</a>
                        </li>
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link" href="#"><img src="{{ asset('/images/serach-icon.png') }}"></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>