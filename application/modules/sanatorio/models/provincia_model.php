<?php
class Provincia_model extends CI_Model {
	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}
	function listar(){
		$query = $this->sanatorio->get('provincias');
		return $query->result();
	}
	
	function listar_region($id_region){
		$this->sanatorio->where("id_regiones",$id_region);
		$this->sanatorio->order_by("desc_ciudades");
		$query = $this->sanatorio->get('ciudades');
		return $query->result();
	}
	function buscar($palabra){
		$this->sanatorio->where("desc_provincias",$palabra);
		$query = $this->sanatorio->get('provincias');
		return $query->row();
	}
	function get($id){
		$this->sanatorio->where("id",$id);
		$query = $this->sanatorio->get('provincias');
		return $query->row();
	}
}