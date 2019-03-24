<?php 

foreach ($penjual as $p) {
	$nama_penjual = $p->nama_penjual;
	$status = $p->status_akun;
}
?>



	<div class="container mb-1 bg-white" style="margin-top: 60px;">
		<div class="row text-center">
			<div class="col-md-6 col-sm-6 bg-white py-3 border">
				<div class="row">
					<div class="col-md-6 text-left"><h1 class="h5 font-weight-light">Produk</h1></div>
					<div class="col-md-6">
						<table width="100%" border="0">
							<tr class="text-success">
								<td align="right" width="80%">Total Produk</td>
								<td align="center" width="10%">:</td>
								<td align="left" width="10%"><?php echo $total_produk;?></td>
							</tr>								
							<tr class="text-success">
								<td align="right">Total Stok</td>
								<td align="center">:</td>
								<td align="left" ><?php foreach($total_stok->result() as $tp){ echo $tp->totproduk;}?></td>
							</tr>					
							<tr class="text-warning">
								<td align="right">Terjual (Stok)</td>
								<td align="center">:</td>
								<td align="left"><?php echo $produk_terjual; ?></td>
							</tr>					
						</table>						
					</div>
				</div>
				
			</div>					
			<div class="col-md-6 col-sm-6 bg-white py-3 border">
				<div class="row">
					<div class="col-md-6 text-left"><h1 class="h5 font-weight-light">Order</h1>	</div>
					<div class="col-md-6">
						<table width="100%" border="0">
							<tr class="text-success">
								<td align="right" width="80%">Selesai</td>
								<td align="center" width="10%">:</td>
								<td align="left" width="10%"><?php echo $transaksi_selesai->num_rows();?></td>
							</tr>					
							<tr class="text-warning">
								<td align="right">Dalam Proses</td>
								<td align="center">:</td>
								<td align="left"><?php echo $transaksi_dikirim->num_rows(); ?></td>
							</tr>					
							<tr class="text-danger">
								<td align="right">Batal</td>
								<td align="center">:</td>
								<td align="left"><?php echo $transaksi_batal->num_rows(); ?></td>
							</tr>
						</table>						
					</div>
				</div>
			</div>									
		</div>
		<div class="row">
			<div class="col bg-white p-3 text-center border">			
				<div id="grafik"></div>
			</div>	
		</div>
	</div>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script> 
	<script type="text/javascript">
		var chart  = Highcharts.chart('grafik', {
          title: {
              text: 'Grafik Perbulan'
          },
          xAxis: { categories: [ <?php foreach($bulan as $b): echo "'".$b->bulan."', ";  endforeach; ?> ] },
          yAxis: {
              title: {
                  text: 'Rupiah (Rp)'
              }
          },
          legend: {
              layout: 'vertical',
              align: 'right',
              verticalAlign: 'middle'
          },
          series: [{
              name: 'Transaksi',
              data: [<?php foreach($total as $t): echo $t->jml.", "; endforeach; ?>]
          }],
          responsive: {
              rules: [{
                  condition: {
                      maxWidth: 600
                  },
                  chartOptions: {
                      legend: {
                          layout: 'horizontal',
                          align: 'center',
                          verticalAlign: 'bottom'
                      }
                  }
              }]
          }
      	});         
	</script>	