@extends('admin.master')

@section('name', auth()->user()->firstname)

   @section('content')

         <div id="content-wrapper">
            <div class="container-fluid pt-5 pb-5">
               <div class="row">
                  <div class="col-md-8 mx-auto text-center upload-video pt-5 pb-5">
                     <h1><i class="fas fa-file-upload text-primary"></i></h1>
                     <form action="/admin/upload_media" method="post" enctype="multipart/form-data">
                        <h4 class="mt-5">Select Video files to upload</h4>
                        <div class="form-group">
                           <input required type="file" class="form-control" placeholder="Select a file" name="filename">
                           @error('filename')
                           <span >
                            <p style="color: red;">{{ $message }}</p>
                           </span>
                           @enderror
                           <input required type="hidden" value="@if(isset( $media_id )){{$media_id}}@endif " name="media_id">
                           @error('media_id')
                           <span >
                            <p style="color: red;">{{ $message }}</p>
                           </span>
                           @enderror
                           @if(isset($err_msg))
                           <span >
                            <p style="color: red; text-align: center;">{{ $err_msg }}</p>
                           </span>
                           @endif
                        </div>
                        {{ csrf_field()}}
                        <div class="mt-4">   
                           <button type="submit" name="submit" class="btn btn-outline-primary">Upload Video</button>
                        </div>
                     </form>
                     
                  </div>
               </div>
            </div>
            <!-- /.container-fluid -->
            <!-- Sticky Footer -->
            <footer class="sticky-footer">
               <div class="container">
                  <div class="row no-gutters">
                     <div class="col-lg-6 col-sm-6">
                         <p class="mt-1 mb-0"><strong class="text-dark">TV</strong> by Aminaami
                           
                        </p>
                     </div>
                     <div class="col-lg-6 col-sm-6 text-right">
                        <div class="app">
                           <a href="#"><img alt="" src="{{ asset('img/google.png') }}"></a>
                           <a href="#"><img alt="" src="{{ asset('img/apple.png') }}"></a>
                        </div>
                     </div>
                  </div>
               </div>
            </footer>
         </div>
         <!-- /.content-wrapper -->
      </div>
      <!-- /#wrapper -->
      <!-- Scroll to Top Button-->
      <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
      </a>
      <!-- Logout Modal-->
      <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                  </button>
               </div>
               <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
               <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <a class="btn btn-primary" href="login.html">Logout</a>
               </div>
            </div>
         </div>
      </div>
      <!-- Bootstrap core JavaScript-->
      @endsection   