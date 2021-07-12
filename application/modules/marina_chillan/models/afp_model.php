<?php
class Afp_model extends CI_Model {
	
	function __construct(){
		$this->marina_chillan = $this->load->database('marina_chillan', TRUE);
	}

	function listar(){
		$this->marina_chillan->select('*');
		$this->marina_chillan->from('afp');
		$query = $this->marina_chillan->get();
		return $query->result();
	}

	function get($id){
		$this->marina_chillan->where('id', $id);
		$query = $this->marina_chillan->get('afp');
		return $query->row();
	}

	function buscar($palabra){
		$this->marina_chillan->where("desc_afp",$palabra);
		$query = $this->marina_chillan->get('afp');
		return $query->row();
	}

}
?>