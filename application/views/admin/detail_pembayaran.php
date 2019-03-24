           <div class="col-md-12 col-sm-12 p-4">
              <div class="col bg-fluid p-3">
                <div class="row">

                  <?php 
                    foreach ($pembayaran as $n) {
                      $id   = $n->id_transaksi;
                      $unik    = $n->kode_unik;
                      $total_tagihan = $n->total_order+$n->ongkir+$unik;
                      $bukti = $n->bukti_pembayaran;
                      $w_order = $n->waktu_order;
                      $w_bayar = $n->waktu_konfir_pembayaran;
                      $status = $n->status_transaksi;  
                      
                      $nm_bank = $n->nm_bank;
                      $an_bank = $n->an_rek;
                      $no_bank = $n->no_rek;         
                    }
                  ?>
                  <div class="col-md-3">
                    <img id="myImg" alt="Bukti Pembayaran" src="<?php echo base_url('assets/foto/transaksi/buktipembayaran/'.$bukti);?>" class="img-fluid rounded">
                    <h1 class="h5 text-center">Bukti Pembayaran</h1>
                  </div>
                  <div class="col-md-9">
                    <table border="0" cellpadding="10">
                      <tbody>
                        <tr>
                          <td colspan="2"><h1 class="h5 font-weight-bold">#<?php echo $id; ?></h1></td>
                        </tr>
                        <tr>
                          <td>Bank Tujuan </td>
                          <td> : <?php echo $nm_bank." ".$an_bank." ".$no_bank; ?></td>
                        </tr>
                        <tr>
                          <td>Kode Transaksi </td>  
                          <td> : <?php echo $unik; ?></td>
                        </tr>                        
                        <tr>
                          <td>Total Tagihan </td>  
                          <td> : Rp<?php echo number_format($total_tagihan,0,",","."); ?></td>
                        </tr>
                        <tr>
                          <td>Waktu Konfirmasi Pembayaran </td>
                          <td> : <?php echo $w_bayar; ?></td>
                        </tr>                        
                        <tr>
                          <td colspan="2" align="center">                                                 
                                    <a href="<?php echo site_url('/Admin/verifikasi_pembayaran/'.$id);?>" class="btn btn-success">
                                       Verifikasi <span data-feather="check"></span>                                       
                                    </a>
                          </form>
                                     
                          </td>
                        </tr>
                      </tbody>
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