<?php
class Tipo_gratificacion_model extends CI_Model {

	function __construct(){
		$this->marina_chillan = $this->load->database('marina_chillan', TRUE);
	}

	function get($id){
		$this->marina_chillan->where("id",$id);
		$query = $this->marina_chillan->get('tipo_gratificacion');
		return $query->row();
	}

}
?>