
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title>ADMIN</title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/dev/css/bootstrap.min.css">
    <link href="<?php echo base_url();?>assets/dev/css/login_admin.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  </head>
  <body class="bg-dark">
    <form class="form-signin" method="post" action="<?php echo site_url();?>/Admin/cek_login">
      <div class="text-center mt-1 mb-4">
       <!--  <img class="mb-3 mt-3" src="<?php //echo base_url();?>assets/img/icon/admin.png" alt="" width="72" height="72"> -->
        <h1 class="h3 mb-3 font-weight-bold text-light">ADMIN</h1>
      </div>
      <?php 
      if($this->session->flashdata('gagal')==TRUE):
          echo $this->session->flashdata('gagal');
      endif; 
      ?>
      <div class="form-label-group">
        <input type="text" id="inputEmail" class="form-control" placeholder="Username" name="username" required autofocus>
        <label for="inputEmail">Username</label>
        <?php echo form_error('username'); ?>
      </div>
      

      <div class="form-label-group">
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
        <label for="inputPassword">Password</label>
        <?php echo form_error('password'); ?>
      </div>
      

      <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
      <p class="mt-3 mb-3 text-muted text-center">&copy; Multi E-commerce</p>
    </form>
  </body>
</html>
