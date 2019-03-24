  <div class="container mb-3" style="margin-top:75px">

    <div class="row">

        <div class="col-md-3"></div>

        <div class="col-md-6 col-sm-12">
          <div class="card">
            <div class="card-header text-center">
              <h4 class="h5 my-0">Konfirmasi Pengiriman</h4>
            </div>
            <div class="card-body">
              <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo site_url();?>/Penjual/cek_konfirmasi_pengiriman">
                <div class="row mb-3">
                  <div class="col-md-12">
                    <input type="hidden" value="<?php echo $this->uri->segment(3);?>" name="id" >
                    <input type="text" class="form-control" placeholder="Nomor Resi" name="no_resi">
                    <?php echo form_error('no_telp'); ?>
                  </div>
                </div>
                <div class="row mb-3 mt-0">
                  <div class="col-md-12">
                    <div class="text-center">
                      <img src="#" id="preview" class="img-fluid rounded" alt="" width="100%">
                    </div>
                    <div class="custom-file">                                                                
                      <label class="custom-file-label" for="gambar">Foto Bukti Pengiriman</label>
                      <input type="file" class="custom-file-input" id="gambar" name="foto_resi">
                    </div>
                    <small class="text-muted text-left">Maximal ukuran foto 3MB dan type jpg atau jpeg</small>
                  </div>  
                </div>            
                  <hr>
                <div class="float-right">
                  <button type="button" class="btn btn-danger" onclick="javascript:history.back()"><span ></span> Kembali</button>
                  <button type="submit" class="btn btn-success">Kirim <i class="fa fa-paper-plane-o"></i></button>
                </div>            
              </form>
            </div>
          </div>                
        </div>  

        <div class="col-md-3"></div>
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