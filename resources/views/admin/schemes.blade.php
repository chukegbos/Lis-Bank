@extends('layouts.sitemaster')
@section('pageTitle', 'All loans')
@section('content')
<div class="breadcromb-area">
  <div class="row">
    <div class="col-md-6  col-sm-6">
      <div class="seipkon-breadcromb-left pt-3  pull-right text-center">
        <h3>All Loans</h3>
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
                        <th>User</th>
                        <th>Trancs ID</th>
                        <th>Package</th>
                        <th>Interest (%)</th>
                        <th>Amount Invested</th>
                        <th>Withdrawable</th>
                        <th>Date of Approval</th>
                        <th>Date of Completion</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($investments as $investment)
                        <tr>
                          <td>{{ $investment->fullname }}</td>
                          <td>{{ $investment->transaction_id }}</td>
                          <td>{{ $investment->name }}</td>
                          <td>{{ $investment->commission }}</td>
                          <td>{{ $investment->amount }}</td>
                          <td>
                            @if($investment->paid==1)
                              {{ $investment->balance }}
                            @else
                              -
                            @endif
                          </td>
                          <td>
                            @if($investment->paid==1)
                              {{ \Carbon\Carbon::createFromTimeStamp(strtotime($investment->created_at))->toFormattedDateString() }}
                            @else
                              -
                            @endif
                          </td>
                          <td>
                            @if($investment->paid==1)
                              @if($investment->withdrawal_date==NULL)
                                -
                              @else
                                {{ \Carbon\Carbon::createFromTimeStamp(strtotime($investment->withdrawal_date))->toFormattedDateString() }}
                              @endif
                            @else
                              -
                            @endif
                          </td>
                          <td>
                            @if($investment->withdraw==1)
                              <span class="btn btn-warning btn-xs">Concluded</span>
                            @else
                              <span class="btn btn-primary btn-xs">Still Running</span>
                            @endif
                            <!--@if($investment->paid==0)
                              <a href="{{ url('user/investments/invoice') }}/?id={{ $investment->id }}" class="btn btn-info btn-xs">Click to pay</a>
                            @else
                              @if($investment->status=="Click to withdraw")
                                @if($investment->withdraw==NULL)
                                  <a href="#" data-toggle="modal" data-target="#editSession{{ $investment->id }}" class="btn btn-success btn-xs">Click to withdraw</a>

                                  <div class="modal fade mt-5" id="editSession{{ $investment->id }}" tabindex="-1" role="dialog" aria-labelledby="editSession{{ $investment->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>

                                        <form method="POST" action="{{ url('user/withdraws') }}">
                                          @csrf
                                          <div class="modal-body">
                                            <input type="hidden" name="id" value="{{ $investment->id }}">
                                            <input type="hidden" name="amount" value="{{ $investment->balance }}">
                                          </div>
                                          <h5>Are you sure you want to withdraw</h5>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                            <button type="submit" class="btn btn-primary">Yes</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                @elseif($investment->withdraw==1)
                                  <span class="btn btn-warning btn-xs">Requested</span>
                                @else
                                  <span class="btn btn-primary btn-xs">Concluded</span>
                                @endif
                              @else
                                <span class="btn btn-danger btn-xs">{{ $investment->status }}</span>
                              @endif
                            @endif-->
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
