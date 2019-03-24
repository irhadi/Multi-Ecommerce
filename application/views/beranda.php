    <div id="demo" class="carousel slide" data-ride="carousel" style="margin-top: 56px;">
      <ul class="carousel-indicators">
        <li data-target="#demo" data-slide-to="0" class="active"></li>
        <li data-target="#demo" data-slide-to="1"></li>
      </ul>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="<?php echo base_url('assets/img/carousel/1a.jpg'); ?>" alt="Los Angeles">
          <div class="carousel-caption text-right">
            <h3>Banyak Pilihan Toko Penjual Gerabah</h3>
            <p>yang memasarkan produk di website ini</p>
          </div>   
        </div>
        <div class="carousel-item">
          <img src="<?php echo base_url('assets/img/carousel/1b.jpg'); ?>" alt="Chicago">
          <div class="carousel-caption text-right">
            <p><h3>Terdapat Berbagai Macam Produk Gerabah</h3>
            yang ditawarkan oleh penjual</p>
          </div>   
        </div>
      </div>
      <a class="carousel-control-prev" href="#demo" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </a>
      <a class="carousel-control-next" href="#demo" data-slide="next">
        <span class="carousel-control-next-icon"></span>
      </a>
    </div>

      <div class="py-3">
        <div class="container">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h4">Daftar Toko</h1>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
                <input type="text" class="form-control" id="search" name="search" placeholder="Cari toko atau penjual">
              </div>
            </div>
          </div> 

          <div id="list_penjual"></div>
      
        </div>
      </div>

    <script type="text/javascript">
      get_penjual();
      
      function get_penjual(query){
        $.ajax({
          url : '<?php echo site_url();?>'+'/Web/get_list_penjual',
          method : 'POST',
          data :{query:query},
          success:function(data){
            $('#list_penjual').html(data);
          },
        });
      }
      $('#search').keyup(function(){
        var cari = $(this).val();
        if(cari != '')
        {
          get_penjual(cari);
        }
        else
        {
          get_penjual();
        }
      });

    </script>
