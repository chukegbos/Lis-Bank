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
               <a href="{{ url('/admin/dashboard') }}">
               <i class="fa fa-desktop"></i>
               Dashboard
               </a>
            </li>

            <li>
               <a href="#transfer" data-toggle="collapse" aria-expanded="false">
               <i class="fa fa-bank"></i>
               Plans
               </a>
               <ul class="collapse list-unstyled" id="transfer">
                  <li><a href="{{ url('admin/loan-plan') }}">Loan Plans</a></li>
                  <li><a href="{{ url('admin/investment-plan') }}">Investment Plans</a></li>
               </ul>
            </li>

            <li>
               <a href="{{ url('/admin/deposit') }}">
               <i class="fa fa-credit-card"></i>
               Deposits
               </a>
            </li>

            <li>
               <a href="{{ url('/admin/bank-transactions') }}">
               <i class="fa fa-cubes"></i>
               All Bank Transactions
               </a>
            </li>

            <li>
               <a href="{{ url('/admin/withdraw') }}">
               <i class="fa fa-money"></i>
               Withdraw
               </a>
            </li>
            <li>
               <a href="{{ url('/admin/investments') }}">
               <i class="fa fa-rocket"></i>
               IV Scheme
               </a>
            </li>

            <li>
               <a href="{{ url('/admin/save') }}">
               <i class="fa fa-handshake-o"></i>
               All Piggy Save
               </a>
            </li>

            <li>
               <a href="{{ url('/admin/schemes') }}">
               <i class="fa fa-hourglass-o"></i>
               All Loan Investment
               </a>
            </li>

            <li>
               <a href="{{ url('/admin/users') }}">
               <i class="fa fa-users"></i>
               All Users
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
               <a href="{{ url('admin/setting') }}">
               <i class="fa fa-cogs"></i>
               Site Setting
               </a>
            </li>

            <li>

               <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.querySelector('#admin-logout-form').submit();">
                <i class="fa fa-power-off"></i> sign out</a>
              </a>

              <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>

                
            </li>
         </ul>
      </div>
   </nav>
</aside>