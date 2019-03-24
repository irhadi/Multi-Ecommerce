   <?php
     $id_kota = 0;
     $unik = rand(10,999);
     foreach($alamat as $k){
        $id_kota = $k->kota;
      }
   ?>

   <div class="py-3">
    <div class="container" style="margin-top:57px">   
    <form method="post" action="<?php echo site_url();?>/Checkout/simpan_order">


      <div class="row">        

          <div class="col-md-4 order-md-2 p-2">
            
            <h4 class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-muted">Keranjang</span>
              <span class="badge badge-secondary badge-pill"><?php echo count($this->cart->contents()); ?></span>
            </h4>
            <ul class="list-group mb-3">
              <?php 
                $cart=$this->cart->contents();
                $grand_total=0;
                foreach($cart as $item):
                $grand_total = $grand_total+($item['berat']*$item['qty']);
              ?>   
                <input type="hidden" name="cart[<?php echo $item['id'];?>][rowid]" value="<?php echo $item['rowid']; ?>"/>
                <input type="hidden" name="cart[<?php echo $item['id'];?>][price]" value="<?php echo $item['price']; ?>"/>
                <input type="hidden" name="cart[<?php echo $item['id'];?>][berat]" value="<?php echo $item['berat']; ?>"/>
                <input type="hidden" name="cart[<?php echo $item['id'];?>][qty]"   value="<?php echo $item['qty']; ?>"/>     
                <input type="hidden" name="cart[<?php echo $item['id'];?>][id]"    value="<?php echo $item['id']; ?>"/>
                <input type="hidden" name="cart[<?php echo $item['id'];?>][name]"    value="<?php echo $item['name']; ?>"/>
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div class="text-center">
                  <img src="<?php echo base_url('assets/foto/penjual/produk/'.$item['pic'])?>" class="rounded float-left"width="80">
                  <h6 class="my-0 font-weight-bold"><?php echo $item['name']; ?></h6>
                  <!-- <small class="text-muted">Brief description</small> -->
                </div>
                <span class="text-muted text-right">
                  Qty <?php echo $item['qty']; ?> <br>
                  <?php echo number_format($item['berat'],0,",",".");?> gram<br>
                  Rp<?php echo number_format($item['price'],0,",",".");?>
                </span>
              </li>
              <?php endforeach;?>
            </ul>          

            <ul class="list-group mb-3">
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <h6 class="my-0">Total Berat</h6>
                </div>
                <span class="text-muted text-right"><?php echo $grand_total; ?> gram</span>
              </li>
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <h6 class="my-0">SubTotal Harga</h6>
                </div>
                <span class="text-muted text-right">Rp<?php echo $total_harga = $this->cart->total(); ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <h6 class="my-0">Ongkos Kirim</h6>
                </div>
                <span class="text-muted text-right"><div id="ongkir"></div></span>
              </li>
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <h6 class="my-0">Total Harga</h6>
                </div>
                <span class="text-muted text-right"><div id="total"></div></span>
              </li>
            </ul>

          </div>

        <div class="col-md-8">

          <div class="card p-3" id="step1" >
            <div class="d-flex justify-content-between align-items-center">
              <h4 class="my-0 font-weight-normal">Detail Pembeli</h4>
              <span class=""><a href="<?php echo site_url();?>/Checkout/edit_alamat" role="button"><i class="fa fa-edit"></i> Edit</a></span>
            </div> <hr>
            <div class="table-responsive">
              <table class="table table-borderless">
                <?php 
                foreach($alamat as $a){
                ?>
                <tr>
                  <td>Nama</td>
                  <td>:</td>
                  <td><?php echo $a->nama; ?></td>
                </tr>
                <tr>
                  <td>Nomor Telepon</td>
                  <td>:</td>
                  <td><?php echo $a->notelp; ?></td>
                </tr>
                <tr>
                  <td>Alamat lengkap</td>
                  <td>:</td>
                  <td><?php echo $a->alamat; ?></td>
                </tr>
                <?php
                }
                ?>
              </table>
            </div>
              <p class="mt-2">
                <a href="#" role="button" class="btn btn-primary float-right" id="next_step2"> Jasa Pengiriman <i class=" fa fa-chevron-circle-right"></i></a>
              </p>
          </div>          

          <div class="card p-3" id="step2" style="display: none;">
            <h4 class="my-0 font-weight-normal d-flex justify-content-between align-items-center">
              Jasa Pengiriman
            </h4> <hr>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">  
                  <select class="custom-select" id="kurir">
                    <option value="">Pilih Kurir</option>
                    <option value="jne">JNE</option>
                    <option value="tiki">TIKI</option>
                    <option value="pos">POS Indonesia</option>
                  </select>
                </div>                  
              </div>
              <div class="col-md-8">
                <div class="form-group"> 
                  <select class="custom-select" id="layanan" disabled>
                    <option value="">Pilih Layanan</option>
                  </select>
                </div>                
              </div>
            </div> 

            <div class="mt-3">
                <a href="#" id="back_step1" class="btn btn-outline-secondary float-left"><i class="fa fa-chevron-circle-left"></i> Alamat</a>
                <a href="#" role="button" class="btn btn-primary float-right disabled" id="next_step3">Metode Pembayaran <i class=" fa fa-chevron-circle-right"></i></a>              
            </div>
          </div>


          <div class="card p-3" id="step3"  style="display: none;" >
            <h4 class="my-0 font-weight-normal">
              Metode Pembayaran
            </h4> <hr>
              <ul class="list-group mb-3">
                <?php
                  foreach ($rekening as $p) {
                    echo "
                      <li class='list-group-item d-flex justify-content-between lh-condensed'>
                          <div class='custom-control custom-radio'>
                            
                              <input type='radio' class='custom-control-input' id='customRadio".$p->id_rekening."' name='rekening' value=".$p->id_rekening.">
                              <label class='custom-control-label' for='customRadio".$p->id_rekening."'><img src='".base_url()."assets/img/icon/".$p->logo_bank."' class='mx-2' height='25'>
                              Transfer ke rekening ".$p->nm_bank."
                            </label>
                          </div>                                                                            
                      </li>
                    ";
                  }
                ?>                
              </ul>
              <p class="mt-3">
                <a href="#" id="back_step2" class="btn btn-outline-secondary float-left"><i class="fa fa-chevron-circle-left"></i> Jasa Pengiriman</a>
                  <input type="hidden" name="unik" value="<?php echo $unik; ?>"/>
                  <input type="hidden" id="f_kurir" name="kurir"/>
                  <input type="hidden" id="f_layanan" name="layanan"/>
                  <input type="hidden" id="f_ongkir" name="ongkir"/>
                  <input type="hidden" id="f_total" name="total"/>
                  <input type="hidden" id="f_id_rekening" name="id_rekening"/>
                  <?php if($cek_order === 1){ ?>
                    <a href="#"
                        id="order_blok" 
                        class="btn btn-primary float-right disabled"
                        title="Pemesanan diblok"
                        data-toggle="popover" 
                        data-placement="top" 
                        data-content="Mohon maaf anda tidak dapat melakukan pemesanan lagi karena ada pemesanan yang belum anda bayar"
                    >
                        Konfirmasi Pembayaran <i class="fa fa-chevron-circle-right"></i>
                    </a>
                  <?php }else{ ?>
                    <button id="order" class="btn btn-primary float-right" type="submit" disabled>Konfirmasi Pembayaran <i class="fa fa-chevron-circle-right"></i></button>
                  <?php } ?>                
              </p>
          </div>                            
        </div>       
    </div>
    </form>
