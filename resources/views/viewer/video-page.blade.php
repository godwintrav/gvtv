@extends('viewer.master')

@section('name', auth()->user()->firstname)

@section('content')
         <div id="content-wrapper">
            <div class="container-fluid pb-0">
               <div class="video-block section-padding">
                  <div class="row">
                     <div class="col-md-8">
                        <div class="single-video-left">
                           <div class="single-video">
                              <!-- <video width="100%" height="315" controls>
                                    <source src="{{
                                  asset('storage/'.$media->filename ?? '') }}" type="video/mp4">
                              </video> -->
                              <video width="100%" height="315" controls autoplay>
                                    <source src="{{ asset('storage/'. $media->filename ?? '') }}" type="video/mp4" >
                              </video>
                           </div>
                           <div class="single-video-title box mb-3">
                              <h2><a>{{$media->title ?? ''}}</a></h2>
                              <p class="mb-0"><i class="fas fa-eye"></i> {{ $num_views ?? ''}}</p>
                           </div>
                           <div class="single-video-author box mb-3">
                              <div class="float-right"><a><button class="btn btn-danger" type="button" id="addButton" data-id="{{$media->id ?? ''}}">  Add to Playlist
                              </button></a> <button class="btn btn btn-danger" type="button" id="likeButton" data-id="{{$media->id ?? ''}}"><i class="fas fa-thumbs-up"></i><span id="likeTxt">  {{count(json_decode($media->likes))}}</span></button></div>
                              <img class="img-fluid" src="{{ asset('img/s4.png') }}" alt="">
                              <p><a href="#"><strong>Aminaami Channel</strong></a> <span title="" data-placement="top" data-toggle="tooltip" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></span></p>
                              <small>Published on {{$media->created_at->format('g:ia \o\n l jS F Y') ?? ''}}</small>
                           </div>
                           <div class="single-video-info-content box mb-3">
                              <!-- <h6>Cast:</h6>
                              <p>Nathan Drake , Victor Sullivan , Sam Drake , Elena Fisher</p> -->
                              <!-- <h6>Category :</h6>
                              <p>{{$media->tags ?? ''}}</p> -->
                              <h6>About :</h6>
                              <p>{{$media->description ?? ''}} </p>
                              <h6>Tags :</h6>
                              <p class="tags mb-0">
                              @if(isset($vid_tags))
                                 @foreach($vid_tags as $vid_tag)
                                 <span><a >{{ strtoupper($vid_tag) }}</a></span>
                                @endforeach
                              @endif
                              </p>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="single-video-right">
                           <div class="row">
                              <div class="col-md-12">
                              @if(isset($adverts['0']))
                                 <div style="background-image: url({{ asset('storage/'. $adverts['0']->content ?? '') }}); background-repeat: no-repeat; background-size: cover;" class="adblock">
                                    <div class="img">
                                       <br>
                                    </div>
                                 </div>
                                 @endif
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
                                    @if(isset($upNexts) && $upNexts != null)
                                    <h6>Up Next</h6>
                                 </div>
                              </div>
                              <div class="col-md-12">

                                 
                                    @foreach($upNexts as $video)
                                       <div class="video-card video-card-list">
                                          <div class="video-card-image">
                                             <a class="play-icon" href="/viewer/ad/{{$video->id}}"><i class="fas fa-play-circle"></i></a>
                                             <a href="/viewer/ad/{{$video->id}}"><img class="img-fluid" src="{{ asset('storage/'.$video->thumbnail ?? '') }}" alt=""></a>
                                             <div class="time"></div>
                                          </div>
                                          <div class="video-card-body">
                                             <div class="video-title">
                                                <a href="/viewer/ad/{{$video->id}}">{{ $video->title ?? ''}}</a>
                                             </div>
                                             <div class="video-page text-success">
                                             Aminaami Tv  <a title="" data-placement="top" data-toggle="tooltip" href="/viewer/ad/{{$video->id}}" data-original-title="Verified"><i class="fas fa-check-circle text-success"></i></a>
                                             </div>
                                             <div class="video-view">
                                             {{count(json_decode($video->views))}} views &nbsp;<i class="fas fa-calendar-alt"></i> {{$video->created_at->format('M d Y') ?? ''}}
                                             </div>
                                          </div>
                                       </div>
                                    @endforeach
                                 @endif

                                 @if(isset($adverts['1']))
                                    <div style="background-image: url({{ asset('storage/'. $adverts['1']->content ?? '')}} ); background-repeat: no-repeat; background-size: cover;" class="adblock mt-0">
                                       <div class="img">
                                          
                                          <br>
                                       </div>
                                    </div>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /.container-fluid -->
            <!-- Sticky Footer -->
            <!-- <footer class="sticky-footer">
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
                  <a class="btn btn-primary" href="/viewer/logout">Logout</a>
               </div>
            </div>
         </div>
      </div>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script type="text/javascript">

      $('#addButton').click(function(){
         var dataId = $(this).attr("data-id");
	      addToPlaylist(dataId);
       });

       $('#likeButton').click(function(){
         var dataId = $(this).attr("data-id");
	      addLikes(dataId);
       });

      function addToPlaylist(id){
         $.ajax({
            url: '/viewer/addPlaylist/'+ id,
            type: 'GET',
            dataType: 'json',
            success: function(response){
               if(response != null){
                  $("#addButton").html(response);
               }
            }
         });
      }

      function addLikes(id){
         $.ajax({
            url: '/viewer/addLikes/'+ id,
            type: 'GET',
            dataType: 'json',
            success: function(response){
               if(response != null){
                  $("#likeTxt").html(" "+response);
               }
            }
         });
      }

      </script>
      @endsection   