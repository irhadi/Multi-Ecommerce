<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keranjang extends CI_Controller {
	function __construct()
	{
		parent::__construct();
	}
	function tambah()
	{
		$id_toko = $this->input->post('id_toko');
		$toko_session = $this->input->post('toko');
		if($toko_session == '')
		{
			$this->session->set_userdata('toko', $id_toko);
		}
		else if($id_toko !== $toko_session){
			$this->cart->destroy();
			$this->session->set_userdata('toko', $id_toko);
		}
		
		$data  =  array (
	        'id'       	=> $this->input->post('id'), 
	        'name'     	=> $this->input->post('name'), 
	        'price'    	=> $this->input->post('price'), 
	        'pic'     	=> $this->input->post('pic'), 
	        'qty'  	  	=> $this->input->post('qty'),
	        'berat'    	=> $this->input->post('berat'),
	        'stok'    	=> $this->input->post('stok')
		);	
		
		if(count($this->cart->contents()) > 0)
		{			
			$cart = $this->cart->contents();
			foreach($cart as $c)
			{
				$c_id = $c['id'];
				$c_qty = $c['qty'];
			}
			$hitung = $c_qty + $this->input->post('qty');
			if($c_id == $this->input->post('id') && $hitung > $this->input->post('stok'))
			{					
				$output = "<small class='badge badge-pill badge-danger'>".count($this->cart->contents())."</small>";
				$response = array('status' => 'error', 'notif' => $output, 'pesan' => 'Maximal stok '.$this->input->post('stok'));
			}else{
				$this->cart->insert($data);
				$output = "<small class='badge badge-pill badge-danger'>".count($this->cart->contents())."</small>";
				$response = array('status' => 'success', 'notif' => $output, 'pesan' => 'Telah ditambahkan');
			}
		}else{
			if( $this->input->post('qty') < 1)
			{
				$response = array('status' => 'error', 'notif' => '', 'pesan' => 'stok harus diatas 0');
			}
			else if($this->input->post('qty') > $this->input->post('stok'))
			{
				$response = array('status' => 'error', 'notif' => '', 'pesan' => 'Melebihi stok yang tersedia');
			}else{
				$this->cart->insert($data);
				$output = "<small class='badge badge-pill badge-danger'>".count($this->cart->contents())."</small>";
				$response = array('status' => 'success', 'notif' => $output, 'pesan' => 'Telah ditambahkan');
			}			
		}
		echo json_encode($response);
	}
	
	function notif()
	{	
		$output='';
		$rows = count($this->cart->contents());
		if($rows > 0)
		{
			$output = "<small class='badge badge-pill badge-danger'>".$rows."</small>";
		}
		echo $output;

	}

	function tampil()
	{
		$output = '';
        $grand_total=0;
        $output .='
			<div class="modal-header">
	          <h4 class="modal-title">Keranjang</h4>
	          <button type="button" class="close" data-dismiss="modal">×</button>
	        </div>';
		
		$rows= count($this->cart->contents());
	    if($rows > 0)
	    {
			$output .='<div class="modal-body">
						<!--<div class="d-flex justify-content-between flex-wrap mb-1 flex-md-nowrap">
				            <h1 class="h5">Detail Keranjang</h1>
          					<button type="button" class="btn btn-danger hapus_semua"><i class="fa fa-trash-o" aria-hidden="true"></i> Hapus Semua</button>
			          	</div> -->
				            <div class="table-responsive-md">
				          		<table class="table table-sm table-borderless">
				          			';
	    	$cart= $this->cart->contents();
			foreach($cart as $item){
			 	$grand_total = $grand_total+($item['berat']*$item['qty']);
				$output .='	<tr>
			    		        <td align="center"><img width="120" class="rounded" src="'.base_url().'assets/foto/penjual/produk/'.$item["pic"].'"/>
			    		        	<br>'.$item['name'].'
			    		        </td>
		        		        <td align="right" class="float-right" style="max-width:130px">
									<div class="input-group">
								    <input type="number" max="'.$item['stok'].'" class="form-control" name="qty" style="min-width:40px;max-width:70px" value="'.$item["qty"].'" id="update'.$item['id'].'"/>    
								    <div class="input-group-append">
								      <button type="button" class="btn btn-primary btn-sm update" data-id="'.$item['id'].'" data-row="'.$item["rowid"].'"
		                          	> <i class="fa fa-pencil" aria-hidden="true"> </i> </button> 
								    </div>
								  </div>'		        		        
		        		        	.$item['berat']*$item["qty"].' gram<br>Rp'
		        		        	.number_format($item['price']*$item["qty"],0,",",".").'
		        		        </td>
		        		        <td align="right">
		    		          		<button type="button" class="btn btn-sm btn-danger hapus" data-row="'.$item["rowid"].'">
		                          	<i class="fa fa-times" style="font-size:20px"></i></button>              
		        		        </td>
		    		       </tr>';
			}
			$output.= '		<tr class="border-top" align="left">
			                  <td colspan="1"></td>
			                  <td>Total Berat</td>
			                  <td align="right">'.$grand_total.' gram</td>
			                </tr>                    
			                <tr align="left">
			                  <td colspan="1"></td>
			                  <td>Sub Total Harga</td>
			                  <td align="right">Rp'.$total_harga = number_format($this->cart->total(),0,",",".").'</td>
			                </tr>                		
                	</table>
               	</div>
            </div>

        <div class="modal-footer">';


        $output .= '<a class="btn btn-success" href="'.site_url().'/Checkout">Lanjutkan Pemesanan <i class="fa fa-angle-double-right"></i></a>
        			</div></form>';


		}else{
			$output .= '
			<div class="modal-body">
			<div class="container">
					<div class="col">
						<img src="'.base_url().'assets/img/icon/cartEmpty.png" class="mx-auto d-block" width="150"></div>
						<h3 class="h4 pt-4 text-center">Keranjang anda kosong</h3>
					</div>
				</div>
			</div>
			</div>
	        <div class="modal-footer">
	         	<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
	        </div>
			';
		}
		$output .= '</div>
					';
		echo $output;
	}

	function update()
	{
		$cart = $this->cart->contents();
		foreach($cart as $c)
		{
			$c_rowid = $c['rowid'];
			$c_qty = $c['qty'];
			$c_stok = $c['stok'];
		}
		$data = array(
			'rowid' => $this->input->post('rowid'),
			'qty' => $this->input->post('qty')
		);

		if($c_rowid === $this->input->post('rowid') && $this->input->post('qty') > $c_stok)
		{	
			$max = "Stok Maximal ".$c_stok;
			$response = array('status' => 'error', 'notif' => $max);
		}else{
			$this->cart->update($data);
			$response = array('status' => 'success', 'notif' => 'telah diupdate');
		}
	   	echo json_encode($response);
	}	

	function hapus_semua()
	{
		$this->cart->destroy();
		$this->session->unset_userdata('toko');
		$this->tampil();
	}

	function hapus()
	{
		$rowid = $this->input->post('rowid');
		$data = array(
			'rowid' => $rowid, 
			'qty' => 0 
		);
		$this->cart->update($data);
		
		$rows = count($this->cart->contents());
		if($rows == 0){
			$this->session->unset_userdata('toko');
		}
		$this->tampil();
	}	
}
?>