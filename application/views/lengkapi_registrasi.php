<?php
  
  foreach($penjual as $n)
  {
    $id = $n->id_penjual;
    $nm_toko = $n->nama_toko;
    $nm_penjual = $n->nama_penjual;
    $notelp = $n->notelp;
    $email = $n->email;
    $token = $n->token;
  }
?>

<!--Formulir registrasi-->
<div class="container mb-1" style="margin-top:75px">
  <div class="row">

  <div class="col-md-2"></div>

    <div class="col-md-8">

    <div class="card overlay">
      <div class="card-header">
        <h4 class="my-0 font-weight-normal">Lengkapi Data Akun</h4>
      </div>
      <div class="card-body">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo site_url('/Registrasi/update_akun/'.$token) ?>"> 
          <!-- <input type="hidden" class="readonly form-control" id="id_penjual" name="id_penjual" value="<?php //echo $id; ?>"> -->
            <div class="row">
              <div class="col mb-3">
                  <input type="hidden" value="<?php echo $id; ?>" name="id_penjual" readonly>
                  <input type="text" class="form-control" id="nama_toko" value="<?php echo $nm_toko; ?>" name="nama_toko" readonly>
                  <?php echo form_error('nama_toko'); ?>
              </div>
              <div class="col mb-3">
                    <input type="text" class="form-control" value="<?php echo $nm_penjual; ?>" name="nama_penjual" readonly>
                    <?php echo form_error('nama_penjual'); ?>
              </div> 
            </div>  
            <div class="row">
              <div class="col-md-6 mb-3">
                  <input type="text" class="form-control" value="<?php echo $notelp; ?>" name="no_telp" readonly>
                  <?php echo form_error('no_telp'); ?>
              </div>  
            </div>
            <div class="row">
              <div class="col-md-12 mb-3">
                  <textarea class="form-control" rows="5" name="alamat" placeholder="Alamat Detail ( Sesuai KTP )"></textarea>
                  <?php echo form_error('alamat'); ?>
              </div>                    
            </div>
            <div class="row">
              <div class="col-md-12 mb-3">
                <div class="text-center">
                  <img src="#" id="preview" class="" alt="" width="50%">
                </div>
                <div class="custom-file">                                                                
                  <label class="custom-file-label" for="gambar">Logo Toko</label>
                  <input type="file" class="form-control" id="gambar" name="logo_toko">
                </div>
                <small class="text-muted text-left">Format jpg, png atau jpeg dan ukuran foto maximal 3 MB </small>                  
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                  <input type="text" class="form-control" placeholder="Nama Bank" name="nm_bank">
                  <?php echo form_error('nm_bank'); ?>
              </div>
              <div class="col-md-6 mb-3">
                  <input type="text" class="form-control" placeholder="Atas Nama" name="an_rek_bank">
                  <?php echo form_error('an_rek_bank'); ?>
              </div>
            </div> 
            <div class="row">
              <div class="col-md-6 mb-3">
                  <input type="text" class="form-control" placeholder="Nomor Rekening Bank" name="no_rek_bank">
                  <?php echo form_error('no_rek_bank'); ?>
              </div>
              <div class="col-md-12">
                  <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" readonly>
                  <?php echo form_error('email'); ?>
              </div>
            </div> 
<!--             <div class="row">
              <div class="col-md-12 mb-3">        
                  <input type="password" class="form-control" id="password" name="password">
                  <?php //echo form_error('password'); ?>
              </div>
            </div> 
            <div class="row">
              <div class="col-md-12 mb-3">        
                  <input type="password" class="form-control" id="repassword" name="repassword">
                  <?php //echo form_error('repassword'); ?>
              </div>
            </div> --> 
            <hr>
            <div class="row">
              <div class=" col-md-12 mb-3 text-right">         
                  <button type="submit" class="btn btn-success btn-block">Simpan</button>
              </div>
            </div> 
        </form>
      </div>
    </div>

    </div>

  <div class="col-md-2"></div>

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
</script>