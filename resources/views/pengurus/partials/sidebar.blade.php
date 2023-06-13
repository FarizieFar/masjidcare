
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <i class="fas fa-mosque elevation-3 ml-3 mr-2"></i>
      <span class="brand-text font-weight-light">{{ Auth::user()->masjid->nama }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">(No. Rekening: {{ Auth::user()->masjid->nomor_rekening ? Auth::user()->masjid->nomor_rekening : 'Kosong' }})</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">DASHBOARD</li>
          <li class="nav-item">
            <a href="/pengurus-dashboard" class="nav-link">
              <i class="nav-icon fas fa-gauge"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/pengurus-dashboard/data-donasi" class="nav-link">
              <i class="nav-icon fas fa-hand-holding-dollar"></i>
              <p>
                Data Donasi
              </p>
            </a>
          </li>

          <li class="nav-header mt-2">PENCAIRAN</li>
          <li class="nav-item">
            <a href="/pengurus-dashboard/permintaan-pencairan" class="nav-link">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                Permintaan Pencairan
              </p>
            </a>
          </li>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
