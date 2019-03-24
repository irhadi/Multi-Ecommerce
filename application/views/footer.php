	
	<script type="text/javascript">		
		const toast = swal.mixin({
          toast: true,
          position: 'center',
          showConfirmButton: false,
          timer: 2000
        });

		$(document).ready(function(){

			$('[data-toggle="tooltip"]').tooltip();

			<?php if($pesan = $this->session->flashdata('toast')){ ?>
				toast({ 
					type: '<?php echo $pesan['type']; ?>',
					title: '<?php echo $pesan['pesan']; ?>'
				})
			<?php }else if($pesan = $this->session->flashdata('swal')){ ?>
				Swal({
					type: '<?php echo $pesan['type']; ?>',
					title: '<?php echo $pesan['title']; ?>',
					text: '<?php echo $pesan['pesan']; ?>'				  
				})			
			<?php }else if($pesan = $this->session->flashdata('swaltimer')){ ?>
				Swal({
					position: 'center',
					type: '<?php echo $pesan['type']; ?>',
					title: '<?php echo $pesan['title']; ?>',
					text: '<?php echo $pesan['pesan']; ?>',
					showConfirmButton: false,
					timer: 1500				  
				})			
			<?php } ?>	
					
			$('.preloader').fadeOut();
			$('#notifkeranjang').load("<?php echo site_url();?>/Keranjang/notif");
			
			<?php if($this->uri->segment(2)=='pembayaran' || $this->uri->segment(2)=='pemesanan' || $this->uri->segment(2)=='sukses'){ ?>
				$('#tampil_keranjang').hide();
			<?php } ?>

		});
		      

		$('#tampil_keranjang').click(function(){
          $('#data_keranjang').load("<?php echo site_url();?>/Keranjang/tampil");
          $('#keranjang').modal();      
        }); 


      	<?php if(empty($this->session->userdata('id_pembeli'))): ?>
        	$("#login").click(function(){  
              var email = $("#email").val();  
              var password = $("#password").val();
              if(email == '' || password == ''){
                $("div.login_msg").show();  
                $("div.lgn").html("Email dan Password Tidak boleh kosong");
              }else{          
                $.ajax({  
                type: "POST",  
                url:  "<?php echo site_url(); ?>/Web/cek_login",  
                data: {email: email, password: password},  
                cache: false,
                  beforeSend:function(){
                    $('.loading').addClass('fa fa-spinner fa-spin');
                  },
                  success: function(result){  
                      if(result!=0){    
                        window.location.replace(result);  
                      }else{
                        $("div.login_msg").show();
                        $("div.lgn").html("Email atau password salah!");
                      }
                  },
                  complete:function(){
                    $('.loading').removeClass('fa fa-spinner fa-spin');
                  }
                });
              }  
        	});
		<?php endif; ?>        	


		<?php if($this->session->userdata('login_Pembeli')==FALSE): ?>


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

        <?php endif; ?>    

		$(document).on('click', '.update', function(){
			var id = $(this).data("id");
			var rowid = $(this).data("row");
			var qty = $('#update' + id).val();
			$.ajax({          
			  url: "<?php echo site_url();?>/Keranjang/update",
			  type: "POST",
			  dataType : 'json',
			  data: {rowid:rowid, qty:qty},
			  success: function (response) {
			    if(response.status == "success"){
			      toast({type: 'success',title: response.notif})
			      $('#data_keranjang').load("<?php echo site_url();?>/Keranjang/tampil");
			    }else if(response.status == "error"){
			      toast({type: 'error',title: response.notif})
			      $('#data_keranjang').load("<?php echo site_url();?>/Keranjang/tampil");              
			    }
			  }
			});
		});

		$(document).on('click', '.hapus', function(){
			var rowid = $(this).data("row");
			swal({
			  title: 'Anda yakin?',
			  text: 'ingin menghapus item',
			  type: 'warning',
			  showCancelButton: true,
			  focusCancel:true,
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus'
			}).then((result) => {
			  if (result.value) {
			    $.ajax({
			      url : "<?php echo site_url()?>/Keranjang/hapus",
			      type: "POST",
			      data: {rowid:rowid},
			      success: function(data)
			      {
			        $('#data_keranjang').html(data);
			        $('#notifkeranjang').load("<?php echo site_url();?>/Keranjang/notif");
			        toast({type: 'success',title: 'Item telah dihapus'})
			      },
			    });
			  }
			})
		});

		$(document).on('click', '.hapus_semua', function(){
			swal({
			  title: 'Anda yakin?',
			  text: 'ingin menghapus semua item',
			  type: 'warning',
			  showCancelButton: true,
			  focusCancel:true,
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Hapus'
			}).then((result) => {
			  if (result.value) {
			    $.ajax({
			      url : "<?php echo site_url()?>/Keranjang/hapus_semua",       
			      success: function(data)
			      {
			        $('#data_keranjang').html(data);
			        $('#notifkeranjang').load("<?php echo site_url();?>/Keranjang/notif");
			        toast({type: 'success',title:'semua item telah dihapus'})
			      },
			    });
			  }
			})
		});

	</script>	
  	<footer class="text-dark text-center bg-white border-top">
		<?php if($this->uri->segment(1) == '' || $this->uri->segment(2) == 'produk'): ?>
		<div class="card-group">
		  <div class="card border-0">
		    <div class="card-body text-center">
		    	<h5>PEMBAYARAN</h5><br>

				<table class="table-borderless mx-auto">
					<tr>
						<?php echo $this->CI->tampil_bank(); ?>
					</tr>
				</table>
		    </div>
		  </div>
		  <div class="card border-0">
		    <div class="card-body text-center">
				<h5>PENGIRIMAN</h5><br>
				<table class="mx-auto">
					<tr>
						<td><span class="badge badge-light border"><img src="<?php echo base_url();?>assets/img/icon/POS.png" class="mx-auto d-block" height="30"></span></td>
						<td><span class="badge badge-light border"><img src="<?php echo base_url();?>assets/img/icon/TIKI.png" class="mx-auto d-block" height="30"></span></td>
						<td><span class="badge badge-light border"><img src="<?php echo base_url();?>assets/img/icon/JNE.png" class="mx-auto d-block" height="30"></span></td>
					</tr>
				</table>
		    </div>
		  </div>
		</div>
		<?php endif; ?>
		<div class="col-md-12 border-top p-3 text-light" style="background-color: #ff751a">
			<div class="row">
				<div class="col-md-6 text-left">&copy; Multi E-commerce 2018</div>
				<div class="col-md-6 text-right small">( Halaman ditampilkan dalam <strong>{elapsed_time}</strong> detik )</small></span></div>
			</div>
		</div>
	</footer>
</body>
</html>