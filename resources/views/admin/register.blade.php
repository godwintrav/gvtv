<!DOCTYPE html>
<html lang="en">
   
<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Askbootstrap">
      <meta name="author" content="Askbootstrap">
      <title>Aminaami TV</title>
      <!-- Favicon Icon -->
      <link rel="icon" type="image/png" href="{{ asset('admin/img/favicon.png') }}">
      <!-- Bootstrap core CSS-->
      <link href="{{ asset('admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
      <!-- Custom fonts for this template-->
      <link href="admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
      <!-- Custom styles for this template-->
      <link href=" {{ asset('admin/css/osahan.css') }} " rel="stylesheet">
      <!-- Owl Carousel -->
      <link rel="stylesheet" href="admin/vendor/owl-carousel/owl.carousel.css">
      <link rel="stylesheet" href="admin/vendor/owl-carousel/owl.theme.css">
   </head>
   <body class="login-main-body">
      <section class="login-main-wrapper">
         <div class="container-fluid pl-0 pr-0">
            <div class="row no-gutters">
               <div class="col-md-5 p-5 bg-white full-height">
                  <div class="login-main-left">
                     <div class="text-center mb-5 login-main-left-header pt-4">
                        <img src="admin/img/favicon.png" class="img-fluid" alt="LOGO">
                        <h5 class="mt-3 mb-3">Welcome to Aminaami Tv</h5>
                        <p>It is a long established fact that a reader <br> will be distracted by the readable.</p>
                     </div>
                     <form action="/register_admin" method="post">
                        <div class="form-group">
                           <label>First Name</label>
                           <input required type="text" class="form-control" placeholder="Enter firstname" name="firstname">
                        </div>
                        @error('firstname')
                           <span >
                            <p style="color: red;">{{ $message }}</p>
                           </span>
                        @enderror
                        <div class="form-group">
                           <label>Last Name</label>
                           <input required type="text" class="form-control" placeholder="Enter lastname" name="lastname">
                        </div>
                        @error('lastname')
                           <span >
                            <p style="color: red;">{{ $message }}</p>
                           </span>
                        @enderror
                        <div class="form-group">
                           <label>Email</label>
                           <input required type="email" class="form-control" placeholder="Enter Email" name="email">
                        </div>
                        @error('email')
                           <span >
                            <p style="color: red;">{{ $message }}</p>
                           </span>
                        @enderror
                        <div class="form-group">
                           <label>Password</label>
                           <input type="password" class="form-control" placeholder="Enter password" name="password">
                        </div>
                        <div class="form-group">
                           <label>Confirm Password</label>
                           <input id="password-confirm" type="password" placeholder="Confirm password" class="form-control" name="password_confirmation" required>
                        </div>
                        @error('password')
                           <span >
                            <p style="color: red;">{{ $message }}</p>
                           </span>
                        @enderror
                        {{ csrf_field()}}
                        <div class="mt-4">
                           <button type="submit" name="submit" class="btn btn-outline-primary btn-block btn-lg">Sign Up</button>
                        </div>
                     </form>
                     <div class="text-center mt-5">
                        <p class="light-gray">Already have an Account? <a href="/admin_login">Sign In</a></p>
                     </div>
                  </div>
               </div>
               <div class="col-md-7" >
                  <div style="display: none;" class="login-main-right bg-white p-5 mt-5 mb-5" >
                     <div class="owl-carousel owl-carousel-login">
                        <div class="item">
                           <div class="carousel-login-card text-center">
                              <img src="{{ asset('admin/img/login.pn') }}g" class="img-fluid" alt="LOGO">
                              <h5 class="mt-5 mb-3">Watch cool videos online</h5>
                           </div>
                        </div>
                        <div class="item">
                           <div class="carousel-login-card text-center">
                              <img src="{{ asset('admin/img/login.pn') }}g" class="img-fluid" alt="LOGO">
                              <h5 class="mt-5 mb-3">Download videos effortlessly</h5>
                           </div>
                        </div>
                        <div class="item">
                           <div class="carousel-login-card text-center">
                              <img src="{{ asset('admin/img/login.pn') }}g" class="img-fluid" alt="LOGO">
                              <h5 class="mt-5 mb-3">Create your playlist</h5>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- Bootstrap core JavaScript-->
      <script src="admin/vendor/jquery/jquery.min.js"></script>
      <script src="admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- Core plugin JavaScript-->
      <script src="admin/vendor/jquery-easing/jquery.easing.min.js"></script>
      <!-- Owl Carousel -->
      <script src="admin/vendor/owl-carousel/owl.carousel.js"></script>
      <!-- Custom scripts for all pages-->
      <script src="admin/js/custom.js"></script>
   </body>
</html>