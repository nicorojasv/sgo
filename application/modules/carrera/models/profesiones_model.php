<?php
class Profesiones_model extends CI_Model {
	
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function listar(){
		$this->carrera->select('*');
		$this->carrera->from('profesiones');
		$query = $this->carrera->get();
		return $query->result();
	}

	function get($id){
		$this->carrera->where('id', $id);
		$query = $this->carrera->get('profesiones');
		return $query->row();
	}


	
	function editar($id,$data){
		//$this->carrera->cache_delete_all();
		$this->carrera->where('id', $id);
		$this->carrera->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->carrera->insert('usuarios',$data); 
		return $this->carrera->insert_id();
	}

	function eliminar($id){
		//$this->carrera->cache_delete_all();
		$this->carrera->delete('usuarios', array('id' => $id)); 
	}

}
?>