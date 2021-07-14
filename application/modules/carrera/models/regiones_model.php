<?php
class Regiones_model extends CI_Model {
	
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function listar(){
		$this->carrera->select('*');
		$this->carrera->from('regiones');
		$query = $this->carrera->get();
		return $query->result();
	}

	function get($id){
		$this->carrera->where('id', $id);
		$query = $this->carrera->get('regiones');
		return $query->row();
	}






	
	function editar($id,$data){
		//$this->carrera->cache_delete_all();
		$this->carrera->where('id', $id);
		$this->carrera->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->general->insert('usuarios',$data); 
		return $this->general->insert_id();
	}

	function eliminar($id){
		//$this->carrera->cache_delete_all();
		$this->carrera->delete('usuarios', array('id' => $id)); 
	}

}
?>