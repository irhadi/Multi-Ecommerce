  <div class="container mb-3" style="margin-top:75px">
    <div class="row">

        <div class="col-md-4"></div>

        <div class="col-md-4 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4 class="h5 my-0 text-center font-weight-normal">Login</h4>
            </div>
            <div class="card-body">
              <?php if($pesan = $this->session->flashdata('login')){ ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?php echo $pesan['pesan']; ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <?php } ?>
              <form class="form-horizontal" method="post" action="<?php echo site_url();?>/Login/cek_login">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                  </div>
                  <input type="email" class="form-control" name="email" id="email" autocomplete="email">                  
                </div>              
                <?php echo form_error('email'); ?>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span>
                  </div>
                  <input type="password" class="form-control" name="password" id="password" autocomplete="password">                  
                </div>
                <?php echo form_error('password'); ?>
                <hr>
                <button type="submit" class="btn btn-block btn-primary">Login</button>
              </form>
                <div class="mt-2 text-center">
                  <a href="<?php echo site_url('/Login/recovery'); ?>" class="nav-link">
                    <i class="fa fa-lock"></i> Lupa password ?
                  </a>                  
                </div>
            </div>

          </div>    
        </div>

        <div class="col-md-4"></div>

    </div>
  </div>