@extends('admin.master')

@section('name', auth()->user()->firstname)
   @section('index', 'active')

      @section('content')
         <div id="content-wrapper">
            <div class="container-fluid pb-0">
               <div class="top-mobile-search">
                  <div class="row">
                     <div class="col-md-12">   
                     <form method="post" action="/admin/search" class="mobile-search">
                           <div class="input-group">
                           {{ csrf_field()}}
                             <input type="text" name="search" placeholder="Search for..." class="form-control">
                               <div class="input-group-append">
                                 <button type="submit" class="btn btn-dark"><i class="fas fa-search"></i></button>
                               </div>
                           </div>
                        </form>   
                     </div>
                  </div>
               </div>
               
               <hr>
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="main-title">
                           <div class="btn-group float-right right-action">
                              <a href="#" class="right-action-link text-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Sort by <i class="fa fa-caret-down" aria-hidden="true"></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right">
                                 <a class="dropdown-item" href="#"><i class="fas fa-fw fa-star"></i> &nbsp; Top Rated</a>
                                 <a class="dropdown-item" href="#"><i class="fas fa-fw fa-signal"></i> &nbsp; Viewed</a>
                                 <a class="dropdown-item" href="#"><i class="fas fa-fw fa-times-circle"></i> &nbsp; Close</a>
                              </div>
                           </div>
                           <h6>Featured Videos</h6>
                        </div>
                     </div>
                     @if(isset($videos))
                        @foreach($videos as $video)
                        <div class="col-xl-3 col-sm-6 mb-3">
                           <div class="video-card">
                              <div class="video-card-image">
                                 <a class="play-icon" href="/admin/video/{{$video->id}}"><i class="fas fa-play-circle"></i></a>
                                 <a href="/admin/video/{{$video->id}}"><img class="img-fluid" src="{{ asset('storage/'.$video->thumbnail ?? '') }}" alt=""></a>
                                 <div class="time"></div>
                              </div>
                              <div class="video-card-body">
                                 <div class="video-title">
                                    <a href="/admin/video/{{$video->id}}">{{ $video->title ?? ''}}</a>
                                 </div>
                                 <div class="video-page text-success">
                                    Aminaami Tv  <a title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                 </div>
                                 <div class="video-view">
                                  {{count(json_decode($video->views))}} views &nbsp;<i class="fas fa-calendar-alt"></i> {{ $video->created_at->format('M d Y') ?? ''}}
                                 </div>
                              </div>
                           </div>
                        </div>
                        @endforeach
                     @else
                        <div class="col-xl-3 col-sm-6 mb-3">
                           <h4 style="text-align: center;">No Video Found</h4>
                        </div>
                     @endif
                  </div>
               </div>
               
               
            </div>
            <!-- /.container-fluid -->
            <!-- Sticky Footer -->
            <!-- <footer class="sticky-footer">
               <div class="container">
                  <div class="row no-gutters">
                     <div class="col-lg-6 col-sm-6">
                        <p class="mt-1 mb-0"><strong class="text-dark">Vidoe</strong>. 
                           <small class="mt-0 mb-0"><a class="text-primary" target="_blank" href="https://www.templatespoint.net/">Templates Point</a>
                           </small>
                        </p>
                     </div>
                     <div class="col-lg-6 col-sm-6 text-right">
                        <div class="app">
                           <a href="#"><img alt="" src="{{ asset('admin/img/google.png') }}"></a>
                           <a href="#"><img alt="" src="{{ asset('admin/img/apple.png') }}"></a>
                        </div>
                     </div>
                  </div>
               </div>
            </footer> -->
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
                  <a class="btn btn-primary" href="/admin/logout">Logout</a>
               </div>
            </div>
         </div>
      </div>
      @endsection