            <div class="container-fluid"> 
              <div class="row p-1 mt-3">  
                <div class="col text-white">
                  <div class="px-5 py-3 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3" style="background-color: #4abdac">
                    <div id="user-penjual" class="h1 text-uppercase"></div>
                    <span class="h5 text-uppercase font-weight-light">Penjual</span>
                  </div>
                 
                </div>      
                <div class="col text-white">
                  <div class="px-5 py-3 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3" style="background-color: #f44336;">
                    <div id="user-pembeli" class="h1"></div>
                    <span class="h5 text-uppercase font-weight-light">Pembeli</span>
                  </div>                
                </div>      
                <div class="col text-white">
                  <div class="px-5 py-3 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3" style="background-color: #f8b633">
                    <div id="produk" class="h1"></div>
                    <span class="h5 text-uppercase font-weight-light">Produk</span>
                  </div>                  
                </div>      
                <div class="col text-white">
                  <div class="px-5 py-3 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3" style="background-color: #08899e">
                    <div id="transaksi" class="h1"></div>
                    <span class="h5 text-uppercase font-weight-light">Transaksi</span>
                  </div>
                </div>
                <div class="col-md-12 col-sm-12">
                  <div class="col px-0 text-center">
                    <div id="grafik"></div> 
                  </div>                 
                </div>
              </div>


            </div> 
          </div>
        </div>
        <script>window.jQuery || document.write('<script src="base_url();?>assets/dev/js/jquery-slim.min.js"><\/script>')</script>
        <script src="<?php echo base_url();?>assets/dev/js/popper.min.js"></script>
        <script src="<?php echo base_url();?>assets/dev/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>         
        <script src="<?php echo base_url('assets/dev/js/animationCounter.js'); ?>"></script>
        <script type="text/javascript">
          $('#user-penjual').animationCounter({
              start: 0,
              step: 1,
              delay:100,
              end:"<?php echo $total_penjual; ?>"
          
            });      
          $('#user-pembeli').animationCounter({
              start: 0,
              step: 1,
              delay:100,
              end:"<?php echo $total_pembeli; ?>"
            });      
          $('#produk').animationCounter({
              start: 0,
              step: 1,
              delay:100,
              end:"<?php echo $total_produk; ?>"
            });      
          $('#transaksi').animationCounter({
              start: 0,
              step: 1,
              delay:100,
              end:"<?php echo $totaltransaksi->num_rows(); ?>"
          }); 
        </script>         

        <!-- <script src="<?php //echo base_url();?>assets/dev/js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->

        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/series-label.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
                           
        <script type="text/javascript">
      
          feather.replace();


          var chart = Highcharts.chart('grafik', {
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
                name: 'Total Transaksi',
                data: [<?php foreach($totaltransaksi->result() as $t): echo $t->jml.", "; endforeach; ?>]
            }, {
                name: 'Total Biaya Admin',
                data: [<?php foreach($keuntungan as $t): echo $t->fee.", "; endforeach; ?>]
            }],

    // series: [{
    //     name: 'Installation',
    //     data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
    // }, {
    //     name: 'Manufacturing',
    //     data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
    // }, {
    //     name: 'Sales & Distribution',
    //     data: [11744, 17722, 16005, 19771, 20185, 24377, 32147, 39387]
    // }, {
    //     name: 'Project Development',
    //     data: [null, null, 7988, 12169, 15112, 22452, 34400, 34227]
    // }, {
    //     name: 'Other',
    //     data: [12908, 5948, 8105, 11248, 8989, 11816, 18274, 18111]
    // }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
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
      </div>
    </div>
  </body>
</html>
