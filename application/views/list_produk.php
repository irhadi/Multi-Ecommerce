
  <!-- jumbotron -->
  <div class="jumbotron mb-3 jumbotron-fluid text-white" style="margin-top: 56px;background-color: #ff751a">
    <div class="container text-center">

            <div class="h2"><?php echo $title1[0]; ?>&nbsp;&nbsp;<span class="small" style="cursor:pointer" id="info_penjual"><i class="fa fa-info-circle"></i></span></div>
               
            <p class=""><i class="fa fa-dropbox" aria-hidden="true"></i> Produk : <?php echo $totpro; ?></p>
    </div>
  </div>

  <div class="modalinfo"><div class="info"></div></div>

  <div class="modal fade" id="modalDetail">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="detail_produk"></div>
      </div>
    </div>
  </div>
  <div class="py-3">
    <div class="container">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h4 head-list">Daftar Produk</h1>
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fa fa-search"></i></span>
            </div>
            <input type="text" class="form-control" id="searchproduk" name="searchproduk" placeholder="Cari produk">
          </div>
        </div>     
      </div>
      <div id="produk"></div>
    </div>
  </div>


  <script type="text/javascript">
    <?php $uri_s = $this->uri->segment(3); ?>

    tampil_produk();

    function tampil_produk(query){
      var slug = '<?php echo $uri_s; ?>';
      $.ajax({
        url : '<?php echo site_url();?>/Web/get_list_produk/',
        method : 'POST',
        data :{slug:slug, query:query},
        success:function(data){
          $('#produk').html(data);
        }
      });
    }
    $('#searchproduk').keyup(function(){
      var cari = $(this).val();
      if(cari != '')
      {
        tampil_produk(cari);
      }
      else
      {
        tampil_produk();
      }
    });

    $(document).on('click', '.add', function(){
      var idtoko = $(this).data('idtoko');
      var toko = '<?php echo $this->session->userdata('toko'); ?>';
      var produk_id = $(this).data('id');
      var produk_nama = $(this).data('name');
      var produk_harga = $(this).data('price');
      var produk_gambar = $(this).data('pic');
      var produk_berat = $(this).data('berat');
      var produk_stok = $(this).data('stok');
      var quantity = $('#' + produk_id).val();
      
      function save(){
        $.ajax({
          url: '<?php echo site_url();?>/Keranjang/tambah',
          type: 'POST',
          dataType:'json',
          data: {id_toko: idtoko, toko: toko, id: produk_id, name: produk_nama, price: produk_harga, 
              pic: produk_gambar, qty: quantity,
              berat: produk_berat, stok: produk_stok},
          success: function(data){ 
            $('#notifkeranjang').html(data.notif);
            if(data.status == 'success'){
              toast({type: 'success',title: data.pesan})
            }else if(data.status == 'error'){
              toast({type: 'error', title: data.pesan})
            }               
          }
        });    
      }
      if(toko == '')
      {
        save();
      }
      else if(toko !== '' && idtoko !== toko)
      {
        swal({
          title: 'Anda ingin mengganti toko?',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya'
        }).then((result) => {
          if (result.value) {
            save();
          }
        })           
      }
      else
      {
        save();
      }   
    });

    $(document).on('click','#info_penjual', function(){
      var slug = '<?php echo $uri_s; ?>';
      $('.info').load('<?php echo site_url(); ?>/Web/info_penjual/'+slug);
      $('.modalinfo').fadeToggle(); 
    });        

    $(document).on('click','.copy', function(){
        var copyText = document.getElementById('kontak');
        var input = document.createElement('input');
        input.value = copyText.textContent;
        document.body.appendChild(input);
        input.select();
        document.execCommand('Copy');
        $('.modalinfo').hide();
        Swal('Kontak di copy', input.value, 'success');
        input.remove();
    });

    $(document).on('click','.detail', function(){
       var id = $(this).data('id');
       $('.detail_produk').load('<?php echo site_url(); ?>/Web/detail_produk/'+id);
       $('#modalDetail').modal(); 
    });
  </script>