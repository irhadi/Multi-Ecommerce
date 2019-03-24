            <div class="col-md-12 col-sm-12 p-4">
              
              <?php if(!empty($penjual_baru)) { ?>
              <div class="col p-3 bg-fluid mb-3 border border-success">                                              
                <h1 class="h4">Pendaftar Baru <span class="badge badge-danger badge-pill"><?php echo count($penjual_baru); ?> </span></h1><br>
                <div class="table-responsive-lg">
                  <table id="table1" class="table table-borderless table-striped table-hover border border-secondary" cellspacing="0">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Nama Toko</th>
                        <!-- <th>Total pesanan</th> -->
                        <th>Nama Penjual</th> 
                        <th>No.Hp</th> 
                        <th>Email</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $no = 1;
                        foreach($penjual_baru as $n){
                          $n_id_penjual   = $n->id_penjual;
                          $n_nama_toko    = $n->nama_toko;
                          $n_nama_penjual = $n->nama_penjual;
                          $n_notelp       = $n->notelp;
                          $n_email        = $n->email;
                      ?>
                        <tr>
                          <td><?php echo $no++; ?></td>
                          <td><?php echo $n_nama_toko;?></td>
                          <td><?php echo $n_nama_penjual;?></td>
                          <td><?php echo $n_notelp;?></td>
                          <td><?php echo $n_email;?></td>
                          
                          <td><a href="<?php echo site_url('/Admin/tampil_penjual_baru/'.$n_id_penjual);?>" class="btn btn-info btn-sm"><span data-feather="eye"></span> Tampilkan</a></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div> 
              </div>
              <?php } ?>
              <div class="col bg-fluid p-3">
                <!--Tampil Data Penjual lama-->
                <div class="table-responsive-lg">
                  <table id="table2" class="table table-borderless table-striped table-hover border border-secondary" cellspacing="0">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th>Nama Toko</th>
                        <th>Nama Penjual</th> 
                        <th>No.Hp</th> 
                        <th>Email</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th></th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach($penjual_lama as $p)  {
                          $id_penjual   = $p->id_penjual ;
                          $nama_toko    = $p->nama_toko ;
                          $nama_penjual = $p->nama_penjual ;
                          $notelp       = $p->notelp ;
                          $email        = $p->email ;
                          $status       = $p->status_akun  ;
                          $login   = $p->last_login ;
                      ?>
                      <tr>
                        <th scope="row"><?php echo $id_penjual; ?></th>
                        <td><?php echo $nama_toko;?></td>
                        <td><?php echo $nama_penjual;?></td>
                        <td><?php echo $notelp;?></td>
                        <td><?php echo $email;?></td>
                        <td>
                          <?php 
                            if($status == 'aktif') {
                              echo '<span data-feather="eye" class="text-success"></span> Tampil';
                            }else if($status == 'bolehkan'){
                              echo '<span data-feather="thumbs-up" class="text-primary"></span> Di Bolehkan';                  
                            }else if($status == 'blokir'){
                              echo '<span data-feather="slash" class="text-danger"></span> Di Blokir';   
                            }
                          ?>
                        </td>  
                        <td><?php echo $login;?></td>               
                        <td>
                          <?php
                            if($status == 'aktif') {
                              echo '<a href="'.site_url('/Admin/blokir/'.$id_penjual).'" class="btn btn-danger btn-sm" role="button"> <span data-feather="user-x"></span> Blokir'.'</a>&nbsp;';
                            }else if($status == 'bolehkan'){
                              echo '<a href="'.site_url('/Admin/hapus/'.$id_penjual).'" class="btn btn-danger btn-sm" role="button"> <span data-feather="trash-2"></span> Hapus</a>';
                            }else if($status == 'blokir'){
                              echo '<a href="'.site_url('/Admin/buka_blokir/'.$id_penjual).'" class="btn btn-success btn-sm" role="button"> <span data-feather="user-check"></span> Buka Blokir'.'</a>&nbsp;';
                            }

                            // if($status == 'aktif' && $masa_aktif <= $tggl_sekarang)
                            // {
                            //   echo '<a href="'.site_url('/Admin/perpanjang/'.$id_penjual).'" class="btn btn-info btn-sm" role="button"> <span data-feather="plus-circle"></span> Perpanjang'.'</a>';
                            // }
                          ?>
                        </td>
                        
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="<?php echo base_url('assets/dataTables2/jquery.dataTables.js'); ?>"></script>
        <script src="<?php echo base_url('assets/dataTables2/dataTables.bootstrap4.js'); ?>"></script> 
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script type="text/javascript">

          $('#table1').DataTable({});
          $('#table2').DataTable({});
          
          feather.replace();
                          
        </script>
      </div>
    </div>
  </body>
</html>
