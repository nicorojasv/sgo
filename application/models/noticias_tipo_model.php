<?php
class Noticias_tipo_model extends CI_Model {
	function listar(){
		//$this->db->order_by("id","desc");
		$query = $this->db->get('noticias_tipo');
		return $query->result();
	}

	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('noticias_tipo');
		return $query->row();
	}

	function ingresar($data){
		$this->db->insert('noticias_tipo',$data);
		return $this->db->insert_id();
	}

	function eliminar($id){
		$this->db->delete('noticias_tipo', array('id' => $id)); 
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('noticias_tipo', $data);
		return $id;
	}
}