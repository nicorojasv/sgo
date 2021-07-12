<?php
class Empresas_model extends CI_Model {

	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function listar(){
		$query = $this->sanatorio->get('empresa');
		return $query->result();
	}
	
	function get($id){
		$this->sanatorio->where('id',$id);
		$query = $this->sanatorio->get('empresa');
		return $query->row();
	}
	



	function get_rut($rut){
		$this->sanatorio->where('rut',$rut);
		$query = $this->sanatorio->get('empresa');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('empresa', $data); 
	}
	
	function ingresar($data){
		$this->sanatorio->insert('empresa',$data); 
		return $this->sanatorio->insert_id();
	}
	
	function eliminar($id){
		$this->sanatorio->delete('empresa', array('id' => $id)); 
	}

}