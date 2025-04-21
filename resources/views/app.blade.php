<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- basic -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- mobile metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- site metas -->
        <title>Blog @hasSection('title') | @yield('title') @endif</title>
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- bootstrap css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
        <!-- style css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
        <!-- Responsive-->
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
        <!-- fevicon -->
        <link rel="icon" href="../images/fevicon.png" type="image/gif" />
        <!-- Scrollbar Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}">
        <!-- Tweaks for older IEs-->
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
        <script src="https://kit.fontawesome.com/ae75e06636.js" crossorigin="anonymous"></script>
        <!-- owl stylesheets --> 
        <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
        <!-- Scripts -->
        <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
        <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>

        <script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY') }}/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: 'textarea.myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
                plugins: 'code table lists image',
                toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | image',
                file_picker_types: 'image',
                placeholder: 'Type content here...',
                images_upload_url: '{{ route('img.upload') }}',
                images_upload_credentials: true,
                images_upload_headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },

                // thêm headers với CSRF token
                images_upload_handler: (blobInfo, progress) => {
                    return new Promise((resolve, reject) => {
                        const xhr = new XMLHttpRequest();
                        xhr.withCredentials = true;
                        xhr.open('POST', '{{ route('img.upload') }}');

                        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                        xhr.setRequestHeader('Accept', 'application/json');

                        xhr.upload.onprogress = (e) => {
                            progress(e.loaded / e.total * 100);
                        };

                        xhr.onload = () => {
                            if (xhr.status === 403) {
                                reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                                return;
                            }

                            if (xhr.status < 200 || xhr.status >= 300) {
                                reject('HTTP Error: ' + xhr.status);
                                return;
                            }

                            try {
                                const json = JSON.parse(xhr.responseText);

                                if (!json || typeof json.location !== 'string') {
                                    reject('Invalid JSON: ' + xhr.responseText);
                                    return;
                                }

                                resolve(json.location);
                            } catch (e) {
                                reject('Could not parse JSON: ' + e.message);
                            }
                        };

                        xhr.onerror = () => {
                            reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                        };

                        const formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo.filename());

                        xhr.send(formData);
                    });
                }
            });
        </script>
        <style>
            .admin-sidebar {
                width: 250px;
                transition: all 0.3s;
            }
        
            .admin-wrapper.sidebar-collapsed .admin-sidebar {
                margin-left: -250px;
            }
        
            @media (max-width: 768px) {
                .admin-sidebar {
                    position: fixed;
                    top: 0;
                    left: 0;
                    height: 100vh;
                    background: #343a40;
                    z-index: 999;
                    transform: translateX(-100%);
                }
        
                .admin-wrapper.sidebar-open .admin-sidebar {
                    transform: translateX(0);
                }
        
                .content-wrapper {
                    padding-left: 1rem;
                }
            }
        </style>
    </head>
    <body>
        @include('partials/header')
        <!-- about section start --> 
        @if (Request::is('admin*'))
            <div class="admin-wrapper d-flex">
                <div class="admin-sidebar">
                    @include('partials.sidebar')
                </div>
                <div class="content-wrapper flex-grow-1 p-4">
                    <button class="btn btn-outline-secondary mb-3" id="toggleSidebar">
                        ☰ Menu
                    </button>
                    @yield('content')
                </div>
            </div>
        @else
            @yield('content')
        @endif
        
        @include('partials/footer')
        <!-- Javascript files-->
        <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery-3.0.0.min.js"></script>
        <script src="js/plugin.js"></script>
        <!-- sidebar -->
        <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="js/custom.js"></script>
        <!-- javascript --> 
        <script src="js/owl.carousel.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const wrapper = document.querySelector('.admin-wrapper');
                const toggleBtn = document.getElementById('toggleSidebar');
        
                if (toggleBtn) {
                    toggleBtn.addEventListener('click', function () {
                        if (window.innerWidth < 768) {
                            wrapper.classList.toggle('sidebar-open');
                        } else {
                            wrapper.classList.toggle('sidebar-collapsed');
                        }
                    });
                }
            });
        </script>
    </body>
</html>