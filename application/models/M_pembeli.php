<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class M_pembeli extends CI_Model{

		var $table = 't_pembeli';

		function cek_login($email,$password){
			$data=array(
				'email'=>$email,
				'password'=>$password
			);
			$this->db->where($data);
			return $this->db->get($this->table);
		}	

		function get_pembeli($id){
			$data=array('id_pembeli'=>$id);
			$this->db->where($data);
			return $this->db->get($this->table);			
		}
		function id_pembeli() {
	        $this->db->select('RIGHT(id_pembeli,2) as kode', FALSE);
	        $this->db->order_by('id_pembeli', 'DESC');
	        $this->db->limit(1);
	        $query = $this->db->get($this->table);      //cek dulu apakah ada sudah ada kode di tabel.    
	        if ($query->num_rows() <> 0) {
	            $data = $query->row();
	            $kode = intval($data->kode) + 1;
	        } else {
	            $kode = 1;
	        }
	        $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);
	        $kodejadi = "PB" . $kodemax;
	        return $kodejadi;
	    }
		function insert_alamat($id, $data){
			$where=array(
				'id_pembeli'=>$id,
			);
			$this->db->where($where);
			$this->db->update($this->table, $data);
		}
		

		function simpan_registrasi($data)
		{
			$this->load->database();
			$this->db->insert($this->table,$data);
		}

		function update($id, $pwd)
		{
			$this->db->where('id_pembeli',$id);
			$this->db->set('password', $pwd);
			return $this->db->update($this->table);
		}

		function cek_password_lama($id, $pwd)
		{
			$this->db->where('id_pembeli', $id);
			$this->db->where('password', $pwd);
			return $this->db->get($this->table);
		}

		function get_data()
		{
			return $this->db->get($this->table);
		}


		function cek_email($email){
			$this->db->where('email', $email);
			return $this->db->get($this->table);
		}	

		function simpan_token($where, $data)
		{
			$this->db->where('email', $where);
			$this->db->set($data);
			return $this->db->update($this->table);
		}

		function aktifasi($key)
		{
			$where = array("token" => $key);
			$data = array('status_akun' => 'aktif', 'token' => '');
			$this->db->where($where);			
			$this->db->update($this->table, $data);

			return $this->db->affected_rows();
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
