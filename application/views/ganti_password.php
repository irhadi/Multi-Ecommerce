    <div class="container mb-1" style="margin-top:65px">
      <div class="row">
        <div class="col-md-3 col-lg-4 col-sm-2"></div>
        <div class="col-md-6 col-lg-4 col-sm-8">
          <div class="card">
            <div class="card-header">
              <h4 class="h5 my-0 font-weight-normal">Ganti Password</h4>
            </div>
            <div class="card-body">
              <form method="post" action="<?php echo site_url();?>/Web/cek_ganti_password">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Masukkan Password Lama" name="passold">
                  <?php echo form_error('passold'); ?>
                </div>                
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Masukkan Password Baru" name="passnew">
                  <?php echo form_error('passnew'); ?>
                </div>                
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Masukkan Ulang Password Baru" name="repassnew">
                  <?php echo form_error('repassnew'); ?>
                </div>    
                <div class="form-group form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" name="check" type="checkbox" value="1"> Tetap login
                  </label>
                </div>
                <hr>
                <div class="text-right">                  
                  <button type="button" class="btn btn-secondary" onclick="javascript:history.back()"><span ></span> Batal</button>
                  <button class="btn btn-success"  type="submit">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-lg-4 col-sm-2"></div>
        </div>
      </div>
    </div>