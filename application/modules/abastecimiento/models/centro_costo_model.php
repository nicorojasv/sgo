<?php
class Centro_costo_model extends CI_Model {

	function __construct(){
		$this->general = $this->load->database('general', TRUE);
	}

	function listar(){
		$query = $this->general->get('centro_costo');
		return $query->result();
	}

	function get($id){
		$this->general->where('id', $id);
		$query = $this->general->get('centro_costo');
		return $query->row();
	}

	function editar($id,$data){
		//$this->db->cache_delete_all();
		$this->general->where('id', $id);
		$this->general->update('centro_costo', $data); 
	}

	function ingresar($data){
		//$this->db->cache_delete_all();
		$this->general->insert('centro_costo',$data); 
		return $this->general->insert_id();
	}
	
	function eliminar($id){
		//$this->db->cache_delete_all();
		$this->general->delete('centro_costo', array('id' => $id)); 
	}
}