            <div class="col-md-12 col-sm-12 p-4">
              <div class="col bg-fluid p-3">

                              
                <div class="table-responsive-sm">
                  <table id="table" class="table table-borderless table-striped table-hover border border-secondary" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Dari</th> 
                        <th>Pesan</th>
                        <th>Tanggal Waktu</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        foreach($lapor as $p)  {
                          $id    = $p->id_laporkan ;
                          $id_penjual    = $p->id_penjual ;
                          $id_pembeli    = $p->nama  ;
                          $id_konfirmasi = $p->id_konfirmasi ;
                          $isi_laporan   = substr($p->isi_laporan, 0, 40). '...';
                          $tgglwaktu     = $p->tgglwaktu;
                      ?>
                      <tr>
                        <td><?php echo $id_pembeli; ?></td>
                        <td><?php echo $isi_laporan; ?></td>
                        <td><?php echo $tgglwaktu; ?></td>
                        <td><a href="<?php echo base_url('admin/detail_laporan/'.$id); ?>" class="btn btn-info btn-sm"><i class="fa fa-envelope-open-o" aria-hidden="true"></i> Buka</a></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
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

          $('#table').DataTable({});
          
          feather.replace();
                    
        </script>
      </div>
    </div>
  </body>
</html>                   