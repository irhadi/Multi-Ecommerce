            <div class="col-md-12 col-sm-12 p-4">
              
              
              <div class="col bg-fluid p-3"> 

                <div class="row">

                  <?php 
                    foreach ($penjual_baru as $n) {
                      $n_id_penjual   = $n->id_penjual;
                      $n_nama_toko    = $n->nama_toko;
                      $n_nama_penjual = $n->nama_penjual;
                      $n_notelp       = $n->notelp;
                      $n_email        = $n->email;
                      $n_foto_ktp     = $n->foto_ktp;
                      $n_token = $n->token;
                    }
                  ?>
                  <div class="col-md-3">
                    
                    <img id="myImg" alt="Foto KTP" src="<?php echo base_url('assets/foto/penjual/ktp/'.$n_foto_ktp);?>" class="img-fluid rounded">
                    <h1 class="h5 text-center">Foto KTP</h1>
                  </div>
                  <div class="col-md-9 h6">
                    <table border="0" cellpadding="15">
                      <tbody>
                        <tr>
                          <td colspan="2" class="h5 font-weight-bold">#<?php echo $n_id_penjual; ?></td>
                        </tr>
                        <tr>
                          <td width="150">Nama Toko</td>
                          <td>: <?php echo $n_nama_toko; ?></td>
                        </tr>
                        <tr>
                          <td>Nama Penjual</td>  
                          <td>: <?php echo $n_nama_penjual; ?></td>
                        </tr>
                        <tr>
                          <td>Nomor Telepon</td>
                          <td>: <?php echo $n_notelp; ?></td>
                        </tr>
                        <tr>
                          <td>Email</td>
                          <td>: <?php echo $n_email; ?></td>
                        </tr>    
                        <tr>
                          <td colspan="2" align="center">
                          <form method="post" action="<?php echo site_url('/Admin/konfirmasi_penjual_baru');?>">
                            <input type="hidden" name="id_penjual" value="<?php echo $n_id_penjual; ?>">
                            <input type="hidden" name="email" value="<?php echo $n_email; ?>">
                            <input type="hidden" name="token" value="<?php echo $n_token; ?>">                            
                            <button type="submit" class="btn btn-success" name="bolehkan" value="bolehkan">
                              <span data-feather="user-check"></span> Bolehkan
                            </button>
                            <button type="submit" class="btn btn-danger" name="tolak" value="tolak">
                              <span data-feather="user-x"></span> Tolak
                            </button>
                          </form>
                                     
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="text-center mt-3">
                      
                      
                    </div>
                  </div>

                </div>

              </div>

            </div>

          </div>
        </div> 

        <div id="myModal" class="modalgambar">
          <span class="closemodalgambar">&times;</span>
          <img class="modal-gambar-content" id="img01">
          <div id="caption"></div>
        </div>
        <!-- <script src="<?php //echo base_url();?>assets/dev/js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
        <script>window.jQuery || document.write('<script src="base_url();?>assets/dev/js/jquery-slim.min.js"><\/script>')</script>
        <script src="<?php echo base_url();?>assets/dev/js/popper.min.js"></script>
        <script src="<?php echo base_url();?>assets/dev/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script type="text/javascript">
          
          feather.replace();
                                 
          var modal = document.getElementById('myModal');
          var img = document.getElementById;
          var modalImg = document.getElementById('img01');
          var captionText = document.getElementById('caption');
          
          $('#myImg').click(function(){
            modal.style.display = 'block';
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
          })
          var span = document.getElementsByClassName('closemodalgambar')[0];

          span.onclick = function() { 
            modal.style.display = 'none';
          }                                  
        </script>
      </div>
    </div>
  </body>
</html>
