<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">
    <title><?php if(!empty($title)): echo $title; endif; ?></title>
    <!-- <link rel="stylesheet" href="<?php //echo base_url();?>assets/dev/css/2.bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link href="<?php echo base_url();?>assets/dev/css/admin.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/dataTables2/dataTables.bootstrap4.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">     
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.7/dist/sweetalert2.all.min.js"></script>
    
    <script src="http://code.jquery.com/jquery-2.2.1.min.js"></script>
    
    <script type="text/javascript">
        var auto_refresh = setInterval(function(){
          $('#notiftransaksi').load('<?php echo site_url('/Admin/notif_transaksi'); ?>');
          $('#notifpenjualbaru').load('<?php echo site_url('/Admin/notif_penjual_baru'); ?>');
        },1000);     

      const toast = swal.mixin({
        toast: true,
        position: 'bottom-end',
        showConfirmButton: false,
        timer: 2000
      });   

      $(document).ready(function(){ 

        <?php if($pesan = $this->session->flashdata('toast')){ ?>
          toast({ 
            type: '<?php echo $pesan['type']; ?>',
            title: '<?php echo $pesan['pesan']; ?>'
          })
        <?php }else if($pesan = $this->session->flashdata('swal')){ ?>
          Swal({
            type: '<?php echo $pesan['type']; ?>',
            title: '<?php echo $pesan['title']; ?>',
            text: '<?php echo $pesan['pesan']; ?>'          
          })      
        <?php }else if($pesan = $this->session->flashdata('swaltimer')){ ?>
          Swal({
            position: 'center',
            type: '<?php echo $pesan['type']; ?>',
            title: '<?php echo $pesan['title']; ?>',
            text: '<?php echo $pesan['pesan']; ?>',
            showConfirmButton: false,
            timer: 2000         
          })      
        <?php } ?>          
      });
    </script>  

  </head>

  <body>
    <nav class="navbar navbar-dark sticky-top flex-md-nowrap p-0 navbar-color">
      <a class="navbar-brand col-sm-3 py-3 col-md-2 mr-0 font-weight-bold text-center" href="<?php echo site_url();?>/Admin/dashboard"><span data-feather="shield"></span> ADMIN</a>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="<?php echo site_url();?>/Admin/keluar"><span data-feather="log-out"></span> Keluar</a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid bg-fluid">
      <div class="row">
        <div class="col-md-2 col-sm-3 col-xs-2 p-0 pt-1 pb-1 sidebar">
          <nav>
              <ul class="nav flex-column p-2">
                <li class="nav-item d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mr-1">
                  <a class="nav-link <?php if($this->uri->segment(2)=='dashboard'): echo 'active'; endif; ?>" href="<?php echo site_url();?>/Admin/dashboard">
                    <span data-feather="home"></span>
                    Dashboard
                  </a>
                </li>
                <li class="nav-item d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mr-1">
                  <a class="nav-link <?php if($this->uri->segment(2)=='data_transaksi'): echo 'active'; endif; ?>" href="<?php echo site_url();?>/Admin/data_transaksi">               
                    <span data-feather="dollar-sign"></span>
                    Data Transaksi                                    
                  </a>
                  <div id="notiftransaksi"></div>
                </li>                
                <li class="nav-item d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mr-1">
                  <a class="nav-link <?php if($this->uri->segment(2)=='data_produk'): echo 'active'; endif; ?>" href="<?php echo site_url();?>/Admin/data_produk">                  
                    <span data-feather="package"></span>
                    Data Produk
                  </a>
                </li>
                <li class="nav-item d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mr-1">
                  <a class="nav-link <?php if($this->uri->segment(2)=='data_pembeli'): echo 'active'; endif; ?>" href="<?php echo site_url();?>/Admin/data_pembeli">          
                    <span data-feather="users"></span>
                    Data User Pembeli                    
                  </a>
                </li>                
                <li class="nav-item d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mr-1">
                  <a class="nav-link <?php if($this->uri->segment(2)=='data_penjual'): echo 'active'; endif; ?>" href="<?php echo site_url();?>/Admin/data_penjual">        
                    <span data-feather="users"></span>
                    Data User Penjual                   
                  </a>
                  <div id="notifpenjualbaru"></div>
                </li>                
<!--                 <li class="nav-item d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mr-1">
                  <a class="nav-link <?php //if($this->uri->segment(2)=='data_laporan_pembeli'): echo 'active'; endif; ?>" href="<?php //echo site_url();?>/Admin/data_laporan_pembeli">                  
                    <span data-feather="mail"></span>
                    Email                  
                  </a>
                  <div id="notiflaporan"></div>                  
                </li> -->
                <h6 class="d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                  <span>Pengaturan</span>
                  <span data-feather="settings"></span>
                </h6>
                <li class="nav-item d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mr-1">
                  <a class="nav-link" href="<?php echo site_url();?>/Admin/ganti_password">
                    <span data-feather="lock"></span>
                    Ganti password
                  </a>
                </li>
                <li class="nav-item d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mr-1">
                  <a class="nav-link" href="<?php echo site_url();?>/Admin/rekening">
                    <span data-feather="credit-card"></span>
                    Rekening
                  </a>
                </li>          
<!--                 <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><span data-feather="users"></span> Data User </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="#"></a>
                    <a class="dropdown-item" href="#">Pembeli</a>
                  </div>
                </li> -->
              </ul>      
          </nav>        
        </div>

          
        <div class="col-md-10 col-sm-9 col-xs-10 pt-0 in-shadow content">
          <div class="row">
            <div class="col-md-12 d-flex justify-content-between align-items-center bot-shadow bg-fluid">            
              <h1 class="h5 py-3"><?php echo $heading; ?></h1> 
              <!-- <ul class="breadcrumb bg-dark mt-3">
              <?php
                //if($heading=="Dashboard")
               // {
                  //echo '<li class="breadcrumb-item active"><span data-feather="home"></span> '.$heading.'</li>';
               // }else{
               //   echo '<li class="breadcrumb-item"><a href="'.site_url().'/Admin/dashboard">Dashboard</a></li>
               //         <li class="breadcrumb-item active">'.$heading.'</li>';
               // }
              ?>
              </ul> -->
                            
            </div>