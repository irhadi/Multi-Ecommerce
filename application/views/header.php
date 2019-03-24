<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url('assets/img/icon/favicon2.png');?>">
    <title><?php 
    if(empty($title)){
      echo $title1[0]; 
    }else{
      echo $title;
    }
    ?></title>
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
      .notif #notifkeranjang {
        position: absolute;
        top: -8px;
        right: -14px;
      }
      .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: none;
      }
      .preloader .loading {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%,-50%);
        font: 14px arial;
      }   
/*      .section{
        position: fixed;
        top: 70px;
      }
      .col-8 div{
        height: 500px;
        padding-top: 70px;
      }*/
    </style>
  </head>
  <body class="bg-light">
    <div class="preloader">
        <div class="loading">
          <img src="<?php echo base_url('assets/img/gif/preloader3.gif');?>" width="70">
        </div>
    </div>

    <header>
      <nav class="navbar bg-white navbar-light navbar-expand-md fixed-top mb-3" style="border-bottom: 3px solid #ff751a">
        <a class="navbar-brand text-uppercase font-weight-bold" href="<?php echo site_url(); ?>">Multi E-commerce</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
            <li class="pl-3 nav-item">
              <a class="nav-link" target="_blank" href="<?php echo site_url();?>/Web/tentang">
                Tentang
              </a>
            </li>    
            </ul>      
<!--           <ul class="navbar-nav mr-auto">
            <li class="pl-3 nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Tentang</a>
              <div class="dropdown-menu dropdown-menu-left">
                <a class="dropdown-item" href="#">Cara Pembelian</a>
                <a class="dropdown-item" href="#">Cara Pengembalian</a>
             </div>
            </li>                  
          </ul>   -->

          <ul class="navbar-nav mr-right">

            <?php if($this->session->userdata('login_Pembeli')==TRUE):?>

            <li class="pl-3 nav-item">
              <a class="nav-link" href="<?php echo site_url();?>/Web/transaksi"><i class="fa fa-exchange" style="font-size:18px"></i> 
                 Transaksi
              </a>
            </li>
            
            <?php endif; ?>

            <li class="pl-3 nav-item">
              <a href="#keranjang" id="tampil_keranjang" class="nav-link" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="notif">
                  <i class="fa fa-shopping-cart" style="font-size:22px"></i>
                  <small id="notifkeranjang"></small>
                </div>
              </a> 
            </li>   

            <?php if($this->session->userdata('login_Pembeli')==TRUE){ ?>

            <li class="pl-3 nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o" style="font-size:18px"></i>
              <?php 
                $session = $this->session->userdata('email_pembeli');
                $potong = (explode("@",$session));
                echo $potong[0];
              ?>                
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-header">Sunting Akun</div>
                <a class="dropdown-item" href="<?php echo site_url();?>/Web/ganti_password">Ganti Password</a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo site_url();?>/Web/keluar" class="dropdown-item">Keluar</a>
             </div>
            </li>

            <?php } else { ?>

            <li class="pl-3 nav-item">
              <a href="<?php echo site_url();?>/Login" class="nav-link">
                Login
              </a>
            </li>                
            <li class="pl-3 nav-item dropdown">
              <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Daftar
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="<?php echo site_url();?>/Registrasi/pembeli">Pembeli</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo site_url();?>/Registrasi/penjual">Penjual</a>
             </div>
            </li>

            <?php } ?>

          </ul>
        </div>
      </nav>
    </header>

  <div class="modal fade" id="keranjang">
    <div class="modal-dialog modal-md">
      <div class="modal-content"><div id="data_keranjang"></div></div>
    </div>
  </div>