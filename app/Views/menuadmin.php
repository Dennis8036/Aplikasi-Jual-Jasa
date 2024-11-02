
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <img src="<?= base_url('images/img/' . $setting->logo_dashboard) ?>"  class="logo-dashboard" width="90px">
        
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="ti-view-list"></span>
        </button>
       
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown mr-1">

<div class="row">
<style>
        .card-title {
            font-size: 18px;
            font-weight: ;
            color: ;
            margin-bottom: 20px;
            text-align: center;
        }
</style>
 <div class="card-body">
  <br>

            <h5 class="card-title"><?= session()->get('username')?></h5>
          </div>



          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
              <img src="<?= ($dennis->foto_profile) ? base_url('images/img/' . $dennis->foto_profile) : base_url('images/img/fotouser.jfif') ?>" 
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="<?= base_url('Home/profileadmin')?>">
                <i class="ti-user"></i>
                Profile
              </a>
                            <a class="dropdown-item" href="<?= base_url('Home/changepassword')?>">
                <i class="ti-key"></i>
                Change Password
              </a>
                                          <a class="dropdown-item" href="<?= base_url('Home/lockscreen')?>">
                <i class="ti-lock"></i>
                Lock Screen
              </a>
              <a class="dropdown-item" href="<?= base_url('Home/logout')?>">
                <i class="ti-power-off text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="ti-view-list"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          
          <?php if(session()->get('id_level') == 1) { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('Home/dashboardadmin')?>">
              <i class="ti-shield menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
<?php } ?>

<?php if(session()->get('id_level') == 1) { ?>
          <li class="nav-item">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('Home/jasa')?>">
              <i class="ti-view-list-alt menu-icon"></i>
              <span class="menu-title">Jasa</span>
            </a>
          </li>
<?php } ?>

          

<?php if(session()->get('id_level') == 1) { ?>
          <li class="nav-item">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('Home/pembayaran')?>">
              <i class="ti-money menu-icon"></i>
              <span class="menu-title">Pembayaran</span>
            </a>
          </li>
<?php } ?>

<?php if(session()->get('id_level') == 1) { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('Home/laporan')?>">
              <i class="ti-agenda menu-icon"></i>
              <span class="menu-title">Laporan</span>
            </a>
          </li>
          <?php } ?>

<?php if(session()->get('id_level') == 1) { ?>
           <li class="nav-item">
            <a class="nav-link" href="<?= base_url('Home/user')?>">
              <i class="ti-user menu-icon"></i>
              <span class="menu-title">User</span>
            </a>
          </li>
<?php } ?>


<?php if(session()->get('id_level') == 1) { ?>
                      <li class="nav-item">
            <a class="nav-link" href="<?= base_url('Home/activity')?>">
              <i class="ti-pie-chart menu-icon"></i>
              <span class="menu-title">Log Activity</span>
            </a>
          </li>
          </li>
<?php } ?>
 
 <?php if(session()->get('id_level') == 1) { ?>
          <li class="nav-item">
    <a class="nav-link" href="<?= base_url('Home/setting')?>">
        <i class="ti-settings menu-icon"></i> <!-- Ikon settings dengan jarak -->
        <span class="menu-title">Setting</span>
    </a>
</li>
<?php } ?>
         
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="d-flex justify-content-between align-items-center">
               
               </div>
              </div>

             
   
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        