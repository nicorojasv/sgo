<?php
class Tipo_gratificacion_model extends CI_Model {

	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function get($id){
		$this->wood->where("id",$id);
		$query = $this->wood->get('tipo_gratificacion');
		return $query->row();
	}

}
?>