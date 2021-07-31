@extends('admin.master')

@section('name', auth()->user()->firstname)
@section('allusers', 'active')

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
                           <h6>All Users</h6>
                        </div>
                     </div>
                     <table id="users" class="table table-bordered table-hover">
                        <thead>
                           <tr>
                                 <th>Name</th>
                                 <th>Email</th>
                                 <th>User Type</th>
                                 <th>Country</th>
                                 <th>Subscribed</th>
                                 <th>Delete Account</th>
                           </tr>
                        </thead>
                        <tbody id="setData">
                           @if(isset($users))
                              @foreach ($users as $user)
                              
                                    <tr>
                                       <td>{{$user->firstname." ".$user->lastname}}</td>
                                       <td>{{$user->email}}</td>
                                       <td>{{$user->user_type}}</td>
                                       <td>{{$user->country}}</td>
                                       @if($user->subscription->isSubscribed == "true")
                                            <td>Subscribed</td>
                                        @else 
                                            <td>Not Subscribed</td>
                                        @endif
                                        <td><a href="/admin/deleteUser/{{$user->id}}"><button class="btn btn-danger js-delete" data-user-id="user.Id">Delete</button></a></td>
                                    </tr>
                                    
                              @endforeach
                           @endif   
                        </tbody>

                  </table>
                     
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