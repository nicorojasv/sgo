<?php
class Sucursales_model extends CI_Model {

	function __construct(){
		$this->general = $this->load->database('general', TRUE);
	}

	function listar(){
		$query = $this->general->get('sucursales');
		return $query->result();
	}

	function get($id){
		$this->general->where('id', $id);
		$query = $this->general->get('sucursales');
		return $query->row();
	}

	function editar($id,$data){
		//$this->db->cache_delete_all();
		$this->general->where('id', $id);
		$this->general->update('sucursales', $data); 
	}

	function ingresar($data){
		//$this->db->cache_delete_all();
		$this->general->insert('sucursales',$data); 
		return $this->general->insert_id();
	}
	
	function eliminar($id){
		//$this->db->cache_delete_all();
		$this->general->delete('sucursales', array('id' => $id)); 
	}
}