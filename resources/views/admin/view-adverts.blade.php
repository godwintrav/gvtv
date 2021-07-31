@extends('admin.master')

@section('name', auth()->user()->firstname)
@section('view_adverts', 'active')

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
                           <h6>All Ads</h6>
                        </div>
                     </div>
                     <table id="users" class="table table-bordered table-hover">
                        <thead>
                           <tr>
                                 <th>Title</th>
                                 <th>Description</th>
                                 <th>File Path</th>
                                 <th>Tags</th>
                                 <th>Owner</th>
                                 <th>Delete</th>
                           </tr>
                        </thead>
                        <tbody id="setData">
                           @if(isset($adverts))
                              @foreach ($adverts as $advert)
                              
                                    <tr>
                                       <td>{{$advert->title}}</td>
                                       <td>{{$advert->description}}</td>
                                       <td>{{$advert->content}}</td>
                                       <td>{{$advert->tags}}</td>
                                       <td>{{ $advert->owner}}</td>
                                       @if($advert->active == 1)
                                          <td><a href="/admin/disableAd/{{$advert->id}}"><button class="btn btn-danger js-delete" data-user-id="user.Id">Disable</button></a></td>
                                       @else
                                          <td><a href="/admin/activateAd/{{$advert->id}}"><button class="btn btn-danger js-delete" data-user-id="user.Id">Activate</button></a></td>
                                       @endif   
                                    </tr>
                                    
                              @endforeach
                           @endif   
                        </tbody>

                  </table>
                     
                  </div>
               </div>
               
               
            </div>
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