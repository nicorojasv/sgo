<?php
class Fotostrab_model extends CI_Model {
	function listar(){
		$query = $this->db->get('fotos_trab');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('fotos_trab');
		return $query->row();
	}
	function get_usuario($id){
		$this->db->where('id_usuarios',$id);
		$query = $this->db->get('fotos_trab');
		return $query->row();
	}
	
	function ingresar($data){
		$this->db->insert('fotos_trab',$data); 
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('fotos_trab', $data); 
	}
	
	function borrar($id){
		$this->db->where('id_usuarios', $id);
		$this->db->delete('fotos_trab');
	}
}