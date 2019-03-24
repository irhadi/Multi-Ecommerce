<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->library('Rajaongkir');
		if($this->session->userdata('login_Pembeli')!=TRUE){
			$pesan = array('title' => 'Anda harus login!', 'pesan' => 'Lanjut ke pemesanan harus login dulu.');
			$this->session->set_flashdata('popup_warning', $pesan);
			redirect(site_url('/Web'));
		}				
	}
	
	function index(){
		$id_pembeli = $this->session->userdata('id_pembeli');
		$rajaongkir =$this->Rajaongkir->province();
		$json = json_decode($rajaongkir, TRUE);
		$data['province'] = $json['Rajaongkir']['results'];
		$data['alamat'] = $this->M_pembeli->get_pembeli($id_pembeli)->result();
		$this->load->view('header', $data);
		$this->load->view('form_alamat', $data);
		$this->load->view('footer');
	}
	function kota($id){
		$rajaongkir =$this->rajaongkir->city($id);
		$json = json_decode($rajaongkir, TRUE);
		$data = $json['Rajaongkir']['results'];

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
		echo json_encode($data['Rajaongkir']['results']);
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
		if(count($this->cart->contents()) < 0){
			$pesan = array('title' => 'Keranjang kosong!', 'pesan' => 'silahkan pilih produk dahulu.');
			$this->session->set_flashdata('popup_warning', $pesan);
			redirect(site_url('/Web'));
		}
		$data['title'] = "Pemesanan";
		$id = $this->session->userdata('id_pembeli');
		$id_penjual = $this->session->userdata('toko');
		$data['alamat'] = $this->M_pembeli->get_pembeli($id)->result();
		$data['cek_order'] = $this->M_auth->cek_order($id, $id_penjual)->num_rows();
		$this->load->view('header',$data);
		$this->load->view('pemesanan',$data);
		$this->load->view('footer');
	}
	function simpan_order()
	{
		$id_pembeli = $this->session->userdata('id_pembeli');
		$id_penjual = $this->session->userdata('toko');
		$id_konfirmasi = $this->M_konfirmasi->id_konfirmasi();

		$tggl = date('Y-m-d H:i:s');
        $date = date_create($tggl);
        date_add($date, date_interval_create_from_date_string('24 hours'));  

		$data_konfirmasi = array(
			'id_konfirmasi' => $id_konfirmasi,
			'id_penjual' 	=> $id_penjual,
			'id_pembeli' 	=> $id_pembeli,
			'kode_unik' 	=> $this->input->post('unik'),
			'total_pesanan' => $this->input->post('total'),
			'kurir' 		=> $this->input->post('kurir'),
			'layanan' 		=> $this->input->post('layanan'),
			'ongkir' 		=> $this->input->post('ongkir'),
			'tggl' 			=> date_format($date, 'Y-m-d H:i:s')
		);
		$this->M_auth->insert_konfirmasi($data_konfirmasi);

		foreach($this->cart->contents() as $cart){
			$data_order = array(
				'id_konfirmasi' => $id_konfirmasi,
				'id_produk' => $cart['id'],
				'nama_produk' => $cart['name'],				
				'jumlah_produk' => $cart['qty'],
				'total_harga' => $cart['price']*$cart['qty']
			);	
		$this->M_auth->insert_order($data_order);
		}

		$order = $this->M_order->ambil_data($id_konfirmasi);
		foreach($order->result() as $o){
			$id_produk = $o->id_produk;
			$stok = $o->jumlah_produk;
			$this->M_produk->update_stok($id_produk, $stok);
		}

		$this->cart->destroy();
		$this->session->unset_userdata('toko');
		redirect(site_url('/Checkout/pembayaran/'.$id_konfirmasi));
	}
	function update_konfirmasi($id_konfirmasi)
	{
		$nama_foto 	= "ft-".$id_konfirmasi.time();		
		$config['upload_path']	='./assets/foto/struk/';
		$config['allowed_types']='jpg|jpeg';
		$config['file_name']	= $nama_foto;
		$config['max_size']		= 3072;
		$this->upload->initialize($config);

		if(!$this->upload->do_upload('struk'))
		{
			$pesan = array('title' => 'Gagal', 'pesan' => $this->upload->display_errors());
			$this->session->set_flashdata('popup_error', $pesan);
			$this->pembayaran($id_konfirmasi);
		}
		else{
			$foto = $this->upload->data('file_name');
			$data = array(
				'tggl' => date('Y-m-d H:i:s'),
				'ft_struk_transfer' => $foto,
				'status' => 1
			);
			$this->M_konfirmasi->update($id_konfirmasi, $data);
			// $order = $this->M_order->ambil_data($id_konfirmasi);
			// foreach($order->result() as $o){
			// 	$id_produk = $o->id_produk;
			// 	$stok = $o->jumlah_produk;

			// 	$this->M_produk->update_stok($id_produk, $stok);
			// }
			redirect(site_url('/Checkout/Sukses'));
		}
	}

	function pembayaran($id_konfirmasi)
	{
		$get_konfirmasi = $this->M_konfirmasi->get_konfirmasi($id_konfirmasi)->result();
		$data['konfirmasi'] = $get_konfirmasi;
		foreach ($get_konfirmasi as $k) {
			 	$get_penjual = $this->M_penjual->get_penjual($k->id_penjual)->result();
		}
		$data['penjual'] = $get_penjual;
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

	public function show_button($id_konfirmasi)
	{
		$button = '';
		$status = $this->M_konfirmasi->get_konfirmasi($id_konfirmasi);

		foreach ($status->result() as $s) {
			$get = $s->status;
			$nr = $s->nomor_resi;
		}

		if($get == 0){
			$button .= '<button class="btn btn-danger" id="hapus_pemesanan">Batalkan Pemesanan</button> ';
			$button .= '<a href="'.site_url('/Checkout/pembayaran/'.$id_konfirmasi).'" class="btn btn-primary">Konfirmasi Pembayaran</a> ';

		}else if ($get == 2) {
			$button .= '<p class="text-center">Transaksi Selesai</p>';
		}else{
			$cek = $this->cek_data_laporan($id_konfirmasi);
			if($cek == 0){
			  $button .= '<button class="btn btn-danger" data-toggle="modal" data-target="#ModalLaporkan" role="button" aria-haspopup="true" aria-expanded="false">
			    Laporkan Penjual
			  </button>';
			}else{
			   $button .= '<button type="button" class="btn btn-danger" disabled>Telah di laporkan</button>';
			}
		}
		echo $button;
	}

	function simpan_laporan_pembeli()
	{		
		$data = array(
			'id_konfirmasi' => $this->input->post('id_konfirmasi'),
			'id_penjual' => $this->input->post('id_penjual'),
			'id_pembeli' => $this->input->post('id_pembeli'),
			'isi_laporan' => $this->input->post('isi_laporan'),
			'tgglwaktu' => date('Y-m-d h:i:s'),
			'status' => 0
		);
		$this->M_laporkan->simpan($data);
		$this->show_button($this->input->post('id_konfirmasi'));
	}

	function hapus_pemesanan()
	{
		$id_konfirmasi = $this->input->post('id');
		
		//ambil data order
		$get_data_order = $this->M_order->get_row_order_by_id_konfirmasi($id_konfirmasi);
		foreach($get_data_order->result() as $data_order){
			 $id = $data_order->id_produk; //ambil id_produk
			 $qty = $data_order->jumlah_produk; //dan jumlah produk

			 $update_stok = $this->M_produk->kembalikan_stok($id, $qty);//jalankan query untuk mengembalikan stok
		}
		$data = $this->M_konfirmasi->hapus($id_konfirmasi);
		echo site_url('/Web/transaksi');
	}

	function cek_data_laporan($id_konfirmasi)
	{
		$id_pembeli = $this->session->userdata('id_pembeli');
		return $this->M_laporkan->cek_laporan($id_konfirmasi, $id_pembeli)->num_rows();
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