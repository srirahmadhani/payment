
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
   <!-- Sidebar - Brand -->
   <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon rotate-n-15">
         <i class="fas fa-laugh-wink"></i>
      </div>
      <div class="sidebar-brand-text mx-3">Kampung Sarosah</div>
   </a>
   <!-- Divider -->
   <hr class="sidebar-divider my-0">
   <!-- Nav Item - Dashboard -->
   <li class="nav-item active">
      <a class="nav-link" href="{{ url('/home') }}">
      <i class="fas fa-fw fa-chart-line" ></i>
      <span>Dashboard </span></a>
   </li>
   <!-- Divider -->
   <hr class="sidebar-divider">
   <!-- Heading -->
   <div class="sidebar-heading">
   </div>
   <!-- Nav Item - Pages Collapse Menu -->
   @if($authposition == 'KS2')
   <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
         <i class="fas fa-fw fa-folder-open"></i>
         <span>Data Master</span>
         </a>
         <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
               <a class="collapse-item" href="{{ url('/ticket') }}">Tiket</a>
               <a class="collapse-item" href="{{ url('/visitor') }}">Pengunjung</a>
               <a class="collapse-item" href="{{ url('/employee') }}">Pegawai</a>
               <a class="collapse-item" href="{{ url('/position') }}">Jabatan</a>  
            </div>
         </div>
      </li>
   <hr class="sidebar-divider">
   @endif
   @if($authposition =='KS3' or $authposition == 'KS2')
<li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
      <i class="fas fa-fw fa-credit-card"></i>
      <span>Transaksi</span>
      </a>
      <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
         <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ url('/topup') }}">Top Up</a>
            <a class="collapse-item" href="{{ url('/payment') }}">Payment</a>
         </div>
      </div>
   </li>
   @endif
   <!-- Divider -->
   <hr class="sidebar-divider">
   <!-- Nav Item - Data Master -->
   @if($authposition == 'KS1' OR $authposition == 'KS2')
   <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
      <i class="fas fa-fw fa-table"></i>
      <span>Laporan</span>
      </a>
      <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
         <a class="collapse-item" href="{{url('/report/topup')}}">Top Up</a>
         <a class="collapse-item" href="{{url('/report/payment_report')}}">Payment</a>
      </div>
   </li>
   @endif
   <hr class="sidebar-divider">
   
   <!-- Nav Item Transaksi-->
  <!--  @if($authposition == 'KS1' or $authposition == 'KS2')
   <hr class="sidebar-divider">
   <li class="nav-item">
      <a class="nav-link" href="{{ route('user') }}">
      <i class="fas fa-fw fa-cog"></i>
      <span>Management User</span></a>
   </li>

   @endif -->
   <!-- Divider -->
   <!-- Sidebar Toggler (Sidebar) -->
   <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
   </div>
</ul>
<!-- End of Sidebar