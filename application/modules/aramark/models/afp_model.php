<?php
class Afp_model extends CI_Model {
	
	function __construct(){
		$this->aramark = $this->load->database('aramark', TRUE);
	}

	function listar(){
		$this->aramark->select('*');
		$this->aramark->from('afp');
		$query = $this->aramark->get();
		return $query->result();
	}

	function get($id){
		$this->aramark->where('id', $id);
		$query = $this->aramark->get('afp');
		return $query->row();
	}

	function buscar($palabra){
		$this->aramark->where("desc_afp",$palabra);
		$query = $this->aramark->get('afp');
		return $query->row();
	}

}
?>