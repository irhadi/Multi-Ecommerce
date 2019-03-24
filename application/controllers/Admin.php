<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller
{ 	
	public $CI = NULL;
	function __construct()
	{
		parent::__construct();
		$this->CI = & get_instance();			
		$this->load->helper('tanggal_indo');
	}
	
	public function format_tanggal($tanggal)
	{
		return mediumdate_indo($tanggal);
	}

	function index()
	{		
		$this->load->view('admin/index');
	}

	function dashboard()
	{
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }
        $header['title'] = 'Admin | Dashboard';
		$header['heading'] = 'Dashboard';
		$data['total_penjual'] 	= $this->M_penjual->get_data_penjual_lama()->num_rows();
		$data['total_pembeli'] 	= $this->M_pembeli->get_data()->num_rows();
		$data['total_produk'] 	= $this->M_produk->get_data()->num_rows();
		// //Get total transaksi status dikirim (sukses)
		$data['bulan'] = $this->M_transaksi->get_bulan()->result();
		$data['totaltransaksi'] = $this->M_transaksi->get_total_transaksi();
		$data['keuntungan'] = $this->M_transaksi->get_keuntungan()->result();
		$this->load->view('admin/header', $header);
		$this->load->view('admin/dashboard', $data);
	}

	function data_penjual()
	{
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }
		$id = '';
		$header['title'] = 'Admin | Data Penjual';
		$header['heading'] = 'Data Penjual';
		$data['penjual_baru'] = $this->M_penjual->get_data_penjual_baru($id)->result();
		$data['penjual_lama'] = $this->M_penjual->get_data_penjual_lama()->result();
		$this->load->view('admin/header',$header);
		$this->load->view('admin/data_penjual',$data);		   
	}	

	function tampil_penjual_baru($id)
	{
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }
        $data['penjual_baru'] = $this->M_penjual->get_data_penjual_baru($id)->result();
		$header['title'] = 'Admin | Data Penjual';
		$header['heading'] = 'Penjual Baru';
		$this->load->view('admin/header',$header);
		$this->load->view('admin/tampil_penjual_baru',$data);
	}

	function konfirmasi_penjual_baru()
	{
		$id = $this->input->post('id_penjual');
		$email = $this->input->post('email');
		$token = $this->input->post('token');

		$bolehkan = $this->input->post('bolehkan');
		$tolak = $this->input->post('tolak');

		$where = array('id_penjual' => $id);

		$data = array('status_akun' => 'bolehkan');

		if($bolehkan == 'bolehkan')
		{			

			$konfir['link'] = site_url('/Registrasi/lengkapi_data_akun/'.$token);
			$konfir['tombol'] = "Konfirmasi Email";
			$konfir['pesan'] = "Selamat Anda telah diterima menjadi penjual di MULTI ECOMMERCE<br><br>
			Harap konfirmasi email dan melengkapi data akun dengan mengklik tautan dibawah.<br>";

			$subject = "Konfirmasi Email";
			$message = $this->load->view('template/email/konfirmasi_email', $konfir, TRUE);

			
		  	$this->load->library('email');	    
		    //konfigurasi pengiriman
		    $this->email->from('Multi E-Commerce');
		    $this->email->to($email);
		    $this->email->subject($subject);
		    $this->email->message($message);

			if( $this->email->send())
			{
				$query = $bolehkan;
				$this->M_penjual->konfirmasi_penjual_baru($query, $where, $data);
				$pesan = array(
					'type' => 'success',
					'title' => 'Sukses',
					'pesan' => $email.' telah disetujui.'
				);
				$this->session->set_flashdata('swal', $pesan);
				redirect(site_url('/Admin/data_penjual'));
			}else{
				$pesan = array(
					'type' => 'error',
					'title' => 'Gagal',
					'pesan' => 'Terjadi kesalahan saat mengirim pesan aktivasi akun ke email'
				);
				$this->session->set_flashdata('swal', $pesan);
				$this->tampil_penjual_baru($id);
			}
		}
		else
		{			
			
			$konfir['link'] = site_url('/Web/tentang');
			$konfir['tombol'] = "Syarat";
			$konfir['pesan'] = "Selamat Anda telah menjadi mitra kami di MULTI ECOMMERCE<br><br>
			Harap konfirmasi email dan melengkapi data akun dengan mengklik tautan dibawah.<br>";

			$subject = "Registrasi ditolak";
			$message = $this->load->view('template/email/konfirmasi_email', $konfir, TRUE);
			
		  	$this->load->library('email');
		    $this->email->from('Multi E-Commerce');
		    $this->email->to($email);
		    $this->email->subject($subject);
		    $this->email->message($message);

			if( $this->email->send())
			{
				$query = $tolak;
				$this->M_penjual->konfirmasi_penjual_baru($query, $where, $data);
				$pesan = array(
					'type' => 'success',
					'title' => 'Sukses',
					'pesan' => $email.' telah ditolak.'
				);
				$this->session->set_flashdata('swal', $pesan);
				redirect(site_url('/Admin/data_penjual'));
			}else{
				$pesan = array(
					'type' => 'error',
					'title' => 'Gagal',
					'pesan' => 'Terjadi kesalahan saat mengirim email'
				);
				$this->session->set_flashdata('swal', $pesan);
				$this->tampil_penjual_baru($id);		
			}			
		}
	}


	function data_transaksi()
	{
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }

		$header['title'] = 'Admin | Data Transaksi';
		$header['heading'] = 'Data Transaksi';

		$get_status_konfir_pembayaran = array('status_transaksi'=>'konfirpembayaran');
		$data['status_konfir_pembayaran'] = $this->M_transaksi->get_data_join_pembeli($get_status_konfir_pembayaran)->result();		

		$get_status_di_bayar = array('status_transaksi'=>'dibayar');
		$data['status_di_bayar'] = $this->M_transaksi->get_data_join_pembeli($get_status_di_bayar)->result();		

		$get_status_di_bayar = array('status_transaksi'=>'refund');
		$data['status_refund'] = $this->M_transaksi->get_data_join_pembeli($get_status_di_bayar)->result();		

		$get_status_batal = array('status_transaksi'=>'batal');
		$data['status_batal'] = $this->M_transaksi->get_data_join_pembeli($get_status_batal)->result();		

		$get_status_konfir_pengiriman = array('status_transaksi'=>'konfirpengiriman');
		$data['status_konfir_pengiriman'] = $this->M_transaksi->get_data_join_penjual($get_status_konfir_pengiriman)->result();		

		$get_status_di_kirim = array('status_transaksi'=>'dikirim');
		$data['status_di_kirim'] = $this->M_transaksi->get_data_join_penjual($get_status_di_kirim)->result();
		
		$get_status_selesai = array('status_transaksi'=>'selesai');
		$data['status_selesai'] = $this->M_transaksi->get_data_join_penjual($get_status_selesai)->result();

		$this->load->view('admin/header', $header);
		$this->load->view('admin/data_transaksi', $data);
	}	

	
	function detail_transaksi($id)
	{
		if($this->session->userdata('login_Admin')!=TRUE){
			show_404();
		}else{		
			
			$header['title'] = 'Admin | Detail Transaksi';
			$header['heading'] = 'Detail Transaksi';

			$data['transaksi'] = $this->M_transaksi->get_detail_transaksi($id)->result();
			foreach ($data['transaksi'] as $t) {
				$data['penjual'] =$this->M_penjual->get_penjual($t->id_penjual)->result();
				$data['pembeli'] =$this->M_pembeli->get_pembeli($t->id_pembeli)->result();
			}

			$data['order'] = $this->M_order->get_order($id)->result();

			$this->load->view('admin/header',$header);
			$this->load->view('admin/detail_transaksi',$data);
		}
	}	

	function detail_pembayaran($id)
	{
		if($this->session->userdata('login_Admin')!=TRUE){
			show_404();
		}else{		
			
			$header['title'] = 'Admin | Detail Pembayaran';
			$header['heading'] = 'Detail Pembayaran';

			$data['pembayaran'] = $this->M_transaksi->get_detail_pembayaran($id)->result();

			$this->load->view('admin/header',$header);
			$this->load->view('admin/detail_pembayaran',$data);
		}
	}	
	
	function verifikasi_pembayaran($id)
	{
		if($this->session->userdata('login_Admin')!=TRUE){
			show_404();
		}else{		
			$verifikasi = $this->M_transaksi->verifikasi_pembayaran($id);
			if($verifikasi)
			{
				$pesan = array(
					'type' => 'success',
					'title' => 'Sukses',
					'pesan' => 'Pembayaran telah diverifikasi.'
				);
				$this->session->set_flashdata('swal', $pesan);
				redirect(site_url('/Admin/data_transaksi'));
			}
		}
	}	

	function detail_pengiriman($id)
	{
		if($this->session->userdata('login_Admin')!=TRUE){
			show_404();
		}else{		
			
			$header['title'] = 'Admin | Detail Pengiriman';
			$header['heading'] = 'Detail Pengiriman';

			$data['pengiriman'] = $this->M_transaksi->get_detail_pengiriman($id)->result();

			$this->load->view('admin/header',$header);
			$this->load->view('admin/detail_pengiriman',$data);
		}
	}

	function verifikasi_pengiriman($id)
	{
		if($this->session->userdata('login_Admin')!=TRUE){
			show_404();
		}else{		
			$verifikasi = $this->M_transaksi->verifikasi_pengiriman($id);
			if($verifikasi)
			{
				$pesan = array(
					'type' => 'success',
					'title' => 'Sukses',
					'pesan' => 'Pengiriman telah diverifikasi.'
				);
				$this->session->set_flashdata('swal', $pesan);
				redirect(site_url('/Admin/data_transaksi'));
			}
		}
	}

	function data_pembeli()
	{
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }			
		$header['title'] = 'Admin | Data Pembeli';
		$header['heading'] = 'Data Pembeli';
	
		$data['pembeli'] = $this->M_pembeli->get_data()->result();
		$this->load->view('admin/header',$header);
		$this->load->view('admin/data_pembeli',$data);	   
	}	

	function data_produk()
	{	
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }			

		$header['title'] = 'Admin | Data Produk';
		$header['heading'] = 'Data Produk';

		$data['produk'] = $this->M_produk->get_data()->result();
		$this->load->view('admin/header',$header);
		$this->load->view('admin/data_produk',$data);	
	}	

	function data_laporan_pembeli()
	{
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }			
		$header['title'] = 'Admin | Laporan Pembeli';
		$header['heading'] = 'Laporan Pembeli';
	
		$data['lapor'] = $this->M_laporkan->get_data()->result();
		$this->load->view('admin/header',$header);
		$this->load->view('admin/data_laporan_pembeli',$data);
	}

	function hapus($id)
	{
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }		
		$hapus = $this->M_penjual->hapus_penjual($id);
		$pesan = array('title'=>'Sukses!', 'pesan' => 'Email telah dhapus');
		$this->session->set_flashdata('sukses', $pesan);
		redirect(site_url('/Admin/data_penjual'));
	}

	function cek_login()
	{
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE)
        {
       	     $this->index();   	
		}
		
			$username	= $this->input->post('username');
			$password 	= md5($this->input->post('password'));
			$cek = $this->M_admin->cek_login($username, $password);
			if($cek->num_rows() == 1)
			{
				foreach($cek->result() as $data)
				{
					$data_session = array(
						'id_admin'=>$data->id_admin,
						'username'=>$data->username,
						'login_Admin' => TRUE
					);
					$this->session->set_userdata($data_session);
					redirect(site_url('/Admin/dashboard'));
				}
			}
			else
			{
				$this->session->set_flashdata(
					'gagal', 
					'<div class="alert alert-danger alert-dismissible">
    					<button type="button" class="close" data-dismiss="alert">&times;</button>
    					Username atau password salah.
  					</div>'
  				); 
		        redirect(site_url('/Admin')); 
			} 		

	}

	function keluar()
	{
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }		
		$this->session->sess_destroy();
		redirect(site_url('/Admin'));
	}

	function blokir($id)
	{
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }			
		$this->M_penjual->blokir($id);

		$pesan = array('title' => 'Sukses', 'pesan' => 'Berhasil memblokir');
		$this->session->set_flashdata('success', $pesan);


		redirect('admin/data_penjual');
	}	

	function verifikasi($id)
	{
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }			
		$this->M_penjual->verifikasi($id);

		$pesan = array('title' => 'Sukses', 'pesan' => 'Berhasil Verifikasi');
		$this->session->set_flashdata('success', $pesan);


		redirect(site_url('/Admin/data_penjual'));
	}
	
	function konfirm_transaksi_selesai($id)
	{
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }			
		$header['title'] = 'Admin | Konfirmasi Transaksi Selesai';
		$header['heading'] = 'Konfirmasi Transaksi Selesai';
		$data['id'] = $id;
		$data['penjual'] = $this->M_transaksi->get_detail_transaksi_join_penjual($id)->result();
		$this->load->view('admin/header',$header);
		$this->load->view('admin/konfirm_transaksi_selesai', $data);
	}	

	function konfirm_transaksi_batal($id)
	{
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }			
		$header['title'] = 'Admin | Konfirmasi Transaksi Batal';
		$header['heading'] = 'Konfirmasi Transaksi Batal';
		$data['id'] = $id;
		$data['transaksi'] = $this->M_transaksi->get_detail_transaksi($id)->result();

		$this->load->view('admin/header',$header);
		$this->load->view('admin/konfirm_transaksi_batal', $data);
	}

	function cek_konfirmasi_selesai($id_transaksi)
	{

        	$nama_foto 	= "BS".$id_transaksi.time();

			$data = array(
				// 'catatan' => $this->input->post('catatan'),
				'status_transaksi' => 'selesai',	
				'waktu_konfir_transaksi' => date('Y-m-d H:i:s')			
			);

			$config['upload_path']	='./assets/foto/transaksi/buktitransfer/';
			$config['allowed_types']='jpg|jpeg';
			$config['max_size']		= 3078;
			$config['file_name']	= $nama_foto;
        	
        	$this->upload->initialize($config);					 
		
			if(!$this->upload->do_upload('foto_transfer'))
			{
				$pesan = array(
					'type'	=>'error',
					'title'	=>'Gagal!', 
					'pesan' => $this->upload->display_errors('(',')')
				);
				$this->session->set_flashdata('swal', $pesan);
				$this->konfirm_transaksi_selesai($id_transaksi);			
			}
			else
			{
				$upload = $this->upload->data();
				$gambar = $upload['file_name'];
				$data['bukti_transfer'] = $gambar;
				$this->M_transaksi->update($id_transaksi, $data);
				
				$where = array('id_transaksi'=> $id_transaksi);
				$transaksi = $this->M_transaksi->get_data_join_penjual($where)->result();
				foreach ($transaksi as $t) {
					$email = $t->email;
					$total = $t->total_order+$t->ongkir;
					$time = $t->waktu_konfir_transaksi;
				}
				$subject = "TRANSFER DANA TRANSAKSI";
				$message = "Kami telah mentransfer dana transaksi kepada anda.
				<br>Berikut informasi transaksi dan bukti transfer: <br>
				<br>Invoice : #".$id_transaksi."
				<br>Total Bayar : Rp".number_format($total,0,",",".")."
				<br>Biaya Admin : - Rp5.000
				<br>Total Transfer : Rp".number_format($total-5000,0,",",".")."
				<br>Tanggal dan Waktu : ".$time;
				
			  	$this->load->library('email');
			    $this->email->from('Multi E-Commerce');
			    $this->email->to($email);
			    $this->email->subject($subject);
			    $this->email->message($message);
			    $this->email->attach(base_url('assets/foto/transaksi/buktitransfer/'.$gambar));
				$this->email->send(TRUE);

				$pesan = array('type'=>'success', 'title' => 'Sukses', 'pesan' => 'Bukti Transfer telah dikirim');
				$this->session->set_flashdata('swal', $pesan);
				redirect(site_url().'/Admin/data_transaksi');	
        	}         	
	}

	function cek_konfirmasi_batal($id_transaksi)
	{
        	$nama_foto 	= "BR".$id_transaksi.time();

			$data = array(
				'status_transaksi' => 'batal',
				'waktu_konfir_transaksi' => date('Y-m-d H:i:s')			
			);

			$config['upload_path']	='./assets/foto/transaksi/buktitransfer/';
			$config['allowed_types']='jpg|jpeg';
			$config['max_size']		= 3078;
			$config['file_name']	= $nama_foto;
        	
        	$this->upload->initialize($config);					 
		
			if(!$this->upload->do_upload('foto_transfer'))
			{
				$pesan = array(
					'type'	=>'error',
					'title'	=>'Gagal!', 
					'pesan' => $this->upload->display_errors('(',')')
				);
				$this->session->set_flashdata('swal', $pesan);
				$this->konfirm_transaksi_batal($id_transaksi);			
			}
			else
			{
				$upload = $this->upload->data();
				$gambar = $upload['file_name'];
				$data['bukti_transfer'] = $gambar;
				$this->M_transaksi->update($id_transaksi, $data);
				
				$get_data_order = $this->M_order->get_row_order_by_id_transaksi($id_transaksi);
				foreach($get_data_order->result() as $data_order){
					 $idp = $data_order->id_produk; //ambil id_produk
					 $stok = $data_order->qty; //dan stok
					 $update_stok = $this->M_produk->kembalikan_stok($idp, $stok);//jalankan query untuk mengembalikan stok
				}
				$where = array('id_transaksi'=> $id_transaksi);
				$transaksi = $this->M_transaksi->get_data_join_pembeli($where)->result();
				foreach ($transaksi as $t) {
					$email = $t->email;
					$total = $t->total_order+$t->kode_unik+$t->ongkir;
					$time = $t->waktu_order;
				}
				$subject = "PENGEMBALIAN DANA";
				$message = "Kami mohon maaf atas ketidaknyamanan anda bertransaksi, Kami telah mentransfer pengembalian dana anda.
				<br>Berikut informasi pemesanan dan bukti transfer:<br>
				<br>Invoice : #".$id_transaksi."
				<br>Total Bayar : Rp".number_format($total,0,",",".")."
				<br>Tanggal dan Waktu".$time;
				
			  	$this->load->library('email');
			    $this->email->from('Multi E-Commerce');
			    $this->email->to($email);
			    $this->email->subject($subject);
			    $this->email->message($message);
			    $this->email->attach(base_url('assets/foto/transaksi/buktitransfer/'.$gambar));
				$this->email->send(TRUE);

				$pesan = array('type'=>'success', 'title' => 'Sukses', 'pesan' => 'Bukti Transfer telah dikirim');
				$this->session->set_flashdata('swal', $pesan);
				redirect(site_url().'/Admin/data_transaksi');	
        	} 
	}


	function buka_blokir($id)
	{
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }			
		$this->M_penjual->buka_blokir($id);

		$pesan = array('title' => 'Sukses', 'pesan' => 'Berhasil membuka pemblokiran');
		$this->session->set_flashdata('success', $pesan);

		redirect(site_url('/Admin/data_penjual'));
	}
	

	function notif_transaksi()
	{
        $where_in = array('konfirpembayaran', 'konfirpengiriman', 'refund');
		$cek = $this->M_transaksi->get_data_where_in($where_in);
		if($cek->num_rows() > 0)
		{
			echo "<span class='badge badge-pill badge-danger'>".$cek->num_rows()."</span>";
		}else{
			echo "";
		}
	}		

	function notif_penjual_baru()
	{
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }		
        $id = '';
		$cek = $this->M_penjual->get_data_penjual_baru($id);
		if($cek->num_rows()<>0)
		{
			echo "<span align='right' class='badge badge-pill badge-danger'>".$cek->num_rows()."</span>";
		}else{
			echo "";
		}

	}	

	function ganti_password()
	{
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }		
		$header['title'] = 'Admin | Ganti password';
		$header['heading'] = 'Ganti password';		
		$this->load->view('admin/header', $header);
		$this->load->view('admin/ganti_password');
	}

	function cek_ganti_password()
	{
		if($this->session->userdata('login_Admin')!=TRUE){
			show_404();
		}				
		$id_pembeli = $this->session->userdata('id_pembeli');
		

		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');	
		$this->form_validation->set_rules('passold', 'Password Lama', 'required|min_length[8]');
		$this->form_validation->set_rules('passnew', 'Password Baru', 'required|min_length[8]');
		$this->form_validation->set_rules('repassnew', 'Ulang Password Baru', 'required|matches[passnew]');
		
        if ($this->form_validation->run() == FALSE)
        {
        	$this->ganti_password();
		}
		$passwordold = md5($this->input->post('passold'));
		$passwordnew = md5($this->input->post('repassnew'));
        $id_admin = $this->session->userdata('id_admin');
        $tetap_login = $this->input->post('check');    	
    	$cekpasssword = $this->M_admin->cek_password_lama($id_admin, $passwordold)->num_rows();
        if($cekpasssword == 1) 
        { 
	    	$update = $this->M_admin->update_password($id_admin, $passwordnew);

			if($tetap_login == '1')
			{
		    	$pesan = array('type'=> 'success', 'title' => 'Sukses!', 'pesan' => 'Berhasil Mengganti Password');
				$this->session->set_flashdata('pesan', $pesan);				
				$this->ganti_password();
			}else{
				$this->keluar();
			}		    
        } 
        else 
        { 
           $pesan = array('type'=> 'danger', 'title' => 'Gagal!', 'pesan' => 'Password lama salah.');
		   $this->session->set_flashdata('pesan', $pesan);
           $this->ganti_password(); 
        } 		  	
    }

	function rekening()
	{		
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }	
        
		$header['title'] = 'Admin | Rekening';
		$header['heading'] = 'Rekening';	

		$this->load->view('admin/header', $header);
		$this->load->view('admin/data_rekening');
	}	

	function hapus_rek($id)
	{
	   	if($this->session->userdata('login_Admin') != TRUE){
            show_404();
        }
        $where = array('id_rekening' => $id);
		$this->M_rekening->hapus($where)->result();
	}	

	function simpan_rek()
	{
		$this->M_rekening->simpan($data)->result();
	}	

	function update_rek()
	{
		$where = array('id_rekening' => $id);
		$this->M_rekening->update($where, $data)->result();
	}



	function rekening_list()
	{	
		$list = $this->M_rekening->get_rekening_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $rek) {
			$no++;
			$row = array();
			$row[] = $rek->nm_bank;
			$row[] = $rek->an_rek;
			$row[] = $rek->no_rek;
			if($rek->logo_bank)
				$row[] = '<a href="'.base_url('assets/img/icon/'.$rek->logo_bank).'" target="_blank"><img src="'.base_url('assets/img/icon/'.$rek->logo_bank).'" height="30" /></a>';
			else
				$row[] = '(Tidak Ada Gambar)';

			//add html for action
			$row[] = '<a class="btn btn-sm btn-danger float-center" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$rek->id_rekening."'".')"><i class="fa fa-trash"></i></a>';
		
			$data[] = $row;
		}

		$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->M_rekening->count_all(),
					"recordsFiltered" => $this->M_rekening->count_filtered(),
					"data" => $data,
				);
		echo json_encode($output);
	}

	function tambah_rekening()
	{
		$this->_validate();
		
		$data = array(
				'nm_bank' => $this->input->post('nm_bank'),
				'an_rek' => $this->input->post('an_rek'),
				'no_rek' => $this->input->post('no_rek')
			);

		if(!empty($_FILES['logo']['name']))
		{
			$gambar = $this->_do_upload();

			$data['logo_bank'] = $gambar;
		}

		$insert = $this->M_rekening->simpan($data);

		echo json_encode(array("status" => TRUE));
	}

	public function hapus_rekening($id)
	{
		$where = array('id_rekening' => $id);
		$rek = $this->M_rekening->get_rekening($where)->row();
		if(file_exists('assets/img/icon/'.$rek->logo_bank) && $rek->logo_bank){
			unlink('assets/img/icon/'.$rek->logo_bank);
		}
		
		$this->M_rekening->hapus($where);
		echo json_encode(array("status" => TRUE));
	}

	private function _do_upload()
	{			
		$nama_foto 	= $this->input->post('nm_bank');
		$pre_slug=strtolower(str_replace(" ", "-", $nama_foto));		
		$config['upload_path']	='./assets/img/icon/';
		$config['allowed_types']='jpg|png|jpeg';
		$config['file_name']	= $pre_slug;
        
        $this->upload->initialize($config);

        if(!$this->upload->do_upload('logo')) //upload and validate
        {
            $data['inputerror'][] = 'logo';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		$upload = $this->upload->data();
        return $upload['file_name'];
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nm_bank') == '')
		{
			$data['inputerror'][] = 'nm_bank';
			$data['error_string'][] = 'Nama is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('an_rek') == '')
		{
			$data['inputerror'][] = 'an_rek';
			$data['error_string'][] = 'Harga is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('no_rek') == '')
		{
			$data['inputerror'][] = 'no_rek';
			$data['error_string'][] = 'Berat is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}		
	}		
}
?>