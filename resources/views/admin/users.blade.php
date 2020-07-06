@extends('layouts.sitemaster')
@section('pageTitle', 'All Users')
@section('content')

<div class="breadcromb-area">
  <div class="row">
    <div class="col-md-6  col-sm-6">
      <div class="seipkon-breadcromb-left pt-3  pull-right text-center">
        <h3>All Users</h3>
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

      <div class="table-responsive p-2">
        <table class="table table-hover" id="example1">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Acct Number</th>
              <th>Acct Balance</th>
              <th>Acct Type</th>
              <th>Date Joined</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $user)
              <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->account_number }}</td>
                <td>{{ $user->total_balance }} <a href="#" data-toggle="modal" data-target="#addfund{{ $user->id }}" class="pull-right" style="color: blue">Add Fund</a></td>
                <td>{{ $user->account_type }}</td>
                <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($user->created_at))->toFormattedDateString() }}</td>

                <td style="padding: 10px">
                  <a href="{{ url('admin/searchaccount') }}/{{ $user->account_number }}" style="color: blue"> Profile</a>
                  |
                  <a href="{{ url('users') }}/{{ $user->id }}" target="_blank" style="color: green">
                    Login
                  </a>
                  |
                  <a href="#" onclick="event.preventDefault(); document.getElementById('delete{{ $user->id }}').submit();" style="color: red">
                    Delete
                  </a>

                  <form id="delete{{ $user->id }}" action="{{ url('admin/users') }}/{{ $user->id }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                    {{ Method_field('DELETE') }}
                  </form>  
                </td>

                <div class="modal fade" id="addfund{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                  <div class="modal-dialog" style="background:white">
                      <div class="modal-content">
                        <div class="modal-header">
                            <h4>Add Fund</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          
                        </div>
                        <div class="modal-body">
                            <form method="post" class="profile-wrapper" action="{{ url('admin/addfund') }}" >
                                {{ csrf_field() }}
                              
                                <div class="form-group">                   
                                    <input class="form-control" type="number" name="balance" required autofocus>
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
              </tr> 
            @empty
            @endforelse 
          </tbody>                
        </table>
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
