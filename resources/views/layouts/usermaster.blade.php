<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <meta name="description" content="" />
      <meta name="keywords" content="" />
      <meta name="author" content="">
      <!-- Title -->
      <title>@yield('pageTitle') - {{ $setting->sitename }}</title>
      <!-- Favicon -->
      <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon/favicon-32x32.png' ) }}">
      <!-- Animate CSS -->
      <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css' ) }}">
      <link rel="stylesheet" href="{{ asset('assets/css/mb.css' ) }}">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css' ) }}">
      <!-- Font awesome CSS -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/font-awesome/font-awesome.min.css' ) }}">
      <!-- Themify Icon CSS -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/themify-icons/themify-icons.css' ) }}">
      <!-- Perfect Scrollbar CSS -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.css' ) }}">
      <!-- Jvector CSS -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/jvector/css/jquery-jvectormap.css' ) }}">
      <!-- Daterange CSS -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/css/daterangepicker.css' ) }}">
      <!-- Bootstrap-select CSS -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.min.css' ) }}">
      <!-- Summernote CSS -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/css/summernote.css' ) }}">
      <!-- Main CSS -->
      <link rel="stylesheet" href="{{ asset('assets/css/seipkon.css' ) }}">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="{{ asset('assets/css/responsive.css' ) }}">

      <!-- DataTables CSS -->
      <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/css/dataTables.bootstrap.min.css' ) }}">
      <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/css/buttons.bootstrap.min.css' ) }}">
      <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/css/responsive.bootstrap.min.css' ) }}">
      <script src="{{ asset('assets/js/jquery-3.1.0.min.js' ) }}"></script>

      <style>
        /*
            these styles will animate bootstrap alerts.
        */
        .alert{
            z-index: 99;
            right:18px;
            min-width:30%;
            position: fixed;
            animation: slide 10.5s forwards;
        }

        @keyframes slide {
            100% { top: 30px; }
        }

        @media screen and (max-width: 668px) {
            .alert{ /* center the alert on small screens */
                left: 10px;
                right: 10px; 
            }
        }
      </style>
   </head>

   <body>
       
      <!-- Start Page Loading -->
      <div id="loader-wrapper">
         <div id="loader"></div>
         <div class="loader-section section-left"></div>
         <div class="loader-section section-right"></div>
      </div>
      <!-- End Page Loading -->
       
      <!-- Wrapper Start -->
      <div class="wrapper">
         <!-- Main Header Start -->
         <header class="main-header">
             
            <!-- Logo Start -->
            <div class="seipkon-logo">
               <a href="{{ url('/') }}">
               <img src="{{ asset('storage') }}/{{ $setting->logo }}" alt="logo" style="height: 50px; width: 100px">
               </a>
            </div>
            <!-- Logo End -->
             
            <!-- Header Top Start -->
            <nav class="navbar navbar-default">
               <div class="container-fluid">
                  <div class="header-top-section">
                     <div class="pull-left">
                         
                        <!-- Collapse Menu Btn Start -->
                        <button type="button" id="sidebarCollapse" class=" navbar-btn">
                        <i class="fa fa-bars"></i>
                        </button>
                     </div>
                     <div class="header-top-right-section pull-right">

                        <ul class="nav nav-pills nav-top navbar-right">
                           
                           <!-- Full Screen Btn Start -->
                           <li>
                              <a href="#"  id="fullscreen-button">
                              <i class="fa fa-arrows-alt"></i>
                              </a>
                           </li>
                           <!-- Full Screen Btn End -->
                            <li class="pull-left" style="margin-top: 20px">
                                <span class="li_a"><b>Available Balance:</b></span> {{ round(Auth::user()->balance, 2) }} {{ Auth::user()->currency_type }}
                            </li>
                            <li class="pull-left" style="margin-top: 20px">
                                <span class="li_a"><b>Total Balance:</b></span> {{ round(Auth::user()->total_balance, 2) }} {{ Auth::user()->currency_type }}
                            </li>
                            
                           <!-- Profile Toggle Start -->
                           <li class="dropdown">
                              <a class="dropdown-toggle profile-toggle" href="#" data-toggle="dropdown">
                                 @if(Auth::user()->image==NULL)
                                    <img src="{{ asset('storage') }}/{{ $setting->logo }}"  class="profile-avator"  style="height: 40px; width: 50px">
                                 @else
                                    <img src="{{ asset('storage') }}/{{ Auth::user()->image }}"  class="profile-avator"  style="height: 40px; width: 50px">
                                 @endif
                                 <div class="profile-avatar-txt">
                                    <p>{{ Auth::user()->name }}</p>
                                    <i class="fa fa-angle-down"></i>
                                 </div>
                              </a>
                              <div class="profile-box dropdown-menu animated bounceIn">
                                 <ul>
                                    <li><a href="{{ url('/user/profile') }}"><i class="fa fa-user"></i> view/Edit profile</a></li>
                                    
                                    <li><a href="{{ url('account-statement') }}"><i class="fa fa-flash"></i> Activity Log</a></li>
                                    <li><a href="{{ url('user/password') }}"><i class="fa fa-wrench"></i> Change Password</a></li>
                                    @if(Auth::guard('web')->check() && !Auth::guard('admin')->check())
                                      <li>
                                        <a href="{{ route('logout') }}"
                                          onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                                          <i class="fa fa-power-off"></i>
                                          {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        
                                      </li>
                                    @endif
                                 </ul>
                              </div>
                           </li>
                           <!-- Profile Toggle End -->
                            
                        </ul>
                     </div>
                  </div>
               </div>
            </nav>
            <!-- Header Top End -->          
         </header>
         <!-- Main Header End -->
          
         <!-- Sidebar Start -->
         @include('inc.usersidebar')
         <!-- End Sidebar -->
          
         <!-- Right Side Content Start -->
         <section id="content" class="seipkon-content-wrapper">
            
               @yield('content')
             
            <!-- Footer Area Start -->
            <footer class="seipkon-footer-area">
               <p>Alrights Reserved {{ date('Y') }},<a href="{{ url('/') }}">{{ $setting->sitename }}</a></p>
            </footer>
            <!-- End Footer Area -->
             
         </section>
         <!-- End Right Side Content -->
          
      </div>
      <!-- End Wrapper -->
       
       
      <!-- jQuery -->
      
      <!-- Bootstrap JS -->
      <script src="{{ asset('assets/plugins/bootstrap/bootstrap.min.js' ) }}"></script>
      <!-- Bootstrap-select JS -->
      <!-- Datatables -->
      <script src="{{ asset('assets/plugins/datatables/js/jquery.dataTables.min.js' ) }}"></script>
      <script src="{{ asset('assets/plugins/datatables/js/dataTables.bootstrap.min.js' ) }}"></script>
      <script src="{{ asset('assets/plugins/datatables/js/dataTables.buttons.min.js' ) }}"></script>
      <script src="{{ asset('assets/plugins/datatables/js/buttons.bootstrap.min.js' ) }}"></script>
      <script src="{{ asset('assets/plugins/datatables/js/buttons.flash.min.js' ) }}"></script>
      <script src="{{ asset('assets/plugins/datatables/js/buttons.html5.min.js' ) }}"></script>
      <script src="{{ asset('assets/plugins/datatables/js/buttons.print.min.js' ) }}"></script>
      <script src="{{ asset('assets/plugins/datatables/js/dataTables.responsive.min.js' ) }}"></script>
      <script src="{{ asset('assets/plugins/datatables/js/responsive.bootstrap.min.js' ) }}"></script>
      <script src="{{ asset('assets/plugins/datatables/js/jszip.min.js' ) }}"></script>
      <script src="{{ asset('assets/plugins/datatables/js/pdfmake.min.js' ) }}"></script>
      <script src="{{ asset('assets/plugins/datatables/js/vfs_fonts.js' ) }}"></script>
      
      <script src="{{ asset('assets/plugins/bootstrap-select/js/bootstrap-select.min.js' ) }}"></script>
      <!-- Daterange JS -->
      <script src="{{ asset('assets/plugins/daterangepicker/js/moment.min.js' ) }}"></script>
      <script src="{{ asset('assets/plugins/daterangepicker/js/daterangepicker.js' ) }}"></script>
      <!-- Jvector JS -->
      <script src="{{ asset('assets/plugins/jvector/js/jquery-jvectormap-1.2.2.min.js' ) }}"></script>
      <script src="{{ asset('assets/plugins/jvector/js/jquery-jvectormap-world-mill-en.js' ) }}"></script>
      <script src="{{ asset('assets/plugins/jvector/js/jvector-init.js' ) }}"></script>
      <!-- Raphael JS -->
      <script src="{{ asset('assets/plugins/raphael/js/raphael.min.js' ) }}"></script>
      <!-- Morris JS -->
      <script src="{{ asset('assets/plugins/morris/js/morris.min.js' ) }}"></script>
      <!-- Sparkline JS -->
      <script src="{{ asset('assets/plugins/sparkline/js/jquery.sparkline.js' ) }}"></script>
      <!-- Chart JS -->
      <script src="{{ asset('assets/plugins/charts/js/Chart.js' ) }}"></script>
     
      

     

      <!-- Perfect Scrollbar JS -->
      <script src="{{ asset('assets/plugins/perfect-scrollbar/jquery-perfect-scrollbar.min.js' ) }}"></script>
      <!-- Vue JS -->
      <script src="{{ asset('assets/plugins/vue/vue.min.js' ) }}"></script>
      <!-- Summernote JS -->
      <script src="{{ asset('assets/plugins/summernote/js/summernote.js' ) }}"></script>
      <script src="{{ asset('assets/plugins/summernote/js/custom-summernote.js' ) }}"></script>
      <!-- Dashboard JS -->
      <script src="{{ asset('assets/js/dashboard.js' ) }}"></script>
      <!-- Custom JS -->
      <script src="{{ asset('assets/js/seipkon.js' ) }}"></script>


       {{-- Success Alert --}}
       @if(session('status'))
           <div class="alert alert-success alert-dismissible fade show" role="alert">
               {{session('status')}}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
       @endif

       {{-- Error Alert --}}
       @if(session('error'))
           <div class="alert alert-danger alert-dismissible fade show" role="alert">
               {{session('error')}}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
       @endif

       <script>
           //close the alert after 3 seconds.
           $(document).ready(function(){
            setTimeout(function() {
               $(".alert").alert('close');
            }, 40000);
         });
       </script>
   </body>
</html>