@extends('layouts.sitemaster')
@section('pageTitle', 'Dashboard')
@section('content')
<div class="breadcromb-area">
   <div class="row">
      <div class="col-md-6  col-sm-6">
         <div class="seipkon-breadcromb-left">
            <h3>Dashboard</h3>
         </div>
      </div>
      <div class="col-md-6 col-sm-6">
         <div class="seipkon-breadcromb-right">
            
         </div>
      </div>
   </div>

   <div class="row" style="margin-top: 150px">
       <div class="col-md-6  col-sm-6">
         <div class="seipkon-breadcromb-left">
            <h3><b>Phone</b>: {{ $setting->phone }}</h3>
            <br>
            <h3><b>Email</b>: {{ $setting->email }}</h3>
            <br>
            <h3><b>Address</b>: {{ $setting->address}}</h3>
         </div>
      </div>
     
   </div>
</div>

<div class="page-content">
   	<div class="container-fluid">
      	<div class="row">
         	<div class="col-md-4">
               	<div class="card bg-gradient-default shadow">
                  	<div class="card-body">
                     	<h3 class="card-title mb-3 text-white">Piggy Save</h3>
                     	<p class="card-text mb-4 text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna .</p>
                  	</div>
               	</div>
         	</div>

	        <div class="col-md-4">
	            <div class="card bg-gradient-default shadow">
	                <div class="card-body">
	                    <h3 class="card-title mb-3 text-white">Loan Investment</h3>
	                    <p class="card-text mb-4 text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna .</p>
	                </div>
	            </div>
	        </div>

         	<div class="col-md-4">
               	<div class="card bg-gradient-default shadow">
                  	<div class="card-body">
                     	<h3 class="card-title mb-3 text-white">IV Scheme</h3>
                     	<p class="card-text mb-4 text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna .</p>
                  	</div>
               	</div>
         	</div>
      	</div>
   	</div>
</div>


<style>
   #content > .page-content {
    min-height: 50vh !important;
    padding: 30px 15px;
   }
   .breadcromb-area{
      min-height: 350px;
      background-image: url('{{ asset('assets/img/breadcromb1.jpg') }}');
      background-size: cover;
      padding: 40px;
      color: #fff
   }

   .btn-excel{
      background: #000;
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
</style>
@endsection