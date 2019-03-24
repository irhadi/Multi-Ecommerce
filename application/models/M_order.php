<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class M_order extends CI_Model{
		var $table = 't_order';
		function __construct(){
			parent::__construct();
		}	    

		function simpan_order($data){
			$this->db->insert($this->table, $data);
		}

	    function get_order($id)
	    {
			$this->db->where('id_transaksi', $id);			
			return $this->db->get($this->table); 	
	    }

		function get_row_order_by_id_transaksi($id)
		{
	    	$where = array('id_transaksi' => $id);
	    	$this->db->where($where);
	    	return $this->db->get($this->table);
		}	

		function get_stok_terjual($id)
		{
	    	$query = $this->db->query("SELECT SUM(IF(id_produk = '$id', qty,0)) as tot FROM t_order");
	    	return $query;
		}
	}
?>
