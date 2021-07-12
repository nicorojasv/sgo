<?php
class Fotosemp_model extends CI_Model {
	function listar(){
		$query = $this->db->get('fotos_emp');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('fotos_emp');
		return $query->row();
	}
	function get_empresa($id){
		$this->db->where('id_empresa',$id);
		$query = $this->db->get('fotos_emp');
		return $query->row();
	}
	
	function ingresar($data){
		$this->db->insert('fotos_emp',$data); 
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('fotos_emp', $data); 
	}
	
	function borrar($id){
		$this->db->where('id_empresa', $id);
		$this->db->delete('fotos_emp');
	}
}