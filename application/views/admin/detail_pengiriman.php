           <div class="col-md-12 col-sm-12 p-4">
              <div class="col bg-fluid p-3">
                <div class="row">

                  <?php 
                    foreach ($pengiriman as $n) {
                      $id   = $n->id_transaksi;
                      $kurir = $n->kurir;
                      $layanan = $n->layanan;
                      $ongkir = $n->ongkir;
                      $resi = $n->nomor_resi;
                      $bukti = $n->bukti_pengiriman;

                      $w_kirim = $n->waktu_konfir_pengiriman;
                    }
                  ?>
                  <div class="col-md-4">
                    
                    <img id="myImg" alt="Bukti Pengiriman" src="<?php echo base_url('assets/foto/transaksi/buktipengiriman/'.$bukti);?>" class="img-fluid rounded">
                    <h1 class="h5 text-center">Bukti Pengiriman</h1>
                  </div>
                  <div class="col-md-8">
                    <table border="0" cellpadding="10">
                        <tr>
                          <td colspan="2"><h1 class="h5 font-weight-bold">#<?php echo $id; ?></h1></td>
                        </tr>
                        <tr>
                          <td>Kurir </td>
                          <td> : <?php echo $kurir; ?></td>
                        </tr>
                        <tr>
                          <td>Layanan </td>  
                          <td> : <?php echo $layanan; ?></td>
                        </tr>                        
                        <tr>
                          <td>Ongkos Kirim</td>  
                          <td> : Rp<?php echo number_format($ongkir,0,",","."); ?></td>
                        </tr>                        
                        <tr>
                          <td>Nomor Resi</td>  
                          <td> : <?php echo $resi; ?></td>
                        </tr>
                        <tr>
                          <td>Waktu Konfirmasi Pengiriman </td>
                          <td> : <?php echo $w_kirim; ?></td>
                        </tr>                        
                        <tr>
                          <td colspan="2" align="center">                                                 
                            <a href="<?php echo site_url('/Admin/verifikasi_pengiriman/'.$id);?>" class="btn btn-success">
                               Verifikasi <span data-feather="check"></span>                                       
                            </a>                                     
                          </td>
                        </tr>
                    </table>
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
        <script src="<?php echo base_url('assets/dataTables2/jquery.dataTables.js'); ?>"></script>
        <script src="<?php echo base_url('assets/dataTables2/dataTables.bootstrap4.js'); ?>"></script> 
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script type="text/javascript">

          $('#table').DataTable({});
          
          feather.replace();      
               
          var modal = document.getElementById('myModal');
          var img = document.getElementById('myImg');
          var modalImg = document.getElementById('img01');
          var captionText = document.getElementById('caption');
          
          img.onclick = function(){
            modal.style.display = 'block';
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
          }
          var span = document.getElementsByClassName('closemodalgambar')[0];

          span.onclick = function() { 
            modal.style.display = 'none';
          }                     
        </script>
      </div>
    </div>
  </body>
</html>               