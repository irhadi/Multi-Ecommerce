           <div class="col-md-12 col-sm-12 p-4">
              <div class="col bg-fluid p-3">
                <div class="text-right">
                  <button class="btn btn-sm btn-outline-light" onclick="location.reload();"><span data-feather="refresh-cw"></span> Refresh</button>
                  
                </div>
              <ul class="nav nav-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home">KONFIRMASI PEMBAYARAN 
                      <?php if(!empty($status_konfir_pembayaran)){ echo "<span class='badge-pill badge-danger small'>".count($status_konfir_pembayaran)."</span>"; } ?>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu1">DI BAYAR 
                      <?php if(!empty($status_di_bayar)){ echo "<span class='badge-pill badge-danger small'>".count($status_di_bayar)."</span>"; } ?>                      
                    </a>
                  </li>                  
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu2">REFUND 
                      <?php if(!empty($status_refund)){ echo "<span class='badge-pill badge-danger small'>".count($status_refund)."</span>"; } ?>                      
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu3">KONFIRMASI PENGIRIMAN 
                      <?php if(!empty($status_konfir_pengiriman)){ echo "<span class='badge-pill badge-danger small'>".count($status_konfir_pengiriman)."</span>"; } ?>                        
                    </a>
                  </li>                  
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu4">DI KIRIM
                      <?php if(!empty($status_di_kirim)){ echo "<span class='badge-pill badge-danger small'>".count($status_di_kirim)."</span>"; } ?>
                    </a>
                  </li>    
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu5">BATAL
                      <?php if(!empty($status_batal)){ echo "<span class=''>(".count($status_batal).")</span>"; } ?>
                    </a>
                  </li>                  
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu6">SELESAI
                      <?php if(!empty($status_selesai)){ echo "<span class=''>(".count($status_selesai).")</span>"; } ?>
                    </a>
                  </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                  
                  <div id="home" class="container tab-pane active border border-top-0 p-3"><br>
                    
                    <p>Catatan : Harap segera verifikasi pembayaran.</p><br>

                      <div class="table-responsive-lg">
                        <table id="table1" class="table table-borderless table-striped table-hover border border-secondary" cellspacing="0">
                          <thead>
                            <tr>
                              <th scope="col">No.Transaksi</th>
                              <th>Nama Pembeli</th>
                              <th>Total Tagihan</th>
                              <!-- <th>Waktu Order</th> -->
                              <th>Waktu Konfirmasi Pembayaran</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
                              foreach($status_konfir_pembayaran as $p1)  {
                                $id1   = $p1->id_transaksi ;
                                $nama1 = $p1->nama ;
                                $w_bayar1  = $p1->waktu_konfir_pembayaran ;
                                $w_order1  = $p1->waktu_order;
                                $status1 = $p1->status_transaksi; 
                                $total1 = $p1->kode_unik+$p1->total_order+$p1->ongkir;         
                            ?>
                            <tr>
                              <td><?php echo $id1; ?></td>
                              <td><?php echo $nama1 ?></td>
                              <td>Rp<?php echo $total1; ?></td>
                              <td><?php echo $w_bayar1; ?></td>
                              <td>
                                  <a href="<?php echo site_url('/Admin/detail_pembayaran/'.$id1);?>" class="btn btn-info btn-sm">
                                     <span data-feather="eye"></span> Tampilkan
                                  </a> 
                              </td>
                            </tr>                
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>

                  </div>

                  <div id="menu1" class="container tab-pane fade border border-top-0 p-3"><br>

                    <p>Catatan : pembayaran yang telah diverifikasi sudah dikirim ke penjual untuk segera dilakukan pengiriman.</p><br>

                    <div class="table-responsive-lg">
                      <table id="table2" class="table table-borderless table-striped table-hover border border-secondary" cellspacing="0">
                        <thead>
                          <tr>
                            <th scope="col">No.Transaksi</th>
                            <th>Nama Pembeli</th>
                            <th>Total Tagihan</th>
                            <!-- <th>Waktu Order</th> -->
                            <th>Waktu Konfirmasi Pembayaran</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            foreach($status_di_bayar as $p2)  {           
                          ?>
                          <tr>
                            <td scope="row"><b><?php echo $p2->id_transaksi; ?></b></td>
                            <td><?php echo $p2->nama; ?></td>
                            <td>Rp<?php echo number_format($p2->kode_unik+$p2->total_order+$p2->ongkir,0,',','.'); ?></td>
                            <td><?php echo $p2->waktu_konfir_pembayaran; ?></td>
                            <td><a class="btn btn-info btn-sm" href="<?php echo site_url('/Admin/detail_transaksi/'.$p2->id_transaksi);?>"><span data-feather="eye"></span> Detail</a>
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>      
                  </div>

                  <div id="menu2" class="container tab-pane fade border border-top-0 p-3"><br>

                    <p>Catatan : Harap segera verifikasi pengiriman.</p><br>

                    <div class="table-responsive-lg">
                      <table id="table3" class="table table-borderless table-striped table-hover border border-secondary" cellspacing="0">
                        <thead>
                          <tr>
                            <th scope="col">No.Transaksi</th>
                            <th>Nama Toko</th>
                            <th>Nama Penjual</th>
                            <th>Waktu Konfirmasi Pengiriman</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            foreach($status_refund as $refund)  {          
                          ?>
                          <tr>
                            <td scope="row"><b><?php echo $refund->id_transaksi; ?></b></td>
                            <td><?php echo $refund->nama; ?></td>
                            <td>Rp<?php echo number_format($refund->kode_unik+$refund->total_order+$refund->ongkir,0,',','.'); ?></td>
                            <td><?php echo $refund->waktu_konfir_pembayaran; ?></td>
                            <td><a class="btn btn-info btn-sm" href="<?php echo site_url('/Admin/detail_transaksi/'.$refund->id_transaksi);?>"><span data-feather="eye"></span> Detail</a>
                              <a class="btn btn-success btn-sm" href="<?php echo site_url('/Admin/konfirm_transaksi_batal/'.$refund->id_transaksi);?>">
                               <span data-feather="check"></span> Konfirmasi Refund
                              </a>
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>

                  </div>                    

                  <div id="menu3" class="container tab-pane fade border border-top-0 p-3"><br>

                    <p>Catatan : Harap segera verifikasi pengiriman.</p><br>

                    <div class="table-responsive-lg">
                      <table id="table4" class="table table-borderless table-striped table-hover border border-secondary" cellspacing="0">
                        <thead>
                          <tr>
                            <th scope="col">No.Transaksi</th>
                            <th>Nama Toko</th>
                            <th>Nama Penjual</th>
                            <th>Waktu Konfirmasi Pengiriman</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            foreach($status_konfir_pengiriman as $p3)  {
                              $id3   = $p3->id_transaksi ;
                              $nama_penjual3 = $p3->nama_penjual;
                              $nama_toko3 = $p3->nama_toko;
                              $w_kirim3  = $p3->waktu_konfir_pengiriman;
                              $status3 = $p3->status_transaksi;            
                          ?>
                          <tr>
                            <td scope="row"><b><?php echo $id3; ?></b></td>
                            <td><?php echo $nama_toko3; ?></td>
                            <td><?php echo $nama_penjual3; ?></td>
                            <td><?php echo $w_kirim3; ?></td>
                            <td><a class="btn btn-info btn-sm" href="<?php echo site_url('/Admin/detail_pengiriman/'.$id3);?>"><span data-feather="eye"></span> Tampilkan</a></td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>

                  </div> 

                  <div id="menu4" class="container tab-pane fade border border-top-0 p-3"><br>
                    
                    <p>Catatan : segera konfirmasi transaksi telah selesai apabila paket telah sampai, dengan mentransfer total bayar ke penjual</p><br>
                    
                    <div class="table-responsive-lg">
                      <table id="table5" class="table table-borderless table-striped table-hover border border-secondary" cellspacing="0">
                        <thead>
                          <tr>
                            <th scope="col">No.Transaksi</th>
                            <th>Nama Toko</th>
                            <th>Nama Penjual</th>
                            <!-- <th>Status</th> -->
                            <th>Waktu Konfirmasi Pengiriman</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            foreach($status_di_kirim as $p4)  {
                              $id4   = $p4->id_transaksi ;
                              $nama_penjual4 = $p4->nama_penjual;
                              $nama_toko4 = $p4->nama_toko;
                              $resi4 = $p4->nomor_resi;
                              $w_kirim4  = $p4->waktu_konfir_pengiriman;
                              $status4 = $p4->status_transaksi;            
                          ?>
                          <tr>
                            <td scope="row"><b><?php echo $id4; ?></b></td>
                            <td><?php echo $nama_toko4; ?></td>
                            <td><?php echo $nama_penjual4; ?></td>
                            <!-- <td><i class="fa fa-circle text-success"></i> <?php //echo "Nomor Resi : ".$resi4; ?></td> -->
                            <td><?php echo $w_kirim4; ?></td>
                            <td>
                              <a class="btn btn-info btn-sm" href="<?php echo site_url('/Admin/detail_transaksi/'.$id4);?>">
                                <span data-feather="eye"></span> Detail
                              </a>&nbsp;
                              <a class="btn btn-success btn-sm" href="<?php echo site_url('/Admin/konfirm_transaksi_selesai/'.$id4);?>">
                                <span data-feather="check"></span> Selesai 
                              </a>
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>

                  </div>                  

                  <div id="menu5" class="container tab-pane fade border border-top-0 p-3"><br>
                    <div class="table-responsive-lg">
                      <table id="table6" class="table table-borderless table-striped table-hover border border-secondary" cellspacing="0">
                        <thead>
                          <tr>
                            <th scope="col">No.Transaksi</th>
                            <th>Nama Pembeli</th>
                            <th>Total Transfer</th>
                            <th>Waktu Konfir Transaksi</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            foreach($status_batal as $p5){
                              $id5   = $p5->id_transaksi ;
                              $nama5 = $p5->nama;
                              $w_batal5  = $p5->waktu_konfir_transaksi;
                              $status5 = $p5->status_transaksi;
                              $total5 = $p5->total_order+$p5->ongkir+$p5->kode_unik;                       
                          ?>
                          <tr>
                            <td scope="row"><b><?php echo $id5; ?></b></td>
                            <td><?php echo $nama5; ?></td>
                            <td><?php echo $total5; ?></td>
                            <td><?php echo $w_batal5; ?></td>
                            <td>
                              <a class="btn btn-info btn-sm" href="<?php echo site_url('/Admin/detail_transaksi/'.$id5);?>">
                                <span data-feather="eye"></span> Tampilkan
                              </a>&nbsp;
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div id="menu6" class="container tab-pane fade border border-top-0 p-3"><br>
                    <!-- <p>Catatan : pengiriman yang telah diverifikasi sudah dikirim ke pembeli.</p><br> -->
                    
                    <div class="table-responsive-lg">
                      <table id="table7" class="table table-borderless table-striped table-hover border border-secondary" cellspacing="0">
                        <thead>
                          <tr>
                            <th scope="col">No.Transaksi</th>
                            <th>Nama Toko</th>
                            <th>Total Bayar</th>
                            <th>Waktu Konfir Transaksi</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            foreach($status_selesai as $p6){
                              $id6   = $p6->id_transaksi ;
                              $nama_penjual6 = $p6->nama_penjual;
                              $nama_toko6 = $p6->nama_toko;
                              $resi6 = $p6->nomor_resi;
                              $w_kirim6  = $p6->waktu_konfir_pengiriman;
                              $w_selesai6  = $p6->waktu_konfir_transaksi;
                              $status6 = $p6->status_transaksi;
                              $total6 = $p6->total_order+$p6->ongkir;            
                          ?>
                          <tr>
                            <td scope="row"><b><?php echo $id6; ?></b></td>
                            <td><?php echo $nama_toko6; ?></td>
                            <td><?php echo $total6; ?></td>
                            <td><?php echo $w_selesai6; ?></td>
                            <td>
                              <a class="btn btn-info btn-sm" href="<?php echo site_url('/Admin/detail_transaksi/'.$id6);?>">
                                <span data-feather="eye"></span>Tampilkan
                              </a>&nbsp;
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
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

          $('#table4').DataTable({});
          $('#table6').DataTable({});
          $('#table5').DataTable({});
          $('#table7').DataTable({});
          $('#table3').DataTable({});
          $('#table1').DataTable({});
          $('#table2').DataTable({});
          
          feather.replace();
                    
        </script>
      </div>
    </div>
  </body>
</html>                      