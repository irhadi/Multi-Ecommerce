            <div class="col-md-12 col-sm-12 p-4">

              <div class="col p-4 mb-3 bg-fluid">
                <div class="text-right mb-3 mr-3">
                  <button class="btn btn-success btn-sm" id="tambah"><i class="fa fa-plus"></i> Tambah</button>
                  <button class="btn btn-outline-light btn-sm" onclick="reload_table()"><i class="fa fa-refresh"></i> Refresh</button>
                </div> <hr>                
                <div class="table-responsive-lg">
                  <table class="table table-borderless table-striped table-hover border border-secondary" cellspacing="0" id="rekening" >
                    <thead>
                      <tr>
                        <th>Nama Bank</th> 
                        <th>Atas Nama</th> 
                        <th>Nomor Rekening</th>
                        <th>Logo</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div> 
              </div>

            </div>

          </div>
        </div> 


        <div class="modal fade" id="modal_form" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header navbar-color">
                      <div class="h4 modal-title text-white"></div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                      <form action="#" id="form" class="form-horizontal">

                          <div class="form-group">
                              <input name="nm_bank" placeholder="Nama Bank" class="form-control" type="text">
                              <span class="help-block text-danger"></span>
                          </div>

                          <div class="form-group">
                              <input name="an_rek" placeholder="Atas Nama" class="form-control" type="text">
                              <span class="help-block text-danger"></span>
                          </div>

                          <div class="form-group">
                              <input name="no_rek" placeholder="Nomor Rekening" class="form-control" type="text">
                              <span class="help-block text-danger"></span>
                          </div>

                          <div class="form-group" id="photo-preview">
                            <label class="">Gambar</label>
                              <div>(Tidak ada gambar)</div>
                          </div>

                          <div class="form-group">
                            <label id="label-photo">Upload Gambar</label>
                            <div>
                              <input name="logo" class="form-control-file border" type="file">
                              <span class="help-block text-danger"></span>
                            </div>  
                          </div>                                             
                      </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="button" id="btnSave" class="btn btn-primary">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- End Bootstrap modal -->

   
        <script src="<?php echo base_url();?>assets/dev/js/popper.min.js"></script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="<?php echo base_url('assets/dataTables2/jquery.dataTables.js'); ?>"></script>
        <script src="<?php echo base_url('assets/dataTables2/dataTables.bootstrap4.js'); ?>"></script>
        <script src="<?php echo base_url();?>assets/dev/js/bootstrap.min.js"></script> 
        <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
        <script type="text/javascript">

          var table;
          var base_url = '<?php echo base_url();?>';
          $(document).ready(function(){ 

            table = $('#rekening').DataTable({ 
                'processing': true,
                'serverSide': true,
                'order': [],
                'ajax': {'url': '<?php echo site_url("/Admin/rekening_list")?>', 'type': 'POST' },
                'columnDefs': [ 
                  { 'targets': [ -1 ], 'orderable': false, },
                  { 'targets': [ -2 ], 'orderable': false, },
                ],
            });

            $('input').change(function(){
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });

          feather.replace();

          });
          
          function reload_table(){
              table.ajax.reload(null,false);
          } 

          $('#tambah').click(function(){
              $('#form')[0].reset();
              $('.form-group').removeClass('has-error');
              $('.help-block').empty();

              $('#modal_form').modal('show');
              $('.modal-title').text('Tambah Rekening');
              $('#photo-preview').hide();
              $('#label-photo').text('Upload Gambar'); 
          })
              
          $('#btnSave').click(function(){
              $('#btnSave').text('saving...');
              $('#btnSave').attr('disabled',true);
              // ajax simpan data produk ke database
              var formData = new FormData($('#form')[0]);
              $.ajax({
                  url : "<?php echo site_url('/Admin/tambah_rekening')?>",
                  type: "POST",
                  data: formData,
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
                              
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                          }

                      }
                      $('#btnSave').text('save');
                      $('#btnSave').attr('disabled',false);
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      swal({ type: 'error', title: 'Oops...', text: 'Error adding / update data' });
                      $('#btnSave').text('save'); //change button text
                      $('#btnSave').attr('disabled',false); //set button enable 

                  }
              });
          });  


          function delete_person(id)
          {
              swal({
                title: 'Anda Yakin?',
                text: "ingin menghapus rekening",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
              }).then((result) => {
                if (result.value) {
                  $.ajax({
                      url : "<?php echo site_url('/Admin/hapus_rekening')?>/"+id,
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
      </div>
    </div>
  </body>
</html>