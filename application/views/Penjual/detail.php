<?php 
foreach($transaksi as $k):
  $id = $k->id_transaksi;
  $status = $k->status_transaksi;
  $gambar = $k->bukti_pembayaran;
  $gambartransfer = $k->bukti_transfer;
  $no_resi = $k->nomor_resi;
  $tgl = $k->waktu_konfir_pembayaran;
  $tgl1 = $k->waktu_konfir_pengiriman;
  $tgl2 = $k->waktu_konfir_transaksi;
  $id_penjual = $k->id_penjual;
  $kurir = $k->kurir;
  $layanan = $k->layanan;
  $ongkir = $k->ongkir;
  $unik = $k->kode_unik;
  $total_pesanan = $k->total_order;
  $pisah_datetime = (explode(" ",$tgl));
  
  $nama = $k->nama;
  $notelp = $k->notelp;
  $alamat = $k->alamat;

	$date = date_create($tgl);
  	date_add($date, date_interval_create_from_date_string('24 hours'));
	$kadaluarsa = date_format($date, 'Y-m-d H:i:s')." / ";
	$sekarang = date('Y-m-d H:i:s');  	
endforeach;
?>

<div class="container bg-white pt-3 p-5 mb-1 border" style="margin-top: 61px;">
	<div class="clearfix mb-4 border-bottom">
	  <span class="float-left">
	  	<h1 class="h3 font-weight-normal">Order
	  		<!-- <a class="btn btn-primary" href="<?php //echo site_url('/Cetak/receipt/'.$id);?>" target="_BLANK"><i class="fa fa-print"></i> Cetak</a> -->
	  	</h1>
	  </span>
	  <span class="float-right text-right">
	  	<h1 class="h3 font-weight-normal">#<?php echo $id.'/'.$pisah_datetime[0];?></h1>
	  	<?php if($status == 'dibayar' && $kadaluarsa > $sekarang){?>
	  		<p>Batas Waktu Konfirmasi Pengiriman : <?php echo date_format($date, 'Y-m-d H:i:s'); ?></p>
	  	<?php }else if($status == 'dikirim'){?>
	  		<p>Dikirim : <?php echo $tgl1; ?></p>	  	
	  	<?php }else if($status == 'refund'){?>
	  		<p>Refund : <?php echo $tgl2; ?></p>
	  	<?php }else if($status == 'konfirpengiriman'){ ?>
	  		<p>Pengiriman dikonfirmasi : <?php echo $tgl1; ?></p>
	  	<?php }else if($status == 'batal'){ ?>
	  		<p>Telah dibatalkan : <?php echo $tgl2; ?></p>
	  	<?php }else if($status == 'selesai'){ ?>
	  		<p>Selesai : <?php echo $tgl2;?></p>
	  	<?php } ?>
	  </span>
	</div>
	<div class="row">
		<div class="col-md-6">
		  <h4 class="font-weight-normal">Detail Pembeli</h4>
			  <ul class="list-unstyled">
			  	<li><b>Nama :</b> <?php echo $nama; ?></li>
			    <li><b>Nomor Telepon :</b> <?php echo $notelp; ?></li>
			    <li><b>Alamat :</b> <?php echo $alamat; ?></li>	
			  </ul>
		</div>	
		<div class="col-md-6">
		  <h4 class="font-weight-normal">Jasa Pengiriman</h4>
		  <ul class="list-unstyled">
		    <li><b>Kurir :</b> <?php echo $kurir;?></li>
		    <li><b>Layanan :</b> <?php echo $layanan; ?></li>
		    <li><b>Ongkos Kirim :</b> <?php echo $ongkir; ?></li>
		    <li><b>Nomor Resi :</b> <?php if(!empty($no_resi)){echo $no_resi;}else{ echo "-";} ?></li>
		  </ul>
		</div>		
	</div>	
	<hr>
	<h4 class="font-weight-normal">Produk yang dipesan</h4>
	<div class="row mt-3">
		<div class="col-md-12 col-sm-12 col-lg-12">
		  <table class="table table-sm table-bordered">
			<thead class="thead-light">
              <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Qty</th>
                <th>Satuan</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach($order as $o): ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $o->nama; ?></td>
                <td><?php echo $o->qty; ?></td>
                <td><?php echo $o->harga_satuan; ?></td>
                <td>Rp<?php echo number_format($o->total_harga,0,",","."); ?></td>
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
              	<td>Ongkos kirim</td>
              	<td>Rp<?php echo number_format($ongkir,0,",","."); ?></td>
              </tr>          
              <tr>
              	<td></td>
              	<td></td>
              	<td>Biaya Admin</td>
              	<td>- Rp5.000</td>
              </tr>          
              <tr>
              	<td></td>
              	<td></td>
              	<td>Total Bayar</td>
              	<td>Rp<?php echo number_format($total_pesanan+$ongkir-5000,0,",",".");?></td>
              </tr>          	
          </table>
        </div>
    </div>
	<?php 
	if($status == 'dibayar' && $kadaluarsa > $sekarang){ 		
	?>
	<div class="text-center mt-3">		
		<button type="button" class="btn btn-danger" onclick="javascript:history.back()"><span ></span> Kembali</button>
		<a href="<?php echo site_url('/Penjual/konfirmasi_pengiriman/'.$id);?>" class="btn btn-primary">Konfirmasi Pengiriman</a>	
	</div>
	<?php } ?>	



<?php if($status == 'selesai'){ ?>
	Transaksi Telah selesai, Periksa email anda kami telah mengirim email bukti transfer dana transaksi.	
<?php } ?>   	
</div>

