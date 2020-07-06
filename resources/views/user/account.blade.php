@extends('layouts.usermaster')
@section('pageTitle', 'Statement of Accounts')
@section('content')
<div class="breadcromb-area">
   <div class="row">
      <div class="col-md-6  col-sm-6">
          <div class="seipkon-breadcromb-left pt-3  pull-right text-center">
            <h3>Statement of Account</h3>
            <br>
          </div>
      </div>
   </div>
</div>

<div class="page-content">
  <div class="row">
     <div class="col-md-12">
        <div class="page-box" id="page-box">
           <div class="table-responsive advance-table">
              <table id="example1" class="table display table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Purpose</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($accounts as $account)
                    <tr>
                      <td>
                        {{ \Carbon\Carbon::createFromTimeStamp(strtotime($account->created_at))->toDateTimeString() }} 
                      </td>
                      <td>{{ $account->type }}</td>
                      <td>{{ $account->amount }}</td>
                      <td>{{ $account->purpose }}</td>
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
      min-height: 200px;
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
