<?php
class Salud_model extends CI_Model {
	function listar(){
		$query = $this->db->get('salud');
		return $query->result();
	}
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('salud');
		return $query->row();
	}
	function buscar($palabra){
		$this->db->where("desc_salud",$palabra);
		$query = $this->db->get('salud');
		return $query->row();
	}
	function actualizar($data,$id){
		$this->db->where('id', $id);
		$this->db->update('salud', $data); 
	}
}