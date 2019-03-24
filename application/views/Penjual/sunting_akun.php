<!--Formulir registrasi-->
      <?php 
        foreach($sunting as $a)
        {
          $nama_toko    = $a->nama_toko;
          $nama_penjual = $a->nama_penjual;
          $slug = $a->slug_penjual;
          $no_telp      = $a->notelp;
          $alamat       = $a->alamat;
          $nama_bank    = $a->nm_bank;
          $logo_toko    = $a->logo_toko;
          $an_rek_bank  = $a->an_rek_bank;
          $no_rek_bank  = $a->no_rek_bank;

          $status = $a->status_akun;
          // $masa_aktif = $a->masa_aktif;
        }
      ?> 
        <div class="container mb-1 p-4 border bg-white" style="margin-top: 61px;">
          <div class="row mb-4">
            <div class="col-md-12">
                <h4 class="h4">Sunting Akun</h4><hr> 
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
              <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="h5">Logo Toko</span>
              </h4>
                <?php if($pesan = $this->session->flashdata('pesan_gambar')) : ?>
                <div id="message" class="alert <?php echo ($pesan['status']) ? 'alert-success':'alert-danger'; ?> alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Success!</strong> <?php echo $pesan['pesan']; ?>.
                </div>
              <?php endif; ?>              
              <ul class="list-group">
                <li class="list-group">
                    <img src="<?php echo base_url('assets/foto/penjual/logo/'.$logo_toko) ?>" id="preview" class="img-fluid rounded" alt="" width="100%"/><br/>
                </li>
                <li class="list-group">
                  <form action="<?php echo site_url();?>/Penjual/update_logo" method="POST" enctype="multipart/form-data" >
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="logo_toko" id="customFile">
                        <label class="custom-file-label" for="customFile">Ganti Gambar</label>
                      </div>
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Upload</button>
                      </div>                      
                    </div>
                    <small class="text-muted">File Maximal 3 MB ( Tipe JPG, JPEG, PNG )</small>  
                  </form>                 
                </li>
              </ul>              
            </div>

            <div class="col-md-8 order-md-1">              
              <form action="<?php echo site_url('/Penjual/update_akun'); ?>" method="post">
              <h3 class="h5">Profil</h3>        
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="nama_toko">Nama Toko</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-home" aria-hidden="true"></i></span>
                      </div>   
                      <input type="text" class="form-control" id="nama_toko" value="<?php echo $nama_toko; ?>" name="nama_toko" onkeyup="createslug()"> 
                      <input type="hidden" class="form-control" id="slug" name="slug" value="<?php echo $slug; ?>">
                    </div>
                    <span class="text-danger"><?php echo form_error('nama_toko');?></span>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="nama_penjual">Nama Penjual</label>                    
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                      </div>                    
                      <input type="text" class="form-control" id="nama_penjual" value="<?php echo $nama_penjual; ?>" name="nama_penjual">
                    </div>
                    <span class="text-danger"><?php echo form_error('nama_penjual');?></span>
                  </div>                  
                </div>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="notelp">Nomor Hp</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                      </div>
                      <input type="text" class="form-control" id="notelp" value="<?php echo $no_telp; ?>" name="no_telp">                       
                    </div>    
                    <span class="text-danger"><?php echo form_error('no_telp');?></span>                
                  </div>
                </div>
                <div class="mb-3">
                  <label for="address">Alamat</label>
                  <textarea class="form-control" rows="4" id="comment" name="alamat"><?php echo $alamat;?></textarea>
                  <span class="text-danger"><?php echo form_error('alamat');?></span>                 
                </div>
                <br>
                <h3 class="h5">Rekening</h3>
                <hr>
                <div class="row">
                  <div class="col-md-3 mb-3">
                    <label class="control-label" for="nm_bank">Bank</label>
                    <input type="text" class="form-control" id="nm_bank" value="<?php echo $nama_bank;?>" name="nm_bank">
                    <span class="text-danger"><?php echo form_error('nm_bank'); ?></span>
                  </div>
                  <div class="col-md-5 mb-3">
                    <label class="control-label" for="an_rek_bank">Atas Nama</label>
                    <input type="text" class="form-control" id="an_rek_bank" value="<?php echo $an_rek_bank;?>" name="an_rek_bank">
                    <span class="text-danger"><?php echo form_error('an_rek_bank'); ?></span>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="control-label" for="no_rek_bank">Nomor Rekening</label>
                    <input type="text" class="form-control" id="no_rek_bank" value="<?php echo $no_rek_bank;?>" name="no_rek_bank">
                    <span class="text-danger"><?php echo form_error('no_rek_bank'); ?></span>
                  </div>                    
                </div>          
                <hr class="mb-4">
                <div class="mb-3">
                      <div align="right">
                        <button type="submit" class="btn btn-primary" value="submit">Simpan</button>
                        <button type="reset" class="btn btn-outline-secondary" value="reset">Reset</button>
                        <button type="button" class="btn btn-danger" onclick="javascript:history.back()">Batal</button>
                      </div>
                    </div>
              </form>
            </div>
          </div>
        </div>

        <script type="text/javascript">
        function createslug()
        {
            var slug = $('#nama_toko').val();
            $('#slug').val(slugify(slug));
        }

        function slugify(text)
        {
            return text.toString().toLowerCase()
                    .replace(/\s+/g, '-')           // Replace spaces with -
                    .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                    .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                    .replace(/^-+/, '')             // Trim - from start of text
                    .replace(/-+$/, '');            // Trim - from end of text
        }             
        </script>
