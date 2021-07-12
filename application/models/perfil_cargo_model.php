<?php
class Perfil_cargo_model extends CI_Model {
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('perfil_cargo');
		return $query->row();
	}

	function get_cargo($id){
		$this->db->where('cargos_id',$id);
		$query = $this->db->get('perfil_cargo');
		return $query->row();
	}

	function listar(){
		$query = $this->db->get('perfil_cargo');
		return $query->result();
	}
}