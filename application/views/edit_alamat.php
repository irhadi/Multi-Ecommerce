    <div class="container" style="margin-top:73px">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8  bg-white p-4 mb-1 border">
 
            <h4 class="h4 my-0 font-weight-normal mb-3">Edit Alamat</h4><hr>

            <?php
              foreach($alamat as $a){
            ?>
            <form method="post" action="<?php echo site_url();?>/Checkout/simpan_alamat" class="needs-validation">
              <div class="mb-3">
                <label for="nama">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $a->nama ;?>"/>
              </div>

              <div class="mb-3">
                <label for="nohp">Nomor Hp</label>
                <input type="text" class="form-control" id="notelp" name="nohp" value="<?php echo $a->notelp ;?>"/>
              </div>

              <div class="mb-3">
                <label for="alamat">Alamat Detail</label>
                <textarea class="form-control" rows="5" id="comment" name="alamat"><?php $alamat = (explode("_",$a->alamat));
                    echo $alamat[0];
                  ?></textarea>
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
                </div>
                <div class="col-md-6 mb-3">
                  <label for="state">Kota</label>
                    <select class="custom-select d-block w-100" name="kota" id="kota">

                    </select>
                    <input type="hidden" id="nama_kota" name="nama_kota" value="">

                </div>
              </div><br>
              <?php } ?>
              <button class="btn btn-success btn-block spn"  type="submit">Simpan</button>
            </form>
            </div>
        <div class="col-md-2"></div>
      </div>
    </div>


    <script type="text/javascript">

      $('#kota').prop('disabled', true);
      $('.spn').prop('disabled', true);      
      $('#prov').change(function(){
        var url='<?php echo site_url();?>/Checkout/kota/'+$(this).val();
        $('#kota').load(url);
        var cntrol = $(this);            
        var finalvalue = cntrol.find(':selected').data('prov');
        $('#nama_prov').val(finalvalue);
        $('#kota').prop('disabled', false)
      });

      $('#kota').change(function(){
        var cntrol = $(this);            
        var finalvalue = cntrol.find(':selected').data('kota');
          $('#nama_kota').val(finalvalue);
          $('.spn').prop('disabled', false);  
      });      
    </script>