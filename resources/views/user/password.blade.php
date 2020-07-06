@extends('layouts.usermaster')
@section('pageTitle', 'Change Password')
@section('content')
<div class="breadcromb-area">
   <div class="row">
      <div class="col-md-6  col-sm-6">
        <div class="seipkon-breadcromb-left pt-3  pull-right text-center">
          <h3>Change Password</h3>
        </div>
      </div>
   </div>
</div>

<div class="page-content">  
  <div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
      <div class="card mt-3">
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

        <div class="card-body">
          <form method="POST" action="{{ route('userchangePassword') }}">
            {{ csrf_field() }}
                            
            <div class="form-group-inner{{ $errors->has('current-password') ? ' has-error' : '' }}">
                <label>Current Password</label>
                <input id="current-password" type="password" class="form-control" name="current-password" required>
                @if ($errors->has('current-password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('current-password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group-inner{{ $errors->has('new-password') ? ' has-error' : '' }}">
                <label>New Password</label>
                <input id="new-password" type="password" class="form-control" name="new-password" required>
                @if ($errors->has('new-password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('new-password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group-inner{{ $errors->has('new-password') ? ' has-error' : '' }}">
                <label>Confirm New Password</label>
                <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
            </div>
                 
            <div class="form-group" style="margin-top: 10px">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Change Password
                    </button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
   .breadcromb-area{
      min-height: 250px;
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
