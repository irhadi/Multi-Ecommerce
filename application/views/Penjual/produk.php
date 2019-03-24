
  <div class="container p-4 bg-white border mb-1" style="margin-top: 61px;">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4">Data Produk</h1>
        <div>
          <button class="btn btn-success btn-sm" onclick="add_person()"><i class="fa fa-plus"></i> Tambah Data</button>
          <button class="btn btn-outline-secondary btn-sm" onclick="reload_table()"><i class="fa fa-refresh"></i> Refresh</button>
        </div>
      </div>
      <div class="table-responsive-lg">
        <table class="table table-sm table-bordered" id="produk">
          <thead class="thead-light">
            <tr>        
              <th>Nama</th>
              <th>Harga</th>
              <th>Berat</th>
              <th>Stok</th>
              <th>Tanggal</th>
              <th style="max-width:150px;">Gambar</th>
              <th>Aksi</th>        
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>   
  </div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Form Produk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form action="#" id="form" class="form-horizontal">
                <input type="hidden" name="id"/> 
                  <div class="form-group">
                      <input name="nama" placeholder="Nama Produk" id="nama" class="form-control" type="text">
                      <span class="help-block text-danger"></span>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                          <input name="berat" placeholder="Berat Produk" id="berat" class="form-control" type="text">
                          <span class="help-block text-danger"></span>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <input name="harga" placeholder="Harga Produk" class="form-control" type="text">
                          <span class="help-block text-danger"></span>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <input name="stok" id="stok" placeholder="Stok Produk" class="form-control" type="text">
                          <span class="help-block text-danger"></span>
                      </div>    
                    </div>

                  </div>


                    
                  <div class="form-group">
                      <label for="deskripsi">Deskripsi</label>
                      <div class="errdeskripsi">
                        <div class="err_msg">
                        </div>
                      </div>
                      <textarea id="deskripsi" class="form-control" name="deskripsi"></textarea>                      
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group" id="photo-preview">
                      <label class="">Gambar</label>
                        <div>
                            (Tidak ada gambar)
                            <span class="help-block text-danger"></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label id="label-photo">Upload Gambar</label>
                        <div>
                          <input name="gambar" class="form-control-file border" type="file">
                          <span class="help-block text-danger"></span>
                        </div>  
                      </div>
                    </div>                          
                  </div>                                              
              </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<script src="<?php echo base_url('assets/dataTables2/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo base_url('assets/dataTables2/dataTables.bootstrap4.js'); ?>"></script>
<script src="<?php echo base_url().'assets/ckeditor/ckeditor.js'?>"></script>

