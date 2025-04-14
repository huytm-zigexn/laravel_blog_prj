<div class="header_section">
    <div class="container-fluid header_main">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="logo" href="{{ route('app') }}"><img src="../images/logo.png"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
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
                            <form action={{ route('logout') }} method="POST">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link" style="border: none; margin-top: 3px">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href={{ route('get_register') }}>Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href={{ route('get_login') }}>Login</a>
                        </li>
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link" href="#"><img src="../images/serach-icon.png"></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>