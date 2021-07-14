<?php
class Afp_model extends CI_Model {
	
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function listar(){
		$this->carrera->select('*');
		$this->carrera->from('afp');
		$query = $this->carrera->get();
		return $query->result();
	}

	function get($id){
		$this->carrera->where('id', $id);
		$query = $this->carrera->get('afp');
		return $query->row();
	}

	function buscar($palabra){
		$this->carrera->where("desc_afp",$palabra);
		$query = $this->carrera->get('afp');
		return $query->row();
	}

}
?>