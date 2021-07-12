<?php
class Tipo_gratificacion_model extends CI_Model {

	function __construct(){
		$this->aramark = $this->load->database('aramark', TRUE);
	}

	function get($id){
		$this->aramark->where("id",$id);
		$query = $this->aramark->get('tipo_gratificacion');
		return $query->row();
	}

}
?>