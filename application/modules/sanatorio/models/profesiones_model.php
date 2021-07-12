<?php
class Profesiones_model extends CI_Model {
	
	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function listar(){
		$this->sanatorio->select('*');
		$this->sanatorio->from('profesiones');
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function get($id){
		$this->sanatorio->where('id', $id);
		$query = $this->sanatorio->get('profesiones');
		return $query->row();
	}


	
	function editar($id,$data){
		//$this->sanatorio->cache_delete_all();
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->sanatorio->insert('usuarios',$data); 
		return $this->sanatorio->insert_id();
	}

	function eliminar($id){
		//$this->sanatorio->cache_delete_all();
		$this->sanatorio->delete('usuarios', array('id' => $id)); 
	}

}
?>