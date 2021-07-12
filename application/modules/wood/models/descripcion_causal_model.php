<?php
class Descripcion_causal_model extends CI_Model {

	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function get($id){
		$this->wood->where("id",$id);
		$query = $this->wood->get('descripcion_causal');
		return $query->row();
	}

}
?>