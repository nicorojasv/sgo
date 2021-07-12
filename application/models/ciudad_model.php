<?php
class Ciudad_model extends CI_Model {
	function listar(){
		$this->db->order_by("desc_ciudades ASC");
		$query = $this->db->get('ciudades');
		return $query->result();
	}
	
	function listar_region($id_region){
		$this->db->where("id_regiones",$id_region);
		$this->db->order_by("desc_ciudades");
		$query = $this->db->get('ciudades');
		return $query->result();
	}
	function buscar($palabra){
		$this->db->where("desc_ciudades",$palabra);
		$query = $this->db->get('ciudades');
		return $query->row();
	}
	
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('ciudades');
		return $query->row();
	}
}