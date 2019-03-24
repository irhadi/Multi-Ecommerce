<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <style>
/*  body {
    position: relative;
  }*/
  ul.nav-pills {
    top: 10px;
    position: fixed;
  }
  div.col-8 div {
    height: 600px;
  }
  </style>
</head>
<body data-spy="scroll" data-target="#myScrollspy" data-offset="1">

<div class="container-fluid pr-0">
  <div class="row">    
    <nav class="col-md-3 col-4" id="myScrollspy">
      <ul class="nav nav-pills flex-column">
        <li class="nav-item mb-3 text-center" style="border-bottom: 3px solid #ff751a">
          <a class="nav-link mt-2 h5" href="<?php echo site_url();?>">Multi Ecommerce</a>
        </li>        
        <li class="nav-item">
          <a class="nav-link active" href="#section1">Tentang Multi E-commerce</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#section2">Syarat mendaftar sebagai penjual</a>
        </li>
<!--         <li class="nav-item">
          <a class="nav-link" href="#section3">Section 3</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Section 4</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#section41">Link 1</a>
            <a class="dropdown-item" href="#section42">Link 2</a>
          </div>
        </li> -->
      </ul>
    </nav>
    <div class="col-md-9 col-sm-12 col-8 border-left">
      <div id="section1" class="p-5">    
        <h1 class="h3">Tentang Multi E-commerce</h1>
        <p>Multi Ecommerce merupakan salah satu online marketplace yang menyediakan sarana jual–beli dari konsumen ke konsumen. konsumen yang dapat membuka toko online di Multi Ecommerce hanya penjual kerajinan gerabah yang ada dikasongan bantul dan melayani pembeli dari seluruh Indonesia untuk transaksi satuan maupun banyak dalam toko tertentu.</p>
      </div>
      <div id="section2" class="p-5">         
        <ul class="list-unstyled">
          <li><h1 class="h3">Syarat mendaftar sebagai penjual</h1></li>
          <li>
            <ul>
              <li>Konsumen yang dibolehkan membuka toko online di Multi Ecommerce hanya penjual kerajinan gerabah bertempat tinggal di kasongan bantul</li>
              <li>Konsumen yang mendaftar sebagai penjual wajib mengisi data pribadi secara lengkap dan jujur di halaman akun (profil)</li>
            </ul>
          </li>
        </ul>        

      </div>        
<!--       <div id="section3" class="p-5">         
        <h1>Section 3</h1>
        <p>Try to scroll this section and look at the navigation list while scrolling!</p>
      </div>
      <div id="section41" class="p-5">         
        <h1>Section 4-1</h1>
        <p>Try to scroll this section and look at the navigation list while scrolling!</p>
      </div>      
      <div id="section42" class="p-5">         
        <h1>Section 4-2</h1>
        <p>Try to scroll this section and look at the navigation list while scrolling!</p>
      </div> -->
    </div>
  </div>
</div>

</body>
</html>
