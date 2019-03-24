	<script type="text/javascript">
		const toast = swal.mixin({
          toast: true,
          position: 'center',
          showConfirmButton: false,
          timer: 2000
        });	


        // function notifikasi() {
        //   if (!Notification) {
        //       alert('Browsermu tidak mendukung Web Notification.'); 
        //       return;
        //   }
        //   if (Notification.permission !== "granted"){
        //       Notification.requestPermission();
        //   }else{
        //       $.ajax({
        //         url:'<?php //echo site_url('/Penjual/notif_click'); ?>',
        //         type : 'post',
        //         dataType: 'json',
        //         success:function(response)
        //         {
        //           if(response.notif !== 0)
        //           {
        //             var notifikasi = new Notification('Anda Memiliki '+response.notif+' Orderan Baru', {
        //               icon: '<?php //echo base_url('assets/img/icon/notification.png');?>',
        //               body: 'Klik untuk melihat!',
        //             });
        //             clearTimeout(auto_refresh);               
        //             notifikasi.onclick = function(){
        //                 window.open(response.klik);                        
        //             };
        //           }else{

        //           }
        //         }
        //       });
        //   }
        // }


		$(document).ready(function(){			
			var auto_refresh = setTimeout(function(){ 
				$.ajax({
					url:'<?php echo site_url('/Penjual/notif_order'); ?>',
					type : 'post',
					success:function(response)
					{
					  if(response.notif != 0)
					  {
					  	$('#notiforder').html(response);	
					  }
					}
				});
			},1000);

			$('.preloader').fadeOut();
        	
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
	            timer: 2000         
	          })      
	        <?php } ?> 	   	
		});	
	</script>
	<footer class="text-center p-4 bg-white border-top">
		<div class="container">
		<span class="text-dark">Aplikasi Multi E-commerce Menggunakan Codeigniter</span>
		</div>
	</footer>	
</body>
</html>