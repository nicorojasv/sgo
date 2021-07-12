<?php
class Afp_model extends CI_Model {
	
	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function listar(){
		$this->sanatorio->select('*');
		$this->sanatorio->from('afp');
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function get($id){
		$this->sanatorio->where('id', $id);
		$query = $this->sanatorio->get('afp');
		return $query->row();
	}

	function buscar($palabra){
		$this->sanatorio->where("desc_afp",$palabra);
		$query = $this->sanatorio->get('afp');
		return $query->row();
	}

}
?>