<?php
class Afp_model extends CI_Model {
	
	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function listar(){
		$this->terramar->select('*');
		$this->terramar->from('afp');
		$query = $this->terramar->get();
		return $query->result();
	}

	function get($id){
		$this->terramar->where('id', $id);
		$query = $this->terramar->get('afp');
		return $query->row();
	}

	function buscar($palabra){
		$this->terramar->where("desc_afp",$palabra);
		$query = $this->terramar->get('afp');
		return $query->row();
	}

}
?>