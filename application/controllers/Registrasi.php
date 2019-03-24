<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrasi extends CI_Controller{
	function __construct()
	{
		parent::__construct();
	}    

	function pembeli()
	{
		$header['title'] = 'Registrasi Pembeli';
		$this->load->view('header',$header);
		$this->load->view('registrasi_pembeli');
		$this->load->view('footer');
	}	
	
	public function submit_pembeli()
	{
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[t_pembeli.email]|is_unique[t_penjual.email]');			
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
		$this->form_validation->set_rules('repassword', 'Re-Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE)
        {
            $this->pembeli();
        }
        else
        {
        	$email = $this->input->post('email');
        	$pass = $this->input->post('password');
        	$id_pembeli = $this->M_pembeli->id_pembeli();

        	$token = md5($id_pembeli.time());
		    //memasukan ke array
			$data = array(
				'id_pembeli' => $id_pembeli,
				// 'nama' => '',
				// 'notelp' => '',
				// 'alamat' => '',
				// 'kota' => '',
				'email' => $email,
				'password' => md5($pass),
				'status_akun' => 'baru',
				'token' => $token
			);
			$konfir['tombol'] = "Konfirmasi Email";
			$konfir['link'] = site_url('/Registrasi/konfirmasi_email/').$token;
			$konfir['pesan'] = "Harap konfirmasi alamat email Anda dengan mengklik tautan di bawah ini.<br><br>
			Kami mungkin perlu mengirimkan Anda informasi penting tentang layanan kami dan penting bagi kami 
			untuk memiliki alamat email yang akurat.<br><br>";

			$subject = "Konfirmasi Email";
			$message = $this->load->view('template/email/konfirmasi_email', $konfir, TRUE);				

		  	$this->load->library('email');
		    $this->email->from('Multi E-Commerce');
		    $this->email->to($email);
		    $this->email->subject($subject);
		    $this->email->message($message);

			if($this->email->send())
			{			
				$this->M_pembeli->simpan_registrasi($data);
				$pesan['judul'] = 'KONFIRMASI EMAIL';
				$pesan['pesan'] = "Email telah dikirim ke <b>".$email."</b>.<br>Harap periksa email dari kami dan klik tautan yang disertakan untuk mengaktifkan akun Anda.";
			}
			else
			{			    
			    $pesan['pesan'] = "Email gagal terkirim ke ".$email;
			}	
			$header['title'] = 'Konfirmasi Email';
		    $this->load->view('header', $header);
			$this->load->view('konfirmasi_email', $pesan);
			$this->load->view('footer');
		}
	}

	function konfirmasi_email($key)
	{	
		if($this->M_pembeli->aktifasi($key))
		{
			$pesan = array('type'=>'success', 'title' => 'Sukses', 'pesan' => 'Akun anda sudah aktif.');
			$this->session->set_flashdata('swal', $pesan);
			redirect(site_url('/Login'));
		}
		else
		{
			show_404();
		}			
	}

	function lengkapi_data_akun($key)
	{
		$cek = $this->M_penjual->get_penjual_by_kode_aktifasi($key);
		if($cek->num_rows() == 1)
		{			
			$pesan = array('type'=>'info', 'title' => 'Info', 'pesan' => 'Lengkapi data akun.');
			$this->session->set_flashdata('swal', $pesan);
			
			$header['title'] = 'Lengkapi data akun';
			$data['penjual'] = $cek->result();

		    $this->load->view('header', $header);
			$this->load->view('lengkapi_registrasi',$data);
			$this->load->view('footer');			
		}
		else
		{
			show_404();
		}		

	}

	function update_akun($key)
	{
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('nm_bank', 'Nama Bank', 'required|min_length[3]');
		$this->form_validation->set_rules('an_rek_bank', 'Atas Nama', 'required');
		$this->form_validation->set_rules('no_rek_bank', 'Nomor Rekening Bank', 'required|is_numeric|min_length[10]');

		if ($this->form_validation->run() == FALSE)
        {
            $this->lengkapi_data_akun($key);
        }
        else
        {
        	$id = $this->input->post('id_penjual');
        	$where = array( 'id_penjual' => $id);

        	$nama_foto 	= "LT".$id.time();
        	$data = array(			
				'alamat'		=> $this->input->post('alamat'),
				'nm_bank'		=> $this->input->post('nm_bank'),
				'an_rek_bank'	=> $this->input->post('an_rek_bank'),
				'no_rek_bank'	=> $this->input->post('no_rek_bank'),
				'status_akun'   => 'aktif',								
				'token'	=> ''
			);
						
			$config['upload_path']	='./assets/foto/penjual/logo/';
			$config['allowed_types']='jpg|png|jpeg';
			$config['max_size'] = 3078;		
			$config['file_name']= $nama_foto;
			
			$this->upload->initialize($config);					 

			if(!$this->upload->do_upload('logo_toko')){
				$pesan = array('type'=>'error', 'title' => 'Upload!', 'pesan' => $this->upload->display_errors('( ',' )'));
				$this->session->set_flashdata('swal', $pesan);
				$this->lengkapi_data_akun($id);
			}else{
				$upload = $this->upload->data();
	        	//Compress Image
	            $config2['image_library']='gd2';
	            $config2['source_image']='./assets/foto/penjual/logo/'.$upload['file_name'];
	            $config2['create_thumb']= FALSE;
	            $config2['maintain_ratio']= FALSE;
	            $config2['quality']= '70%';
	            $config2['width']= 600;
	            $config2['height']= 350;
	            $config2['new_image']= './assets/foto/penjual/logo/'.$upload['file_name'];
	            $this->load->library('image_lib', $config2);
	            $this->image_lib->resize();

				$gambar = $upload['file_name'];

				$data['logo_toko'] = $gambar;

				$this->M_penjual->update($where, $data);			
				$pesan = array('type'=>'success', 'title' => 'Sukses', 'pesan' => 'Akun anda telah aktif.');
				$this->session->set_flashdata('swal', $pesan);
				redirect(site_url());			
	        }	
        }
	}
	// function cek_email()
	// {
	// 	$email = $this->input->post('cek_email');
	// 	$cek_email = $this->M_penjual->cek_email($email);
	// 	if($cek_email->num_rows() == 1)
	// 	{
	// 		foreach ($cek_email->result() as $e) {
	// 			$id = $e->id_penjual;	
	// 		}
	// 		echo site_url('/Web/lengkapi_registrasi/'.$id);
	// 	}else{
	// 		echo 0;
	// 	}			
	// }
	


	// function update_registrasi($id)
	// {
		
	// }

	// private function masa_aktif()
	// {
	// 	$tggl_skrg = date('Y-m-d');
	// 	$masa_aktif = date('Y-m-d', strtotime('+30 days', strtotime($tggl_skrg)));
	// 	return $masa_aktif;
	// }

	function penjual()
	{
		$header['title'] = 'Registrasi Penjual';		
		$this->load->view('header',$header);
		$this->load->view('registrasi_penjual');
		$this->load->view('footer');
	}

function submit_penjual()
{
	$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	$this->form_validation->set_rules('nama_toko', 'Nama Toko', 'required|is_unique[t_penjual.nama_toko]');
	$this->form_validation->set_rules('nama_penjual', 'Nama Penjual', 'required|is_unique[t_penjual.nama_penjual]');
	$this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|is_numeric|max_length[14]');
	$this->form_validation->set_rules('email', 'Email', 'required|is_unique[t_pembeli.email]|is_unique[t_penjual.email]');
	$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
	$this->form_validation->set_rules('repassword', 'Masukkan ulang password', 'required|matches[password]');

    if($this->form_validation->run() == FALSE){
        $this->penjual();
    }else{
    	$id_penjual = $this->M_penjual->id_penjual();
    	$nama_foto 	= "KTP".$id_penjual.time();
		$data = array(		
			'id_penjual'	=> $id_penjual,		
			'nama_toko'		=> $this->input->post('nama_toko'),
			'nama_penjual'	=> $this->input->post('nama_penjual'),
			'slug_penjual'	=> $this->input->post('slug'),
			'notelp'		=> $this->input->post('no_telp'),
			'email'			=> $this->input->post('email'),
			'password'		=> md5($this->input->post('repassword')),
			'status_akun'	=> 'baru',								
			'token'	=> md5($id_penjual.time())
		);
		
		$config['upload_path']	='./assets/foto/penjual/ktp/';
		$config['allowed_types']='jpg|png|jpeg';
		$config['max_size']		= 3078;
		$config['file_name']	= $nama_foto;
    	
    	$this->upload->initialize($config);					 
	
		if(!$this->upload->do_upload('foto_ktp')){
			$pesan = array('type'	=>'error','title'	=>'Gagal!','pesan' => $this->upload->display_errors(' ', ' '));
			$this->session->set_flashdata('swal', $pesan);
			$this->penjual();			
		}else{
			$upload = $this->upload->data();
			$gambar = $upload['file_name'];
			$data['foto_ktp'] = $gambar;
			$this->M_penjual->simpan_registrasi($data);

			$pesan['pesan'] ='<b>Terima kasih telah mendaftar</b>.<br>Email anda sudah terdaftar, Mohon menunggu verifikasi dalam waktu 1 x 24 jam. 
			<br> email konfirmasi akan dikirim ke email anda apabila anda memenuhi <a href='.site_url('/Web/tentang').'>syarat</a> mendaftar sebagai penjual.';
							
			$header['title'] = 'Registrasi Penjual';
		    $this->load->view('header', $header);
			$this->load->view('registrasi_penjual', $pesan);
			$this->load->view('footer');				
    	}	
	}	
}


}
?>
