    <div class="container mb-1" style="margin-top:65px">
      <div class="row">
        <div class="col-md-3 col-lg-4 col-sm-2"></div>
        <div class="col-md-6 col-lg-4 col-sm-8">
          <div class="card">
            <div class="card-header">
              <h4 class="h5 my-0 font-weight-normal">Reset Password</h4>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo site_url();?>/Login/cek_reset_password">
                <input type="hidden" name="token" value="<?php echo $token; ?>">           
                <input type="hidden" name="user" value="<?php echo $user; ?>">           
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Masukkan Password Baru" name="passnew">
                  <?php echo form_error('passnew'); ?>
                </div>                
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Masukkan Ulang Password Baru" name="repassnew">
                  <?php echo form_error('repassnew'); ?>
                </div>    
                <hr>
                <button class="btn btn-success btn-block"  type="submit">Simpan</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-lg-4 col-sm-2"></div>
        </div>
      </div>
    </div>