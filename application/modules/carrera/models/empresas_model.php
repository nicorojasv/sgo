<?php
class Empresas_model extends CI_Model {

	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function listar(){
		$query = $this->carrera->get('empresa');
		return $query->result();
	}
	
	function get($id){
		$this->carrera->where('id',$id);
		$query = $this->carrera->get('empresa');
		return $query->row();
	}
	



	function get_rut($rut){
		$this->carrera->where('rut',$rut);
		$query = $this->carrera->get('empresa');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('empresa', $data); 
	}
	
	function ingresar($data){
		$this->carrera->insert('empresa',$data); 
		return $this->carrera->insert_id();
	}
	
	function eliminar($id){
		$this->carrera->delete('empresa', array('id' => $id)); 
	}

}