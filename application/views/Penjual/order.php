  <div class="container p-4 bg-white mb-1 border" style="margin-top: 61px;">

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
        <h1 class="h4">Data Order</h1>
      </div>

      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" href="#Terbaru">Terbaru</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#Dikonfirmasi">Di konfirmasi</a>
        </li>      
        <li class="nav-item">
          <a class="nav-link" href="#Dikirim">Di Kirim</a>
        </li>        
        <li class="nav-item">
          <a class="nav-link" href="#History">Riwayat Transaksi</a>
        </li>
      </ul>

      <div class="tab-content mb-3">
        <div id="Terbaru" class="tab-pane active border border-top-0 p-3">
          <?php if(!empty($order_terbaru)) { ?>
            <p><b>Catatan : </b>Harap segera mengkonfirmasi pengiriman</p><br>
            <div class="table-responsive-lg">
              <table id="table1" class="table table-striped table-hover table-borderless">
                <thead class="thead-light">
                  <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Total Bayar</th>
                    <th>Status</th> 
                    <th>Di Bayar</th> 
                    <th></th> 
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach($order_terbaru as $o){
                    $id1    = $o->id_transaksi;
                    $nama1    = $o->nama;
                    $total1 = $o->total_order;
                    $unik1 = $o->kode_unik;
                    $ongkir1   = $o->ongkir;
                    $resi1 = $o->nomor_resi;
                    $status = $o->status_transaksi;
                    $wk_bayar1    = $o->waktu_konfir_pembayaran;                 
                  ?>                          
                    <tr>
                      <td><?php echo $id1;?></td>
                      <td><?php echo $nama1; ?></td>
                      <td>Rp<?php echo number_format($total1+$ongkir1-5000,0,',','.');?></td>
                      <td>
                        <?php
                         if($status=="dibayar"){
                          echo "<span class='text-success'><i class='fa fa-circle'></i></span> Telah Dibayar ";
                         }else{
                          echo "<span class='text-warning'><i class='fa fa-circle'></i></span> Refund";
                         }
                        ?>
                      </td>
                      <td><?php echo $wk_bayar1;?></td>
                      <td>
                        <a href="<?php echo site_url('/Penjual/detail_order/'.$id1); ?>" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Tampilkan</a>
                      </td>
                    </tr>
                  <?php } ?> 
                </tbody>
              </table>
            </div>          
          <?php }else{ ?>
            <div class="col-md-12 text-center"><h1 class="h4">Belum ada order terbaru!</h1></div>
          <?php } ?>
        </div>      

        <div id="Dikonfirmasi" class="tab-pane border border-top-0 p-3">
        <?php if(!empty($order_dikonfirmasi)) { ?>       
            <p><b>Catatan : Menunggu verifikasi dari admin.</b></p><br>
            <div class="table-responsive-lg">
              <table id="table2" class="table table-striped table-borderless">
                <thead class="thead-light">
                  <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Total Bayar</th>
                    <th>Status</th> 
                    <th>Waktu konfirmasi pengiriman</th> 
                    <th></th> 
                  </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($order_dikonfirmasi as $p){
                      $id2    = $p->id_transaksi;
                      $nama2    = $p->nama;
                      $total2 = $p->total_order;
                      $ongkir2    = $p->ongkir;
                      $resi2 = $p->nomor_resi;
                      $wk_kirim2 = $p->waktu_konfir_pengiriman;                      
                    ?> 
                    <tr>
                      <td><?php echo $id2; ?></td>
                      <td><?php echo $nama2; ?></td>
                      <td>Rp<?php echo number_format($total2+$ongkir2-5000,0,',','.'); ?></td>
                      <td><i class="fa fa-circle text-success"></i> Telah dikonfirmasi</td>
                      <td><?php echo $wk_kirim2; ?></td>
                      <td>
                        <a href="<?php echo site_url('/Penjual/detail_order/'.$id2); ?>" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Tampilkan</a>
                      </td>
                    </tr>
                    <?php } ?>
                </tbody>
              </table>
            </div>          
            <?php }else{ ?>
              <div class="col-md-12 text-center"><h1 class="h4">Belum ada order dikonfirmasi!</h1></div>
            <?php } ?>
        </div>

        <div id="Dikirim" class="tab-pane fade border border-top-0 p-3">
          <?php if(!empty($order_dikirim)) { ?>
            <!-- <h2 class="h3">Riwayat Transaksi</h2><br> -->
            <div class="table-responsive-lg">
              <table id="table3" class="table table-hover table-striped table-borderless">
                <thead class="thead-light">
                  <tr>
                    <th>No.Order</th>
                    <th>Nama Pembeli</th>
                    <th>Total Bayar</th>
                    <th>Status</th> 
                    <th>Waktu Konfirmasi pengiriman</th> 
                    <th></th> 

                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $no = 1;
                    foreach($order_dikirim as $o){
                      $id_kirim   = $o->id_transaksi;
                      $nama_kirim    = $o->nama;
                      $total_order_kirim = $o->total_order;
                      $kode_unik_kirim = $o->kode_unik;
                      $ongkir_kirim    = $o->ongkir;
                      $status_kirim = $o->status_transaksi;
                      $nomor_resi_kirim = $o->nomor_resi;
                      $w_konfir_pembayaran_kirim    = $o->waktu_konfir_pembayaran;
                      $w_konfir_pengiriman_kirim    = $o->waktu_konfir_pengiriman;
                  ?>
                    <tr>
                      <td><?php echo $id_kirim; ?></td>
                      <td><?php echo $nama_kirim; ?></td>
                      <td><?php echo number_format($total_order_kirim+$ongkir_kirim-5000,0,',','.');?></td>
                      <td><span class="text-success"><i class="fa fa-circle"></i></span> <?php echo 'Nomor Resi : '.$nomor_resi_kirim; ?></td>
                      <td><?php echo $w_konfir_pengiriman_kirim;?></td>
                      <td>
                        <a href="<?php echo site_url('/Penjual/detail_order/'.$id_kirim); ?>" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Tampilkan</a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          <?php }else{ ?>
            <div class="col-md-12 text-center"><h1 class="h4">Belum Ada Order dikirim !</h1></div>
          <?php } ?>
        </div>

        <div id="History" class="tab-pane fade border border-top-0 p-3">
          <?php if(!empty($order_history)) { ?>
            <!-- <h2 class="h3">Riwayat Transaksi</h2><br> -->
            <div class="table-responsive-lg">
              <table id="table4" class="table table-hover table-striped table-borderless">
                <thead class="thead-light">
                  <tr>
                    <th>No.Order</th>
                    <th>Nama Pembeli</th>
                    <th>Total Bayar</th>
                    <th>Status</th> 
                    <th>Waktu Transaksi</th> 
                    <th></th> 

                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $no = 1;
                    foreach($order_history as $o){
                      $id_history    = $o->id_transaksi;
                      $nama_history    = $o->nama;
                      $total_order_history = $o->total_order;
                      $kode_unik_history = $o->kode_unik;
                      $ongkir_history    = $o->ongkir;
                      $status_history = $o->status_transaksi;
                      $nomor_resi_history = $o->nomor_resi;
                      $w_konfir_pembayaran_history    = $o->waktu_konfir_pembayaran;
                      $w_konfir_pengiriman_history    = $o->waktu_konfir_pengiriman;
                      $w_konfir_tr    = $o->waktu_konfir_transaksi;
                  ?>
                    <tr>
                      <td><?php echo $id_history; ?></td>
                      <td><?php echo $nama_history; ?></td>
                      <td><?php echo number_format($total_order_history+$ongkir_history-5000,0,',','.');?></td>
                      <td>
                        <?php if($status_history == 'selesai') { ?>
                           <span class="text-success"><i class="fa fa-circle"></i></span> <?php echo 'Nomor Resi : '.$nomor_resi_history; ?>
                        <?php }else{ ?>
                           <span class="text-danger"><i class="fa fa-circle"></i></span> Batal (Refund)
                        <?php } ?>
                       
                      </td>
                      <td><?php echo $w_konfir_tr;?></td>
                      <td>
                        <a href="<?php echo site_url('/Penjual/detail_order/'.$id_history); ?>" class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Tampilkan</a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          <?php }else{ ?>
            <div class="col-md-12 text-center"><h1 class="h4">Belum Ada riwayat transaksi !</h1></div>
          <?php } ?>
        </div>
      </div>
  </div>
<script src="<?php echo base_url('assets/dataTables2/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/dataTables2/dataTables.bootstrap4.js'); ?>"></script> 
  <script type="text/javascript">
    $(".nav-tabs a").click(function(){
      $(this).tab('show');      
    });
    $('#table1').DataTable({});
    $('#table2').DataTable({});
    $('#table3').DataTable({});
    $('#table4').DataTable({});
  </script>