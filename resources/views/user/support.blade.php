@extends('layouts.usermaster')
@section('pageTitle', 'Support')
@section('content')
<div class="breadcromb-area">
   <div class="row">
      <div class="col-md-6  col-sm-6">
         <div class="seipkon-breadcromb-left">
            <h3>Contact us at:</h3>
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
      
      </div>
   </div>
</div>


<style>
   #content > .page-content {
    min-height: 50vh !important;
    padding: 30px 15px;
   }
   .breadcromb-area{
      min-height: 650px;
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