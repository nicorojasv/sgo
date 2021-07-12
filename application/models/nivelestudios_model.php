<?php
class Nivelestudios_model extends CI_Model {
	function listar(){
		$query = $this->db->get('nivel_estudios');
		$this->db->order_by("id");
		return $query->result();
	}
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('nivel_estudios');
		return $query->row();
	}
	function buscar($palabra){
		$this->db->where("desc_nivelestudios",$palabra);
		$query = $this->db->get('nivel_estudios');
		return $query->row();
	}
}