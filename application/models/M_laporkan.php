<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class M_laporkan extends CI_Model{
		var $table = 't_laporkan';

		function simpan($data){
			$this->db->insert('t_laporkan',$data);
		}

		function cek_laporan($id_konfirmasi, $id_pembeli)
		{
			$this->db->where('id_konfirmasi', $id_konfirmasi);
			$this->db->where('id_pembeli', $id_pembeli);			
			return $this->db->get($this->table);
		}

		function cek_pesan()
		{
			$this->db->where('status','0');
			return $this->db->get($this->table);
		}

		function get_data()
		{
			$this->db->join('t_pembeli', 't_pembeli.id_pembeli = t_laporkan.id_pembeli');
			return $this->db->get($this->table);
		}		

		function get_data_by_($id)
		{
			$this->db->where('id_laporkan =', $id);
			$this->db->join('t_penjual', 't_penjual.id_penjual = t_laporkan.id_penjual');
			$this->db->join('t_pembeli', 't_pembeli.id_pembeli = t_laporkan.id_pembeli');
			return $this->db->get($this->table);
		}

		function cek_data_status_laporan()
		{
			$this->db->where('status', 0);
			return $this->db->get($this->table);
		}
		function update_status($id)
		{
			$this->db->set('status', 1);
			$this->db->where('id_laporkan', $id);
			$this->db->update($this->table);
		}
		function get_total_di_laporkan_by_id_penjual($id)
		{
			$this->db->where('id_penjual', $id);
			return $this->db->get($this->table);
		}
	}
?>
