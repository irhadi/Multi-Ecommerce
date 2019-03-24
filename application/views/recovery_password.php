  <div class="container mb-3" style="margin-top:75px">
    <div class="row">

        <div class="col-md-4"></div>

        <div class="col-md-4 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4 class="h5 my-0 text-center font-weight-normal">Reset Password</h4>
            </div>
            <div class="card-body">

                              
                <?php if(empty($pesan)){ ?>
                  <div class="alert alert-info alert-dismissible fade show" role="alert">
                    Masukkan <strong>Email</strong> Anda dan instruksi akan dikirimkan kepada Anda!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <?php }else{ ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $pesan; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>                  
                <?php } ?>


              <form class="form-horizontal" method="post" action="<?php echo site_url();?>/Login/cek_email">
                <div class="input-group">
                  <input type="email" class="form-control" placeholder="Masukkan Email" name="email">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary">Reset</button>
                  </div>
                </div>              
                <?php echo form_error('email'); ?>                
              </form>
            </div>

          </div>    
        </div>

        <div class="col-md-4"></div>

    </div>
  </div>