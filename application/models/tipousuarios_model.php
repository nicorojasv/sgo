<?php
class Tipousuarios_model extends CI_Model {
	function listar(){
		//$this->db->order_by("tipo_usuarios");
		$query = $this->db->get('tipo_usuarios');
		return $query->result();
	}
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('tipo_usuarios');
		return $query->row();
	}

	function get_categoria($id){
		$this->db->where("usuario_categoria_id",$id);
		$query = $this->db->get('tipo_usuarios');
		return $query->result();
	}
	
	function get_internos(){
		$this->db->where("id !=",1);
		$this->db->where("id !=",2);
		$query = $this->db->get('tipo_usuarios');
		return $query->result();
	}
	
	function ingresar($data){
		$this->db->insert('tipo_usuarios',$data); 
	}
}