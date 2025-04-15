<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
      <!-- Responsive-->
      <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
      <!-- fevicon -->
      <link rel="icon" href="../images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
</head>
<body style="background-color: #080c50;">
    <div class="header_section" style="margin-bottom: 100px; background-color: #fff">
        <div class="container-fluid header_main">
           <nav class="navbar">
              <a class="logo" href={{ route('app') }}><img src="../images/logo.png"></a>
           </nav>
        </div>
    </div>
    <div class="container" style="margin-bottom: 150px">
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow rounded-4">
                        <div class="card-body">
                            <h1 class="mb-4 text-center" style="font-weight: bold">Login</h1>
        
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
        
                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" required>
                                </div>
        
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                                </div>
        
                                <!-- Phone -->
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter your phone number" required>
                                </div>
        
                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                                </div>
        
                                <!-- Submit Button -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
        
                                <!-- Login Link -->
                                <div class="mt-3 text-center">
                                    New user? 
                                    <a href="{{ route('getRegister') }}">Register</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    @include('partials/footer')
</body>
</html>