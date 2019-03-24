<div class="container mb-1" style="margin-top:80px;">
  <h3 class="Text-center">Cara Mendaftar Sebagai Penjual</h3>

  <div id="accordion">
    <div class="card">
      <div class="card-header">
        <a class="card-link" data-toggle="collapse" href="#collapseOne">
          Langkah 1
        </a>
      </div>
      <div id="collapseOne" class="collapse show" data-parent="#accordion">
        <div class="card-body">
          <div class="p-3">
            <h4 class="border-bottom border-gray pb-2 mb-0">Mengirim pesan kepada admin melalui :</h4>
            <div class="lead pt-3">
              <img src="<?php echo base_url('assets/img/icon/whatsapp.png'); ?>" alt="" width="32px" class="mr-2">
              082343545170
            </div>
            <div class="lead pt-3">
              <img src="<?php echo base_url('assets/img/icon/gmail.png'); ?>" alt="" width="32px" class="mr-2">
              Irhadi425@gmail.com
            </div>
            <h4 class="border-top border-gray pt-3 mt-3 mb-0"></h4>
            <dl>
              <dt>Melampirkan :</dt>
              <dd>- Foto KTP</dd>
              <dd>- Email (Email yang akan digunakan mendaftar)</dd>
            </dl>                 
          </div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
        Langkah 2
      </a>
      </div>
      <div id="collapseTwo" class="collapse" data-parent="#accordion">
        <div class="card-body">          
          <div class="p-3">
            <h4 class="border-bottom border-gray pb-2 mb-0">Menyelesaikan Registrasi :</h4>
            <div class="col-md-8 col-sm-12 col-lg-5 pb-2">
              <div class="pt-3">
                <div class="cek_msg" style="display: none;"><div class="alert alert-danger cek"></div></div>  
                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                    </div>
                    <input type="email" class="form-control" placeholder="Masukkan Email yang didaftarkan" name="cek_email" id="cek_email" required>
                    <div class="input-group-append"><button id="cek" class="btn btn-primary"><i class="loading"></i> Daftar</button></div>
                  </div>                            
              </div>              
            </div>
            <dl>
              <dt>Note :</dt>
              <dd>- Langkah ke 2 apabila telah disetujui dan didaftarkan oleh admin   </dd>
            </dl>                             
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>

<script type="text/javascript">
        $("#cek").click(function(){  
          var cek_email = $("#cek_email").val();
          if(cek_email == ''){
            $("div.cek_msg").show();  
            $("div.cek").html("Email tidak boleh kosong");
          }else{
            $.ajax({  
            type: "POST",  
            url:  "<?php echo site_url(); ?>" + "validasi-email",  
            data: {cek_email: cek_email},  
            cache: false,
              beforeSend:function(){
                $('.loading').addClass('fa fa-spinner fa-spin');
              },
              success: function(result){  
                  if(result!=0){    
                    window.location.replace(result);
                  }else{
                    $("div.cek_msg").show();  
                    $("div.cek").html("Email tidak ditemukan");
                  }
              },
              complete:function(){
                $('.loading').removeClass('fa fa-spinner fa-spin');
              }
            });
          }                  
          return false;
        });          
</script>