</div>
</div>
<script type="text/javascript">

$('[type="radio"]').on('click', function(){
  var radios = document.getElementsByName('rekening');

  for (var i = 0, length = radios.length; i < length; i++)
  {
   if (radios[i].checked)
   {

    $('#f_id_rekening').val(radios[i].value);
    $('#order').prop('disabled', false); 
    $('#order_blok').removeClass('disabled');
   }   
  }
})



  $("#next_step2").click(function(){
      $('#step1').hide(0, function() {
        $('#step2').show(0);
      })
  });    

  $("#next_step3").click(function(){
      $('#step2').hide(0, function() {
        $('#step3').show(0);
      })
  });  

  $("#back_step1").click(function(){
      $('#step2').hide(0, function() {
        $('#step1').show(0);
      });
  });

  $("#back_step2").click(0, function(){
      $('#step3').hide(function() {
        $('#step2').show(0);
      });
  });

  $('[data-toggle="popover"]').popover();

 
  var kurir;
  $("#kurir").on("change", function(e){
    e.preventDefault();
    kurir = $('option:selected', this).val();
    var berat = '<?php 
                  $grand_total=0;
                  foreach($this->cart->contents() as $item){
                    $grand_total = $grand_total+($item['berat']*$item['qty']);
                  }
                  echo $grand_total; 
                 ?>';
    var tujuan = '<?php 
                    echo $id_kota; 
                 ?>';
    if(kurir==='')
    {    
        swal('','Pilih salah satu kurir yang tersedia','error');
        $("#kurir").focus();
        $("#next_step3").addClass('disabled'); 
        $("#layanan").html('<option value="">Pilih Layanan</option>');
        $("#layanan").prop("disabled", true);
        $('#ongkir').html('');
        $('#total').html('');

    }else{
      get_layanan(tujuan, berat, kurir);          
      $("#layanan").focus();
    }

  });  

  $("#layanan").on("change", function(e){
    e.preventDefault();
    var layanan = $('option:selected', this).val();
    // var ongkir = '';
    if(layanan == ''){
        swal('','Pilih salah satu layanan yang tersedia','error');
        $("#layanan").focus();
        $('#ongkir').html('');
        $('#total').html('');
        $("#next_step3").addClass('disabled');   
    }else{
      var convert = layanan.split("-");  
      $('#ongkir').html('Rp'+convert[0]);
      var total = '<?php echo $this->cart->total(); ?>';
      var tot_bayar = parseInt(total)+parseInt(convert[0]);
      $('#total').html('Rp'+tot_bayar);
      $('#f_ongkir').val(layanan);
      $('#f_kurir').val(kurir);
      $('#f_layanan').val(convert[1]);
      $('#f_total').val(total);
      $("#next_step3").removeClass('disabled'); 
    }

  });

  function get_layanan(tujuan, berat, kurir)
  {
    var $op= $("#layanan");

    var i, j, x, z = "";

    $.getJSON("/Skripsi/index.php/Checkout/tarif_layanan/"+tujuan+"/"+berat+"/"+kurir, function(data){     
      $.each(data, function(i,field){  
        x += "<option value=''>Pilih Layanan</option>";
        for(i in field.costs)
        {
            // z +=  field.costs[i].service + ": "+field.costs[i].description;
            z +=  field.costs[i].service;
            for (j in field.costs[i].cost) {
                 x += "<option value='"+field.costs[i].cost[j].value+'-'+z+"'>Layanan : "+z+" , Tarif : "+field.costs[i].cost[j].value +", Estimasi : "+field.costs[i].cost[j].etd+" Hari</option>";
            }
          // "+field.costs[i].cost[j].note+"
        }
        $op.html(x);  
        $("#layanan").prop("disabled", false);
      });
    });
  }
</script>

