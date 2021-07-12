<?php
class Categoriasnoticias_model extends CI_Model {
	function listar(){
		$query = $this->db->get('noticias_categoria');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('noticias_categoria');
		return $query->row();
	}
	
	function ingresar($data){
		$this->db->insert('noticias_categoria',$data); 
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('noticias_categoria', $data); 
	}
	
	function borrar($id){
		$this->db->where('id', $id);
		$this->db->delete('noticias_categoria');
	}
}