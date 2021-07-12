<?php
class Usuarios_categoria_model extends CI_Model {

	function listar(){
		$query = $this->db->get('usuarios_categoria');
		return $query->result();
	}

	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('usuarios_categoria');
		return $query->row();
	}

}