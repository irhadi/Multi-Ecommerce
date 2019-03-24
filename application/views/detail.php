<?php 
foreach($transaksi as $k):
  $id = $k->id_transaksi;
  $status = $k->status_transaksi;
  $gambar = $k->bukti_pembayaran;
  $no_resi = $k->nomor_resi;
  // $tgl = $k->tggl;
  // $id_penjual = $k->id_penjual;
  $kurir = $k->kurir;
  $layanan = $k->layanan;
  $ongkir = $k->ongkir;
  $unik = $k->kode_unik;
  $total_pesanan = $k->total_order;
  $w_order = $k->waktu_order;
  $w_k_pembayaran = $k->waktu_konfir_pembayaran;
  $w_k_pengiriman = $k->waktu_konfir_pengiriman;
  $w_k_transaksi = $k->waktu_konfir_transaksi;

  $nm_bank = $k->nm_bank;
  $an_rek = $k->an_rek;
  $no_rek = $k->no_rek;

  $nama = $k->nama;
  $notelp = $k->notelp;
  $alamat = $k->alamat;

  $pisah_datetime = (explode(" ",$w_order));
  $pisah_datetime2 = (explode(" ",$w_k_transaksi));
endforeach;
$sekarang = date('Y-m-d H:i:s');
$date = date_create($w_k_pembayaran);
$kadaluarsa = date_add($date, date_interval_create_from_date_string('24 hours'));
$exp = date_format($kadaluarsa, 'Y-m-d H:i:s');
?>

<div class="container bg-white border mb-1 p-5" style="margin-top: 61px">
    
	<div class="clearfix border-bottom mb-4">
	  <span class="float-left">
	  	<h1 class="h3 font-weight-normal">INVOICE</h1>
	  </span>
	  <span class="float-right">
	  	<h1 class="h3 font-weight-normal"><?php echo $id."/".$pisah_datetime[0];?></h1>
	  	<?php if($status == 'refund'){ ?>
	  		<p class="text-right">Refund</p>
	  	<?php } else if($status == 'batal'){ ?>
	  		<p class="text-right">Telah di Batalkan / <?php echo $pisah_datetime2[0]; ?></p>	  	
	  	<?php } else if($status == 'selesai'){ ?>
	  		<p class="text-right">Selesai / <?php echo $pisah_datetime2[0]; ?></p>
	  	<?php } ?>	  		
	  	
	  </span>
	</div>
	<div class="row">
		<div class="col-md-12">
		  <h4 class="font-weight-normal">Pembeli</h4>
			  <ul class="list-unstyled">
			  	<li><b>Nama : </b><?php echo $nama; ?></li>
			    <li><b>Nomor Telepon : </b><?php echo $notelp; ?></li>
			    <li><b>Alamat : </b><?php echo $alamat; ?></li>	
			  </ul>
		</div>	
	</div>	
	<hr>
	<div class="row">		
		<div class="col-md-6">
		  <h4 class="font-weight-normal">Pembayaran</h4>
			<ul class="list-unstyled">
				<?php if($status == "baru"){ ?>
				<li><b>Status : </b><?php echo "Belum dibayar"; ?></li>					
				<?php } else if($status == "konfirpembayaran"){ ?>
				<li><b>Status : </b><?php echo "Menunggu verifikasi pembayaran"; ?></li>		
				<?php } else { ?>
		        <li><b>Status : </b>Sudah dibayar</li>
	            <?php } ?>
            	<li><b>Bank tujuan : </b><?php echo $nm_bank." ".$an_rek." ".$no_rek; ?></li>
            	<li><b>Total Tagihan : </b>Rp<?php echo number_format($total_pesanan+$unik+$ongkir,0,",","."); ?></li>		      
            	<li><b>Waktu Konfirmasi Pembayaran : </b><?php echo $w_k_pembayaran; ?></li>    	
	        </ul>
		</div>			
		<div class="col-md-6">
		  <h4 class="font-weight-normal">Pengiriman</h4>
		  <ul class="list-unstyled">
		  	<li><b>Status : </b>
	    	<?php 
	    	if($status == 'dibayar'){
	    		echo "Menunggu Konfirmasi Penjual";
	    	}else if($status == 'konfirpengiriman'){
				echo "Menunggu Verifikasi Pengiriman";
	    	}else if($status == 'dikirim' || $status == 'selesai'){ 
	    		echo "Sudah dikirim";
	    	}else{
	    		echo "-";
	    	}
	    	?>		  	
		    </li>
		    <li><b>Kurir : </b> <?php echo $kurir; ?></li>
		    <li><b>Layanan :</b> <?php echo $layanan; ?></li>
		    <li><b>Ongkos Kirim :</b> <?php echo $ongkir; ?></li>
		    <li><b>Nomor Resi :</b> <?php if(empty($no_resi)){echo "-";}else{echo $no_resi;}?></li>
		<!--     <li><b>Waktu Konfirmasi Pengiriman :</b> <?php //echo $w_k_pengiriman;?></li> -->
		  </ul>
		</div>
	</div>
	<hr>
	<h4 class="font-weight-normal">Produk yang anda pesan</h4>
	<div class="row mt-3">
		<div class="col-md-12 col-sm-12 col-lg-12">
		  <table class="table table-sm table-bordered">
            <thead class="thead-light">
              <tr align="center">
                <th width="5%">No</th>
                <th width="45%">Nama</th>
                <th width="10%">Qty</th>
                <th width="20%">Satuan</th>
                <th width="20%">Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; foreach($order as $o): ?>
              <tr>
                <td align="center"><?php echo $no++; ?></td>
                <td><?php echo $o->nama; ?></td>
                <td align="center"><?php echo $o->qty; ?></td>
                <td align="right">Rp<?php echo number_format($o->harga_satuan,0,",","."); ?></td>
                <td align="right">Rp<?php echo number_format($o->total_harga,0,",","."); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <table class="float-right font-weight-bold" cellpadding="5">          
              <tr>
              	<td></td>
              	<td></td>
              	<td>SubTotal</td>
              	<td>Rp<?php echo number_format($total_pesanan,0,",","."); ?></td>
              </tr>          
              <tr>
              	<td></td>
              	<td></td>
              	<td>Kode transaksi</td>
              	<td><?php echo number_format($unik); ?></td>
              </tr>          
              <tr>
              	<td></td>
              	<td></td>
              	<td>Ongkos kirim</td>
              	<td>Rp<?php echo number_format($ongkir,0,",","."); ?></td>
              </tr>          
              <tr>
              	<td></td>
              	<td></td>
              	<td>Total tagihan</td>
              	<td>Rp<?php echo number_format($total_pesanan+$unik+$ongkir,0,",",".");?></td>
              </tr>          	
          </table>
		</div>
