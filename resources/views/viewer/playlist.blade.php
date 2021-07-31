@extends('viewer.master')

   @section('name', auth()->user()->firstname)
   @section('playlist', 'active')

      @section('content')
         <div id="content-wrapper">
            <div class="container-fluid">
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
                           <h6>Playlist</h6>
                        </div>
                     </div>
                    @if(isset($medias) && $medias != null)
                        @foreach($medias as $media)
                        <div class="col-xl-3 col-sm-6 mb-3">
                                 <div class="video-card">
                                    <div class="video-card-image">
                                       <a class="video-close" href="" data-toggle="modal" data-target="#logoutModal{{$media->id}}"><i class="fas fa-times-circle"></i></a>
                                       <a class="play-icon" href="/viewer/ad/{{$media->id}}"><i class="fas fa-play-circle"></i></a>
                                       <a href="/viewer/ad/{{$media->id}}"><img class="img-fluid" src="{{ asset('storage/'.$media->thumbnail ?? '') }}" alt=""></a>
                                       <div class="time"></div>
                                    </div>
                                    <div class="video-card-body">
                                       <div class="video-title">
                                          <a href="/viewer/ad/{{$media->id}}">{{$media->title}}</a>
                                       </div>
                                       <div class="video-page text-success">
                                          Aminaami Tv  <a title="" data-placement="top" data-toggle="tooltip" href="/viewer/ad/{{$media->id}}" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                       </div>
                                       <div class="video-view">
                                       {{count(json_decode($media->views))}} views &nbsp;<i class="fas fa-calendar-alt"></i> {{$media->created_at->format('M d Y') ?? ''}}
                                       </div>
                                    </div>
                                 </div>

                                 <div class="modal fade" id="logoutModal{{$media->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                 <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Delete Video {{$media->title}}?</h5>
                                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">×</span>
                                          </button>
                                       </div>
                                       <div class="modal-body">Are you sure you want to delete this video from your playlist?</div>
                                       <div class="modal-footer">
                                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                          <a class="btn btn-primary" href="/viewer/delete_media/{{$media->id}}">Delete</a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                              </div>
                        @endforeach    
                    @else
                        {{$err_msg ?? ''}}
                    @endif
                     
                  </div>
                  
               </div>
            </div>
            <!-- /.container-fluid -->
            <!-- Sticky Footer -->
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
                  <a class="btn btn-primary" href="/viewer/logout">Logout</a>
               </div>
            </div>
         </div>
      </div>
      @endsection