<script type="text/javascript">
        var save_method; //for save method string
        var table;
        var base_url = '<?php echo base_url();?>';

        function CKupdate(){
          for ( instance in CKEDITOR.instances )
              CKEDITOR.instances[instance].updateElement();
        }
 

        $(document).ready(function(){
          CKEDITOR.replace('deskripsi'); 
          
          table = $('#produk').DataTable({ 
              'processing': true,
              'serverSide': true,
              'order': [],
              'ajax': {'url': '<?php echo site_url("/Penjual/produk_list")?>', 'type': 'POST' },
              'columnDefs': [ 
                { 'targets': [ -1 ], 'orderable': false, },
                { 'targets': [ -2 ], 'orderable': false, },
              ],
          });

          $('input').change(function(){
              $(this).parent().parent().removeClass('has-error');
              $(this).next().empty();
          });

          CKEDITOR.instances.deskripsi.on('change', function() {  
              if(CKEDITOR.instances.deskripsi.getData().length >  0) {
              $('div.errdeskripsi').hide();
              }
          });

          $('select').change(function(){
              $(this).parent().parent().removeClass('has-error');
              $(this).next().empty();
          });

        });
          

          function reload_table(){
              table.ajax.reload(null,false);
          } 
          function add_person()
          {   
              CKEDITOR.instances.deskripsi.setData('', function(){ 
                this.updateElement(); 
              }); 
              save_method = 'add';
              $('#form')[0].reset();
              $('.form-group').removeClass('has-error');
              $('.help-block').empty();

              $('#modal_form').modal('show');
              $('.modal-title').text('Tambah Data');
              $('#photo-preview').hide();
              $('#label-photo').text('Upload Gambar');
          }
          
          function edit_person(id)
          {
              save_method = 'update';
              $('#form')[0].reset();
              $('.form-group').removeClass('has-error');
              $('.help-block').empty();

              //Ajax mengambil data
              $.ajax({
                  url : "<?php echo site_url('/Penjual/produk_edit/')?>" + id,
                  type: "GET",
                  dataType: "JSON",
                  success: function(data)
                  {
                      $('[name="id"]').val(id);
                      $('[name="nama"]').val(data.nama);
                      $('[name="harga"]').val(data.harga);
                      $('[name="berat"]').val(data.berat);
                      $('[name="stok"]').val(data.stok);
                      $('[name="deskripsi"]').val(CKEDITOR.instances.deskripsi.setData(data.deskripsi));
                      CKupdate();
                      $('#modal_form').modal('show');
                      $('.modal-title').text('Edit Data');

                      $('#photo-preview').show();
                      
                      if(data.gambar){
                          $('#label-photo').text('Ganti Gambar');
                          $('#photo-preview div').html('<img src="'+base_url+'assets/foto/penjual/produk/'+data.gambar+'" style="width:100%;">');
                          $('#photo-preview div').append('<br><input type="checkbox" name="remove_photo" value="'+data.gambar+'"/> Hapus gambar ketika disimpan');

                      }
                      else
                      {
                          $('#label-photo').text('Upload Photo'); // label photo upload
                          $('#photo-preview div').text('(No photo)');
                      }
                  },
                  error: function (jqXHR, textStatus, errorThrown){
                      alert('Error mengambil data');
                  }
              });
          }
          function save()
          {
              CKupdate()
              $('#btnSave').text('saving...');
              $('#btnSave').attr('disabled',true);
              var url;

              if(save_method == 'add') {
                  url = "<?php echo site_url('/Penjual/produk_add')?>";
              } else {
                  url = "<?php echo site_url('/Penjual/produk_update')?>";
              }

              // ajax simpan data produk ke database
              var formDa = new FormData($('#form')[0]);
              $.ajax({
                  url : url,
                  type: "POST",
                  data: formDa,
                  contentType: false,
                  processData: false,
                  dataType: "JSON",
                  success: function(data){
                      if(data.status){
                          $('#modal_form').modal('hide');
                          toast({ type: 'success', title: 'Sukses',text:'Data telah disimpan' });  
                          reload_table();
                      }else{                        
                          for (var i = 0; i < data.inputerror.length; i++){
                              if(data.inputerror[i] == 'deskripsi')
                              {
                                $('div.errdeskripsi').show().addClass('text-danger');
                                $("div.err_msg").html(data.error_string[i]); 
                              }else{
                                $('div.errdeskripsi').hide();
                                 $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
                                 $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                              }                                                   
                          }

                      }
                      $('#btnSave').text('save');
                      $('#btnSave').attr('disabled',false);
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      swal({ type: 'error', title: 'Oops...', text: 'Something went wrong!' });
                      $('#btnSave').text('save'); //change button text
                      $('#btnSave').attr('disabled',false); //set button enable 

                  }
              });
          }

          function delete_person(id)
          {
              swal({
                title: 'Anda Yakin?',
                text: "ingin menghapus produk",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
              }).then((result) => {
                if (result.value) {
                  $.ajax({
                      url : "<?php echo site_url('/Penjual/produk_delete')?>/"+id,
                      type: "POST",
                      dataType: "JSON",
                      success: function(data){
                        toast({ type: 'success', title: 'Sukses',text:'Data telah dihapus' });
                        reload_table();
                      },
                      error: function (jqXHR, textStatus, errorThrown){
                        swal({type: 'error',title: 'Oops...',text: 'Something went wrong!'});
                      }
                  });
                }
              });
          }                   
</script>