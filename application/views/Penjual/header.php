<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title><?php if(!empty($title)):echo $title; endif;?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="<?php echo base_url('assets/dataTables2/dataTables.bootstrap4.css'); ?>" rel="stylesheet">  
    <link href="<?php echo base_url('assets/dev/css/style.css'); ?>" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.7/dist/sweetalert2.all.min.js"></script>
    
    <style type="text/css">
      .notif {
        text-decoration: none;
        position: relative;
        display: inline-block;
      }      
      .notif #notiforder {
        position: absolute;
        top: -22px;
        right: -12px;
      }
      .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: #fff;
      }
      .preloader .loading {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%,-50%);
        font: 14px arial;
      }

    </style>
  </head>
  <body class="bg-light">
    <div class="preloader">
        <div class="loading">
          <img src="<?php echo base_url('assets/img/gif/preloader.gif');?>" width="200">
        </div>
    </div>





  <header>
    <nav class="navbar bg-white navbar-light navbar-expand-md fixed-top" style="border-bottom: 3px solid #ff751a">
      <a class="navbar-brand text-uppercase font-weight-bold" href="<?php echo site_url();?>/Penjual">Multi E-commerce</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item pl-3">
            <a class="nav-link <?php if($this->uri->segment(2)==''):echo 'active';endif; ?>" href="<?php echo site_url();?>/Penjual">DASHBOARD</a>
          </li>
          <li class="nav-item pl-3">
            <a class="nav-link <?php if($this->uri->segment(2)=='produk'):echo 'active';endif; ?>" href="<?php echo site_url();?>/Penjual/produk">PRODUK</a>            
          </li>
          <li class="nav-item pl-3">
            <a class="nav-link <?php if($this->uri->segment(2)=='order'):echo 'active';endif; ?>" href="<?php echo site_url();?>/Penjual/order">ORDER <div class="notif"><small id="notiforder"></small></div></a>
          </li>          
        </ul>
        <ul class="navbar-nav mr-right">          
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="fa fa-user-circle-o"></span>
                <?php 
                  $nama = (explode("@",$this->session->userdata('email_penjual')));
                  echo $nama[0];
                ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-header">Pengaturan</div>
              <a class="dropdown-item" href="<?php echo site_url();?>/Penjual/sunting_akun">Sunting Profil</a>
              <a class="dropdown-item" href="<?php echo site_url();?>/Penjual/ganti_password">Ganti password</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?php echo site_url();?>/Penjual/keluar">Keluar</a>
           </div>
          </li>
        </ul>
      </div>
    </nav>
  </header>