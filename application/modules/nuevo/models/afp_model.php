<?php
class Afp_model extends CI_Model {
	
	function __construct(){
		$this->enjoy = $this->load->database('enjoy', TRUE);
	}

	function listar(){
		$this->enjoy->select('*');
		$this->enjoy->from('afp');
		$query = $this->enjoy->get();
		return $query->result();
	}

	function get($id){
		$this->enjoy->where('id', $id);
		$query = $this->enjoy->get('afp');
		return $query->row();
	}

	function buscar($palabra){
		$this->enjoy->where("desc_afp",$palabra);
		$query = $this->enjoy->get('afp');
		return $query->row();
	}

}
?>