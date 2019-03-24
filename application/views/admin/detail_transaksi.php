<?php 
foreach($transaksi as $k):
  $id = $k->id_transaksi;
  $unik = $k->kode_unik;
  $total_order = $k->total_order;
  $total_tagihan = $total_order+$k->ongkir+$unik;  
  $gambar1 = $k->bukti_pembayaran;
  $gambar2 = $k->bukti_pengiriman;
  $kurir = $k->kurir;  
  $layanan = $k->layanan; 
  $ongkir = $k->ongkir;   
  $no_resi = $k->nomor_resi;
  $w_order = $k->waktu_order;
  $w_bayar = $k->waktu_konfir_pembayaran;
  $w_kirim = $k->waktu_konfir_pengiriman;
  $status = $k->status_transaksi;  


  $nm_bank = $k->nm_bank;
  $an_bank = $k->an_rek;
  $no_bank = $k->no_rek;

  // $id_pembeli = $k->id_pembeli;
  // $nm_pembeli = $k->nama;
  // $notelp2 = $k->notelp;
  // $alamat2 = $k->alamat;

  $pisah_datetime = (explode(" ",$w_order));
endforeach;
?>



            <div class="col-md-12 col-sm-12 p-4">
              <div class="col bg-fluid p-5">
        
					<div class="clearfix border-bottom mb-2">
					  <span class="float-left">
					  	<h1 class="h4 font-weight-normal">Detail</h1>
					  </span>
					  <span class="float-right text-right text-uppercase">
					  	<h1 class="h4 font-weight-normal">#<?php echo $id."/".$pisah_datetime[0]."<br>".$status;?></h1>
					  </span>
					</div>
					<div class="row">
						<div class="col-md-6">
						  <h4 class="font-weight-normal">Pembeli</h4>
							  <ul class="list-unstyled">
							  	<?php foreach($pembeli as $pb): ?>
								  	<li><b>Nama :</b> <?php echo $pb->nama; ?></li>
								    <li><b>Nomor Telepon :</b> <?php echo $pb->notelp; ?></li>
								    <li><b>Alamat :</b> <?php echo $pb->alamat; ?></li>
							    <?php endforeach; ?>	
							  </ul>
						</div>	
						<div class="col-md-6">
						  <h4 class="font-weight-normal">Pembayaran</h4>
							  <ul class="list-unstyled">							  	
							    <li><b>Bank Tujuan :</b> <?php echo $nm_bank; ?> <?php echo $an_bank; ?> <?php echo $no_bank; ?></li>
							    <li><b>Total Tagihan :</b> Rp<?php echo number_format($total_tagihan,0,",",".");?></li>
								<li><b>Bukti pembayaran : </b>
									<?php if($gambar1 == " "){ 
										echo "-";
									}else{
										echo "<a target='_blank' href='".base_url('assets/foto/transaksi/buktipembayaran/').$gambar1."'>Tampilkan</a>";
									} 
									?>
				              	</li>					    
							    <li><b>Waktu Konfirmasi Pembayaran :</b> <?php echo $w_bayar;?></li>						
							  </ul>						  				             
						</div>	
					</div>	
					<hr>
					<div class="row">
						<div class="col-md-6">
						  <h4 class="font-weight-normal">Penjual</h4>
						  <ul class="list-unstyled">
						  	<?php foreach($penjual as $pj): ?>
							    <li><b>Nama Toko :</b> <?php echo $pj->nama_toko; ?></li>
							    <li><b>Nama Penjual :</b> <?php echo $pj->nama_penjual; ?></li>
							    <li><b>Nomor Telepon :</b> <?php echo $pj->notelp; ?></li>
							    <li><b>Alamat :</b> <?php echo $pj->alamat; ?></li>
							    <!-- <li><b>Waktu Konfirmasi Pengiriman :</b> <?php //echo $w_kirim;?></li> -->
							<?php endforeach; ?>
						  </ul>
						</div>		
						<div class="col-md-6">
						  <h4 class="font-weight-normal">Pengiriman</h4>
						  <ul class="list-unstyled">
						    <li><b>Kurir :</b> <?php echo $kurir;?></li>
						    <li><b>Layanan :</b> <?php echo $layanan; ?></li>
						    <li><b>Ongkos Kirim :</b> <?php echo $ongkir; ?></li>
						    <li><b>Nomor Resi :</b> <?php echo $no_resi?></li>
							<li><b>Bukti pengiriman : </b>
								<?php if(!empty($gambar2)){
									echo "<a target='_blank' href='".base_url('assets/foto/transaksi/buktipengiriman/').$gambar2."'>Tampilkan</a>";
								} ?>								
			              	</li>							    
						    <li><b>Waktu Konfirmasi Pengiriman :</b> <?php echo $w_kirim;?></li>
			              	</li>								    
						  </ul>
						</div>
					</div>
					<hr>
					<h4 class="font-weight-normal">Order</h4>
					<div class="row mt-3">
						<div class="col-md-7 col-sm-6 col-lg-8">
						  <table class="text-center table table-striped table-sm table-bordered table-hover">
				            <thead class="">
				              <tr>
				                <th>No</th>
				                <th>Nama</th>
				                <th>Qty</th>
				                <th>Harga Satuan</th>
				                <th>Jumlah Harga</th>
				              </tr>
				            </thead>
				            <tbody>
				              <?php $no=1; foreach($order as $o): ?>
				              <tr>
				                <td><?php echo $no++; ?></td>
				                <td><?php echo $o->nama; ?></td>
				                <td><?php echo $o->qty; ?></td>
				                <td>Rp<?php echo number_format($o->harga_satuan,0,",","."); ?></td>
				                <td>Rp<?php echo number_format($o->total_harga,0,",","."); ?></td>
				              </tr>
				              <?php endforeach; ?>
				            </tbody>
				          </table>
						</div>

						<div class="col-md-5 col-sm-6 col-lg-4">
							<ul class="list-group">
							  <li class="list-group-item  bg-fluid d-flex justify-content-between align-items-center">Total order<span class="ml-5">Rp<?php echo number_format($total_order,0,",","."); ?></span></li>
							  <li class="list-group-item  bg-fluid d-flex justify-content-between align-items-center">Kode transaksi<span class="ml-5"><?php echo number_format($unik); ?></span></li>
							  <li class="list-group-item  bg-fluid d-flex justify-content-between align-items-center">Ongkos kirim<span class="ml-5">Rp<?php echo number_format($ongkir,0,",","."); ?></span></li>
							  <li class="list-group-item  bg-fluid d-flex justify-content-between align-items-center font-weight-bold">Total tagihan<span class="ml-5">Rp<?php echo number_format($total_tagihan,0,",",".");?></span></li>
							</ul>
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