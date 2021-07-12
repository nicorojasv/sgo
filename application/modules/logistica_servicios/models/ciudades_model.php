<?php
class Ciudades_model extends CI_Model {
	
	function __construct(){
		$this->log_serv = $this->load->database('log_serv', TRUE);
	}

	function listar(){
		$this->log_serv->select('*');
		$this->log_serv->from('ciudades');
		$this->log_serv->order_by('desc_ciudades','asc');
		$query = $this->log_serv->get();
		return $query->result();
	}

	function get($id){
		$this->log_serv->where('id', $id);
		$query = $this->log_serv->get('ciudades');
		return $query->row();
	}

}
?>