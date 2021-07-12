<?php
class Profesiones_model extends CI_Model {
	
	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function listar(){
		$this->wood->select('*');
		$this->wood->from('profesiones');
		$query = $this->wood->get();
		return $query->result();
	}

	function get($id){
		$this->wood->where('id', $id);
		$query = $this->wood->get('profesiones');
		return $query->row();
	}


	
	function editar($id,$data){
		//$this->wood->cache_delete_all();
		$this->wood->where('id', $id);
		$this->wood->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->wood->insert('usuarios',$data); 
		return $this->wood->insert_id();
	}

	function eliminar($id){
		//$this->wood->cache_delete_all();
		$this->wood->delete('usuarios', array('id' => $id)); 
	}

}
?>