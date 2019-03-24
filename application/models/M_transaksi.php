<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class M_transaksi extends CI_Model{
		var $table = 't_transaksi';
		var $column_order = array(null, 'id_penjual','tggl','status'); //set column field database for datatable orderable
		var $column_search = array('id_penjual','tggl','status'); //set column field database for datatable searchable 
		var $order = array('id_transaksi' => 'asc'); // default order 

		function __construct(){
			parent::__construct();
		}

		function id_transaksi() {
	        $this->db->select('RIGHT(id_transaksi,2) as kode', FALSE);
	        $this->db->order_by('id_transaksi', 'DESC');
	        $this->db->limit(1);
	        $query = $this->db->get($this->table);      //cek dulu apakah ada sudah ada kode di tabel.    
	        if ($query->num_rows() <> 0) {
	            $data = $query->row();
	            $kode = intval($data->kode) + 1;
	        } else {
	            $kode = 1;
	        }
	        $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);
	        $kodejadi = "TID" . $kodemax;
	        return $kodejadi;
	    }

		function simpan_transaksi($data){
			$this->db->insert($this->table, $data);
		}

		function update($id_transaksi, $data){
			$where=array('id_transaksi' => $id_transaksi);
			try{
				$this->db->where($where)->limit(1)->update($this->table, $data);
				return true;
			}catch(Exception $e){
				return $e;
			}
		}
		
		function cek_order($where){
			$this->db->where($where);
			return $this->db->get($this->table);
			$query = $this->db->query("SELECT * FROM t_transaksi where id_pembeli='$id_pembeli' and status_transaksi = 'dibayar'");
			 $query;
		}

//======================================Pembeli===========================================
		function get_order_pembeli($where)
	    {	    	

			$this->db->where($where);
			$this->db->join('t_penjual', 't_penjual.id_penjual = t_transaksi.id_penjual');
			$this->db->order_by('waktu_order', 'ASC');	
			return $this->db->get($this->table); 	
	    }	

		function get_data_transaksi($id)
		{	
			$where = array('tr.id_transaksi' => $id);
			$this->db->from('t_transaksi as tr');
			$this->db->where($where);		
			$this->db->join('t_pembeli as tp', 'tp.id_pembeli = tr.id_pembeli');	
			$this->db->join('t_rekening as trek', 'trek.id_rekening = trek.id_rekening');	
			return $this->db->get();
		}	    
//======================================Pembeli===========================================





//=======================================ADMIN============================================



	    function get_id_pembeli($where)
	    {
	    	$this->db->select('id_pembeli');
			$this->db->where($where);			
			return $this->db->get($this->table); 	
	    }

	    function get_status_dikirim_by_id_penjual($id)
	    {
			$this->db->where('id_penjual', $id);
			$this->db->where('status_transaksi', 'dikirim');
			return $this->db->get($this->table);
	    }	    
	    function get_status_selesai_by_id_penjual($id)
	    {
			$this->db->where('id_penjual', $id);
			$this->db->where('status_transaksi', 'selesai');
			return $this->db->get($this->table);
	    }	    
	    function get_status_batal_by_id_penjual($id)
	    {
			$this->db->where('id_penjual', $id);
			$this->db->where('status_transaksi', 'batal');
			return $this->db->get($this->table);
	    }


		//Penjual
		function cek_data_status_transaksi_by_id_penjual($id_penjual)
		{	
			$where =array(
				'id_penjual' => $id_penjual,
				'status' => 1
			);
			$this->db->where($where);
			return $this->db->get($this->table);
		}

//===============================================================admin================================================================================
		function get_data_join_pembeli($where)
		{	
			if($where != '')
			{
				$this->db->where($where);
			}			
			$this->db->join('t_pembeli', 't_pembeli.id_pembeli = t_transaksi.id_pembeli');	
			return $this->db->get($this->table);
		}			

		function get_data_join_penjual($where)
		{	
			if($where != '')
			{
				$this->db->where($where);
			}			
			$this->db->join('t_penjual', 't_penjual.id_penjual = t_transaksi.id_penjual');	
			return $this->db->get($this->table);
		}		

		function get_data_where_in($where_in)
		{	
			$this->db->where_in('status_transaksi', $where_in);	
			return $this->db->get($this->table);
		}

		function get_detail_transaksi($id)
		{
			$this->db->where('id_transaksi', $id);
			$this->db->join('t_rekening', 't_rekening.id_rekening = t_transaksi.id_rekening');
			return $this->db->get($this->table);
		}		

		function get_detail_transaksi_join_penjual($id)
		{
			$this->db->where('id_transaksi', $id);
			$this->db->join('t_penjual', 't_penjual.id_penjual = t_transaksi.id_penjual');
			return $this->db->get($this->table);
		}


	    function get_detail_pembayaran($id)
	    {
			$this->db->where('id_transaksi', $id);
			$this->db->join('t_rekening', 't_rekening.id_rekening = t_transaksi.id_rekening');
			return $this->db->get($this->table); 	
	    }	    

	    function get_detail_pengiriman($id)
	    {
			$this->db->where('id_transaksi', $id);
			return $this->db->get($this->table);	
	    }

	    function verifikasi_pembayaran($id)
	    {
			$where = array("id_transaksi" => $id);			
			$data = array('status_transaksi' => 'dibayar');
			$this->db->update($this->table, $data, $where);
			return $this->db->affected_rows();
	    }	    

	    function verifikasi_pengiriman($id)
	    {
			$where = array("id_transaksi" => $id);			
			$data = array('status_transaksi' => 'dikirim');
			$this->db->update($this->table, $data, $where);
			return $this->db->affected_rows();
	    }

