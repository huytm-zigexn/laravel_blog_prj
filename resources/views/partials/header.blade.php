<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
    Pusher.logToConsole = true;

    var pusher = new Pusher('8d583216bba683b91203', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('send-noti');
    channel.bind('follow-noti', function(data) {
        console.log('Received data:', data);

        let avatar = data.user_avatar
            ? `<img src="${data.user_avatar}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">`
            : `<img src="https://ui-avatars.com/api/?name=${encodeURIComponent(data.user_name)}&background=0D8ABC&color=fff&size=40" 
                class="rounded-circle" alt="Avatar">`;

        let html = `
            <div class="justify-content-center align-items-center d-flex">
                ${avatar}
                <div>
                    <p>${data.message}</p>
                </div>
            </div>
        `;

        document.querySelector('#notification-container').innerHTML += html;
    });

    channel.bind('liked-post-noti', function(data) {
        console.log('Received data:', data);

        let avatar = data.user_avatar
            ? `<img src="${data.user_avatar}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">`
            : `<img src="https://ui-avatars.com/api/?name=${encodeURIComponent(data.user_name)}&background=0D8ABC&color=fff&size=40" 
                class="rounded-circle" alt="Avatar">`;

        let html = `
            <div class="justify-content-center align-items-center d-flex">
                ${avatar}
                <div>
                    <p>${data.message}</p>
                </div>
            </div>
        `;

        document.querySelector('#notification-container').innerHTML += html;
    });

    channel.bind('commented-post-noti', function(data) {
        console.log('Received data:', data);

        let avatar = data.user_avatar
            ? `<img src="${data.user_avatar}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">`
            : `<img src="https://ui-avatars.com/api/?name=${encodeURIComponent(data.user_name)}&background=0D8ABC&color=fff&size=40" 
                class="rounded-circle" alt="Avatar">`;

        let html = `
            <div class="justify-content-center align-items-center d-flex">
                ${avatar}
                <div>
                    <p>${data.message}</p>
                </div>
            </div>
        `;

        document.querySelector('#notification-container').innerHTML += html;
    });

    channel.bind('followings-publish-post-noti', function(data) {
        console.log('Received data:', data);

        let avatar = data.user_avatar
            ? `<img src="${data.user_avatar}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">`
            : `<img src="https://ui-avatars.com/api/?name=${encodeURIComponent(data.user_name)}&background=0D8ABC&color=fff&size=40" 
                class="rounded-circle" alt="Avatar">`;

        let html = `
            <div class="justify-content-center align-items-center d-flex">
                ${avatar}
                <div>
                    <p>${data.message}</p>
                </div>
            </div>
        `;

        document.querySelector('#notification-container').innerHTML += html;
    });

    channel.bind('authors-publish-post-noti', function(data) {
        console.log('Received data:', data);

        let avatar = data.user_avatar
            ? `<img src="${data.user_avatar}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">`
            : `<img src="https://ui-avatars.com/api/?name=${encodeURIComponent(data.user_name)}&background=0D8ABC&color=fff&size=40" 
                class="rounded-circle" alt="Avatar">`;

        let html = `
            <div class="justify-content-center align-items-center d-flex">
                ${avatar}
                <div>
                    <p>${data.message}</p>
                </div>
            </div>
        `;

        document.querySelector('#notification-container').innerHTML += html;
    });
</script>

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
                        <a class="nav-link" href="{{ route('app') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.posts.index') }}">Blog</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('user.like', Auth::id()) }}" class="nav-link">Favorite Posts</a>
                        </li>
                        @if (isAdmin(Auth::user()))
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                            </li>
                        @endif
                        <li style="position: relative;" class="nav-item">
                            <a class="nav-link nav-noti" href="#"><i style="font-size: 24px; color: #fff" class="fa-solid fa-bell"></i></a>
                            <div class="noti-container" style="z-index: 999; display: none;">
                                <div class="arrow-up" style="position: absolute; top: 76%; right: 30%"></div>
                                <div class="notifications modal-content shadow-lg" style="padding: 20px 20px; border-radius: 10px; max-width: 350px; width: 350px; position: absolute; top: 95%; right: -294%; border: none; z-index: 99999; background-color: #fff">
                                    <h2 class="text-center">Notifications</h2>
                                    <div class="noti" style="max-height: 300px; overflow-y: auto;">
                                        @foreach ($data as $dataItem)
                                            <div style="background-color: aliceblue;" id="notification-container"></div>
                                            <div class="justify-content-center align-items-center d-flex">
                                                @if($dataItem['user_avatar'])
                                                    <a href="{{ route('user.show', $dataItem['user_id']) }}">
                                                        <img src="{{ asset($dataItem['user_avatar']) }}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                                    </a>
                                                @else
                                                    <a href="{{ route('user.show', $dataItem['user_id']) }}">
                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($dataItem['user_name']) }}&background=0D8ABC&color=fff&size=40" 
                                                        class="rounded-circle" alt="Avatar">
                                                    </a>
                                                @endif
                                                
                                                <div>
                                                    <p style="margin-bottom: 0">{!! Str::limit($dataItem['message'], 200) !!}</p>
                                                    <p style="margin-top: 0">
                                                        <small class="text-muted">{{ $dataItem['created_at']->diffForHumans() }}</small>
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.show', Auth::id()) }}" class="nav-link">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff&size=40" 
                                        class="rounded-circle" alt="Avatar">
                                @endif
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