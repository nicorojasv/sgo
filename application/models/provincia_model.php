<?php
class Provincia_model extends CI_Model {
	function listar(){
		$query = $this->db->get('provincias');
		return $query->result();
	}
	
	function listar_region($id_region){
		$this->db->where("id_regiones",$id_region);
		$this->db->order_by("desc_provincias");
		$query = $this->db->get('provincias');
		return $query->result();
	}
	function buscar($palabra){
		$this->db->where("desc_provincias",$palabra);
		$query = $this->db->get('provincias');
		return $query->row();
	}
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('provincias');
		return $query->row();
	}
}