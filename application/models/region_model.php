<?php
class Region_model extends CI_Model {
	function listar(){
		$query = $this->db->get('regiones');
		return $query->result();
	}
	
	function buscar($palabra){
		$this->db->where("desc_regiones",$palabra);
		$query = $this->db->get('regiones');
		return $query->row();
	}
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('regiones');
		return $query->row();
	}
}