<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
			
	}

	function index()
	{	
		$header['title'] = 'Login';
		$this->load->view('header',$header);
		$this->load->view('login');
		$this->load->view('footer');
	}

	function keluar(){
		$this->cart->destroy();
		$hapus_session = array('id_pembeli', 'email_pembeli', 'login_Pembeli');
		$this->session->unset_userdata($hapus_session);
		redirect(site_url());
	}

function cek_login()
{
	$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	$this->form_validation->set_rules('email', 'Email', 'required');			
	$this->form_validation->set_rules('password', 'Password', 'required');

    if ($this->form_validation->run() == FALSE)
    {
        $this->index();
    }

	$email = $this->input->post('email');
	$password = md5($this->input->post('password'));

	$cek_penjual = $this->M_penjual->cek_login($email, $password);
	$cek_pembeli = $this->M_pembeli->cek_login($email, $password);

	if($cek_pembeli->num_rows() == 1)
	{
		foreach($cek_pembeli->result() as $data)
		{
			$id_pembeli = $data->id_pembeli;
			$email = $data->email;
			$aktif = $data->status_akun;
		}
		if($aktif == 'baru')
		{
			$pesan['judul'] = 'KONFIRMASI EMAIL';
			$pesan['pesan'] = "Email telah dikirim ke <b>".$email."</b>.<br>Harap periksa email dari kami dan klik tautan yang disertakan untuk mengaktifkan akun Anda.";
			$header['title'] = 'Konfirmasi Email';
		    $this->load->view('header', $header);
			$this->load->view('konfirmasi_email', $pesan);
			$this->load->view('footer');
		}else{
			$data_session = array(
				'id_pembeli'	=>$id_pembeli,
				'email_pembeli'	=>$email,
				'login_Pembeli' =>TRUE
			);
			$pesan = array('type' => 'success', 'title' => 'Sukses','pesan' => 'Anda Telah login');
			$this->session->set_flashdata('swal', $pesan);
			$this->session->set_userdata($data_session);
			redirect (site_url());
		}
	}
	else if($cek_penjual->num_rows() == 1)
	{
		foreach($cek_penjual->result() as $data)
		{
			$id = $data->id_penjual;				
			$nama_toko = $data->nama_toko;
			$nama_penjual = $data->nama_penjual;
			$notelp = $data->notelp;
			$email = $data->email;
			$status_akun = $data->status_akun;
			$ll = $data->last_login;
		}
		if($status_akun == 'baru')
		{
			$pesan['pesan'] = '<b>Email anda sudah terdaftar</b>.<br>Mohon menunggu verifikasi dalam 1 x 24 jam, kami akan mengirim email apabila anda memenuhi <a target="_blank" href="'.site_url().'/Web/tentang">syarat</a> mendaftar sebagai penjual.';
			$header['title'] = "Registrasi";

			$this->load->view('header', $header);
			$this->load->view('registrasi_penjual', $pesan);
			$this->load->view('footer');
		}
		else if($status_akun == 'bolehkan')
		{			
			$pesan['judul'] = 'KONFIRMASI EMAIL';
			$pesan['pesan'] = "Email ".$email." telah diverifikasi<b>"."</b>.<br>Harap periksa email dari kami dan klik tautan yang disertakan untuk mengkonfirmasi email anda.";

			$header['title'] = "Registrasi";
			$this->load->view('header', $header);
			$this->load->view('registrasi_penjual', $pesan);
			$this->load->view('footer');				
		}
		else if($status_akun == 'aktif')
		{
			$data_session = array(
				'id_penjual'	=> $id,
				'email_penjual'	=> $email,
				'status'		=> $status_akun,
				'masa_aktif'	=> $ll,
				'login_Penjual' => TRUE
			);
			$pesan = array('type' => 'success', 'title' => 'Sukses','pesan' => 'Anda Telah login');
			$this->session->set_flashdata('swal', $pesan);
			$this->session->set_userdata($data_session);
			redirect(site_url('/Penjual'));					
		}			
		else if($status_akun == 'blokir')
		{
			$pesan = array('type' => 'error', 'title' => 'Login Gagal!','pesan' => 'Akun anda telah diblokir.');
			$this->session->set_flashdata('swal', $pesan);
			$this->index();				
		}
		
	}else{
		$pesan = array('pesan' => 'Email atau password salah.');
		$this->session->set_flashdata('login', $pesan);
		$this->index();
	}
}

	function recovery()
	{
		$header['title'] = 'Reset Password';
		$this->load->view('header',$header);
		$this->load->view('recovery_password');
		$this->load->view('footer');
	}	

	function cek_email()
	{		
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		$this->form_validation->set_rules('email', 'Email', 'required');
		if ($this->form_validation->run() == FALSE)
        {
            $this->recovery();
        }

        $email = $this->input->post('email');

        $cek_pembeli = $this->M_pembeli->cek_email($email);
        $cek_penjual = $this->M_penjual->cek_email($email);

        if($cek_pembeli->num_rows() == 1){

        	//buat token
        	$token = md5("recovery".time());
			$data = array('token' => $token);

			$subject = "Reset Password";
			$message = "Silahkan klik tautan dibawah ini untuk mereset kata sandi Anda :<br><br>

					    <a href='".site_url('/Login/reset_password/').$token."' style='box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 1.3em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #3bafda; margin: 0; border-color: #3bafda; border-style: solid; border-width: 10px 20px;'>Reset Password</a><br><br>

					    &mdash;Multi E-COMMERCE
					    ";			

			if($this->kirim_email($email, $subject, $message))
			{			
				//simpan token
				$this->M_pembeli->simpan_token($email, $data);

				$pesan['judul'] = 'KONFIRMASI EMAIL';
				$pesan['pesan'] = "Email telah dikirim ke <b>".$email."</b>.<br>Harap periksa email dari kami dan klik tautan yang disertakan untuk mereset kata sandi akun Anda.";

				$header['title'] = 'Konfirmasi Email';
			    $this->load->view('header', $header);
				$this->load->view('konfirmasi_email', $pesan);
				$this->load->view('footer');				
			}
			else
			{			    
			    $pesan['pesan'] = "Email gagal terkirim ke ".$email;
				$header['title'] = 'Reset Password';
				$this->load->view('header',$header);
				$this->load->view('recovery_password', $pesan);
				$this->load->view('footer');			    
			}						
		}else if($cek_penjual->num_rows() == 1){
        	//buat token
        	$token = md5("recovery".time());
			$data = array('token' => $token);

			$subject = "Reset Password";
			$message = "Silahkan klik tautan dibawah ini untuk mereset kata sandi Anda :<br><br>

					    <a href='".site_url('/Login/reset_password/').$token."' style='box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 1.3em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #3bafda; margin: 0; border-color: #3bafda; border-style: solid; border-width: 10px 20px;'>Reset Password</a><br><br>

					    &mdash;Multi E-COMMERCE
					    ";			

			if($this->kirim_email($email, $subject, $message))
			{			
				//simpan token
				$this->M_penjual->simpan_token($email, $data);

				$pesan['judul'] = 'KONFIRMASI EMAIL';
				$pesan['pesan'] = "Email telah dikirim ke <b>".$email."</b>.<br>Harap periksa email dari kami dan klik tautan yang disertakan untuk mereset kata sandi akun Anda.";

				$header['title'] = 'Konfirmasi Email';
			    $this->load->view('header', $header);
				$this->load->view('konfirmasi_email', $pesan);
				$this->load->view('footer');				
			}
			else
			{			    
			    $pesan['pesan'] = "Email gagal terkirim ke ".$email;
				$header['title'] = 'Reset Password';
				$this->load->view('header',$header);
				$this->load->view('recovery_password', $pesan);
				$this->load->view('footer');			    
			}			
		}else{
		    $pesan['pesan'] = $email." tidak ditemukan";
			$header['title'] = 'Reset Password';
			$this->load->view('header',$header);
			$this->load->view('recovery_password', $pesan);
			$this->load->view('footer');
		}			
	}

    private function kirim_email($email, $subject, $message)
    {
        $this->load->library('email');

        $this->email->from('Multi E-Commerce');
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);
             
        return $this->email->send();   
    }   

    function reset_password($key)
    {
    	$cek_pembeli = $this->M_pembeli->recovery($key);
    	$cek_penjual = $this->M_penjual->recovery($key);

    	$data['token'] = $key;

    	if($cek_pembeli->num_rows() == 1)
    	{   
    		$data['user'] = "pembeli"; 		
			$header['title'] = 'Reset Password';
			$this->load->view('header',$header);
			$this->load->view('reset_password', $data);
			$this->load->view('footer');
    	}else if($cek_penjual->num_rows() == 1){
    		$data['user'] = "penjual";
			$header['title'] = 'Reset Password';
			$this->load->view('header',$header);
			$this->load->view('reset_password', $data);
			$this->load->view('footer');
    	}else{
    		show_404();	
    	}
    }	

    function cek_reset_password()
    {
    	$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		$this->form_validation->set_rules('passnew', 'Password', 'required');			
		$this->form_validation->set_rules('repassnew', 'Ulang Password', 'required|matches[passnew]');

		$key = $this->input->post('token');

        if ($this->form_validation->run() == FALSE)
        {
            $this->reset_password($key);
        }

        $user = $this->input->post('user');

        if($user == 'pembeli'){
			$data = array(
				'password' => md5($this->input->post('repassnew')), 
				'token' => ''
			);
			$this->M_pembeli->reset_password($key, $data);
		}else if($user == 'penjual'){
			$data = array(
				'password' => md5($this->input->post('repassnew')), 
				'token' => ''
			);
			$this->M_penjual->reset_password($key, $data);
		}
		$pesan = array('type'=>'success', 'title' => 'Sukses', 'pesan' => 'Password Telah diubah.');
		$this->session->set_flashdata('swal', $pesan);		
		redirect(site_url('/Login'));
    }
}

?>
