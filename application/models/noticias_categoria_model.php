<?php
class Noticias_categoria_model extends CI_Model {
	function listar(){
		//$this->db->order_by("id","desc");
		$query = $this->db->get('noticias_categoria');
		return $query->result();
	}

	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('noticias_categoria');
		return $query->row();
	}

	function ingresar($data){
		$this->db->insert('noticias_categoria',$data);
		return $this->db->insert_id();
	}

	function eliminar($id){
		$this->db->delete('noticias_categoria', array('id' => $id)); 
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('noticias_categoria', $data);
		return $id;
	}
}