<?php
class Usu_parentesco_model extends CI_Model {

	function listar(){
		$query = $this->db->get('usu_parentesco');
		return $query->result();
	}

	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('usu_parentesco');
		return $query->row();
	}

}