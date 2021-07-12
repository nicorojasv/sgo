<?php
class Tags_contratos_model extends CI_Model {
	function listar(){
		$query = $this->db->get('tags_contratos');
		return $query->result();
	}
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('tags_contratos');
		return $query->row();
	}
	
	function get_var($var){
		$this->db->where("variable",$var);
		$query = $this->db->get('tags_contratos');
		return $query->row();
	}
	
	function ingresar($data){
		$this->db->insert('tags_contratos',$data);
		return $this->db->insert_id();
	}
	function eliminar($id){
		$this->db->delete('tags_contratos', array('id' => $id)); 
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('tags_contratos', $data); 
	}
	
}