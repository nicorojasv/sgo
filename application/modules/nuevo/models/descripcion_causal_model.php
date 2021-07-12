<?php
class Descripcion_causal_model extends CI_Model {

	function __construct(){
		$this->enjoy = $this->load->database('enjoy', TRUE);
	}

	function get($id){
		$this->enjoy->where("id",$id);
		$query = $this->enjoy->get('descripcion_causal');
		return $query->row();
	}

}
?>