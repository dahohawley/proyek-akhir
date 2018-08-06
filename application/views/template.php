<!DOCTYPE html>
<html>
 <head>
     <style type="text/css">
      .error{
        color: red;
      }
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>KPRI Rukun Makmur | <?php echo $this->my_page->read_page();?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo base_url('assets/materialAdmin/')?>vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/notify/animate.css')?>">
    <!-- Fontastic Custom icon font-->
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?php echo base_url('assets/materialAdmin/')?>vendor/font-awesome/css/font-awesome.min.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?php echo base_url('assets/materialAdmin/')?>css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?php echo base_url('assets/materialAdmin/')?>css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?php echo base_url('assets/materialAdmin/')?>favicon.png">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/')?>datatables/datatables.min.css"/>
    
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <div class="page home-page">
      <!-- Main Navbar-->
      <header class="header">
        <nav class="navbar">
          <!-- Search Box-->
          <div class="search-box">
            <button class="dismiss"><i class="icon-close"></i></button>
            <form id="searchForm" action="#" role="search">
              <input type="search" placeholder="What are you looking for..." class="form-control">
            </form>
          </div>
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <!-- Navbar Header-->
              <div class="navbar-header">
                <!-- Navbar Brand --><a href="<?php echo site_url('home')?>" class="navbar-brand">
                  <div class="brand-text brand-big">
                    <span>KPRI </span><strong> Rukun Makmur</strong>
                  </div>
                  <div class="brand-text brand-small"><strong>KPRI</strong></div></a>
                <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
              </div>
              <!-- Navbar Menu -->
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <?php
                if($this->session->userdata('hak_akses') == '1'){
                  $hak_akses = 'ketua';
                }elseif($this->session->userdata('hak_akses') == '2'){
                  $hak_akses = 'bendahara';
                }else{
                  $hak_akses = 'kasir';
                }  
                  $this->load->view('menu/notif_'.$hak_akses);
                ?>
                <!-- Setting Account -->
                <li class="nav-item"><a href="<?php echo base_url('index.php/account/setting')?>" class="nav-link logout"><i class="fa fa-gear"></i></a></li>
                <!-- Logout    -->
                <li class="nav-item"><a href="<?php echo base_url('index.php/account/logout')?>" class="nav-link logout">Logout<i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <div class="page-content d-flex align-items-stretch">
        <!-- Side Navbar -->
        <nav class="side-navbar">
          <!-- Sidebar Header-->
          <div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="<?php echo base_url('assets/gambar/'.$this->session->userdata('fp'))?>" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title">
              <h1 class="h4"><?php echo $this->session->userdata('nama');?></h1>
              <p><?php echo $this->session->userdata('username')?></p>
              <p><?php echo date('Y-m-d');?></p>
            </div>
          </div>
          <!-- Sidebar Navidation Menus-->
          <?php
            if($this->session->userdata('hak_akses') == '1'){
              $this->load->view('menu/menu_ketua');
            }else if($this->session->userdata('hak_akses') == '2'){
              $this->load->view('menu/menu_bendahara');
            }else{
              $this->load->view('menu/menu_kasir');
            }
          ?>
        </nav>
        <div class="content-inner">
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom"><?php echo $this->my_page->read_page()?></h2>
            </div>
          </header>
          <div class="container-fluid">
                <!-- tambahan test -->
                <script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js')?>"></script>
                <script src="<?php echo base_url('assets/materialAdmin/')?>vendor/bootstrap/js/bootstrap.min.js"></script>
                <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
                <script src="<?php echo base_url('assets/js/jquery.validate.js')?>"></script>
                <script src="<?php echo base_url('assets/js/jquery.tabledit.min.js')?>"></script>
                <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
                <!-- -->
                <br>
                <?php echo $contents?>
              </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Javascript files-->
    <script src="<?php echo base_url('assets/notify/bootstrap-notify.min.js')?>"></script>
    <script src="<?php echo base_url('assets/materialAdmin/')?>vendor/popper.js/umd/popper.min.js"> </script>
    <script type="text/javascript" src="<?php echo base_url('assets/')?>datatables/datatables.min.js"></script>
    <script src="<?php echo base_url('assets/materialAdmin/')?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('assets/materialAdmin/')?>vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="<?php echo base_url('assets/materialAdmin/')?>js/charts-home.js"></script>
    <script src="<?php echo base_url('assets/materialAdmin/')?>js/front.js"></script>
  </body>
</html>