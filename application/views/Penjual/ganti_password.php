    <div class="container mb-1" style="margin-top:61px">
      <div class="row">
        <div class="col-md-3 col-lg-4 col-sm-2"></div>
        <div class="col-md-6 col-lg-4 col-sm-8 bg-white border p-4">


              <h4 class="h5 my-0 font-weight-normal text-center">Ganti Password</h4><hr>
                <?php 
                  if($pesan = $this->session->flashdata('pesan')) :
                    echo '<div class="alert alert-'.$pesan['type'].' alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>'.$pesan['title'].'</strong> '.$pesan['pesan'].'
                          </div>';                 
                  endif; 
                ?>   
              <form method="post" action="<?php echo site_url();?>/Penjual/cek_ganti_password">
                <div class="form-group">
                  <input type="text" class="form-control" id="pwdold" placeholder="Masukkan Password Lama" name="passold">
                  <?php echo form_error('passold'); ?>
                </div>                
                <div class="form-group">
                  <input type="text" class="form-control" id="pwdnew" placeholder="Masukkan Password Baru" name="passnew">
                  <?php echo form_error('passnew'); ?>
                </div>                
                <div class="form-group">
                  <input type="text" class="form-control" id="rpwdnew" placeholder="Masukkan Ulang Password Baru" name="repassnew">
                  <?php echo form_error('repassnew'); ?>
                </div>    
                <div class="form-group form-check">
                  <label class="form-check-label">
                    <input class="form-check-input" name="check" type="checkbox" value="1"> Tetap login
                  </label>
                </div>
                <div align="right">
                  
                  <button type="button" class="btn btn-danger" onclick="javascript:history.back()"><span ></span> Batal</button>
                  <button class="btn btn-primary"  type="submit">Simpan</button>
                </div>
              </form>

        </div>
        <div class="col-md-3 col-lg-4 col-sm-2"></div>
        </div>
      </div>
    </div>