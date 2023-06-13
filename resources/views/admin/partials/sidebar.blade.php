@php 
    $i = 0;
    @endphp
    @foreach($masjid as $m)
        @if($m->masjid->request == 'pending')
        @php 
        $i++
        @endphp
        @endif
    @endforeach
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Page</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('admin/profile.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">PENDAFTARAN</li>
          <li class="nav-item">
            <a href="/admin-dashboard/pending" class="nav-link">
              <i class="nav-icon fas fa-clock-rotate-left"></i>
              <p>
                Pending
                @if($i != 0)
                <span class="badge badge-info right">{{ $i }}</span>
                @endif
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin-dashboard/declined" class="nav-link">
              <i class="nav-icon fas fa-circle-xmark"></i>
              <p>
                Ditolak
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin-dashboard/approved" class="nav-link">
              <i class="nav-icon fas fa-check"></i>
              <p>
                Diterima
              </p>
            </a>
          </li>
          <li class="nav-header">DATA</li>
          <li class="nav-item">
            <a href="/admin-dashboard/masjid" class="nav-link">
              <i class="nav-icon fas fa-mosque"></i>
              <p>
                Masjid
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin-dashboard/donatur" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Donatur
              </p>
            </a>
          </li>
          <li class="nav-header mt-3">PESAN DAN PERMINTAAN</li>
          <li class="nav-item">
            <a href="/admin-dashboard/pencairan" class="nav-link">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                Pencairan Dana
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/admin-dashboard/request-donasi" class="nav-link">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                Request Donasi
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
