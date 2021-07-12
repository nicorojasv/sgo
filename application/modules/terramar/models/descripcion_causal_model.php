<?php
class Descripcion_causal_model extends CI_Model {

	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function get($id){
		$this->terramar->where("id",$id);
		$query = $this->terramar->get('descripcion_causal');
		return $query->row();
	}

}
?>