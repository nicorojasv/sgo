<?php
class Provincia_model extends CI_Model {
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}
	function listar(){
		$query = $this->carrera->get('provincias');
		return $query->result();
	}
	
	function listar_region($id_region){
		$this->carrera->where("id_regiones",$id_region);
		$this->carrera->order_by("desc_ciudades");
		$query = $this->carrera->get('ciudades');
		return $query->result();
	}
	function buscar($palabra){
		$this->carrera->where("desc_provincias",$palabra);
		$query = $this->carrera->get('provincias');
		return $query->row();
	}
	function get($id){
		$this->carrera->where("id",$id);
		$query = $this->carrera->get('provincias');
		return $query->row();
	}
}