<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {
	public $CI = NULL;
	function __construct()
	{
		parent::__construct();
		$this->CI = & get_instance();	
		$this->load->library('Rajaongkir');
		if($this->session->userdata('login_Pembeli')!=TRUE){
			$pesan = array('type'=>'info', 'title' => 'Anda harus login!', 'pesan' => '');
			$this->session->set_flashdata('swal', $pesan);
			redirect(site_url('/Login'));
		}				
	}
	
	function index(){
		$id_pembeli = $this->session->userdata('id_pembeli');
		$rajaongkir =$this->rajaongkir->province();
		$json = json_decode($rajaongkir, TRUE);
		$data['province'] = $json['rajaongkir']['results'];
		$data['alamat'] = $this->M_pembeli->get_pembeli($id_pembeli)->result();
		$this->load->view('header', $data);
		$this->load->view('form_alamat', $data);
		$this->load->view('footer');
	}
	
	function kota($id){
		$rajaongkir =$this->rajaongkir->city($id);
		$json = json_decode($rajaongkir, TRUE);
		$data = $json['rajaongkir']['results'];

		$option = "<option>---Pilih Kota---</option>";
		foreach($data as $d){
			$option .="<option data-kota='".$d['city_name']."'value='".$d['city_id']."'>".$d['city_name']."</option>";
		}
		echo $option;
	}

	// function ongkir($id, $berat){
	// 	$rajaongkir =$this->rajaongkir->cost(501, $id, $berat,'jne');
	// 	$json = json_decode($rajaongkir, TRUE);
	// 	$data = $json['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value'];
	// 	return $data;
	// }

	function tarif_layanan($tujuan, $berat, $kurir){
		$asal = 501;
		$tarif = $this->_api_ongkir_post( $asal ,$tujuan, $berat, $kurir);		
		$data = json_decode($tarif, true);
		echo json_encode($data['rajaongkir']['results']);
	}

	function simpan_alamat(){
		
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		$this->form_validation->set_rules('nama', 'Nama', 'required|min_length[3]');			
		$this->form_validation->set_rules('nohp', 'Nomor Hp', 'required|is_numeric|min_length[11]');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required|min_length[20]');
		$this->form_validation->set_rules('nama_prov', 'Provinsi', 'required');
		$this->form_validation->set_rules('nama_kota', 'Kota', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
			$id = $this->session->userdata('id_pembeli');
			$nama 	= $this->input->post('nama');
			$nohp 	= $this->input->post('nohp');
			$prov 	= $this->input->post('nama_prov'); 
			$kota 	= $this->input->post('nama_kota');
			$id_kota= $this->input->post('kota');
			$alamat = $this->input->post('alamat');
			$alamat_lengkap = $alamat."_".$kota."_".$prov.".";
			$data = array(
				"nama"		=> $nama,
				"notelp" 	=> $nohp,
				"alamat" 	=> $alamat_lengkap,
				"kota" 		=> $id_kota
			);
			$this->M_pembeli->insert_alamat($id, $data);
			redirect(site_url().'/Checkout/pemesanan');
		}
	}

	function edit_alamat(){
		$id = $this->session->userdata('id_pembeli');
		$rajaongkir =$this->rajaongkir->province();
		$json = json_decode($rajaongkir, TRUE);
		$data['province'] = $json['rajaongkir']['results'];
		$data['alamat'] = $this->M_pembeli->get_pembeli($id)->result();
		$data['title'] = "Edit Alamat";
		$this->load->view('header',$data);
		$this->load->view('edit_alamat',$data);
		$this->load->view('footer');
	}

	function pemesanan(){
		// if(count($this->cart->contents()) < 0){
		// 	$pesan = array('title' => 'Keranjang kosong!', 'pesan' => 'silahkan pilih produk dahulu.');
		// 	$this->session->set_flashdata('popup_warning', $pesan);
		// 	redirect(site_url('/Web'));
		// }
		$data['title'] = "Pemesanan";
		$id_pembeli = $this->session->userdata('id_pembeli');
		$id_penjual = $this->session->userdata('toko');
		$data['alamat'] = $this->M_pembeli->get_pembeli($id_pembeli)->result();

		$where = array(
			'id_pembeli' => $id_pembeli,
			'status_transaksi' => 'baru'
		);
		$data['cek_order'] = $this->M_transaksi->cek_order($where)->num_rows();
		$query = '';
		$data['rekening'] = $this->M_rekening->get_rekening($query)->result();		
		$this->load->view('header',$data);
		$this->load->view('pemesanan',$data);
		$this->load->view('footer');
	}
	function simpan_order()
	{
		$id_pembeli = $this->session->userdata('id_pembeli');
		$id_penjual = $this->session->userdata('toko');
		$id_transaksi = $this->M_transaksi->id_transaksi();

		// $tggl = date('Y-m-d H:i:s');
        // $date = date_create($tggl);
        // date_add($date, date_interval_create_from_date_string('24 hours'));  
        // date_format($date, 'Y-m-d H:i:s')
		$data_transaksi = array(
			'id_transaksi' 	=> $id_transaksi,
			'id_penjual' 	=> $id_penjual,
			'id_pembeli' 	=> $id_pembeli,
			'id_rekening' 	=> $this->input->post('id_rekening'),
			'kode_unik' 	=> $this->input->post('unik'),
			'total_order' 	=> $this->input->post('total'),
			'kurir' 		=> $this->input->post('kurir'),
			'layanan' 		=> $this->input->post('layanan'),
			'ongkir' 		=> $this->input->post('ongkir'),
			'waktu_order'	=> date('Y-m-d H:i:s'),
			'status_transaksi' => 'baru'
		);
		$this->M_transaksi->simpan_transaksi($data_transaksi);

		foreach($this->cart->contents() as $cart){
			$data_order = array(
				'id_transaksi' => $id_transaksi,
				'id_produk' => $cart['id'],
				'nama' => $cart['name'],				
				'qty' => $cart['qty'],
				'harga_satuan' => $cart['price'],
				'total_harga' => $cart['price']*$cart['qty']
			);	
			
		$this->M_order->simpan_order($data_order);
		}
		
		$order = $this->M_order->get_order($id_transaksi);
		foreach($order->result() as $o){
			$id_produk = $o->id_produk;
			$stok = $o->qty;
			$this->M_produk->update_stok($id_produk, $stok);
		}

		$this->cart->destroy();
		$this->session->unset_userdata('toko');

		//Kirim invoice
		$data['transaksi'] = $this->M_transaksi->get_data_transaksi($id_transaksi)->result();
		$data['order'] 		= $this->M_order->get_order($id_transaksi)->result();	

		$subject = "INVOICE";
		$message = $this->load->view('template/email/invoice_to_pembeli', $data, TRUE);

	  	$this->load->library('email');	    
	    //konfigurasi pengiriman
	    $this->email->from('Multi E-Commerce');
	    $this->email->to($this->session->userdata('email_pembeli'));
	    $this->email->subject($subject);
	    $this->email->message($message);
	    $this->email->send();

		redirect(site_url('/Checkout/pembayaran/'.$id_transaksi));
	}


	function upload_bukti($id_transaksi)
	{
		$nama_foto 	= "BP/".$id_transaksi."/".time();		
		$config['upload_path']	='./assets/foto/transaksi/buktipembayaran/';
		$config['allowed_types']='jpg|jpeg';
		$config['file_name']	= $nama_foto;
		$config['max_size']		= 3072;
		$this->upload->initialize($config);

		if(!$this->upload->do_upload('struk'))
		{
			$pesan = array('type' => 'error', 'title' => 'Upload!', 'pesan' => $this->upload->display_errors());
			$this->session->set_flashdata('swal', $pesan);
			$this->pembayaran($id_transaksi);
		}
		else{
			$foto = $this->upload->data('file_name');
			$data = array(
				'waktu_konfir_pembayaran' => date('Y-m-d H:i:s'),
				'status_transaksi' => 'konfirpembayaran',
				'bukti_pembayaran' => $foto
			);
			$this->M_transaksi->update($id_transaksi, $data);
			redirect(site_url('/Checkout/Sukses'));
		}
	}

	function pembayaran($id_transaksi)
	{ 
		$data['transaksi'] = $this->M_transaksi->get_data_transaksi($id_transaksi)->result();
		$data['title'] = 'Pembayaran';
		$this->load->view('header',$data);
		$this->load->view('pembayaran',$data);
		$this->load->view('footer');
	}

	function sukses()
	{	
		$data['title'] = 'Pembayaran Berhasil';
		$this->load->view('header', $data);
		$this->load->view('sukses');
		$this->load->view('footer');
	}	

	function invoice($id_transaksi)
	{	
		$data['transaksi'] = $this->M_transaksi->get_data_transaksi($id_transaksi)->result();
		$data['order'] 		= $this->M_order->get_order($id_transaksi)->result();	
		$this->load->view('template/email/invoice_to_pembeli', $data);
	}

	function hapus_pemesanan()
	{
		$id_transaksi = $this->input->post('id');
		$get_data_order = $this->M_order->get_row_order_by_id_transaksi($id_transaksi);
		foreach($get_data_order->result() as $data_order){
			 $id = $data_order->id_produk; //ambil id_produk
			 $stok = $data_order->qty; //dan stok
			 $update_stok = $this->M_produk->kembalikan_stok($id, $stok);//jalankan query untuk mengembalikan stok
		}
		$data = $this->M_transaksi->hapus($id_transaksi);
		echo site_url('/Web/transaksi');
	}

	public function get_bank($id)
	{
		$where = array('id_rekening' => $id);
		$getbank = $this->M_rekening->get_rekening($where)->result();
		foreach($getbank as $bank){
		$output = "<img src='".base_url()."assets/img/icon/".$bank->logo_bank."' height='30'>
				<br>				
				Atas Nama : <b>".$bank->an_rek."</b><br>				
				Nomor Rekening : <b>".$bank->no_rek."</b>";
		return $output;
		}
	}	

	function _api_ongkir_post($asal ,$tujuan, $berat, $kurir)
   	{
  	  $curl = curl_init();
	  curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "origin=".$asal."&destination=".$tujuan."&weight=".$berat."&courier=".$kurir,	  
	  CURLOPT_HTTPHEADER => array(
	    "content-type: application/x-www-form-urlencoded",
	    /* masukan api key disini*/
	    "key: b32aff4c84b8c5e69aed7ed97cc37420"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  return $err;
		} else {
		  return $response;
		}
   }
}