@extends('layouts.sitemaster')
@section('pageTitle', 'Transaction Details')
@section('content')
<div class="breadcromb-area">
   <div class="row">
      <div class="col-md-6  col-sm-6">
         <div class="seipkon-breadcromb-left pt-3  pull-right text-center">
            <h3>Transaction Details</h3>
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
          <div class="card-body table-responsive p-0">
              <div class="row">
                  <div class="col-md-6">
                      <table class="table table-hover">
                          <tr>
                            <th width="170px">From</th>
                            <td><a href="{{ url('admin/searchaccount') }}/{{ $transaction->sender_id }}" style="color: blue">{{ $transaction->sender_id }}</a></td>
                          </tr>   

                          <tr>
                            <th width="170px">Sender Name</th>
                            <td>{{ ucwords($user->name) }}</td>
                          </tr>  

                          <tr>
                              <th width="170px">Sender Phone Number</th>
                              <td>{{ $user->phone }}</td>
                          </tr> 

                          <tr>
                              <th width="170px">Sender Email</th>
                              <td>{{ $user->email }}</td>
                          </tr>               

                          <tr>
                              <th width="170px">Description</th>
                              <td>{{ $transaction->description }}</td>
                          </tr> 
                      </table> 
                  </div>
                  <div class="col-md-6">
                      <table class="table table-hover">
                          <tr>
                              <th width="170px">Paid To</th>
                              <td><a href="{{ url('admin/searchaccount') }}/{{ $transaction->sender_id }}" style="color: blue">{{ $transaction->rec_number }}</a></td>
                          </tr> 

                          <tr>
                              <th width="170px">Reciever's Name</th>
                              <td>{{ $transaction->rec_name }}</td>
                          </tr>   

                          <tr>
                              <th width="170px">Reciever's Phone</th>
                              <td>{{ $transaction->rec_phone }}</td>
                          </tr>  

                          <tr>
                              <th width="170px">Reciever's Email</th>
                              <td>{{ $transaction->rec_email }}</td>
                          </tr> 

                          <tr>
                              <th width="170px">Amount Paid</th>
                              <td>{{ $transaction->amount }} {{ $transaction->currency_type }}</td>
                          </tr>  

                          <tr>
                              <th width="170px">Status</th>
                              <td>
                                  {{ $transaction->status }}
                                  <a href="#" data-toggle="modal" data-target="#changestatus" style="color: blue" class="pull-right">Change Status</a>
                              </td>
                          </tr>

                          <tr>
                              <th width="170px">Date Paid</th>
                              <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($transaction->main_date))->toFormattedDateString() }}
                                <a href="#" data-toggle="modal" data-target="#changedate" style="color: blue" class="pull-right">Change Date</a></td>
                          </tr>  
                      </table> 
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="changestatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" style="background:white">
      <div class="modal-content">
        <div class="modal-header">
            <h4>Change Status</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          
        </div>
        <div class="modal-body">
          <form method="post" class="profile-wrapper" action="{{ url('admin/changestatus') }}" >
             {{ csrf_field() }}
              
              <div class="form-group">
                <label for="fname">Select Status</label> 
                <select name="status" class="form-control" required="">
                    <!--<option value="Pending">Pending</option>-->
                    <option value="Approved">Approved</option>
                    <option value="Cancelled">Cancelled</option>
                </select> 
                <input type="hidden" name="id" value="{{ $transaction->id }}">
              </div> 
              <button type="submit" class="btn btn-success pull-right">Save <i class="fa fa-save"></i></button>                              
          </form>
        </div>
        
        <div class="modal-footer">
         
        </div>
      </div><!-- /.modal-content -->                     
  </div>
</div>

<div class="modal fade" id="changedate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" style="background:white">
      <div class="modal-content">
        <div class="modal-header">
            <h4>Change Date</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          
        </div>
        <div class="modal-body">
          <form method="post" class="profile-wrapper" action="{{ url('admin/changedate') }}" >
             {{ csrf_field() }}
              
              <div class="form-group">                   
                  <input class="form-control" type="date" name="main_date" required autofocus>
                  <input type="hidden" name="id" value="{{ $transaction->id }}">
              </div> 
              <button type="submit" class="btn btn-success pull-right">Save <i class="fa fa-save"></i></button>                              
          </form>
        </div>
        
        <div class="modal-footer">
         
        </div>
      </div><!-- /.modal-content -->                     
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
