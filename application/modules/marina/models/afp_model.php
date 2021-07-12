<?php
class Afp_model extends CI_Model {
	
	function __construct(){
		$this->marina = $this->load->database('marina', TRUE);
	}

	function listar(){
		$this->marina->select('*');
		$this->marina->from('afp');
		$query = $this->marina->get();
		return $query->result();
	}

	function get($id){
		$this->marina->where('id', $id);
		$query = $this->marina->get('afp');
		return $query->row();
	}

	function buscar($palabra){
		$this->marina->where("desc_afp",$palabra);
		$query = $this->marina->get('afp');
		return $query->row();
	}

}
?>