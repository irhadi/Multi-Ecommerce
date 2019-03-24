<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class M_penjual extends CI_Model{

		var $table = 't_penjual';

		function cek_login($email,$password){
			$data=array(
				'email'=>$email,
				'password'=>$password
			);
			$this->db->where($data);
			return $this->db->get($this->table);
		}
		
		function keluar($where, $data)
		{
			$this->db->where($where);
			$this->db->update($this->table, $data);
		}	
			
		function id_penjual() {
	        $this->db->select('RIGHT(id_penjual,2) as kode', FALSE);
	        $this->db->order_by('id_penjual', 'DESC');
	        $this->db->limit(1);
	        $query = $this->db->get($this->table);      //cek dulu apakah ada sudah ada kode di tabel.    
	        if ($query->num_rows() <> 0) {
	            $data = $query->row();
	            $kode = intval($data->kode) + 1;
	        } else {
	            $kode = 1;
	        }
	        $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);
	        $kodejadi = "PJ" . $kodemax;
	        return $kodejadi;
	    }

	    function update($where, $data)
	    {
	    	$this->db->set($data);
	    	$this->db->where($where);
	    	return $this->db->update($this->table);
	    }

		function get_list_penjual($query)
		{
			$this->db->select("*");
			$this->db->from($this->table);
			$this->db->where('status_akun =', 'aktif');

			if($query != '')
			{
				$this->db->like('nama_toko', $query);
				$this->db->or_like('nama_penjual', $query);
			}
			return $this->db->get();
		}
		
		function get_penjual($id)
		{	
			$this->db->where('id_penjual',$id);
			return $this->db->get($this->table);	
		}			

		function get_info_penjual($slug)
		{	
			$this->db->where('slug_penjual',$slug);
			return $this->db->get($this->table);	
		}	
		
		function simpan_registrasi($data)
		{
			$this->db->insert($this->table,$data);
		}

//======================================================================Admin===============================================================================
		function get_data_penjual_baru($id)
		{
			if($id != ''){
				$this->db->where('id_penjual', $id);
			}else{
				$this->db->where('status_akun','baru');
			}			
			return $this->db->get($this->table);
		}		

		function get_data_penjual_lama()
		{
			$this->db->where_not_in('status_akun', 'baru');
			return $this->db->get($this->table);
		}

		function konfirmasi_penjual_baru($query, $where, $data)
		{
			$this->db->where($where);
			if($query == 'bolehkan')
			{				
				return $this->db->update($this->table, $data);
			}
			else
			{
				return $this->db->delete($this->table);
			}
			
		}	
//====================================================================EndAdmin==============================================================================

//===================================================================Registrasi=============================================================================
		function aktifasi($key)
		{
			$where = array("token" => $key);			
			$data = array('status_akun' => 'aktif');
			$this->db->update($this->table, $data, $where);
			return $this->db->affected_rows();
		}	

		function get_penjual_by_kode_aktifasi($key)
		{
			$where = array("token" => $key);
			$this->db->where($where);
			return $this->db->get($this->table);
		}
//===================================================================Registrasi=============================================================================



		function blokir($id)
		{
			$this->db->set('status_akun', 'blokir');
			$this->db->where('id_penjual',$id);
			return $this->db->update($this->table);
		}		

		function buka_blokir($id)
		{
			$this->db->set('status_akun', 'aktif');
			$this->db->where('id_penjual',$id);
			return $this->db->update($this->table);
		}


		function Nama_Toko($slug)
		{
			$this->db->where('slug_penjual', $slug);
			$query = $this->db->get($this->table);
			$nama = array();
			foreach ($query->result() as $q) {
				$nama[]= $q->nama_toko;
				$nama[]= $q->logo_toko;				
			}
			return $nama;
		}

		function get_id($slug)
		{
			$this->db->where('slug_penjual', $slug);
			$query = $this->db->get($this->table);
			foreach ($query->result() as $q) {
				$id = $q->id_penjual;
			}
			return $id;
		}
		function cek_email($email)
		{
			$this->db->where('email', $email);
			return $this->db->get($this->table);
		}		

		function cek_duplikasi_email($email)
		{
			$this->db->where('email =', $email);
			return $this->db->get($this->table);
		}


		function tambah_penjual($data)
		{
			$this->db->insert($this->table, $data);
		}

		function hapus_penjual($id)
		{
			$this->db->where('id_penjual', $id);
			$this->db->delete($this->table);
		}
		function update_password($id, $pwd)
		{
			$this->db->where('id_penjual',$id);
			$this->db->set('password', $pwd);
			// $where = array('id_pembeli',$id);
			// $data = array('password', $pwd);
			$query = $this->db->update($this->table);
			return $query;
		}
		function cek_password_lama($id, $pwd)
		{
			$this->db->where('id_penjual', $id);
			$this->db->where('password', $pwd);
			return $this->db->get($this->table);
		}

		// function cek_email($email){
		// 	$this->db->where('email', $email);
		// 	return $this->db->get($this->table);
		// }	

		function simpan_token($where, $data)
		{
			$this->db->where('email', $where);
			$this->db->set($data);
			return $this->db->update($this->table);
		}
		function recovery($key)
		{
			$where = array("token" => $key);
			$this->db->where($where);			
			return $this->db->get($this->table);
		}	

		function reset_password($token, $data)
		{
			$where = array("token" => $token);
			$this->db->where($where);			
			$this->db->update($this->table, $data);
		}					
	}
?>
