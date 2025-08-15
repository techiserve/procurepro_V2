<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Zarq</title>
   <link rel="icon" href="{{ asset('assets/img/favicon.ico') }}" type="image/x-icon">
   <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
   <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

   <!-- 
   font-family: "Poppins", sans-serif;
   font-family: "Inter", sans-serif;
   -->
</head>

<body>
<div class="full-width-background">
    <div class="login-container">
        <div class="login-logo"><a href="#"><img src="assets/img/zarq-Logo-white.png" alt=""></a></div>
        <div class="logine-wrapper">
              <form  id="login-form" action="{{ route('login') }}" method="POST">
                   @csrf
            <div class="logine-input-row"><input type="email" id="email" name="email"  class="{{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="username@tagpay.digital" value="{{ old('email') }}"></div>
                 @error('email')
            <span style="color: #ff7276; font-size: 13px;">{{ $message }}</span>
        @enderror
            <div class="logine-input-row">
                <input type="password"  id="password"  class="{{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" placeholder="Password"/>
                <button type="button" id="btnToggle" class="toggle">
                    <i id="eyeIcon" class="fa fa-eye"></i>
                </button>
            </div>
               @error('password')
                <span style="color: #ff7276; font-size: 13px;">{{ $message }}</span>
            @enderror
            <div class="logine-flex">
                <div class="logine-checkbox">
                    <input type="checkbox" id="remember-me" name="remember-me">
                    <label for="remember-me">Remember Me</label>
                </div>                
                <a href="#" class="forgot-password">Forgot Password?</a>
            </div>
            <div class="btn-logine-input"><input type="submit" value="Login"></div>
        </div>
        </form>
    </div>
    <img src="assets/img/login-bg.jpg" class="full-width-background__image" alt="">
</div>



   <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
   <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
   <script src="{{ asset('assets/js/slick.min.js') }}"></script>
   <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>