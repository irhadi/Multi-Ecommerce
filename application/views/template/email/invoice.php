
<!DOCTYPE html>
	<head>
		<style type="text/css">
		body{background:#efefef;font-family:arial;}
		#wrapshopcart{width:70%;margin:3em auto;padding:30px;background:#fff;box-shadow:0 0 15px #ddd;}
		h1{margin:0;padding:0;font-size:2.5em;font-weight:bold;}
		p{font-size:1em;margin:0;}
		table{margin:2em 0 0 0; border:1px solid #eee;width:100%; border-collapse: separate;border-spacing:0;}
		table th{background:#fafafa; border:none; padding:20px ; font-weight:normal;text-align:left;}
		table td{background:#fff; border:none; padding:12px  20px; font-weight:normal;text-align:left; border-top:1px solid #eee;}
		table tr.total td{font-weight: bold;}
		table tr td.right{text-align: right;}
		.btnsubmit{display:inline-block;padding:10px;border:1px solid #ddd;background:#eee;color:#000;text-decoration:none;margin:2em 0;}
		form{margin:2em 0 0 0;}
		label{display:inline-block;width:auto;}
		input[type=text]{border:1px solid #bbb;padding:10px;width:30em;}
		textarea{border:1px solid #bbb;padding:10px;width:30em;height:5em;vertical-align:text-top;margin:0.3em 0 0 0;}
		.submitbtn{font-size:1.5em;display:inline-block;padding:10px;border:1px solid #ddd;background:#eee;color:#000;text-decoration:none;margin:0.5em 0 0 8em;};
		
		</style>
	</head>
	
	<body>

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
		  $total = $k->total_order;
		  $w_order = $k->waktu_order;
		  $w_k_pembayaran = $k->waktu_konfir_pembayaran;
		  $w_k_pengiriman = $k->waktu_konfir_pengiriman;

		  $nm_bank = $k->nm_bank;
		  $an_rek = $k->an_rek;
		  $no_rek = $k->no_rek;

		  $nama = $k->nama;
		  $notelp = $k->notelp;
		  $alamat = $k->alamat;
		  $email = $k->email;
				  endforeach;
		  $f_total = $total + $ongkir + $unik;
		?>		
		<div id="wrapshopcart">
			<h1>Invoice #<?php echo $id;?></h1>
			
			<h3>Berikut data lengkap Anda : </h3>
			<label>Nama Lengkap : <?php echo $nama; ?> </label><br/>
			<label>Email : <?php echo $email; ?> </label><br/>
			<label>No Telp : <?php echo $notelp; ?> </label><br/>
			<label>Alamat : <?php echo $alamat; ?> </label><br/>			
			
			<h3>Jasa pengiriman yang anda pilih : </h3>
			<label>Kurir : <?php echo $kurir; ?> </label><br/>
			<label>Layanan : <?php echo $layanan; ?> </label><br/>
			<label>ongkir : <?php echo $ongkir; ?> </label><br/>
			
			<h3>Produk Yang Anda Pesan : </h3>
			<table>
				<tr>
					<th width="50%">Produk</th>
					<th width="10%">Quantity</th>
					<th width="20%">Satuan</th>
					<th width="20%">Jumlah</th>
				</tr>
		      <?php foreach($order as $o): ?>
				<tr>
					<td><?php echo $o->nama; ?></td>
					<td><?php echo $o->qty; ?></td>
					<td >Rp<?php echo number_format($o->harga_satuan,0,",","."); ?></td>
					<td class="right">Rp<?php echo number_format($o->total_harga,0,",","."); ?></td>
				</tr>
              <?php endforeach; ?>						
				<tr class="total">
					<td></td>
					<td></td>
					<td>Sub Total</td>
					<td class="right">Rp<?php echo number_format($total,0,",","."); ?></td>
				</tr>				
				<tr class="total">
					<td></td>
					<td></td>
					<td>Kode Transaksi</td>
					<td class="right"><?php echo $unik; ?></td>
				</tr>				
				<tr class="total">
					<td></td>
					<td></td>
					<td>Ongkos kirim</td>
					<td class="right">Rp<?php echo number_format($ongkir,0,",","."); ?></td>
				</tr>				
				<tr class="total">
					<td></td>
					<td></td>
					<td>Total</td>
					<td class="right">Rp<?php echo number_format($f_total,0,",","."); ?></td>
				</tr>							
				<tr class="total">
					<td></td>
					<td></td>
					<td>Batas waktu pembayaran</td>
					<td class="right"><?php $date = date_create($w_order);
		        date_add($date, date_interval_create_from_date_string('24 hours')); 
				echo date_format($date, 'Y-m-d H:i:s'); ?></td>
				</tr>
			</table>			
			
			<h3>Metode Pembayaran Bank Transfer</h3>
			Terima kasih telah melakukan pemesanan produk kerajinan gerabah di Multi e-commerce, silahkan lakukan pembayaran ke rekening berikut :<br><br>
			<label><b><?php echo $nm_bank; ?></b></label><br/>
			<label>Atas nama : <?php echo $an_rek; ?> </label><br/>
			<label>Nomor Rekening : <?php echo $no_rek; ?> </label><br/><br/>
			<p>
				Jika anda sudah melakukan pembayaran, harap segera melakukan konfirmasi pembayaran dengan 
				mengupload bukti transfer ke halaman <a href="<?php echo site_url('Checkout/pembayaran/'.$id);?>">Konfirmasi Pembayaran</a>.
			</p>
			<br>
			<br>
			
			&mdash; Multi E-commerce<br>
			CustomerService@gmail.com<br>
			0011223344

		</div>	
	</body>
</html>



