@extends('layouts.sitemaster')
@section('pageTitle', 'All Deposits')
@section('content')
<div class="breadcromb-area">
   <div class="row">
      <div class="col-md-6 col-sm-6">
         <div class="seipkon-breadcromb-left pt-3  pull-right text-center">
            <h3>All Deposit</h3>
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
                       <th>Reference Id</th>
                       <th>Amount</th>
                       <th>Method</th>
                       <th>Date</th>
                       <th>Status</th>
                       <th>Charge</th>
                       <th>Action</th>
                    </tr>
                 </thead>
                 <tbody>
                    @forelse($deposits as $deposit)
                       <tr>
                          <td>
                             {{ $deposit->ref_id }} 
                           </td>
                          <td>{{ $deposit->amount }}</td>
                          <td>{{ $deposit->method }}</td>
                          <td>{{ $deposit->created_at }}</td>
                          <td>{{ $deposit->status }}</td>
                          <td>{{ $deposit->charge }}</td>
                          <td>@if($deposit->status=="pending")<a href="{{ url('/admin/deposit') }}/{{ $deposit->ref_id }}" style="color: blue">Approve</a> | <a href="#" onclick="event.preventDefault(); document.getElementById('delete{{ $deposit->id }}').submit();" style="color: red">Delete</a>@endif</td>

                          <form id="delete{{ $deposit->id }}" action="{{ url('admin/deposit') }}/{{ $deposit->id }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                            {{ Method_field('DELETE') }}
                          </form> 
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
