@extends('layouts.usermaster')
@section('pageTitle', 'Saving')
@section('content')
<div class="breadcromb-area">
   <div class="row">
      <div class="col-md-6  col-sm-6">
         <div class="seipkon-breadcromb-left pt-3  pull-right text-center">
            <h3>Create your savings</h3>
            <br>
            <a href="#page-box" class="btn btn-excel pull-right">View saving History</a> 
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
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <div class="card text-center">
        <div class="card-body">
          <form method="POST" action="{{ url('user/save') }}">
            @csrf
              <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
              <div class="form-group">
                <label>Amount</label>
                <input type="number" name="amount" class="form-control" required max="{{ Auth::user()->balance }}">
              </div>

              <div class="form-group">
                <label>Due Date</label>
                <input type="date" name="due_date" class="form-control" required>
              </div>

              <div class="form-group">
                <label>Purpose of Saving</label>
                <input type="text" name="purpose" class="form-control" required="" placeholder="For my education">
              </div>
          
              <button type="submit" class="btn btn-primary">Create</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
     <div class="col-md-12">
        <div class="page-box" id="page-box">
           <div class="datatables-example-heading">
              <h3>Piggy Save</h3>
           </div>
           <div class="table-responsive advance-table">
              <table id="example1" class="table display table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Purpose</th>
                    <th>Amount</th>
                    <th>Due Date</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($savings as $saving)
                    <tr>
                      <td>{{ $saving->purpose }}</td>
                      <td>{{ $saving->amount }}</td>
                      <td>
                        {{ \Carbon\Carbon::createFromTimeStamp(strtotime($saving->due_date))->toFormattedDateString() }} 
                      </td>
                      <td>
                        @if($saving->due_date < \Carbon\Carbon::today())
                          Completed
                        @else
                          Running
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
