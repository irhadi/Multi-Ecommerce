<?php 
    foreach($alamat as $al){
      if($al->kota != 0){
        redirect(site_url().'/Checkout/pemesanan');
      }
    }
  ?>

    <div class="container mb-1" style="margin-top:67px">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Detail Pembeli</div>
              <form method="post" action="<?php echo site_url();?>/Checkout/simpan_alamat" class="needs-validation" novalidate>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="nama">Nama Lengkap</label>
                      <input type="text" class="form-control" id="nama" name="nama"/>
                      <?php echo form_error('nama'); ?>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label for="nohp">Nomor Hp</label>
                      <input type="text" class="form-control" id="notelp" name="nohp"/>
                      <?php echo form_error('nohp'); ?>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="alamat">Alamat Detail</label>
                    <textarea class="form-control" rows="5" id="comment" name="alamat"></textarea>
                    <?php echo form_error('alamat'); ?>
                  </div>

                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="country">Provinsi</label>
                      <select class="custom-select d-block w-100" id="prov">
                        <option value="#">--Pilih Provinsi--</option>
                        <?php foreach($province as $p): ?>
                          <option data-prov="<?php echo $p['province']; ?>" value="<?php echo $p['province_id']; ?>"><?php echo $p['province']; ?></option>
                        <?php endforeach;?>
                      </select>
                      <input type="hidden" id="nama_prov" name="nama_prov" value="">
                      <?php echo form_error('nama_prov'); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="state">Kota</label>
                      <select class="custom-select d-block w-100" name="kota" id="kota"></select>
                      <input type="hidden" id="nama_kota" name="nama_kota" value="">
                      <?php echo form_error('nama_kota'); ?>
                    </div>
                  </div><br>
                  <button class="btn btn-primary btn-block" type="submit">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        <div class="col-md-2"></div>
      </div>
    </div>

    <script type="text/javascript">
      $('#prov').change(function(){
          var url='<?php echo site_url();?>/Checkout/kota/'+$(this).val();
          $('#kota').load(url);
          var cntrol = $(this);            
          var finalvalue = cntrol.find(':selected').data('prov');
            $('#nama_prov').val(finalvalue);
        });

        $('#kota').change(function(){
          var cntrol = $(this);            
          var finalvalue = cntrol.find(':selected').data('kota');
            $('#nama_kota').val(finalvalue);
        });
    </script>