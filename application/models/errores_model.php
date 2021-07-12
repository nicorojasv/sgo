<?php
class Errores_model extends CI_Model {
	function listar(){
		$query = $this->db->get('errores');
		return $query->result();
	}
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('errores');
		return $query->row();
	}
	
	function ingresar($data){
		$this->db->insert('errores',$data);
		return $this->db->insert_id();
	}
	function eliminar($id){
		$this->db->delete('errores', array('id' => $id)); 
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('errores', $data); 
	}
	
}