<?php
class Tipo_gratificacion_model extends CI_Model {

	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function get($id){
		$this->sanatorio->where("id",$id);
		$query = $this->sanatorio->get('tipo_gratificacion');
		return $query->row();
	}

}
?>