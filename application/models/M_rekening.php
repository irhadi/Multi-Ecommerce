<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class M_rekening extends CI_Model{

		var $table = 't_rekening';
		var $column_order = array('nm_bank','an_rek','no_rek', null); //set column field database for datatable orderable
		var $column_search = array('nm_bank','an_rek','no_rek'); //set column field database for datatable searchable just firstname , lastname , address are searchable
		var $order = array('id_rekening' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
	}

		function get_rekening($where)		
		{
			if($where != '')
			{
				$this->db->where($where);
			}			
			return $this->db->get($this->table);
		}



		function simpan($data)
		{
			$this->db->insert($this->table, $data);
			return $this->db->insert_id();
		}

		function hapus($where)
		{
			$this->db->where($where);
			$this->db->delete($this->table);
		}
		function update($where, $data)
		{
			$this->db->update($this->table, $data, $where);
			return $this->db->affected_rows();
		}	





		private function _get_rekening_datatables_query()
		{
			$this->db->from($this->table);

			$i = 0;
		
			foreach ($this->column_search as $item) // loop column 
			{
				if($_POST['search']['value']) // if datatable send POST for search
				{
					
					if($i===0)
					{
						$this->db->group_start();
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

		function get_rekening_datatables()
		{
			$this->_get_rekening_datatables_query();
			if($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result();
		}
		function count_filtered()
		{
			$this->_get_rekening_datatables_query();
			$query = $this->db->get();
			return $query->num_rows();
		}
		// public function get_rekening_by_id($id)
		// {
		// 	$this->db->where('id_rekening',$id);
		// 	$query = $this->db->get($this->table);

		// 	return $query->row();
		// }
		public function count_all()
		{
			$this->db->from($this->table);
			return $this->db->count_all_results();
		}		
	}
?>
