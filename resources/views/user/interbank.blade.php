@extends('layouts.usermaster')
@section('pageTitle', 'International Transactions')
@section('content')
<div class="breadcromb-area">
   <div class="row">
        <div class="col-md-6  col-sm-6">
            <div class="seipkon-breadcromb-left pt-3  pull-right text-center">
                <h3>International Transactions</h3>
                <br>
                <a href="#page-box" class="btn btn-excel pull-right">View International Transactions</a> 
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
            <div class="card ">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" action="{{ url('user/international-transfer/storeinterbank') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="your-label" class="form-label">Name of Bank</label>
                                    <input type="text" name="bank_name" required="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="your-label" class="form-label">Reciever's Account Number</label>
                                    <input type="text" name="rec_number" required="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="your-label" class="form-label">Reciever's Account Name</label>
                                    <input type="text" name="rec_name" required="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="your-label" class="form-label">Reciever's Email</label>
                                    <input type="email" name="rec_email" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="your-label" class="form-label">Reciever's Phone Number</label>
                                    <input type="tel" name="rec_phone" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="your-label" class="form-label">Amount</label>
                                    <input type="number" required class="form-control" name="amount">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="your-label" class="form-label">Currency Type</label>
                                    <select name="currency_type" class="form-control" required="">
                                        <option value="USD"> USD</option>

                                        <option value="EUR"> EUR</option>

                                        <option value="PND"> Pounds</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="your-label" class="form-label">PIN</label>
                                    <input type="number" required class="form-control" name="pin">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="your-label" class="form-label">Description</label>
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6 p-4"> 
                                <button class="btn btn-success" type="submit">Transfer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3" id="page-box">
        <div class="col-md-12 m-2">
            <div class="card table-responsive p-0">
                <h3 style="text-align: center; margin: 10px">Debit</h3>
                <table id="example3" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Trans ID</th>
                            <th>Paid to</th>
                            <th>Name</th>
                            <th>amount</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Date</th>
                        </tr> 
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->transaction_id }}</td>
                                <td>{{ $transaction->rec_number }}</td>
                                <td>{{ $transaction->rec_name }}</td>
                                <td>{{ $transaction->amount }} {{ $transaction->currency_type }}</td>
                                <td>{{ $transaction->bank_name }}</td>
                                <td>{{ $transaction->status }}
                                    @if($transaction->status=="Pending")<br>
                                    <a href="#" data-toggle="modal" data-target="#otp{{ $transaction->id }}" style="color: blue">Put OTP</a>
                                    @endif
                                </td>
                                <td>
                                    @if($transaction->status=="Approved")
                                    <a href="{{ url('user/domestic-transfer/viewpdf') }}/{{ $transaction->id }}" style="color: blue">View Receipt</a>
                                    @endif
                                </td>

                                <div class="modal fade" id="otp{{ $transaction->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                  <div class="modal-dialog" style="background:white">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>Put OTP</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" class="profile-wrapper" action="{{ url('/user/domestic-transfer/otp') }}" >
                                                {{ csrf_field() }}
                                              
                                                <div class="form-group">
                                                    <input class="form-control" type="text" name="otp" required autofocus>
                                                    <input type="hidden" name="transaction_id" value="{{ $transaction->transaction_id }}">
                                                </div> 
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-success pull-right">Submit <i class="fa fa-save"></i></button>
                                                </div>                               
                                          </form>
                                        </div>
                                        
                                        <div class="modal-footer">
                                         
                                        </div>
                                      </div><!-- /.modal-content -->                     
                                  </div>
                                </div>
                                <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($transaction->main_date))->toFormattedDateString() }}</td>
                            </tr> 
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12 m-2">
            <div class="card table-responsive p-0">
                <h3 style="text-align: center; margin: 10px">Credit</h3>
                <table id="example1" class="table table-hover">
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Date Paid</th>
                        </tr> 
                    </thead>
                    <tbody>
                        @forelse($recieves as $transaction)
                            <tr>
                                <td>{{ $transaction->sender_id }}</td>
                                <td>{{ $transaction->amount }} {{ $transaction->currency_type }}</td>
                                <td>{{ $transaction->bank_name }}</td>
                                <td>{{ $transaction->status }}</td>
                                <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($transaction->main_date))->toFormattedDateString() }}</td>
                            </tr> 
                        @empty
                        @endforelse
                    </tbody>
                </table>
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

<script type="application/javascript"> 
    $(document).ready( function () {
        $('#example1').DataTable(
            {
                "ordering": false
            });

        $('#example3').DataTable(
            {
                "ordering": false
            });

        $('#example2').DataTable(
            {
                "ordering": true
            });
        });
    function myFunction() {
        let x = document.getElementById("rec_number");
        $.ajax({
            url: "{{ ('domestic-transfer/getuser/') }}"+x.value,
            type: "GET", //send it through post method
            data : {"_token":"{{ csrf_token() }}"},
            dataType: "json",
            success: function(response) {
                if(response.name!=undefined){
                    var codeBlock = 
                    '<span>'+
                        'Reciever Name: ' +response.name +
                    '</span>';

                    document.getElementById("wrapper").innerHTML = codeBlock 
                }
                else
                {
                    var codeBlock = 
                    '<span>'+
                        'Account Not Found!!!' +
                    '</span>';

                    document.getElementById("wrapper").innerHTML = codeBlock 
                }
            },
            error: function(xhr) {
                var codeBlock = 
                '<span>'+
                    'Account Not Found!!!' +
                '</span>';

                document.getElementById("wrapper").innerHTML = codeBlock 
            }
        });
    }
</script>
@endsection