<!-- 			<ul class="list-group">
			  <li class="list-group-item d-flex justify-content-between align-items-center">subTotal<span class="ml-5">Rp<?php //echo number_format($total_pesanan,0,",","."); ?></span></li>
			  <li class="list-group-item d-flex justify-content-between align-items-center">Kode transaksi<span class="ml-5"><?php //echo number_format($unik); ?></span></li>
			  <li class="list-group-item d-flex justify-content-between align-items-center">Ongkos kirim<span class="ml-5">Rp<?php// echo number_format($ongkir,0,",","."); ?></span></li>
			  <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">Total tagihan<span class="ml-5">Rp<?php //echo number_format($total_pesanan+$unik+$ongkir,0,",",".");?></span></li>
			</ul> -->
			<div class="col mt-3 text-center">
				<?php if($status == "baru"){ ?>
					<button class="btn btn-danger" id="hapus_pemesanan">Batalkan</button>
					<a href="<?php echo site_url('/Checkout/pembayaran/'.$id); ?> " class="btn btn-primary">Konfirmasi Pembayaran</a>
				<?php } ?>
			</div>			
	</div>

	<?php if($status == 'refund') { 
		echo "Periksa email anda Kami telah mengirim email Konfirmasi pengembalian dana.";
		}else if($status == 'batal') { 
		echo "Periksa email anda Kami telah mengirim email bukti transfer pengembalian dana.";
		}
?>
</div>

      <div id="myModal" class="modalgambar">
        <span class="closemodalgambar">&times;</span>
        <img class="modal-gambar-content" id="img01">
        <div id="caption"></div>
      </div>

	<script type="text/javascript">
		<?php if($status == "baru"): ?>
			$(document).on('click','#hapus_pemesanan', function(){
		        var id = '<?php echo $id;?>';
		        swal({
		          title: 'Anda yakin ?',
		          text: 'ingin membatalkan pemesanan',
		          type: 'question',
		          showCancelButton: true,
		          focusCancel:true,
		          cancelButtonColor: '#d33',
		          confirmButtonText: 'Ya',
		        }).then((result) => {
		          if (result.value) {
		            $.ajax({
		              url : '<?php echo site_url();?>/Checkout/hapus_pemesanan',
		              type: 'POST',
		              data: {id:id},                   
		              success: function(response)
		              {
		                let timerInterval
		                swal({
		                  type : 'success',
		                  title: 'Pemesanan telah dihapus !',	                  
		                  html: '<strong></strong>.',
		                  timer: 2000,
		                  onOpen: () => {
		                    swal.showLoading()
		                    timerInterval = setInterval(() => {
		                      swal.getContent().querySelector('strong')
		                        .textContent = swal.getTimerLeft()
		                    }, 1000)
		                  },
		                  onClose: () => {
		                    clearInterval(timerInterval);
		                    window.location.assign(response);
		                  }
		                })
		              }
		            });
		           }
		        })
		    });	        
	    <?php endif; ?>
		
		<?php if($status != 'baru'): ?>
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
		<?php endif; ?>

				
</script>


