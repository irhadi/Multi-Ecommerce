  <div class="container mb-3" style="margin-top:75px">
    <div class="row">

        <div class="col-md-4"></div>

        <div class="col-md-4 col-sm-12">
          <div class="card">
            <div class="card-header text-center">
              <h4 class="h5 my-0 text-center font-weight-normal">Daftar Pembeli</h4>
            </div>
            <div class="card-body">
              <form class="form-horizontal" method="post" action="<?php echo site_url();?>/Registrasi/submit_pembeli">
                <div class="form-group">

                    <input type="hidden" name="reg_pembeli" value="pembeli">
                    <input type="email" class="form-control" id="akun" placeholder="Masukkan Email" name="email">
                    <?php echo form_error('email'); ?>

                </div>  
                <div class="form-group">
                      
                    <input type="password" class="form-control" id="password" placeholder="Masukkan Password" name="password">
                    <?php echo form_error('password'); ?>

                </div>
                <div class="form-group">
       
                    <input type="password" class="form-control" id="repassword" placeholder="Masukkan ulang password" name="repassword">
                      <?php echo form_error('repassword'); ?>

                </div>
                  <hr>
                    <button type="submit" class="btn btn-block btn-success">Daftar</button>

              </form>
            </div>
          </div>                
        </div>  
        <div class="col-md-4"></div> 
    </div>
  </div>