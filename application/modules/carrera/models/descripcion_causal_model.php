<?php
class Descripcion_causal_model extends CI_Model {

	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function get($id){
		$this->carrera->where("id",$id);
		$query = $this->carrera->get('descripcion_causal');
		return $query->row();
	}

}
?>