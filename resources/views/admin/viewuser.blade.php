@extends('layouts.sitemaster')
@section('pageTitle', ucwords($user->name))
@section('content')
<div class="breadcromb-area">
   <div class="row">
      <div class="col-md-6  col-sm-6">
         <div class="seipkon-breadcromb-left pt-3  pull-right text-center">
            <h3>{{ ucwords($user->name) }}</h3>
          </div>
      </div>
   </div>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-md-12">
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
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="page-box" id="page-box">
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table-hover">
                                    <tr>
                                        <th width="200px">Account Number</th>
                                        <td>{{ $user->account_number }} 
                                            <span class="pull-right">
                                                <a href="#" id="ban_user" style="color: blue">
                                                    @if($user->ban_user==1)Ban user from login @else Unban user from login @endif
                                                </a>
                                            </span>
                                        </td>
                                    </tr>   

                                    <tr>
                                        <th width="200px">Account Name</th>
                                        <td>
                                            {{ ucwords($user->name) }} 
                                            <span class="pull-right">
                                                <a href="#" id="ban" style="color: blue">
                                                    @if($user->account_status==1)Ban user from transaction @else Unban user from transaction @endif
                                                </a>
                                                </span>
                                        </td>
                                    </tr>  

                                    <tr>
                                        <th width="200px">Phone Number</th>
                                        <td>{{ $user->phone }}</td>
                                    </tr> 

                                    <tr>
                                        <th width="200px">Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>               

                                    <tr>
                                        <th width="200px">Address</th>
                                        <td>{{ $user->address }} {{ $user->city }} {{ $user->state }}, {{ $user->country }}</td>
                                    </tr> 

                                    <tr>
                                        <th width="200px">Password</th>
                                        <td>******** <span class="pull-right"><a href="" data-toggle="modal" data-target="#changepassword" style="color: blue">Reset Password</a></span></td>
                                    </tr> 

                                    <tr>
                                        <th width="200px">PIN</th>
                                        <td>{{ $user->pin }}<span class="pull-right"><a href="#" id="reset" style="color: blue">Reset PIN</a></span></td>
                                    </tr> 

                                    <tr>
                                        <th width="200px">Account Type</th>
                                        <td>{{ $user->account_type }}</td>
                                    </tr> 

                                    <tr>
                                        <th width="200px">Date Joined</th>
                                        <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($user->created_at))->toFormattedDateString() }}</td>
                                    </tr> 
                                </table> 
                            </div>
                            <div class="col-md-4">
                                <table class="table table-hover">
                                    <tr>
                                        <th width="200px">Available Balance</th>
                                        <td>{{ $user->balance }} {{ $user->currency_type }}</td>
                                    </tr>   

                                    <tr>
                                        <th width="200px">Total Balance</th>
                                        <td>{{ $user->total_balance }} {{ $user->currency_type }}</td>
                                    </tr>  

                                    <tr>
                                        <th width="200px">Sort Code</th>
                                        <td>{{ $user->sort_code }}</td>
                                    </tr> 

                                    <tr>
                                        <th width="200px">TOC</th>
                                        <td>{{ $user->toc}}</td>
                                    </tr>               

                                    <tr>
                                        <th width="200px">Transfer Code</th>
                                        <td>{{ $user->tc }}</td>
                                    </tr> 

                                    <tr>
                                        <th width="200px">Tax ID</th>
                                        <td>{{ $user->tax }}</td>
                                    </tr> 

                                    <tr>
                                        <th width="200px">IRDC</th>
                                        <td>{{ $user->irdc }}</td>
                                    </tr> 

                                    <tr>
                                        <th width="200px">IBAN</th>
                                        <td>{{ $user->iban }}</td>
                                    </tr>
                                    <tr>
                                        <th width="200px">Swift Code</th>
                                        <td>{{ $user->swift_code}}</td>
                                    </tr>
                                </table> 
                            </div>
                        </div>
                    </div>
                </div>

                <script type="application/javascript"> 
                    $(document).ready(function(){
                        $('#ban').click(function(){
                            $.ajax({
                                url: "{{ ('ban') }}/{{ $user->id }}",
                                type: "GET", //send it through post method
                                data: { 
                                  //send your data here 
                                },
                                success: function(response) {
                                    let x = window.location.href;
                                    $('#likee').delay(0.0001).load(x);
                                    console.log(x); // Your response.
                                },
                                error: function(xhr) {
                                  console.log("ERROR"+xhr); // Debug errors.
                                }
                            });

                        });
                    });


                    $(document).ready(function(){
                        $('#ban_user').click(function(){
                            $.ajax({
                                url: "{{ ('banuser') }}/{{ $user->id }}",
                                type: "GET", //send it through post method
                                data: { 
                                  //send your data here 
                                },
                                success: function(response) {
                                    let x = window.location.href;
                                    $('#likee').delay(0.0001).load(x);
                                    console.log(x); // Your response.
                                },
                                error: function(xhr) {
                                  console.log("ERROR"+xhr); // Debug errors.
                                }
                            });

                        });
                    });

                    $(document).ready(function(){
                        $('#reset').click(function(){
                            $.ajax({
                                url: "{{ ('reset') }}/{{ $user->id }}",
                                type: "GET", //send it through post method
                                data: { 
                                  //send your data here 
                                },
                                success: function(response) {
                                    let x = window.location.href;
                                    $('#likee').delay(0.0001).load(x);
                                    console.log(x); // Your response.
                                },
                                error: function(xhr) {
                                  console.log("ERROR"+xhr); // Debug errors.
                                }
                            });

                        });
                    });
                </script>

                <div class="modal fade" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                  <div class="modal-dialog" style="background:white">
                      <div class="modal-content">
                        <div class="modal-header">
                            <h4>Reset Password</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          
                        </div>
                        <div class="modal-body">
                          <form method="post" class="profile-wrapper" action="{{ url('admin/changepassword') }}" >
                             {{ csrf_field() }}
                              
                              <div class="form-group">
                                  <label for="fname">New Password</label>                     
                                  <input class="form-control" type="password" name="password" required autofocus>
                                  <input type="hidden" name="id" value="{{ $user->id }}">
                              </div> 
                              <button type="submit" class="btn btn-success pull-right">Save <i class="fa fa-save"></i></button>                              
                          </form>
                        </div>
                        
                        <div class="modal-footer">
                         
                        </div>
                      </div><!-- /.modal-content -->                     
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
   .breadcromb-area{
      min-height: 150px;
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
@endsection
