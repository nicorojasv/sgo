<?php
class Provincia_model extends CI_Model {
	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}
	function listar(){
		$query = $this->terramar->get('provincias');
		return $query->result();
	}
	
	function listar_region($id_region){
		$this->terramar->where("id_regiones",$id_region);
		$this->terramar->order_by("desc_ciudades");
		$query = $this->terramar->get('ciudades');
		return $query->result();
	}
	function buscar($palabra){
		$this->terramar->where("desc_provincias",$palabra);
		$query = $this->terramar->get('provincias');
		return $query->row();
	}
	function get($id){
		$this->terramar->where("id",$id);
		$query = $this->terramar->get('provincias');
		return $query->row();
	}
}