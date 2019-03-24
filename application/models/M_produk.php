<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class M_produk extends CI_Model{

		var $table = 't_produk';
		var $column_order = array('nama','harga','berat','stok','tggl',null); //set column field database for datatable orderable
		var $column_search = array('nama','harga','berat','stok'); //set column field database for datatable searchable just firstname , lastname , address are searchable
		var $order = array('id_produk' => 'desc'); // default order 

		function __construct(){
			parent::__construct();
		}
		function id_produk() {
	        $this->db->select('RIGHT(id_produk,2) as kode', FALSE);
	        $this->db->order_by('id_produk', 'DESC');
	        $this->db->limit(1);
	        $query = $this->db->get('t_produk');      //cek dulu apakah ada sudah ada kode di tabel.    
	        if ($query->num_rows() <> 0) {
	            $data = $query->row();
	            $kode = intval($data->kode) + 1;
	        } else {
	            $kode = 1;
	        }
	        $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);
	        $kodejadi = "PR" . $kodemax;
	        return $kodejadi;
	    }

		function get_produk($id, $query)
		{
			$this->db->select('*');
			$this->db->from($this->table);
			$this->db->where('_id_penjual =', $id);
			$this->db->where('stok >', 0);
			if($query != '')
			{
				$this->db->like('nama', $query);
				$this->db->or_like('harga', $query);
			}
			return $this->db->get();
		}
	    
//======================================================================Controller Toko==================================================================================
		function get_total_produk($id)
		{
			$query = $this->db->query("SELECT * FROM t_produk WHERE _id_penjual = '$id' AND stok > 0");
			return $query;
		}

//======================================================================Controller Toko==================================================================================

//======================================================================Controller Admin=================================================================================
		function get_data()
		{
			$this->db->select('id_produk, nama, berat, harga, gambar, stok, tggl, id_penjual,nama_toko');
			$this->db->from($this->table);
			$this->db->join('t_penjual', 'id_penjual=_id_penjual');
			return $this->db->get();
		}
//======================================================================Controller Admin=================================================================================

		function get_detail($id)
		{
			$this->db->where('id_produk', $id);
			return $this->db->get($this->table);
		}

//================================================================Akses Controller Penjual==============================================================================
		private function _get_produk_by_id_query()
		{
			$id_penjual=$this->session->userdata('id_penjual');
			$this->db->from($this->table);
			$this->db->where('_id_penjual',$id_penjual);

			$i = 0;
		
			foreach ($this->column_search as $item) // loop column 
			{
				if($_POST['search']['value']) // if datatable send POST for search
				{
					
					if($i===0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->like($item, $_POST['search']['value']);
					}
					else
					{
						$this->db->or_like($item, $_POST['search']['value']);
					}

					if(count($this->column_search) - 1 == $i) //last loop
						$this->db->group_end(); //close bracket
				}
				$i++;
			}
			
			if(isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} 
			else if(isset($this->order))
			{
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}

		function get_produk_query()
		{
			$this->_get_produk_by_id_query();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}

		function count_filtered()
		{
			$this->_get_produk_by_id_query();
			$query = $this->db->get();
			return $query->num_rows();
		}

		public function count_all()
		{
			$this->db->from($this->table);
			return $this->db->count_all_results();
		}

		public function get_produk_by_id($id)
		{
			$this->db->where('id_produk',$id);
			$query = $this->db->get($this->table);

			return $query->row();
		}

		public function save($data)
		{
			$this->db->insert($this->table, $data);
			return $this->db->insert_id();
		}

		public function update($where, $data)
		{
			$this->db->update($this->table, $data, $where);
			return $this->db->affected_rows();
		}
		
		public function delete_by_id($id)
		{
			$this->db->where('id_produk', $id);
			$this->db->delete($this->table);
		}		

		public function get_row_produk_terjual($id)
		{
			$query = $this->db->query("SELECT SUM(qty) as tot FROM t_order where id_transaksi = '$id' group by id_transaksi");
			return $query;
		}
		
		public function get_total_produk_by_id($id)
		{
			$query = $this->db->query("SELECT SUM(stok) as totproduk FROM t_produk where _id_penjual = '$id'");
			return $query;
		}
		public function get_row_produk_by_id_penjual($id)
		{
			$this->db->where('_id_penjual',$id);
			$query = $this->db->get($this->table);

			return $query->num_rows();
		}		

//================================================================Akses Controller Penjual==============================================================================		



//================================================================pembeli==============================================================================
		function kembalikan_stok($id, $stok)
		{
	    	$this->db->query("update t_produk set stok = stok + '$stok' where id_produk = '$id'");
		}
		function update_stok($id, $stok)
		{
			$this->db->query("update t_produk set stok = stok - '$stok' where id_produk = '$id'");
		}


	}
?>
