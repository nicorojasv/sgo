<?php
class Descripcion_causal_model extends CI_Model {

	function __construct(){
		$this->marina = $this->load->database('marina', TRUE);
	}

	function get($id){
		$this->marina->where("id",$id);
		$query = $this->marina->get('descripcion_causal');
		return $query->row();
	}

}
?>