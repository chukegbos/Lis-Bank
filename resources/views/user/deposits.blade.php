@extends('layouts.usermaster')
@section('pageTitle', 'Deposit')
@section('content')
<div class="breadcromb-area">
   <div class="row">
      <div class="col-md-6  col-sm-6">
         <div class="seipkon-breadcromb-left pt-3  pull-right text-center">
            <h3>Make A Deposit</h3>
            <br>
            <a href="#page-box" class="btn btn-excel pull-right">View Deposit History</a> 
         </div>
      </div>
   </div>
</div>

<div class="page-content">  
  <div class="row">
    <div class="col-md-12 p-3">
      <h4 class="text-center"><b>Bank Transfers</b></h4>
    </div>

    @forelse($banks as $bank)
      <div class="col-md-4">
        <a href="#" data-toggle="modal" data-target="#addbank">
          <div class="card p-3 mt-5 btc">
            <div class="card-body">
               <h4><b>{{ $bank->name }}</b></h4>
               <p>Account Number: {{ $bank->account_number }}</p>
               <p>Account Name: {{ $bank->account_name }}</p>
            </div>
          </div>
        </a>
      </div>
      <div class="modal fade mt-5" id="addbank" tabindex="-1" role="dialog" aria-labelledby="addbanklabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form method="POST" action="{{ url('user/deposit/create') }}" enctype="multipart/form-data">
                  @csrf
                   <div class="modal-body">
                      <div class="form-group">
                         <label>Amount</label>
                         <input type="number" name="amount" required="" class="form-control">
                      </div>
                      <div class="form-group">
                         <label>Upload Proof of Payment</label>
                         <input type="file" name="pop" required="" class="form-control">
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
             </div>
          </div>
      </div>
    @empty
    @endforelse 
  </div>

  <div class="row">
    <div class="col-md-12 p-3">
      <h4 class="text-center"><b>Crypto Coin Transfers</b></h4>
    </div>

    @forelse($btcs as $btc)
      <div class="col-md-3">
        <a href="#" data-toggle="modal" data-target="#addAmount{{ $btc->id }}">
          <div class="card p-3 mt-5 btc">
            <div class="card-body text-center">
               <img src="{{ asset('storage') }}/{{ $btc->image }}" class="center img-responsive p-3" style="height: 50px">
               <h4><b>{{ $btc->name }}</b></h4>
            </div>
          </div>
        </a>
      </div>
      <div class="modal fade mt-5" id="addAmount{{ $btc->id }}" tabindex="-1" role="dialog" aria-labelledby="addAmount{{ $btc->id }}Label" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <form method="POST" action="{{ url('user/deposit/create') }}">
                  @csrf
                   <div class="modal-body">
                      <input type="hidden" name="id" value="{{ $btc->id }}">
                      <div class="form-group">
                         <label>Amount</label>
                         <input type="number" name="amount" required="" class="form-control">
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
             </div>
          </div>
      </div>
    @empty
    @endforelse 
  </div>

  <div class="row">
     <div class="col-md-12">
        <div class="page-box" id="page-box">
           <div class="datatables-example-heading">
              <h3>Deposit History</h3>
           </div>
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
                    </tr>
                 </thead>
                 <tbody>
                    @forelse($deposits as $deposit)
                       <tr>
                          <td>
                             {{ $deposit->ref_id }} 
                             @if(!isset($deposit->pop) && ($deposit->status=='pending'))
                                <a href="{{ url('user/deposit/invoice') }}/?ref_id={{ $deposit->ref_id }}&method={{ $deposit->method }}" class="pull-right" style="color: blue">View</a>
                             @endif</td>
                          <td>{{ $deposit->amount }}</td>
                          <td>{{ $deposit->method }}</td>
                          <td>{{ $deposit->created_at }}</td>
                          <td>{{ $deposit->status }}</td>
                          <td>{{ $deposit->charge }}</td>
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
