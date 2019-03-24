<div class="container mb-3" style="margin-top:75px">

  <div class="row">
    
    <?php if(!empty($pesan)){ ?>

      <div class="p-5 col bg-white border text-center">
        <p class=""><?php echo $pesan; ?></p>
      </div> 

    <?php }else{ ?>

      <div class="col-md-3"></div>

      <div class="col-md-6 col-sm-12">
        <div class="card">
          <div class="card-header text-center">
            <h4 class="h5 my-0 text-center font-weight-normal">Daftar Penjual</h4>
          </div>
          <div class="card-body">
            <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo site_url();?>/Registrasi/submit_penjual">
              <div class="row mb-3">
                <div class="col-md-12">
                  <input type="text" class="form-control" placeholder="Nama Toko" id="nama_toko" name="nama_toko" onkeyup="createslug()">
                  <?php echo form_error('nama_toko'); ?>
                </div>              
              </div>                    
              <input type="hidden" class="form-control" id="slug" name="slug">
              <div class="row mb-3">
                <div class="col-md-12">
                  <input type="text" class="form-control" placeholder="Nama Penjual" name="nama_penjual">
                  <?php echo form_error('nama_penjual'); ?>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-12">
                  <input type="text" class="form-control" placeholder="Nomor Telepon" name="no_telp">
                  <?php echo form_error('no_telp'); ?>
                </div>
              </div>
              <div class="row mb-3 mt-0">
                <div class="col-md-12">
                  <div class="text-center">
                    <img src="#" id="preview" class="img-fluid rounded" alt="" width="50%">
                  </div>
                  <div class="custom-file">                                                                
                    <label class="custom-file-label" for="gambar">Foto KTP</label>
                    <input type="file" class="custom-file-input" id="gambar" name="foto_ktp">
                  </div>
                  <small class="text-muted text-left">Maksimal ukuran foto 3MB, type jpg atau jpeg</small>
                </div>  
              </div>
              <div class="row mb-3">
                <div class="col-md-12">   
                  <input type="email" class="form-control" id="akun" placeholder="Masukkan Email" name="email">
                  <?php echo form_error('email'); ?>         
                </div>
              </div>
               <div class="row mb-3">
                <div class="col-md-12">                   
                  <input type="password" class="form-control" id="password" placeholder="Masukkan Password" name="password">
                  <?php echo form_error('password'); ?>
                </div>
              </div>  
              <div class="row mb-3">
                <div class="col-md-12">
                  <input type="password" class="form-control" id="repassword" placeholder="Masukkan ulang password" name="repassword">
                  <?php echo form_error('repassword'); ?>
                </div>
              </div>
                <hr>
                <button type="submit" class="btn btn-block btn-success">Daftar</button>            
            </form>
          </div>
        </div>                
      </div>  

      <div class="col-md-3"></div>

    <?php } ?> 

  </div>
  
</div>

<script type="text/javascript">
  function bacaGambar(input) {
  if(input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#preview').show();
          $('#preview').addClass('mb-3');
          $('#preview').attr('src', e.target.result);
        }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $('#preview').hide();
  $('#gambar').change(function(){
    bacaGambar(this);
  });

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