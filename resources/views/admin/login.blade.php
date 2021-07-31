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
      <link rel="icon" type="image/png" href="{{ asset('admin/img/favicon.') }}png">
      <!-- Bootstrap core CSS-->
      <link href="{{ asset('admin/vendor/boots') }}trap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom fonts for this template-->
      <link href="{{ asset('admin/vendor/fonta') }}wesome-free/css/all.min.css" rel="stylesheet" type="text/css">
      <!-- Custom styles for this template-->
      <link href="{{ asset('admin/css/osahan.c') }}ss" rel="stylesheet">
      <!-- Owl Carousel -->
      <link rel="stylesheet" href="{{ asset('admin/vendor/owl-c') }}arousel/owl.carousel.css">
      <link rel="stylesheet" href="{{ asset('admin/vendor/owl-c') }}arousel/owl.theme.css">
   </head>
   <body class="login-main-body">
      <section class="login-main-wrapper">
         <div class="container-fluid pl-0 pr-0">
            <div class="row no-gutters">
               <div class="col-md-5 p-5 bg-white full-height">
                  <div class="login-main-left">
                     <div class="text-center mb-5 login-main-left-header pt-4">
                        <img src="{{ asset('admin/img/favicon.') }}png" class="img-fluid" alt="LOGO">
                        <h5 class="mt-3 mb-3">Welcome to Aminaami TV</h5>
                        <p>It is a long established fact that a reader <br> will be distracted by the readable.</p>
                     </div>
                     <form action="/login_admin" method="post">
                     {{ csrf_field()}}
                     <div class="form-group">
                           <label>Email</label>
                           <input required type="email" class="form-control" placeholder="Enter Email" name="email">
                        </div> 
                        <div class="form-group">
                           <label>Password</label>
                           <input type="password" class="form-control" placeholder="Enter password" name="password">
                        </div>
                        @error('email')
                           <span >
                            <p style="color: red;">{{ $message }}</p>
                           </span>
                        @enderror

                        @if(isset($err_msg))
                           <span >
                            <p style="color: red; text-align: center;">{{ $err_msg }}</p>
                           </span>
                        @endif
                        
                        <div class="mt-4">
                           <div class="row">
                              <div class="col-12">
                                 <button type="submit" class="btn btn-outline-primary btn-block btn-lg">Sign In</button>
                              </div>
                           </div>
                        </div>
                     </form>
                     <div class="text-center mt-5">
                        <p class="light-gray">Don’t have an account? <a href="/admin_register">Sign Up</a></p>
                     </div>
                  </div>
               </div>
               <div class="col-md-7">
                  <div style="display: none;" class="login-main-right bg-white p-5 mt-5 mb-5">
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
      <script src="{{ asset('admin/vendor/jquer') }}y/jquery.min.js"></script>
      <script src="{{ asset('admin/vendor/boots') }}trap/js/bootstrap.bundle.min.js"></script>
      <!-- Core plugin JavaScript-->
      <script src="{{ asset('admin/vendor/jquer') }}y-easing/jquery.easing.min.js"></script>
      <!-- Owl Carousel -->
      <script src="{{ asset('admin/vendor/owl-c') }}arousel/owl.carousel.js"></script>
      <!-- Custom scripts for all pages-->
      <script src="{{ asset('admin/js/custom.js') }}"></script>
   </body>

</html>