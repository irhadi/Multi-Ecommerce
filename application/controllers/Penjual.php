<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Penjual extends CI_Controller{
	public $CI = NULL;
	function __construct()
	{
		parent::__construct();		
		$this->CI = & get_instance();	
	}
	
	function index()
	{	
		if($this->session->userdata('login_Penjual') != TRUE){
            redirect(site_url('Login'));
        }
        
        $id = $this->session->userdata('id_penjual');
        $data['penjual'] = $this->M_penjual->get_penjual($id)->result();			
		$header['title'] = 'Penjual | Dashboard';

        $data['bulan'] = $this->M_transaksi->get_bulan_by_($id)->result();
		$data['total'] = $this->M_transaksi->get_total_transaksi_by_($id)->result();

		$data['total_stok'] = $this->M_produk->get_total_produk_by_id($id);
		$data['total_produk'] = $this->M_produk->get_row_produk_by_id_penjual($id);
		$data['transaksi_dikirim'] = $this->M_transaksi->get_status_dikirim_by_id_penjual($id);
		$data['transaksi_selesai'] = $this->M_transaksi->get_status_selesai_by_id_penjual($id);
		$data['transaksi_batal'] = $this->M_transaksi->get_status_batal_by_id_penjual($id);

		$total_produk_terjual = 0;
		$row_total = array();
		$row_id_konfir = array();
		
		foreach($data['transaksi_selesai']->result() as $get):
			$row_id_konfir[] = $get->id_transaksi;			
		endforeach;
		
		$row_id=$row_id_konfir;

		for($i=0; $i<count($row_id);$i++){
			foreach ($this->M_produk->get_row_produk_terjual($row_id[$i])->result() as $get) {
				$row_total[] = $get->tot;
			}	
		}
	 
		for($i = 0; $i < count($row_total); $i++){
			$total_produk_terjual = $total_produk_terjual + $row_total[$i];
		} 
		$data['produk_terjual'] = $total_produk_terjual;
		$this->load->view('penjual/header', $header);
		$this->load->view('penjual/dashboard', $data);
		$this->load->view('penjual/footer');
	}

	function keluar()
	{
		if($this->session->userdata('login_Penjual')!=TRUE){
			redirect(site_url('Login'));
		}

		$where = array('id_penjual' => $this->session->userdata('id_penjual'));
		$data = array('last_login' => date('Y-m-d H:i:s'));	

		$this->M_penjual->keluar($where, $data);

		$this->session->sess_destroy();

		redirect(site_url());
	}
	
	function produk()
	{
		if($this->session->userdata('login_Penjual') != TRUE){
            redirect(site_url('Login'));
        }   
		$data['title'] = 'Penjual | Produk';
		$this->load->view('penjual/header',$data);
		$this->load->view('penjual/produk');
		$this->load->view('penjual/footer');
	}	

	function sunting_akun()
	{
		if($this->session->userdata('login_Penjual') != TRUE){
            redirect(site_url('Login'));
        }			
		$id = $this->session->userdata('id_penjual');
		$data['title'] = 'Sunting Akun';
		$data['sunting'] = $this->M_penjual->get_penjual($id)->result();
		$this->load->view('penjual/header', $data);
		$this->load->view('penjual/sunting_akun', $data);
		$this->load->view('penjual/footer');
	}		

	function ganti_password()
	{
		if($this->session->userdata('login_Penjual') != TRUE){
            redirect(site_url('Login'));
        }			
		$id = $this->session->userdata('id_penjual');
		$data['title'] = 'Ganti Password';
		$this->load->view('penjual/header', $data);
		$this->load->view('penjual/ganti_password');
		$this->load->view('penjual/footer');
	}	

	function cek_ganti_password()
	{
		if($this->session->userdata('login_Penjual')!=TRUE){
			redirect(site_url('Login'));
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
        $id_penjual = $this->session->userdata('id_penjual');
        $tetap_login = $this->input->post('check');    	
    	$cekpasssword = $this->M_penjual->cek_password_lama($id_penjual, $passwordold)->num_rows();
        if($cekpasssword == 1) 
        { 
	    	$update = $this->M_penjual->update_password($id_penjual, $passwordnew);

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

	function update_akun()
	{
		if($this->session->userdata('login_Penjual') != TRUE){
            redirect(site_url('Login'));
        }
        $this->form_validation->set_rules('nama_toko', 'Nama Toko', 'required');
        $this->form_validation->set_rules('nama_penjual', 'Nama Penjual', 'required');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|numeric|min_length[10]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|min_length[20]');
        $this->form_validation->set_rules('nm_bank', 'Bank', 'required|min_length[3]');
        $this->form_validation->set_rules('an_rek_bank', 'Atas Nama', 'required');
        $this->form_validation->set_rules('no_rek_bank', 'Nomor Rekening', 'is_numeric|required');

        if ($this->form_validation->run() == FALSE)
        {
                $this->sunting_akun();
        }
        else
        {
        	$where = array('id_penjual' => $this->session->userdata('id_penjual'));
			$data = array(
				'nama_toko'		=> $this->input->post('nama_toko'),
				'nama_penjual'	=> $this->input->post('nama_penjual'),
				'slug_penjual'	=> $this->input->post('slug'),
				'notelp'		=> $this->input->post('no_telp'),
				'alamat'		=> $this->input->post('alamat'),
				'nm_bank'		=> $this->input->post('nm_bank'),
				'an_rek_bank'	=> $this->input->post('an_rek_bank'),
				'no_rek_bank'	=> $this->input->post('no_rek_bank')
			);

			$this->M_penjual->update($where, $data);

			$pesan = array('title' => 'Sukses', 'pesan' => 'Data akun disimpan');
			$this->session->set_flashdata('popup_success', $pesan);
			redirect(site_url().'/Penjual/sunting_akun');     
        }

	}

	function update_logo()
	{
		if($this->session->userdata('login_Penjual') != TRUE){
            redirect(site_url('Login'));
        }			
		$nama_foto 	= "logo-".$this->session->userdata('id_penjual').time();
		$config['upload_path']	='./assets/foto/penjual/logo';
		$config['allowed_types']='jpg|png|jpeg';
		$config['max_size'] = 3078;		
		$config['file_name']= $nama_foto;
		
		$this->upload->initialize($config);					 

		if(!$this->upload->do_upload('logo_toko')){
			$pesan = array('title' => 'Gagal', 'pesan' => $this->upload->display_errors('<span class="text-danger">','</span>'));
			$this->session->set_flashdata('popup_error', $pesan);
			redirect(site_url().'/Penjual/sunting_akun');
		}else{
			$upload = $this->upload->data();
        	//Compress Image
            $config['image_library']='gd2';
            $config['source_image']='./assets/foto/penjual/logo/'.$upload['file_name'];
            $config['create_thumb']= FALSE;
            $config['maintain_ratio']= FALSE;
            $config['quality']= '70%';
            $config['width']= 600;
            $config['height']= 350;
            $config['new_image']= './assets/foto/penjual/logo/'.$upload['file_name'];
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();

			$gambar = $upload['file_name'];
			$penjual = $this->M_penjual->get_penjual($this->session->userdata('id_penjual'))->row();
			if(file_exists('assets/foto/penjual/logo'.$penjual->logo_toko) && $penjual->logo_toko){
				unlink('assets/foto/penjual/logo'.$penjual->logo_toko);
			}
			$data['logo_toko'] = $gambar;
			$this->M_penjual->update(array('id_penjual' => $this->session->userdata('id_penjual')),$data);				
			$pesan = array('title' => 'Sukses', 'pesan' => 'Gambar telah diganti');
			$this->session->set_flashdata('popup_success', $pesan);
			redirect(site_url().'/Penjual/sunting_akun');
		}					
	}

	function order()
	{
		if($this->session->userdata('login_Penjual') != TRUE){
            redirect(site_url('Login'));
        }			
		$data['title'] 	= 'Penjual | Order';
		$id_penjual		= $this->session->userdata('id_penjual');

		$data['order_terbaru']	= $this->M_transaksi->get_order_terbaru($id_penjual)->result();
		$data['order_history']	= $this->M_transaksi->get_order_history($id_penjual)->result();
		$data['order_dikirim']	= $this->M_transaksi->get_order_di_kirim($id_penjual)->result();
		$data['order_dikonfirmasi']	= $this->M_transaksi->get_order_di_konfirmasi($id_penjual)->result();

		$this->load->view('penjual/header',$data);
		$this->load->view('penjual/order',$data);
		$this->load->view('penjual/footer');
	}

	function detail_order($id_transaksi)
	{
		if($this->session->userdata('login_Penjual') != TRUE){
            redirect(site_url('Login'));
        }else{				
			$data['title'] = 'Penjual | Detail order';
			//mengambil detail transaksi yang status dibayar dan nomor resi masih kosong
			$data['transaksi'] = $this->M_transaksi->get_order($id_transaksi)->result();
			$data['order'] 		= $this->M_order->get_order($id_transaksi)->result();			
			$this->load->view('penjual/header',$data);
			$this->load->view('penjual/detail',$data);
			$this->load->view('penjual/footer');
		}
	}

	function konfirmasi_pengiriman($id_transaksi)
	{
		if($this->session->userdata('login_Penjual') != TRUE){
            redirect(site_url('Login'));
        }        
		$header['title'] = 'Penjual | Konfirmasi Pengiriman';
		$this->load->view('penjual/header',$header);
		$this->load->view('penjual/konfirmasi_pengiriman');
		$this->load->view('penjual/footer');
	}	

	function cek_konfirmasi_pengiriman()
	{
        $this->form_validation->set_rules('no_resi', 'Nomor Resi', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->konfirmasi_pengiriman($this->input->post('id'));
        }
        else
        {
        	$id_transaksi = $this->input->post('id');
        	$nama_foto 	= "BR".$id_transaksi.time();

			$data = array(
				'nomor_resi' => $this->input->post('no_resi'),
				'status_transaksi' => 'konfirpengiriman',
				'waktu_konfir_pengiriman' => date('Y-m-d H:i:s')
			);

			$config['upload_path']	='./assets/foto/transaksi/buktipengiriman/';
			$config['allowed_types']='jpg|jpeg';
			$config['max_size']		= 3078;
			$config['file_name']	= $nama_foto;
        	
        	$this->upload->initialize($config);					 
		
			if(!$this->upload->do_upload('foto_resi'))
			{
				$pesan = array(
					'type'	=>'error',
					'title'	=>'Gagal!', 
					'pesan' => $this->upload->display_errors(' ',' ')
				);
				$this->session->set_flashdata('swal', $pesan);
				$this->konfirmasi_pengiriman($id_transaksi);			
			}
			else
			{
				$upload = $this->upload->data();
				$gambar = $upload['file_name'];
				$data['bukti_pengiriman'] = $gambar;
				$this->M_transaksi->update($id_transaksi, $data);

				$pesan = array('type'=>'success', 'title' => 'Sukses', 'pesan' => 'Nomor resi telah dikirim');
				$this->session->set_flashdata('swal', $pesan);
				redirect(site_url().'/Penjual/detail_order/'.$id_transaksi);	
        	}
         	
        }
	}
	// function konfirmasi_pengiriman($id_transaksi)
	// {
	// 	if($this->session->userdata('login_Penjual') != TRUE){
	//            show_404();
	//        }					
	// 	$data['title'] = 'Penjual | Konfirmasi Pengiriman';
	// 	$data['id_konfirmasi'] = $id_konfirmasi;	
	// 	$this->load->view('penjual/v_header',$data);
	// 	$this->load->view('penjual/v_konfirmasi_pengiriman',$data);
	// 	$this->load->view('penjual/v_footer');
	// }

	function get_id($id_konfirmasi)
	{
		if($this->session->userdata('login_Penjual') != TRUE){
            show_404();
        }					
		$where = array('id_konfirmasi' =>  $id_konfirmasi);
		$get_id['id'] = $this->m_konfirmasi->get_id_pembeli($where)->result();
		foreach($get_id['id'] as $row){
			$id = $row->id_pembeli;
			return $id;
		}
	}

	function get_data($id)
	{
		if($this->session->userdata('login_Penjual') != TRUE){
            show_404();
        }					
		$data['pembeli'] = $this->m_pembeli->get_alamat($id)->result();
		return $data;
	}



	function notif_order()
	{
		if($this->session->userdata('login_Penjual') != TRUE){
            show_404();
        }					
		$cek = $this->M_transaksi->get_order_terbaru($this->session->userdata('id_penjual'));
		if($cek->num_rows()<>0)
		{
			echo "<span class='badge badge-pill badge-danger'>".$cek->num_rows()."</span>";
		}else{
			echo '';
		}

	}		

	function notif_click()
	{
		if($this->session->userdata('login_Penjual') != TRUE){
            show_404();
        }			
		$cek = $this->M_konfirmasi->get_order_terbaru($this->session->userdata('id_penjual'));
		if($cek->num_rows()>0)
		{
			$klik = site_url('/Penjual/order');
			$output = array('klik' => $klik, 'notif' => $cek->num_rows());
			echo json_encode($output);
		}else{
			return false;
		}

	}	

	

	function nama_penjual($id)
	{
		$data['penjual'] = $this->M_penjual->get_penjual($id)->result();
		return $data;
	}	
	



//===========================================================================Halaman Produk (Penjual)==========================================================================
	function produk_list()
	{

		$list = $this->M_produk->get_produk_query();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $produk) {
			$no++;
			$row = array();
			$row[] = $produk->nama;
			$row[] = $produk->harga;
			$row[] = $produk->berat;
			$row[] = $produk->stok;
			$row[] = $produk->tggl;
			if($produk->gambar)
				$row[] = '<a href="'.base_url('assets/foto/penjual/produk/'.$produk->gambar).'" target="_blank"><img src="'.base_url('assets/foto/penjual/produk/'.$produk->gambar).'" style="width:100%" /></a>';
			else
				$row[] = '(Tidak Ada Gambar)';

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$produk->id_produk."'".')"><i class="fa fa-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$produk->id_produk."'".')"><i class="fa fa-trash"></i> Hapus</a>';
		
			$data[] = $row;
		}

		$output = array(
					"draw" => $_POST['draw'],
					"recordsTotal" => $this->M_produk->count_all(),
					"recordsFiltered" => $this->M_produk->count_filtered(),
					"data" => $data,
				);
		echo json_encode($output);
	}

	function produk_edit($id)
	{
		$data = $this->M_produk->get_produk_by_id($id);
		echo json_encode($data);
	}

	function produk_add()
	{
		$this->_validate();
		
		$data = array(
				'id_produk' => $this->M_produk->id_produk(),
				'_id_penjual'=> $this->session->userdata('id_penjual'),
				'nama' => $this->input->post('nama'),
				'harga' => $this->input->post('harga'),
				'berat' => $this->input->post('berat'),
				'stok' => $this->input->post('stok'),
				'deskripsi' => $this->input->post('deskripsi'),
				'tggl' => date('Y-m-d')
			);

		if(!empty($_FILES['gambar']['name']))
		{
			$gambar = $this->_do_upload();

			$data['gambar'] = $gambar;
		}

		$insert = $this->M_produk->save($data);

		echo json_encode(array("status" => TRUE));
	}

	function produk_update()
	{
		if($this->session->userdata('login_Penjual') != TRUE){
            show_404();
        }			
		$this->_validate();
		$data = array(
				'nama' => $this->input->post('nama'),
				'harga' => $this->input->post('harga'),
				'berat' => $this->input->post('berat'),
				'stok' => $this->input->post('stok'),
				'deskripsi' => $this->input->post('deskripsi'),
				'tggl' => date('Y-m-d')
			);

		if($this->input->post('remove_photo')) // if remove photo checked
		{
			if(file_exists('assets/foto/penjual/produk/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
				unlink('assets/foto/penjual/produk/'.$this->input->post('remove_photo'));
			$data['gambar'] = '';
		}

		if(!empty($_FILES['gambar']['name']))
		{
            $gambar = $this->_do_upload();

			//delete file
			$produk = $this->M_produk->get_produk_by_id($this->input->post('id'));
			if(file_exists('assets/foto/penjual/produk/'.$produk->gambar) && $produk->gambar)
				unlink('assets/foto/penjual/produk/'.$produk->gambar);

			$data['gambar'] = $gambar;
		}
		$where = array('id_produk' => $this->input->post('id'));
		$this->M_produk->update($where, $data);
		echo json_encode(array("status" => TRUE));
	}

	public function produk_delete($id)
	{
		if($this->session->userdata('login_Penjual') != TRUE){
            show_404();
        }			
		//delete file
		$produk = $this->M_produk->get_produk_by_id($id);
		if(file_exists('assets/foto/produk/'.$produk->gambar) && $produk->gambar)
			unlink('assets/foto/produk/'.$produk->gambar);
		
		$this->M_produk->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	private function _do_upload()
	{
		if($this->session->userdata('login_Penjual') != TRUE){
            show_404();
        }			
		$nama_foto 	= "pr-".$this->session->userdata('id_penjual').time();
		$config['upload_path']	='./assets/foto/penjual/produk/';
		$config['allowed_types']='jpg|png|jpeg';
		$config['file_name']	= $nama_foto;
		$config['max_size']		= 3078;
        
        $this->upload->initialize($config);

        if(!$this->upload->do_upload('gambar')) //upload and validate
        {
            $data['inputerror'][] = 'gambar';
			$data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		$upload = $this->upload->data();

		//compress image
		$config['image_library']='gd2';
        $config['source_image']='./assets/foto/penjual/produk/'.$upload['file_name'];
        $config['create_thumb']= FALSE;
        $config['maintain_ratio']= FALSE;
        $config['quality']= '70%';
        $config['width']= 600;
        $config['height']= 350;
        $config['new_image']= './assets/foto/penjual/produk/'.$upload['file_name'];
        
        $this->load->library('image_lib', $config);

        $this->image_lib->resize();

        return $upload['file_name'];
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('harga') == '')
		{
			$data['inputerror'][] = 'harga';
			$data['error_string'][] = 'Harga is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('berat') == '')
		{
			$data['inputerror'][] = 'berat';
			$data['error_string'][] = 'Berat is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('stok') == '')
		{
			$data['inputerror'][] = 'stok';
			$data['error_string'][] = 'Stok is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('deskripsi') == '')
		{
			$data['inputerror'][] = 'deskripsi';
			$data['error_string'][] = 'deskripsi is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}		
	}	
//===========================================================================Halaman Produk (Penjual)==========================================================================	
}
?>