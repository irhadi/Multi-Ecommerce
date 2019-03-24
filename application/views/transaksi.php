<div class="container bg-white p-4 border mb-1" style="margin-top:61px">
  <h2 class="h3">Transaksi</h2>


      <hr>
      <?php if($order==0){ ?>
        <img width="100" src="<?php echo base_url('assets/img/icon/cart-empty.png'); ?>"/>
        <h2 align="center">Pemesanan Masih Kosong</h2>
        <p align="center">Anda Belum Melakukan Pemesanan</p>
      <?php }else{ ?>
          <div class="table-responsive-lg">
            <table id="table" class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th>No. Transaksi</th>
                  <th>Total Tagihan</th>
                  <th>Status</th>
                  <th>Di buat</th>  
                  <th>Di bayar</th>  
                  <th>Di kirim</th>  
                  <th></th> 

                </tr>
              </thead>
              <tbody>
                <?php 
                  $no = 1;
                  foreach($order as $o)  {
                    $id  = $o->id_transaksi; 
                    $penjual    = $o->nama_penjual;
                    $total_pesanan  = $o->total_order+$o->kode_unik+$o->ongkir;
                    $w_order        = $o->waktu_order;
                    $w_k_bayar      = $o->waktu_konfir_pembayaran;
                    $w_k_kirim      = $o->waktu_konfir_pengiriman;
                    $status         = $o->status_transaksi;
                    $nomor_resi     = $o->nomor_resi;
                    // $sekarang = date('Y-m-d H:i:s');
                    // $date = date_create($w_k_bayar);
                    // $kadaluarsa = date_add($date, date_interval_create_from_date_string('24 hours'));
                    // $exp = date_format($kadaluarsa, 'Y-m-d H:i:s');
                ?>
                <tr>
                  <td><b><?php echo $id; ?></b></td>
                  <!-- <td><b><?php //echo $penjual; ?></b></td> -->
                  <td>Rp<?php echo number_format($total_pesanan,0,",","."); ?></td>
                  
                  <td>
                    <?php 
                      if($status == 'dikirim' || $status == 'selesai'){
                        echo '<span class="text-success"><i class="fa fa-circle" aria-hidden="true"></i></span> Nomor Resi : '.$nomor_resi;
                      }else if($status == 'konfirpengiriman') {
                        echo '<span class="text-info"><i class="fa fa-circle" aria-hidden="true"></i></span> Dalam Proses Pengiriman';
                      }else if($status == 'konfirpembayaran') {
                        echo '<span class="text-warning"><i class="fa fa-circle" aria-hidden="true"></i></span> Menunggu Verifikasi Pembayaran</span>';
                      }else if($status == 'dibayar') {
                        echo '<span class="text-success"><i class="fa fa-circle" aria-hidden="true"></i></span> Sudah dibayar</span>';                    
                      }else if($status == 'refund') {
                        echo '<span class="text-warning"><i class="fa fa-circle" aria-hidden="true"></i></span> Refund</span>';             
                      }else if($status == 'batal') {
                        echo '<span class="text-danger"><i class="fa fa-circle" aria-hidden="true"></i></span> Batal</span>';             
                      }else if($status == 'dibayar') {
                        echo '<span class="text-success"><i class="fa fa-circle" aria-hidden="true"></i></span> Sudah dibayar</span>';
                      }else if($status == 'baru') {
                        echo '<span class="text-warning"><i class="fa fa-circle" aria-hidden="true"></i></span> Belum dibayar</span>';
                      }
                    ?>
                  </td>
                  <td><?php echo $w_order;?></td>
                  <td><?php echo $w_k_bayar ;?></td>
                  <td><?php echo $w_k_kirim;?></td>
                  <!-- <td><?php //echo $w_k_bayar;?></td> -->
                  <td>
                    <a href="<?php echo site_url('/Web/detail/'.$id);?>" role="button" class="btn btn-outline-info btn-sm">
                      <i class="fa fa-eye"></i>
                      Tampilkan</a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
      <?php } ?>

</div>


<script src="<?php echo base_url('assets/dataTables2/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/dataTables2/dataTables.bootstrap4.js'); ?>"></script> 
<script type="text/javascript">
  $('#table').DataTable({});
  $(".nav-tabs a").click(function(){
      $(this).tab('show');
  });  
</script>