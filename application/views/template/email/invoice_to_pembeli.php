<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

<!-- Mirrored from coderthemes.com/minton/dark-dark/email-templates/billing.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 19 May 2018 13:48:05 GMT -->
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Minton - Responsive Admin Dashboard Template</title>


<style type="text/css">
img {
max-width: 100%;
}
body {
-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
}
body {
background-color: #f6f6f6;
}
@media only screen and (max-width: 640px) {
  body {
    padding: 0 !important;
  }
  h1 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h2 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h3 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h4 {
    font-weight: 800 !important; margin: 20px 0 5px !important;
  }
  h1 {
    font-size: 22px !important;
  }
  h2 {
    font-size: 18px !important;
  }
  h3 {
    font-size: 16px !important;
  }
  .container {
    padding: 0 !important; width: 100% !important;
  }
  .content {
    padding: 0 !important;
  }
  .content-wrap {
    padding: 10px !important;
  }
  .invoice {
    width: 100% !important;
  }
}
</style>
</head>

<body itemscope itemtype="http://schema.org/EmailMessage" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

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

<table class="body-wrap" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
		<td class="container" width="800" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 800px !important; clear: both !important; margin: 0 auto;" valign="top">
			<div class="content" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 800px; display: block; margin: 0 auto; padding: 20px;">
				<table class="main" width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap aligncenter" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 20px;" align="center" valign="top">
					<table width="100%" cellpadding="0" cellspacing="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
						<h2 class="aligncenter" style="font-family: 'Helvetica Neue',Helvetica,Arial,'Lucida Grande',sans-serif; box-sizing: border-box; font-size: 24px; color: #000; line-height: 1.2em; font-weight: 400; text-align: center; margin: 40px 0 0;" align="center">
							Terima kasih Telah Berbelanja di Multi E-commerce
						</h2>
									</td>
								</tr><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
									<td class="content-block aligncenter" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
										<table class="invoice" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; text-align: left; width: 90%; margin: 40px auto;">
												<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
													<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;" valign="top">
														<b>INVOICE : #<?php echo $id." / ".$w_order;?></b>
														<br>
														Batas Waktu Konfirmasi Pembayaran : <?php $date = date_create($w_order);
												        date_add($date, date_interval_create_from_date_string('24 hours')); 
														echo date_format($date, 'Y-m-d H:i:s'); 
														?>
													</td>
												</tr>												
												<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
													<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;" valign="top">
														<b>Berikut data lengkap anda :</b>
														<br>
														<label>Nama : <?php echo $nama; ?></label><br>
														<label>Email : <?php echo $email; ?></label><br>
														<label>No Telp : <?php echo $notelp; ?></label><br>
														<label>Alamat : <?php echo $alamat; ?></label><br>
													</td>												
												</tr>
												<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
													<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;" valign="top">
														<b>Jasa pengiriman yang anda pilih :</b>
														<br>
														<label>Kurir : <?php echo $kurir; ?> </label><br/>
														<label>Layanan : <?php echo $layanan; ?> </label><br/>
														<label>ongkir : <?php echo $ongkir; ?> </label><br/>
													</td>	
												</tr>												
												<tr style="font-family: 'Helvetica Neue',Helvetica,Arial	,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
													<td colspan="2" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;" valign="top">	
														<b>Produk yang anda pesan :</b>
														<table class="invoice-items" cellpadding="0" cellspacing="0" border="0" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; margin: 0;">
															<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top;text-align: center; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-width: 2px; border-bottom-color: #333; border-bottom-style: solid; margin: 0; padding: 5px 0;" valign="top">
																	No
																</td>	
																<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; margin: 0; padding: 5px 0;" valign="top">
																	Nama Produk
																</td>
																<td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; margin: 0; padding: 5px 0;" align="center" valign="top">
																	Quantity
																</td>					
																<td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; margin: 0; padding: 5px 0;" align="right" valign="top">
																	Satuan
																</td>																
																<td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; margin: 0; padding: 5px 0;" align="right" valign="top">
																	Total  
																</td>
															</tr>	

		
            																
															<?php $no=1; foreach($order as $o): ?>
															<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 5px 0;" valign="top">
																	<?php echo $no++; ?>
																</td>	
																<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;" valign="top">
																	<?php echo $o->nama; ?>
																</td>
																<td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 5px 0;" align="center" valign="top">
																	<?php echo $o->qty; ?>
																</td>					
																<td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 5px 0;" align="right" valign="top">
																	Rp<?php echo number_format($o->harga_satuan,0,",","."); ?>
																</td>																
																<td class="alignright" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 5px 0;" align="right" valign="top">
																	Rp<?php echo number_format($o->total_harga,0,",","."); ?>  
																</td>
															</tr>
															<?php endforeach; ?>

															<tr class="total" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																<td colspan="4" align="right" style="border-top-width: 2px; border-top-color: #333; border-top-style: solid;">Sub Total :</td>
																<td align="right" style="border-top-width: 2px; border-top-color: #333; border-top-style: solid;">Rp<?php echo number_format($total,0,",","."); ?></td>
															</tr>															
															<tr class="total" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																<td colspan="4" align="right" >Kode Transaksi :</td>
																<td align="right"><?php echo $unik; ?></td>
															</tr>															
															<tr class="total" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																<td colspan="4" align="right" >Ongkos kirim :</td>
																<td align="right">Rp<?php echo number_format($ongkir,0,",","."); ?></td>
															</tr>															
															<tr class="total" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
																<td colspan="4" align="right" >Total Tagihan :</td>
																<td align="right">Rp<?php echo number_format($f_total,0,",","."); ?></td>
															</tr>
														</table>
													</td>
												</tr>
												<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
													<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;" valign="top">
														<b>Metode Pembayaran Bank Transfer</b><br>
														silahkan lakukan pembayaran ke rekening berikut :<br>

														BNI<br>
														Atas nama : uni <br>
														Nomor Rekening : 1234-56-7890-123 <br><br>

														Jika anda sudah melakukan pembayaran, harap segera melakukan konfirmasi pembayaran dengan mengupload bukti transfer ke halaman 
														<a href="<?php echo site_url('Checkout/pembayaran/'.$id);?>">Konfirmasi Pembayaran</a>.	
													</td>	
												</tr>	
											</table>
										</td>
								</tr>													
								<tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
									<td class="content-block aligncenter" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">
													&mdash; Multi E-commerce<br>
			CustomerService@gmail.com<br>
			0011223344
									</td>
								</tr>
					</table></td>
					</tr></table><div class="footer" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
					<table width="100%" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="aligncenter content-block" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;" align="center" valign="top">Questions? Email <a href="mailto:" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">coderthemes@gmail.com</a></td>
						</tr></table></div></div>
		</td>
		<td style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
	</tr></table></body>

<!-- Mirrored from coderthemes.com/minton/dark-dark/email-templates/billing.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 19 May 2018 13:48:05 GMT -->
</html>
