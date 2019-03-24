            <div class="col-md-12 col-sm-12 p-4">
              <div class="col bg-fluid p-3">    
                
<!--                 <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Success!</strong>adaw.
                </div> -->
                
                <div class="table-responsive">
                  <table id="table" class="table table-borderless table-striped table-hover border border-secondary" cellspacing="0">
                    <thead>
                      <tr>
                        <th scope="col">ID Pembeli</th>
                        <th>Nama</th>
                        <th>Nomor Telepon</th> 
                        <!-- <th>Alamat</th>  -->
                        <th>Email</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        foreach($pembeli as $p)  {
                          $id_pembeli = $p->id_pembeli ;
                          $nama       = $p->nama ;
                          $no_telp    = $p->notelp ;
                          $alamat     = $p->alamat ;
                          $email      = $p->email;
                      ?>
                      <tr>
                        <th><?php echo $id_pembeli; ?></th>
                        <td><?php echo $nama; ?></td>
                        <td><?php echo $no_telp; ?></td>
                        <!-- <td><?php //echo $alamat; ?></td> -->
                        <td><?php echo $email; ?></td>
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
