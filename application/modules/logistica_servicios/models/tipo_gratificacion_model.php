<?php
class Tipo_gratificacion_model extends CI_Model {

	function __construct(){
		$this->log_serv = $this->load->database('log_serv', TRUE);
	}

	function get($id){
		$this->log_serv->where("id",$id);
		$query = $this->log_serv->get('tipo_gratificacion');
		return $query->row();
	}

}
?>