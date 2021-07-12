<?php
class Experiencia_model extends CI_Model {
	function listar(){
		$query = $this->db->get('experiencia');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('experiencia');
		return $query->row();
	}
	
	function get_usuario($id){
		$this->db->where("id_usuarios",$id);
		$query = $this->db->get('experiencia');
		return $query->result();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('experiencia', $data); 
	}
	
	function ingresar($data){
		$this->db->insert('experiencia',$data); 
	}
	
	function borrar($id){
		$this->db->where('id', $id);
		$this->db->delete('experiencia');
	}
}