//===============================================================admin================================================================================

		function get_bulan()
		{
			$query = $this->db->query('select date_format(waktu_konfir_transaksi,"%b %y") as bulan from t_transaksi WHERE status_transaksi = "selesai" group by MONTH(waktu_konfir_transaksi) order by waktu_konfir_transaksi ASC');
			return $query;
		}

		function get_total_transaksi()
		{
			$query = $this->db->query('SELECT sum(total_order+ongkir-5000) as jml FROM t_transaksi WHERE status_transaksi = "selesai" group by MONTH(waktu_konfir_transaksi) order by waktu_konfir_transaksi ASC');
			return $query;
		}

		function get_keuntungan()
		{
			$query = $this->db->query('SELECT sum(kode_unik+5000) as fee FROM t_transaksi WHERE status_transaksi = "selesai" group by MONTH(waktu_konfir_transaksi) order by waktu_konfir_transaksi ASC');
			return $query;
		}	
		//End Admin




		//Penjual
		function get_bulan_by_($id)
		{
			$query = $this->db->query("select date_format(waktu_konfir_transaksi,'%b %y') as bulan from t_transaksi WHERE status_transaksi = 'selesai' and id_penjual = '$id' group by MONTH(waktu_konfir_transaksi) order by waktu_konfir_transaksi ASC");
			return $query;
		}

		function get_total_transaksi_by_($id)
		{
			$query = $this->db->query("SELECT sum(total_order+ongkir-5000) as jml FROM t_transaksi WHERE status_transaksi = 'selesai' and id_penjual = '$id' group by MONTH(waktu_konfir_transaksi) order by waktu_konfir_transaksi ASC");
			return $query;
		}		
		//End Penjual

		function status_transaksi($id_transaksi)
		{	
			return $this->db->query("SELECT status FROM t_transaksi WHERE id_transaksi = '$id_transaksi'");
		}

		function hapus($id)
		{
			$this->db->where('id_transaksi', $id);
			$this->db->delete($this->table);
		}

//============================================PENJUAL============================================
		function get_order($id)
		{
			$where = array(
					'id_transaksi' => $id,
			);
			$this->db->where($where);
			$this->db->join('t_pembeli', 't_pembeli.id_pembeli = t_transaksi.id_pembeli');
			return $this->db->get($this->table);
		}

	    function get_order_terbaru($id)
	    {
			$where = "id_penjual = '$id' AND status_transaksi ='dibayar' OR status_transaksi = 'refund'";
	    	$this->db->where($where);
	    	$this->db->join('t_pembeli', 't_pembeli.id_pembeli = t_transaksi.id_pembeli');
	    	return $this->db->get($this->table);	
	    }	    

	    function get_order_history($id)
	    {
			$where = "id_penjual = '$id' AND status_transaksi ='selesai' OR status_transaksi = 'batal'";
	    	$this->db->where($where);
	    	$this->db->join('t_pembeli', 't_pembeli.id_pembeli = t_transaksi.id_pembeli');
	    	return $this->db->get($this->table);	
	    }		    

	    function get_order_di_konfirmasi($id)
	    {
			$where = array(
				'id_penjual' => $id,				
				'status_transaksi' => 'konfirpengiriman'
			);
	    	$this->db->where($where);
	    	$this->db->join('t_pembeli', 't_pembeli.id_pembeli = t_transaksi.id_pembeli');
	    	return $this->db->get($this->table);
	    }		    

	    function get_order_di_kirim($id)
	    {
			$where = array(
				'id_penjual' => $id,				
				'status_transaksi' => 'dikirim'
			);
	    	$this->db->where($where);
	    	$this->db->join('t_pembeli', 't_pembeli.id_pembeli = t_transaksi.id_pembeli');
	    	return $this->db->get($this->table);
	    }	


	    function refund()
	    {
	    	$this->db->where('status_transaksi', 'dibayar');
	    	$this->db->join('t_pembeli', 't_pembeli.id_pembeli = t_transaksi.id_pembeli');
	    	return $this->db->get($this->table);
	    }

	    function update_refund($id)
	    {
			$where = array("id_transaksi" => $id);	
			$data = array('status_transaksi' => 'refund');
			$this->db->update($this->table, $data, $where);	    	
	    }

	}
?>
