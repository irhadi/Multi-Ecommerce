<?php 
foreach($penjual as $k):
  $id_transaksi = $k->id_transaksi;
  $total_order = $k->total_order;
  $total_transfer = $total_order+$k->ongkir;  

  $nm_bank = $k->nm_bank;
  $an_bank = $k->an_rek_bank;
  $no_bank = $k->no_rek_bank;
endforeach;
?>

           <div class="col-md-12 col-sm-12 p-4">
              <div class="col bg-fluid p-3">
                <div class="row">
                  <div class="col-md-5">
                    <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo site_url('/Admin/cek_konfirmasi_selesai/'.$id);?>">
                      <div class="row mb-3">
                        <div class="col-md-12">
                          <p>Berikut detail rekening tujuan dan total transfer :</p>
                          <table border="0" cellpadding="10">
                            <tbody>
                              <tr>
                                <td>Nama Bank </td>
                                <td> : <?php echo $nm_bank; ?></td>
                              </tr>                               
                              <tr>
                                <td>Atas Nama</td>
                                <td> : <?php echo $an_bank; ?></td>
                              </tr>                               
                              <tr>
                                <td>Nomor Rekening</td>
                                <td> : <?php echo $no_bank; ?></td>
                              </tr>                                 
                              <tr>
                                <td>Biaya Admin</td>
                                <td> : Rp5.000</td>
                              </tr>                       
                              <tr>
                                <td>Total Transfer </td>  
                                <td> : Rp<?php echo number_format($total_transfer-5000,0,",","."); ?></td>
                              </tr>                      
                              </tr>
                            </tbody>
                          </table>    
                        </div>
<!--                         <div class="col-md-12 mt-3">
                            <label for="address">Catatan</label>
                            <textarea class="form-control" rows="4" id="comment" name="catatan"></textarea>
                            <span class="text-danger"><?php //  echo form_error('catatan');?></span>                                     
                        </div> -->
                      </div>
                      <div class="row mb-3 mt-0">
                        <div class="col-md-12">
                          <div class="text-center">
                            <img src="#" id="preview" class="img-fluid rounded" alt="" width="100%">
                          </div>
                          <div class="custom-file">                                                                
                            <label class="custom-file-label" for="gambar">Foto Bukti Transfer</label>
                            <input type="file" class="custom-file-input" id="gambar" name="foto_transfer">
                          </div>
                          <small class="text-muted text-left">Maximal ukuran foto 3MB dan type jpg atau jpeg</small>
                        </div>  
                      </div>            
                        <hr>
                      <div class="text-center">
                        <button type="button" class="btn btn-secondary" onclick="javascript:history.back()"><span ></span> Kembali</button>
                        <button type="submit" class="btn btn-success">Kirim <i class="fa fa-paper-plane-o"></i></button>
                      </div>            
                    </form>
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
          
          feather.replace();

          function bacaGambar(input) {
          if(input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                  $('#preview').show();
                  $('#preview').addClass('mb-3');
                  $('#preview').attr('src', e.target.result);
                }
              reader.readAsDataURL(input.files[0]);
            }
          }
          $('#preview').hide();
          $('#gambar').change(function(){
            bacaGambar(this);
          });
        </script>
      </div>
    </div>
  </body>
</html>               