<?php
class Tipo_gratificacion_model extends CI_Model {

	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function get($id){
		$this->carrera->where("id",$id);
		$query = $this->carrera->get('tipo_gratificacion');
		return $query->row();
	}

}
?>