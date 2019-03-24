<?php
  foreach($transaksi as $k):
    $id_trans = $k->id_transaksi;
    $id_rek = $k->id_rekening;
    $tggl = $k->waktu_order;
    $kode_tr = $k->kode_unik;
    $ongkir = $k->ongkir;
    $total = $k->total_order;
  endforeach;
  $f_total = $total + $ongkir + $kode_tr;
?>
      <div class="container" style="margin-top:65px">
        
        <div class="row">

          <div class="col-md-2"></div>

          <div class="col-md-8 bg-white  p-4 mb-1 border">
              <h5 class="h4 my-0 font-weight-normal mb-3">Konfirmasi Pembayaran</h5>
              <hr>
                <p class="text-center"><strong>TERIMA KASIH TELAH BERBELANJA DI MULTI-ECOMMERCE!</strong><br>
                Berikut ini adalah rincian tagihan dari pesanan anda, Bila anda telah melakukan pembayaran secara TRANSFER BANK, konfirmasikan pembayaran anda dengan mengupload bukti transaksi disini agar dapat kami proses segera.
                </p><br>

                  <div class="p-1 bg-light border rounded">
                    <table class="table table-borderless">
                      <thead  class="border-bottom">
                        <tr>
                          <th>Rincian Tagihan</th>
                          <th>Metode Pembayaran Bank Transfer ke :</th>
                        </tr>
                      </thead>
                      <tbody>                                            
                        <tr>
                          <td>
                            <div class="pr-2">

                              Nomor Order : <b>#<?php echo $id_trans;?></b><br>
                              Kode Transaksi : <b><?php echo $kode_tr;?></b><br>
                              Total Tagihan : <b>Rp<?php echo number_format($f_total,0,",","."); ?></b><br>
                              Waktu Order : <b><?php echo $tggl;?></b><br>
                              Kadaluarsa : <b><span id="waktu" class=""></span></b>
                            </div>
                          </td>                          
                          <td>
                            <div class="pr-2">
                              <?php echo $this->CI->get_bank($id_rek);?>  
                            </div>
                            
                          </td> 
                        </tr>                   
                      </tbody>
                    </table>
                    
                  </div>
                
                  
                    <p class="p-1 small"><strong>Penting !</strong> <br> - Pemesanan yang sudah dibayar tidak dapat dibatalkan.<br> - Harap segera konfirmasi pembayaran sebelum kadaluarsa</p>

                  <div>
                    <img src="#" id="preview" class="mx-auto d-block" style="display: none"  alt="" width="300"/>
                  </div>                    
                  
              <form method="post" class="form" enctype="multipart/form-data" action="<?php echo site_url('/Checkout/upload_bukti/'.$id_trans);?>">

                  <div class="custom-file">
                    <label class="custom-file-label" for="gambar">Foto Bukti Transfer</label>
                    <input type="file" class="custom-file-input" id="gambar" name="struk">
                    <small class="text-muted">Maximal ukuran file 3 MB Type JPG dan JPEG</small>
                  </div>
                  <br>
                  <div id="expired" class="text-center mt-3">
                    <button class="btn btn-primary btn-block" type="submit">Konfirmasi Pembayaran</button>
                  </div>
              </form>
          </div>

          <div class="col-md-2"></div>

        </div>    
      </div>

      <script type="text/javascript">
        <?php 
        $date = date_create($tggl);
        date_add($date, date_interval_create_from_date_string('24 hours'));  
        ?>
        var countDownDate = new Date("<?php echo date_format($date, 'Y-m-d H:i:s'); ?>").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get todays date and time
            var now = new Date().getTime();
            
            // Find the distance between now an the count down date
            var distance = countDownDate - now;
            
            // Time calculations for days, hours, minutes and seconds
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            // Output the result in an element with id="demo"
            document.getElementById("waktu").innerHTML = hours + " : "
            + minutes + " : " + seconds;
            
            // If the count down is over, write some text 
            if (distance < 0) {
                clearInterval(x);
                $('.custom-file').hide();
                document.getElementById("waktu").innerHTML = "EXPIRED";
                document.getElementById("expired").innerHTML = "EXPIRED";
                swal({
                  type: 'info',
                  title: 'Pesanan anda telah kadaluarsa!',
                  text : 'Silahkan melakukan pemesanan ulang',
                  html: 'Data Pemesanan akan otomatis dihapus',
                  timer: 5000,
                  onOpen: () => {
                    swal.showLoading()
                  },
                  onClose: () => {
                    var id = '<?php echo $id_trans; ?>';
                    $.ajax({
                        url: '<?php echo site_url();?>'+'/Checkout/hapus_pemesanan',
                        type: 'POST',
                        data: { id:id },
                        success: function(response){
                          window.location.assign(response);                   
                        }
                    });
                  }
                })
            }
        }, 1000);

          function bacaGambar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                  $('#preview').attr('src', e.target.result);
                }
              reader.readAsDataURL(input.files[0]);
            }
            }
            $('#gambar').change(function(){
            bacaGambar(this);
          });              
      </script>