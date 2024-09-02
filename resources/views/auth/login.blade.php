@extends('template.guest')


@section('content')
<div id="page-container">

<!-- Main Container -->
<main id="main-container">
  <!-- Page Content -->
  <div class="bg-image" style="background-image: url('template/assets/media/photos/loginpage3.png');">
    <div class="row g-0 ">
      <!-- Main Section -->
      <div class="hero-static col-md-6 d-flex align-items-center" style="">
        <div class="p-3 w-100">
          <!-- Header -->
          <div class="mb-3 text-center">
            <a class="link-fx fs-1" href="#">
              <span class="text-light" style="font-size: 50px;font-weight: 500;">Procure Pro 360</span>
            </a></br>
            <span class="text-light" style="font-size: 15px;font-weight: 100;">Login to continue</span>
          </div>
          <!-- END Header -->

          <!-- Sign In Form -->
          <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _js/pages/op_auth_signin.js) -->
          <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
          <div class="row g-0 justify-content-center">
            <div class="col-sm-8 col-xl-5">
              <form class="js-validation-signin" action="{{ route('login') }}" method="POST">
              @csrf
                <div class="py-3">
                  <div class="mb-4">
                  <label for="company-email" class="col-sm-6 col-form-label col-form-label-sm text-light">Email Address</label>
                    <input class="form-control form-control-lg form-control-alt" id="email" placeholder="arshadt@grouptag.co.za"  type="email" name="email" :value="old('email')" required autofocus autocomplete="username" >
                  </div>
                  <div class="mb-5">
                  <label for="company-email" class="col-sm-3 col-form-label col-form-label-sm text-light">Password</label>
                    <input type="password" class="form-control form-control-lg form-control-alt" placeholder="**********"  name="password" required autocomplete="current-password" />
                  </div>
                </div>
                <div class="mb-5">
                  <button type="submit" class="btn w-100 btn-lg btn-hero" style="background-color: #384559; color: #FEFCFF;border: 2px solid #FEFCFF; border-radius: 5px;">
                    <i class=" opacity-30 me-1"></i>{{ __('Login') }}
                  </button>
                  <p class="" >
                    <a class="btn btn-sm text-light"  style="float: right;" href="{{ route('password.request') }}">
                      <i class=""></i> Forgot password?
                    </a>
                  </p>
                </div>
              </form>
            </div>
          </div>
          <!-- END Sign In Form -->
        </div>
      </div>
      <!-- END Main Section -->
    
      <!-- Meta Info Section -->
      <div class="hero-static col-md-6 d-none d-md-flex align-items-md-center justify-content-md-center text-md-center">
        <div class="p-3">
          <p class="fs-lg text-dark_blue-75 mb-0" style="position: fixed; bottom: 0; right: 0; margin: 20px;">
            Techiserve | Smart Solutions 
          </p>
        </div>
      </div>
      <!-- END Meta Info Section -->
    </div>
  </div>
  <!-- END Page Content -->
</main>
@endsection
