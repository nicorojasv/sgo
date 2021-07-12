<?php
class Contratos_model extends CI_Model {
	function listar(){
		$query = $this->db->get('contratos');
		return $query->result();
	}
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('contratos');
		return $query->row();
	}
	
	function ingresar($data){
		$this->db->insert('contratos',$data);
		return $this->db->insert_id();
	}
	function eliminar($id){
		$this->db->delete('contratos', array('id' => $id)); 
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('contratos', $data); 
	}
	
}