<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	class M_admin extends CI_Model{

		var $table = 't_admin';

		function cek_login($username,$password){
			$data=array(
				'username'=>$username,
				'password'=>$password
			);
			$this->db->where($data);
			return $this->db->get($this->table);
		}	

		// function periode(){
		// 	$query = $this->db->query('SELECT tggl FROM t_konfirmasi WHERE status = 2 group by tggl order by tggl ASC');
		// 	return $query->result();
		// }

		function jml(){
			$query = $this->db->query('SELECT count(*) as jml FROM t_konfirmasi WHERE status = 2 group by MONTH(tggl) order by tggl DESC');
			return $query->result();
		}
		function update_password($id, $pwd)
		{
			$this->db->where('id_admin',$id);
			$this->db->set('password', $pwd);
			// $where = array('id_pembeli',$id);
			// $data = array('password', $pwd);
			$query = $this->db->update($this->table);
			return $query;
		}
		function cek_password_lama($id, $pwd)
		{
			$this->db->where('id_admin', $id);
			$this->db->where('password', $pwd);
			return $this->db->get($this->table);
		}		
	}
?>
