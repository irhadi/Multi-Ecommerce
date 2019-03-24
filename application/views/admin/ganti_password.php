           <div class="col-md-12 col-sm-12 p-4">
              <div class="col bg-fluid p-3">
                <div class="row p-3">             
                  <div class="col-md-4">
                    <?php 
                      if($pesan = $this->session->flashdata('pesan')) :
                        echo '<div class="alert alert-'.$pesan['type'].' alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>'.$pesan['title'].'</strong> '.$pesan['pesan'].'
                              </div>';                 
                      endif; 
                    ?>                    
                    <form method="post" action="<?php echo site_url();?>/Admin/cek_ganti_password">
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
                        <button class="btn btn-success"  type="submit"><span data-feather="save"></span> Simpan</button>
                      </div>
                    </form>                    
                  </div>
                  <div class="col-md-8"></div>
                </div>               
              </div>                 
            </div>

          </div>
        </div> 

        <!-- <script src="<?php //echo base_url();?>assets/dev/js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
        <script>window.jQuery || document.write('<script src="base_url();?>assets/dev/js/jquery-slim.min.js"><\/script>')</script>
        <script src="<?php echo base_url();?>assets/dev/js/popper.min.js"></script>
        <script src="<?php echo base_url();?>assets/dev/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url('assets/dataTables2/jquery.dataTables.js'); ?>"></script>
        <script src="<?php echo base_url('assets/dataTables2/dataTables.bootstrap4.js'); ?>"></script> 
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script type="text/javascript">
          
          feather.replace();
                    
        </script>
      </div>
    </div>
  </body>
</html>                      