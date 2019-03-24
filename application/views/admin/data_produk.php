
            <div class="col-md-12 col-sm-12 p-4">
              <div class="col bg-fluid p-3">
        
                  <div class="table-responsive-lg">
                    <table id="table" class="table table-borderless table-striped table-hover border border-secondary" cellspacing="0">
                      <thead>
                        <tr>
                          <th scope="col">ID Produk</th>
                          <th>Nama Toko</th>
                          <!-- <th>Total pesanan</th> -->
                          <th>Nama</th> 
                          <th>Berat</th> 
                          <th>Harga</th>
                          <th>Stok</th>
                          <th>Gambar</th>
                          <th>Tanggal Upload</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          foreach($produk as $p)  {
                            $id_produk    = $p->id_produk ;
                            $id_penjual   = $p->nama_toko ;
                            $nama         = $p->nama ;
                            $berat        = $p->berat ;
                            $harga        = $p->harga ;
                            $stok         = $p->stok ;
                            $gambar        = $p->gambar;
                            $tggl         = $p->tggl ;                    
                        ?>
                        <tr>
                          <td scope="row"><?php echo $id_produk;?></td>
                          <td><?php echo $id_penjual;?></td>
                          <td><?php echo $nama;?></td>
                          <td><?php echo $berat;?></td>
                          <td><?php echo $harga;?></td>
                          <td><?php echo $stok;?></td>
                          <td style="max-width: 150px"><a href="<?php echo base_url('assets/foto/penjual/produk/'.$gambar);?>"><?php echo $gambar; ?></a></td>
                          <td><?php echo $tggl;?></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>

              </div>                 
            </div>

          </div>
        </div> 

        <!-- <script src="<?php// echo base_url();?>assets/dev/js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
        <script>window.jQuery || document.write('<script src="base_url();?>assets/dev/js/jquery-slim.min.js"><\/script>')</script>
        <script src="<?php echo base_url();?>assets/dev/js/popper.min.js"></script>
        <script src="<?php echo base_url();?>assets/dev/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url('assets/dataTables2/jquery.dataTables.js'); ?>"></script>
        <script src="<?php echo base_url('assets/dataTables2/dataTables.bootstrap4.js'); ?>"></script> 
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script type="text/javascript">

          $('#table').DataTable({});
          
          feather.replace();
                    
        </script>
      </div>
    </div>
  </body>
</html>
