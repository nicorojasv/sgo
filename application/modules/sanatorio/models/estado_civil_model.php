<?php
class Estado_civil_model extends CI_Model {
	
	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function listar(){
		$this->sanatorio->select('*');
		$this->sanatorio->from('estado_civil');
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function get($id){
		$this->sanatorio->where('id', $id);
		$query = $this->sanatorio->get('estado_civil');
		return $query->row();
	}

	
	function editar($id,$data){
		//$this->sanatorio->cache_delete_all();
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->general->insert('usuarios',$data); 
		return $this->general->insert_id();
	}

	function eliminar($id){
		//$this->sanatorio->cache_delete_all();
		$this->sanatorio->delete('usuarios', array('id' => $id)); 
	}

}
?>