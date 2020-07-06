<aside class="seipkon-main-sidebar">
   <nav id="sidebar">
      <!-- Sidebar Profile Start -->
      <div class="sidebar-profile clearfix">
         <div class="profile-avatar">
            @if(Auth::user()->image==NULL)
               <img src="{{ asset('storage') }}/{{ $setting->logo }}" alt="logo" style="height: 50px; width: 100px">
            @else
               <img src="{{ asset('storage') }}/{{ Auth::user()->image }}" alt="logo" style="height: 50px; width: 100px">
            @endif
         </div>
         <div class="profile-info">
            <h4>Acc. Number</h4>
            <p>{{ Auth::user()->account_number }}</p>
         </div>
      </div>
      <!-- Sidebar Profile End -->
       <hr>
      <!-- Menu Section Start -->
      <div class="menu-section">
         <ul class="list-unstyled components">
            <li>
               <a href="{{ url('/home') }}">
               <i class="fa fa-desktop"></i>
               Dashboard
               </a>
            </li>
            <li>
               <a href="#transfer" data-toggle="collapse" aria-expanded="false">
               <i class="fa fa-bank"></i>
               Transfer
               </a>
               <ul class="collapse list-unstyled" id="transfer">
                  <li><a href="{{ url('user/domestic-transfer') }}">Domestic Transfer</a></li>
                  <li><a href="{{ url('user/international-transfer') }}">Foreign Transfer</a></li>
               </ul>
            </li>

            <li>
               <a href="{{ url('/user/deposit') }}">
               <i class="fa fa-credit-card"></i>
               Deposit
               </a>
            </li>

            <li>
               <a href="{{ url('/user/withdraw') }}">
               <i class="fa fa-money"></i>
               Withdraw
               </a>
            </li>
            <li>
               <a href="{{ url('/user/pricing') }}">
               <i class="fa fa-rocket"></i>
               IV Scheme
               </a>
            </li>

            <li>
               <a href="{{ url('/user/save') }}">
               <i class="fa fa-handshake-o"></i>
               Piggy Save
               </a>
            </li>

            <li>
               <a href="{{ url('/user/loan') }}">
               <i class="fa fa-hourglass-o"></i>
               Loan Investment
               </a>
            </li>

            <li>
               <a href="{{ url('account-statement') }}">
               <i class="fa fa-book"></i>
               Account Statement
               </a>
            </li>
         </ul>
      </div>
      <!-- Menu Section End -->
      <hr>
      <!-- Menu Section Start -->
      <div class="menu-section">
         <h3>More</h3>
         <ul class="list-unstyled components">

            <li>
               <a href="{{ url('user/support') }}">
               <i class="fa fa-ticket"></i>
               Supports
               </a>
            </li>
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
   </nav>
</aside>