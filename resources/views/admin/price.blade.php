@extends('layouts.sitemaster')
@section('pageTitle', 'Prices')
@section('content')

<div class="breadcromb-area">
  <div class="row">
    <div class="col-md-6  col-sm-6">
      <div class="seipkon-breadcromb-left pt-3  pull-right text-center">
        <h3>All Investment Plans</h3>
      </div>
    </div>
  </div>
</div>

<div class="page-content">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
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

        <div class="card-header">
            <div class="card-title">
              <h4>Prices
                <button class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#addSession">Add New <i class="fa fa-plus fa-fw"></i></button>
              </h4>
            </div>
            <div class="modal fade mt-5" id="addSession" tabindex="-1" role="dialog" aria-labelledby="addSessionLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="addCourseLabel">Add Price</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <form method="POST" action="{{ url('admin/investment-plan') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                      </div>

                      <div class="form-group">
                        <label>Minimum Amount</label>
                        <input type="number" name="min" class="form-control" required>
                      </div>

                      <div class="form-group">
                        <label>Miximum Amount</label>
                        <input type="number" name="max" class="form-control" required>
                      </div>

                      <div class="form-group">
                        <label>Percentage Interest</label>
                        <input type="number" name="commission" class="form-control" required>
                      </div>

                      <div class="form-group">
                        <label>Duration of Increase</label>
                        <input type="number" name="compound" class="form-control" required>
                      </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        <div class="card-body">
          <div class="table-responsive p-2">
            <table class="table table-hover" id="example1">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Min Amount</th>
                  <th>Max Amount</th>
                  <th>Interest (%)</th>
                  <th>Duration (In Days)</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($prices as $price)
                  <tr>
                    <td>{{ $price->name }}</td>
                    <td>{{ $price->min }}</td>
                    <td>{{ $price->max }}</td>
                    <td>{{ $price->commission }}</td>
                    <td>{{ $price->compound }}</td>
                    <td>
                      <a href="#" data-toggle="modal" data-target="#editSession{{ $price->id }}">
                        Edit <i class="fa fa-edit text-blue"></i>
                      </a>
                      
                      |

                      <a href="#" onclick="event.preventDefault(); document.getElementById('delete{{ $price->id }}').submit();" class="text-red">
                        Delete <i class="fa fa-trash text-red"></i>
                      </a>

                      <form id="delete{{ $price->id }}" action="{{ url('admin/investment-plan') }}/{{ $price->id }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                        {{ Method_field('DELETE') }}
                      </form>  
                    </td>
                  </tr> 

                  <div class="modal fade mt-5" id="editSession{{ $price->id }}" tabindex="-1" role="dialog" aria-labelledby="editSession{{ $price->id }}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="addCourseLabel">Edit Price</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                        </div>

                        <form method="POST" action="{{ url('admin/investment-plan') }}/{{ $price->id }}">
                          @csrf
                          {{ method_field('PUT') }}
                          <div class="modal-body">
                            <div class="form-group">
                              <label>Title</label>
                              <input type="text" name="name" class="form-control" value="{{ $price->name }}">
                            </div>

                            <div class="form-group">
                              <label>Minimum Amount</label>
                              <input type="number" name="min" value="{{ $price->min }}" class="form-control" required>
                            </div>

                            <div class="form-group">
                              <label>Miximum Amount</label>
                              <input type="number" name="max" value="{{ $price->max }}" class="form-control" required>
                            </div>

                            <div class="form-group">
                              <label>Percentage Interest</label>
                              <input type="number" name="commission" value="{{ $price->commission }}" class="form-control" required>
                            </div>

                            <div class="form-group">
                              <label>Duration of Increase</label>
                              <input type="number" name="compound" value="{{ $price->compound}}" class="form-control" required>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                @empty
                @endforelse 
              </tbody>                
            </table>
          </div>
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
