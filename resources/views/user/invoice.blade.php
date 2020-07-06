@extends('layouts.usermaster')
@section('pageTitle', 'Deposit')
@section('content')
<div class="breadcromb-area">
   <div class="row">
      <div class="col-md-6  col-sm-6">
         <div class="seipkon-breadcromb-left pt-3  pull-right text-center">
            <h3>Invoice</h3>
         </div>
      </div>
   </div>
</div>

<div class="page-content">
   <div class="container">
      <div class=" card page-box">
         <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
               <div class="card btc text-center">
                  <div class="card-body">
                     <h4><b>Ref ID</b>: {{ $invoice->ref_id }}</h4><br>
                     <h4><b>Amount</b>: {{ $invoice->amount }} USD</h4><br>
                     <h4><b>Charge</b>: {{ $invoice->charge }} USD</h4><br>
                     <h4><b>Payable</b>: {{ $invoice->payable }} US</h4><br>
                     <h4><b>Status</b>: {{ $invoice->status }}</h4><br>
                     <h4><b>Method</b>: {{ $invoice->method }}</h4>
                     <br>
                     <br>
                     <h4> PLEASE SEND EXACTLY <span style="color: green">{{ $invoice->amount }} USD</span><br><br>
                     TO <span style="color: green">{{ $btc->detail }}</span></h4><br>
                     <div class="card-image">
                        @if(!isset($btc->barcode))
                           <img src="{{ asset('img/barcode.png') }}" style="height: 150px">
                        @else
                           <img src="{{ asset('storage') }}/{{ $btc->barcode }}" style="height: 150px">
                        @endif
                     </div><br>
                     <h4>SCAN TO SEND</h4>
                  </div>
               </div>
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
