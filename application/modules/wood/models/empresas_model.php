<?php
class Empresas_model extends CI_Model {

	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function listar(){
		$query = $this->wood->get('empresa');
		return $query->result();
	}
	
	function get($id){
		$this->wood->where('id',$id);
		$query = $this->wood->get('empresa');
		return $query->row();
	}
	



	function get_rut($rut){
		$this->wood->where('rut',$rut);
		$query = $this->wood->get('empresa');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->wood->where('id', $id);
		$this->wood->update('empresa', $data); 
	}
	
	function ingresar($data){
		$this->wood->insert('empresa',$data); 
		return $this->wood->insert_id();
	}
	
	function eliminar($id){
		$this->wood->delete('empresa', array('id' => $id)); 
	}

}