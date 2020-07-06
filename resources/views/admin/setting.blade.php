@extends('layouts.sitemaster')
@section('pageTitle', 'Site Settings')
@section('content')
<div class="breadcromb-area">
  <div class="row">
    <div class="col-md-6  col-sm-6">
      <div class="seipkon-breadcromb-left pt-3  pull-right text-center">
        <h3>All Investment</h3>
      </div>
    </div>
  </div>
</div>

<div class="page-content">
  <div class="row">
    <div class="col-lg-12">
      @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
          <button type="button" class="close" data-dismiss="alert">×</button> 
          <strong>{{ $message }}</strong>
        </div>
      @endif

      @if (count($errors) > 0)
        <div class="alert alert-danger">
          <strong>Error!</strong>
         
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <div class="page-box">
        <div class="tabs-example">
          <div class="tabs-box-example horizontal-tab-example">
            <ul class="nav nav-tabs" id="service_pro" role="tablist">
              <li class="active">
                <a data-toggle="tab" href="#home" role="presentation">Site Settings</a>
              </li>

              <li>
                <a data-toggle="tab" href="#about" role="presentation">About Company</a>
              </li>

              <li>
                <a data-toggle="tab" href="#session" role="presentation">Admins</a>
              </li>

              <li>
                <a data-toggle="tab" href="#logo" role="presentation">Logo</a>
              </li>

              <li>
                <a data-toggle="tab" href="#bank" role="presentation">Banks</a>
              </li>

              <li>
                <a data-toggle="tab" href="#btc" role="presentation">Cryptos</a>
              </li>
            </ul>

            <div id="seipkkon_tab_content" class="tab-content">
              <div class="tab-pane fade in active" id="home">
                <div class="p-3">
                  <h4>setting Settings</h4>
                </div>
                <form method="POST" action="{{ url('admin/setting') }}/{{ $setting->id }}" enctype="multipart/form-data">
                  @csrf
                  {{ method_field('PUT') }}
                  <div class="form-body">
                    <div class="modal-body">
                      <div class="form-group">
                        <label>Site Name</label>
                        <input type="text" name="sitename" class="form-control" required="" value="{{ $setting->sitename }}">
                      </div>

                      <div class="form-group">
                        <label>Site Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $setting->email }}" required="">
                      </div>

                      <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" class="form-control" value="{{ $setting->phone }}" required="">
                      </div>

                      <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" value="{{ $setting->address }}" required="">
                      </div>

                      <!--<div class="form-group">
                        <label>Facebook Page</label>
                        <input type="text" name="facebook" class="form-control" value="{{ $setting->facebook }}">
                      </div>

                      <div class="form-group">
                        <label>Twitter Page</label>
                        <input type="text" name="twitter" class="form-control" value="{{ $setting->twitter }}">
                      </div>

                      <div class="form-group">
                        <label>LinkedIn Page</label>
                        <input type="text" name="linkedin" class="form-control" value="{{ $setting->linkedin }}">
                      </div>-->

                      <div class="form-group">
                        <label>Facebook Page</label>
                        <input type="text" name="facebook" class="form-control" value="{{ $setting->facebook }}">
                      </div>

                      <div class="form-group">
                        <label>Twitter Page</label>
                        <input type="text" name="twitter" class="form-control" value="{{ $setting->twitter }}">
                      </div>

                      <div class="form-group">
                        <label>LinkedIn Page</label>
                        <input type="text" name="linkedin" class="form-control" value="{{ $setting->linkedin }}">
                      </div>
                      
                    </div>
                  </div>
                  <div class="form-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>

              <div class="tab-pane fade in" id="about">
                <div class="p-3">
                  <h4>About</h4>
                </div>
                <form method="POST" action="{{ url('admin/setting') }}/{{ $setting->id }}" enctype="multipart/form-data">
                  @csrf
                  {{ method_field('PUT') }}
                  <div class="form-body">
                    <div class="modal-body">
                      <div class="form-group">
                        <label>Crypto Info Details</label>
                        <textarea name="vision" class="form-control">{{ $setting->vision }}</textarea>
                      </div>

                      <div class="form-group">
                        <label>Bank Info Details</label>
                        <textarea name="mission" class="form-control">{{ $setting->mission }}</textarea>
                      </div>

                      <div class="form-group">
                          <label>About Us</label>
                          <textarea  class="form-control" id="editorabout" rows="50" cols="110" name="about">{{ $setting->about }}
                          </textarea>
                          <script>
                              // Replace the <textarea id="editor1"> with a CKEditor
                              // instance, using default configuration.
                              CKEDITOR.replace( 'editorabout' );
                          </script>
                        </div>  

                    </div>
                  </div>
                  <div class="form-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>

              <div class="tab-pane fade in" id="session">
                <div class="p-3">
                  <h4>Site Admins
                  <button class="btn btn-success btn-xs float-right" data-toggle="modal" data-target="#addSession">Add New <i class="fa fa-plus fa-fw"></i></button></h4>
                </div>
                <div class="modal fade mt-5" id="addSession" tabindex="-1" role="dialog" aria-labelledby="addSessionLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addCourseLabel">Add Admin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <form method="POST" action="{{ url('admin/setting/admin') }}">
                        @csrf
                        <div class="modal-body">
                          <div class="form-group">
                            <label> Name </label>
                            <input type="text" name="name" class="form-control" required="">
                          </div>

                          <div class="form-group">
                            <label> Email </label>
                            <input type="email" name="email" class="form-control" required="">
                          </div>

                          <div class="form-group">
                            <label> Password </label>
                            <input type="password" name="password" class="form-control" required="">
                          </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="table-responsive p-2">
                  <table class="table table-hover" id="example1">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Modify</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($userss as $users)
                        <tr>
                          <td>{{ $users->name }}</td>
                          <td>{{ $users->email }}</td>
                          <td>
                            <a href="#" data-toggle="modal" data-target="#editSession{{ $users->id }}">
                              <i class="fa fa-edit text-blue"></i>
                            </a>
                            |
                            <a href="#" onclick="event.preventDefault(); document.getElementById('delete{{ $users->id }}').submit();">
                              <i class="fa fa-trash text-red"></i>
                            </a>

                            <form id="delete{{ $users->id }}" action="{{ url('admin/setting/admin') }}/{{ $users->id }}" method="POST" style="display: none;">
                              {{ csrf_field() }}
                              {{ Method_field('DELETE') }}
                            </form>  
                          </td>
                        </tr>  
                        <div class="modal fade mt-5" id="editSession{{ $users->id }}" tabindex="-1" role="dialog" aria-labelledby="editSession{{ $users->id }}Label" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="addCourseLabel">Edit Admin</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>

                              <form method="POST" action="{{ url('admin/setting/admin') }}/{{ $users->id }}">
                                @csrf
                                {{ method_field('PUT') }}
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label> Name </label>
                                    <input type="text" name="name" class="form-control" required="" value="{{ $users->name }}">
                                  </div>

                                  <div class="form-group">
                                    <label> Password </label>
                                    <input type="password" name="password" class="form-control">
                                  </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      @empty
                      @endforelse 
                    </tbody>                
                  </table>
                </div>
              </div>

              <div class="tab-pane fade in" id="logo">
                <div class="p-3">
                  <h4>Upload Logo</h4>
                </div>
                <form method="POST" action="{{ url('admin/setting/logo') }}/{{ $setting->id }}" enctype="multipart/form-data" class="form-inline">
                  @csrf
                  {{ method_field('PUT') }}
                  
                      <div class="form-group">
                        <input type="file" name="logo" class="form-control" required>
                      </div>
                 
                      <button type="submit" class="btn btn-primary">Upload</button>
                  
                </form>
                <div class="m-4">
                  @if($setting->logo==NULL)
                    <div  class="p-4" style="background: red">
                      <img class="img-fluid img-responsive center" src="{{ asset('img/hsm.png') }}" style="height: 200px">
                    </div>
                  @else
                    <img class="img-fluid img-responsive center" src="{{ asset('storage') }}/{{ $setting->logo }}" style="height: 200px">
                  @endif
                </div>
              </div>

              <div class="tab-pane fade in" id="bank">
                <div class="p-3">
                  <h4>Banks
                  <button class="btn btn-success btn-xs float-right" data-toggle="modal" data-target="#addBank">Add New <i class="fa fa-plus fa-fw"></i></button></h4>
                </div>
                <div class="modal fade mt-5" id="addBank" tabindex="-1" role="dialog" aria-labelledby="addBankLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addCourseLabel">Add Bank</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <form method="POST" action="{{ url('admin/setting/bank') }}">
                        @csrf
                        <div class="modal-body">
                          <div class="form-group">
                            <label> Name of Bank </label>
                            <input type="text" name="name" class="form-control" required="">
                          </div>

                          <div class="form-group">
                            <label> Account Number </label>
                            <input type="text" name="account_number" class="form-control" required="">
                          </div>

                          <div class="form-group">
                            <label> Account Name </label>
                            <input type="text" name="account_name" class="form-control" required="">
                          </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="table-responsive p-2">
                  <table class="table table-hover" id="example2">
                    <thead>
                      <tr>
                        <th>Name of Bank</th>
                        <th>Account Number</th>
                        <th>Account Name</th>
                        <th>Modify</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($banks as $bank)
                        <tr>
                          <td>{{ $bank->name }}</td>
                          <td>{{ $bank->account_number }}</td>
                          <td>{{ $bank->account_name }}</td>
                          <td>
                            <a href="#" data-toggle="modal" data-target="#editBank{{ $bank->id }}">
                              <i class="fa fa-edit text-blue"></i>
                            </a>
                            |
                            <a href="#" onclick="event.preventDefault(); document.getElementById('deletebank{{ $bank->id }}').submit();">
                              <i class="fa fa-trash text-red"></i>
                            </a>

                            <form id="deletebank{{ $bank->id }}" action="{{ url('admin/setting/bank') }}/{{ $bank->id }}" method="POST" style="display: none;">
                              {{ csrf_field() }}
                              {{ Method_field('DELETE') }}
                            </form>  
                          </td>
                        </tr>  
                        <div class="modal fade mt-5" id="editBank{{ $bank->id }}" tabindex="-1" role="dialog" aria-labelledby="editBank{{ $bank->id }}Label" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="addCourseLabel">Edit Bank</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>

                              <form method="POST" action="{{ url('admin/setting/bank') }}/{{ $bank->id }}">
                                @csrf
                                {{ method_field('PUT') }}
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label> Name of Bank </label>
                                    <input type="text" name="name" class="form-control" required="" value="{{ $bank->name }}">
                                  </div>

                                  <div class="form-group">
                                    <label> Account Number </label>
                                    <input type="text" name="account_number" class="form-control" required="" value="{{ $bank->account_number }}">
                                  </div>

                                  <div class="form-group">
                                    <label> Account Name </label>
                                    <input type="text" name="account_name" class="form-control" required="" value="{{ $bank->account_name }}">
                                  </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      @empty
                      @endforelse 
                    </tbody>                
                  </table>
                </div>
              </div>

              <div class="tab-pane fade in" id="btc">
                <div class="p-3">
                  <h4>Crypto Currency
                  <button class="btn btn-success btn-xs float-right" data-toggle="modal" data-target="#addBtc">Add New <i class="fa fa-plus fa-fw"></i></button></h4>
                </div>
                <div class="modal fade mt-5" id="addBtc" tabindex="-1" role="dialog" aria-labelledby="addBtcLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addCourseLabel">Add Cypto Currency</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <form method="POST" action="{{ url('admin/setting/btc') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                          <div class="form-group">
                            <label> Name of Crypto </label>
                            <input type="text" name="name" class="form-control" required="">
                          </div>

                          <div class="form-group">
                            <label>Number </label>
                            <input type="text" name="detail" class="form-control" required="">
                          </div>

                          <div class="form-group">
                            <label> Logo </label>
                            <input type="file" name="image" class="form-control" required="">
                          </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="table-responsive p-2">
                  <table class="table table-hover" id="example1">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Detail</th>
                        <th>Image</th>
                        <th>Modify</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($btcs as $btc)
                        <tr>
                          <td>{{ $btc->name }}</td>
                          <td>{{ $btc->detail }}</td>
                          <td>
                            <img src="{{ asset('storage') }}/{{ $btc->image}}" style="height: 50px; width: 70px">
                          </td>
                          <td>
                            <a href="#" data-toggle="modal" data-target="#editBtc{{ $btc->id }}">
                              <i class="fa fa-edit text-blue"></i>
                            </a>
                            |
                            <a href="#" onclick="event.preventDefault(); document.getElementById('deleteBtc{{ $btc->id }}').submit();">
                              <i class="fa fa-trash text-red"></i>
                            </a>

                            <form id="deleteBtc{{ $btc->id }}" action="{{ url('admin/setting/btc') }}/{{ $btc->id }}" method="POST" style="display: none;">
                              {{ csrf_field() }}
                              {{ Method_field('DELETE') }}
                            </form>  
                          </td>
                        </tr>  
                        <div class="modal fade mt-5" id="editBtc{{ $btc->id }}" tabindex="-1" role="dialog" aria-labelledby="editBtc{{ $btc->id }}Label" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="addCourseLabel">Edit Bank</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>

                              <form method="POST" action="{{ url('admin/setting/btc') }}/{{ $btc->id }}" enctype="multipart/form-data">
                                @csrf
                                {{ method_field('PUT') }}
                                <div class="modal-body">
                                  <div class="form-group">
                                    <label> Name of Crypto </label>
                                    <input type="text" name="name" class="form-control" required="" value="{{ $btc->name }}">
                                  </div>

                                  <div class="form-group">
                                    <label> Details </label>
                                    <input type="text" name="detail" class="form-control" required="" value="{{ $btc->detail }}">
                                  </div>

                                  <div class="form-group">
                                    <label> Logo </label>
                                    <input type="file" name="image" class="form-control" required="">
                                  </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      @empty
                      @endforelse 
                    </tbody>                
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
   .breadcromb-area{
      min-height: 100px;
      background-image: url('{{ asset('assets/img/dollar.jpg') }}');
      background-size: cover;
      padding: 40px;
      color: #fff
   }

   .btn-excel{
      background: green;
      color: #fff;
      border-radius: 10px;
   }

   .btn-excel:hover{
      background: blue;
      color: #fff;
      border-radius: 10px;
   }

   .bg-gradient-default {
      background: linear-gradient(87deg, #172b4d 0, #1a174d 100%) !important;
   }

   .shadow {
      box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15) !important;
   }

   .btc:hover{
      background: #47617f;
      color: white;
   }
</style>
<script type="text/javascript">
   
   //Datatables
      $(document).ready( function () {
          $('#example1').DataTable(
            {
                "ordering": false
            });

          $('#example2').DataTable(
            {
                "ordering": true
            });
      } );
</script>
@endsection
