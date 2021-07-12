<?php
class Provincia_model extends CI_Model {
	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}
	function listar(){
		$query = $this->wood->get('provincias');
		return $query->result();
	}
	
	function listar_region($id_region){
		$this->wood->where("id_regiones",$id_region);
		$this->wood->order_by("desc_ciudades");
		$query = $this->wood->get('ciudades');
		return $query->result();
	}
	function buscar($palabra){
		$this->wood->where("desc_provincias",$palabra);
		$query = $this->wood->get('provincias');
		return $query->row();
	}
	function get($id){
		$this->wood->where("id",$id);
		$query = $this->wood->get('provincias');
		return $query->row();
	}
}