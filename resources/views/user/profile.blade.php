@extends('layouts.usermaster')
@section('pageTitle', 'Update Profile')
@section('content')
<div class="breadcromb-area">
   <div class="row">
      <div class="col-md-6  col-sm-6">
         <div class="seipkon-breadcromb-left pt-3  pull-right text-center">
            <h3>Update Profile</h3>
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
      <div class="card">
        <div class="card-body">
          <form method="POST" action="{{ url('user/profile') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Fullname</label>
                  <input type="text" name="name" class="form-control" required value="{{ Auth::user()->name }}">
                </div>

                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" readonly="" value="{{ Auth::user()->email }}">
                </div>

                <div class="form-group">
                  <label>Phone Number</label>
                  <input type="tel" name="phone" class="form-control" required="" value="{{ Auth::user()->phone }}">
                </div>

                <div class="form-group">
                  <label>Profile Picture</label>
                  @if(Auth::user()->image==NULL)
                    <input type="file" name="image" class="form-control" required="">
                  @else
                    <input type="file" name="image" class="form-control">
                  @endif
                </div>
              </div>
                
              <div class="col-md-6">
                <div class="form-group">
                  <label>Account Name</label>
                  <input type="text" name="acc_name" class="form-control" required value="{{ Auth::user()->acc_name }}">
                </div>

                <div class="form-group">
                  <label>Bank Account Number</label>
                  <input type="text" name="acc_number" class="form-control" required="" value="{{ Auth::user()->acc_number }}">
                </div>

                <div class="form-group">
                  <label>Name of Bank</label>
                  <input type="text" name="bank_name" class="form-control" required="" value="{{ Auth::user()->bank_name }}">
                </div>

                <div class="form-group">
                  <label>Kyc verification (Upload an identity document, for example, driver licence, voters card, international passport, national ID.)</label>
                  @if(Auth::user()->id_card==NULL)
                    <input type="file" name="id_card" class="form-control" required="">
                  @else
                    <input type="file" name="id_card" class="form-control">
                  @endif
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Address</label>
                  <input type="text" name="address" class="form-control" required value="{{ Auth::user()->address}}">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>City</label>
                  <input type="text" name="city" class="form-control" required value="{{ Auth::user()->city}}">
                </div>

                <div class="form-group">
                  <label>Country</label>
                  <input type="text" name="country" class="form-control" value="{{ Auth::user()->country}}">
                </div>
              </div>
                
              <div class="col-md-6">
                <div class="form-group">
                  <label>State</label>
                  <input type="text" name="state" class="form-control" required value="{{ Auth::user()->state }}">
                </div>

                <div class="form-group">
                  <label>Zip Code</label>
                  <input type="text" name="zip_code" class="form-control" required="" value="{{ Auth::user()->zip_code }}">
                </div>
              </div>

              <div class="col-md-4 col-sm-4">
                <div class="form-group">
                  <label for="your-label" class="form-label">Account Type</label>
                  <select name="account_type" class="form-control" required="">
                    <option value="Savings Account" @if(Auth::user()->account_type=="Savings Account") selected @endif> Savings Account</option>

                    <option value="Current Account" @if(Auth::user()->account_type=="Current Account") selected @endif> Current Account</option>

                    <option value="Fixed Deposit Account" @if(Auth::user()->account_type=="Fixed Deposit") selected @endif> Fixed Deposit Account</option>
                  </select>
                </div>
              </div>

              <div class="col-md-4 col-sm-4">
                <div class="form-group">
                  <label for="your-label" class="form-label">Currency Type</label>
                  <select name="currency_type" class="form-control" required="">
                    <option value="USD" @if(Auth::user()->currency_type=="USD") selected @endif> USD</option>

                    <option value="EUR" @if(Auth::user()->currency_type=="EUR") selected @endif> EUR</option>

                    <option value="PND" @if(Auth::user()->currency_type=="PND") selected @endif> Pounds</option>
                  </select>
                </div>
              </div>
              
              <div class="col-md-4 col-sm-4">
                <div class="form-group">
                  <label for="your-label" class="form-label">Sort Code</label>
                  <input type="text" value="{{ Auth::user()->sort_code }}" class="form-control" required="" name="sort_code">
                </div>
              </div>

              <div class="col-md-4 col-sm-4">
                <div class="form-group">
                  <label for="your-label" class="form-label">TOC</label>
                  <input type="text" value="{{ Auth::user()->toc }}" class="form-control" required="" name="toc">
                </div>
              </div>
                       
              <div class="col-md-4 col-sm-4">
                <div class="form-group">
                  <label for="your-label" class="form-label">TC</label>
                  <input type="text" value="{{ Auth::user()->tc }}" class="form-control" required="" name="tc">
                </div>
              </div>

              <div class="col-md-4 col-sm-4">
                <div class="form-group">
                  <label for="your-label" class="form-label">Tax No</label>
                  <input type="text" value="{{ Auth::user()->tax }}" class="form-control" required="" name="tax">
                </div>
              </div>

              <div class="col-md-3 col-sm-3">
                <div class="form-group">
                  <label for="your-label" class="form-label">IRDC</label>
                  <input type="text" value="{{ Auth::user()->irdc }}" class="form-control" required="" name="irdc">
                </div>
              </div>

              <div class="col-md-3 col-sm-3">
                <div class="form-group">
                  <label for="your-label" class="form-label">IBAN</label>
                  <input type="text" value="{{ Auth::user()->iban }}" class="form-control" required="" name="iban">
                </div>
              </div>

              <div class="col-md-3 col-sm-3">
                <div class="form-group">
                  <label for="your-label" class="form-label">Swift Code</label>
                  <input type="text" value="{{ Auth::user()->swift_code }}" class="form-control" required="" name="swift_code">
                </div>
              </div>
              <div class="col-md-3 col-sm-3">
                <div class="form-group">
                  <label for="your-label" class="form-label">PIN</label>
                  <input type="number" value="{{ Auth::user()->pin }}" class="form-control" required="" name="pin">
                </div>
              </div>

              <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
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
