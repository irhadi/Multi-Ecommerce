<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends CI_Controller{
	public $CI = NULL;
	function __construct()
	{
		parent::__construct();
		$this->CI = & get_instance();
		$this->refund();
	}

	private function refund()
	{
		$transaksi = $this->M_transaksi->refund()->result();	
    	foreach ($transaksi as $t) {	    		
			$sekarang = date('Y-m-d H:i:s');
			$date = date_create($t->waktu_konfir_pembayaran);
			$kadaluarsa = date_add($date, date_interval_create_from_date_string('24 hours'));
			$exp = date_format($kadaluarsa, 'Y-m-d H:i:s');	 

			$id = $t->id_transaksi;
			$email = $t->email;
			$totalbayar = $t->total_order+$t->kode_unik+$t->ongkir;
			$time = $t->waktu_order;
			
			if($exp < $sekarang){			
				$this->M_transaksi->update_refund($id);
				$konfir['invoice'] = $id;
				$konfir['total'] = "Rp".number_format($totalbayar,0,",",".");
				$konfir['time'] = $time;
				$subject = "PENGEMBALIAN DANA";
				$message = $this->load->view('template/email/refund', $konfir, TRUE);
				
			  	$this->load->library('email');
			    $this->email->from('Multi E-Commerce');
			    $this->email->to($email);
			    $this->email->subject($subject);
			    $this->email->message($message);
				$this->email->send(TRUE);				
			}		
    	}		
	}

	function index()
	{	
		$data['title'] = 'MULTI E-COMMERCE';
		$this->load->view('header',$data);
		$this->load->view('beranda');
		$this->load->view('footer');
	}

	function get_list_penjual()
	{
		$output = '';
		$query = '';
		if($this->input->post('query'))
		{
			$query = $this->input->post('query');
		}
		$data = $this->M_penjual->get_list_penjual($query);
		$output = '<div class="row text-center">';
		if($data->num_rows() != 0)
		{
			foreach ($data->result() as $p) {
			# menampilkan data penjual
	     	$output .='
	          <div class="col-lg-3 col-md-4 col-sm-6">
	            <div class="card mb-3 border">
	              <img class="card-img-top img-fluid" src="'.base_url().'assets/foto/penjual/logo/'.$p->logo_toko.'" alt="Card image cap">
	              <div class="card-body">
	                <h3 class="h4 text-uppercase">'.$p->nama_toko.'</h3>
	                <p class="card-text">
	                  <small class="text-muted"><i class="fa fa-user-circle-o"></i> '.$p->nama_penjual.'</small>
	                  &nbsp;&nbsp;
	                  <small class="text-muted">Produk '.$this->total_produk($p->id_penjual).'</small>
	                </p>
	                <a class="btn btn-block btn-primary" href="'.site_url().'/Web/produk/'.$p->slug_penjual.'"><i class="fa fa-sign-in"></i> Masuk</a>
	              </div>
	            </div>
	          </div>';
	    	}
		}
		else
		{
			$output = '<div class="col-md-12 text-center"><h1 class="h4">Penjual tidak ditemukan</h1></div>';
		}
		$output .= '</div>';

		echo $output;
	}

	function info_penjual($slug)
	{
		$output ='';
		
		$info = $this->M_penjual->get_info_penjual($slug)->result();
		foreach ($info as $i) {
			$output .='
				  <img src="'.base_url().'assets/foto/penjual/logo/'.$i->logo_toko.'" alt="John" style="width:100%">
				  <div class="pt-2 mb-2">
				  	<div class="p-2 lead">
					  <h3>'.$i->nama_toko.'</h3>
					  <i class="fa fa-user-circle"></i> <b>'.$i->nama_penjual.'</b><br>
					  <i class="fa fa-map-marker"></i> '.$i->alamat.'<br>
					  <i class="fa fa-phone"></i> <span id="kontak"> '.$i->notelp.'</span> <span style="cursor:pointer"><i class="fa fa-clone fa-md copy" style="color:#000;"></i></span>
					</div>
					  <p><button class="np" id="info_penjual">Tutup</button></p>
				  <div>
			';
		}
		echo $output;
	}	
function produk($slug)
{	
	$data['title1'] = $this->M_penjual->Nama_Toko($slug);
	$get_id = $this->M_penjual->get_id($slug);
	$data['totpro'] = $this->total_produk($get_id);
	$this->load->view('header', $data);
	$this->load->view('list_produk', $data);
	$this->load->view('footer');
}	

function get_list_produk()
{
	$output = '';
	$query = '';

	$get_id = $this->M_penjual->get_id($this->input->post('slug'));

	$id = $get_id;
	if($this->input->post('query'))
	{
		$query = $this->input->post('query');
	}
	$data = $this->M_produk->get_produk($id, $query);
	$output = '<div class="row mb-3">';
	if($data->num_rows() > 0)
	{
		foreach ($data->result() as $pr) {
		$toko_s = $this->session->userdata('toko');
     	$output .='
          <div class="col-lg-3 col-md-4 col-sm-6">
              <div class="card border bg-white">
                <img alt="'.$pr->nama.'" src="'.base_url().'assets/foto/penjual/produk/'.$pr->gambar.'" class="card-img-top img-fluid">
                <div class="card-body">
                  <h3 class="h4 card-title text-uppercase">'.$pr->nama.'</h3>
                  <div class="row mb-2">
                    <div class="col-sm-12">
                    	<h1 class="h5 p-0" style="color:#ff751a;">Rp'.number_format($pr->harga,0,",",".").'</h1>
                    	<small class="text-muted">
                    		<div class="float-left">Stok : '.$pr->stok.'</div>
                    		<div class="float-right">Terjual : '.$this->terjual($pr->id_produk).'</div>
                    		
                    	</small>
                    </div>
                  </div>
                  <div class="input-group">
					  <input type="number" max="'.$pr->stok.'" class="form-control" name="qty" value="1" id="'.$pr->id_produk.'"/>
					  <div class="input-group-append">
					    <button class="btn btn-success add" 
		                    data-idtoko="'.$pr->_id_penjual.'"
		                    data-id="'.$pr->id_produk.'"
		                    data-name="'.$pr->nama.'"
		                    data-price="'.$pr->harga.'"
		                    data-pic="'.$pr->gambar.'"
		                    data-berat="'.$pr->berat.'"
		                    data-stok="'.$pr->stok.'"
		                    >&nbsp;<i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp; 
		                </button> 
		                <button class="btn btn-info detail" data-id="'.$pr->id_produk.'">Detail</button>
					  </div>
				  </div>	                 	                  
                </div>
			  </div>
          </div>';
    	}
	}
	else
	{
		$output = '<div class="col-md-12 text-center"><h1 class="h4">Produk tidak ditemukan</h1></div>';
	}
	$output .= '</div>';

	echo $output;
}

function terjual($id)
{
	$terjual = $this->M_order->get_stok_terjual($id)->row();
	return $terjual->tot;
}

function detail_produk($id){
    $output = '';
    $detail = $this->M_produk->get_detail($id)->result();
    foreach($detail as $d)
    {
    	$output .='
    	<div class="modal-header">
          <h4 class="modal-title">'.$d->nama.'</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        	<div class="row">
        		<div class="col-md-7">
        			<img src="'.base_url().'assets/foto/penjual/produk/'.$d->gambar.'" class="img-fluid rounded">
        		</div>
        		<div class="col-md-5">
        			<table class="">
	        			<tr>
	        				<td>
	        					<h4 class="" style="color:#ff751a">Rp'.number_format($d->harga,0,",",".").'</h4>
	        				</td>
	        			</tr>	        			
	        			<tr>
	        				<td>
	        					<p class="text-muted">Stok '.$d->stok.'</p>
	        				</td>
						<tr>
						</tr>        					        				
	        				<td>
	        					<p class="text-muted">Berat : '.$d->berat.' gram</p>
	        				</td>
	        			</tr>								
	        			</tr>        					        				
	        				<td>
	        					<p class="text-muted">Upload : '.$this->tanggal_indo($d->tggl, true).'</p>
	        				</td>
	        			</tr>	       
        			</table>
        		</div>
        	</div>
        	<hr>
        	<div class="row">
        		<div class="col-sm-12">'.$d->deskripsi.'</div>
        	</div>
	   	</div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>';
    }
    echo $output;
}

function total_produk($id)
{
	$tot = $this->M_produk->get_total_produk($id)->num_rows();
	return $tot;
}

	function tanggal_indo($tanggal, $cetak_hari = false)
	{
		$hari = array ( 1 =>    'Senin',
					'Selasa',
					'Rabu',
					'Kamis',
					'Jumat',
					'Sabtu',
					'Minggu'
				);
				
		$bulan = array (1 =>   'Januari',
					'Februari',
					'Maret',
					'April',
					'Mei',
					'Juni',
					'Juli',
					'Agustus',
					'September',
					'Oktober',
					'November',
					'Desember'
				);
		$split 	  = explode('-', $tanggal);
		$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
		
		if ($cetak_hari) {
			$num = date('N', strtotime($tanggal));
			return $hari[$num] . ', ' . $tgl_indo;
		}
		return $tgl_indo;
	}      

	function keluar(){
		$hapus_session = array('id_pembeli', 'email_pembeli', 'login_Pembeli');
		$this->session->unset_userdata($hapus_session);
		redirect(site_url());
	}	 

	function ganti_password()
	{
		if($this->session->userdata('login_Pembeli')!=TRUE){
			show_404();
		}			
		$header['title'] = 'Ganti Password';
		$this->load->view('header',$header);
		$this->load->view('ganti_password');
		$this->load->view('footer');	
	}

	function cek_ganti_password()
	{
		if($this->session->userdata('login_Pembeli')!=TRUE){
			show_404();
		}				
		$id_pembeli = $this->session->userdata('id_pembeli');
		

		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');	
		$this->form_validation->set_rules('passold', 'Password Lama', 'required|min_length[8]');
		$this->form_validation->set_rules('passnew', 'Password Baru', 'required|min_length[8]');
		$this->form_validation->set_rules('repassnew', 'Konfirmasi Password Baru', 'required|matches[passnew]');
		
        if ($this->form_validation->run() == TRUE)
        {
        	$passwordold = md5($this->input->post('passold'));
			$passwordnew = md5($this->input->post('repassnew'));
	        $id_pembeli = $this->session->userdata('id_pembeli');

	        $tetap_login = $this->input->post('check');

	        $cekpasssword = $this->M_pembeli->cek_password_lama($id_pembeli, $passwordold)->num_rows();
		    if($cekpasssword >= 1)
		    {
		    	$update = $this->M_pembeli->update( $id_pembeli, $passwordnew);
		    	$pesan = array('type' => 'success', 'title' => 'Sukses','pesan' => 'Berhasil Mengganti Password');
				$this->session->set_flashdata('swaltimer', $pesan);
				if($tetap_login == '1')
				{
					$this->ganti_password();
				}else{
					$this->keluar();
				}
		    }else{
		    	$pesan = array('type' => 'error', 'title' => 'Gagal!','pesan' => 'Password lama tidak cocok');
				$this->session->set_flashdata('swal', $pesan);
				$this->ganti_password();
		    }
		}
		$this->ganti_password();
    }

	function transaksi()
	{
		if($this->session->userdata('login_Pembeli')!=TRUE){
			redirect(site_url('/Login'));
		}else{
			$header['title'] = 'Transaksi';
			$where = array(
	    		'id_pembeli' => $this->session->userdata('id_pembeli')
	    	);
			$data['order']=$this->M_transaksi->get_order_pembeli($where)->result();
			$this->load->view('header',$header);
			$this->load->view('transaksi',$data);
			$this->load->view('footer');
		}
	} 
	
	function detail($id_transaksi)
	{
		if($this->session->userdata('login_Pembeli')!=TRUE){
			redirect(site_url('/Login'));
		}else{		
			$id_pembeli = $this->session->userdata('id_pembeli');
			$data['transaksi'] = $this->M_transaksi->get_data_transaksi($id_transaksi)->result();
			$data['order'] 		= $this->M_order->get_order($id_transaksi)->result();
			$header['title'] = 'Detail Transaksi';
			$this->load->view('header',$header);
			$this->load->view('detail',$data);
			$this->load->view('footer');
		}			
	}	

	function invoice($id_transaksi)
	{
		if($this->session->userdata('login_Pembeli')!=TRUE){
			show_404();
		}else{		
			$id_pembeli = $this->session->userdata('id_pembeli');
			$data['transaksi'] = $this->M_transaksi->get_data_transaksi($id_transaksi)->result();
			$data['order'] 		= $this->M_order->get_order($id_transaksi)->result();
			$header['title'] = 'Invoice';
			$this->load->view('header',$header);
			$this->load->view('template/email/invoice_to_pembeli',$data);
			$this->load->view('footer');
		}			
	}



	public function tampil_bank()
	{
		$get_bank = $this->M_rekening->get_rekening('');

		$data = array();

		foreach($get_bank->result() as $bank) {
			$data[] = "<td><span class='badge badge-light border'><img title='".$bank->nm_bank."' src='".base_url('assets/img/icon/'.$bank->logo_bank)."'height='20'></span></td>";
		}

		for($i=0; $i < count($data); $i++){
			echo $data[$i]; 
		}

	}

	function tentang()
	{
		$this->load->view('tentang');
	}

}
?>
