<?php
class Estadocivil_model extends CI_Model {
	function listar(){
		$query = $this->db->get('estado_civil');
		return $query->result();
	}
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('estado_civil');
		return $query->row();
	}

	function buscar($palabra){
		$this->db->where("desc_estadocivil",$palabra);
		$query = $this->db->get('estado_civil');
		return $query->row();
	}
}