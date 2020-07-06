@extends('layouts.sitemaster')
@section('pageTitle', 'Withdraw')
@section('content')
<div class="breadcromb-area">
   <div class="row">
      <div class="col-md-6  col-sm-6">
         <div class="seipkon-breadcromb-left pt-3  pull-right text-center">
            <h3>Request for withdraw</h3>
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
               <div class="table-responsive advance-table">
                  <table id="example1" class="table display table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($withdraws as $withdraw)
                        <tr>
                          <td>{{ $withdraw->amount }}</td>
                          <td>
                            {{ \Carbon\Carbon::createFromTimeStamp(strtotime($withdraw->created_at))->toFormattedDateString() }} 
                          </td>
                          <td>
                            @if($withdraw->status==NULL)
                              Pending
                              <a href="{{ url('/admin/withdraw') }}/{{ $withdraw->id }}" class="btn btn-excel btn-xs float-right">Approve</a>
                              
                            @else
                              Paid
                            @endif
                          </td>
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
