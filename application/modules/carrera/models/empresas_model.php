<?php
class Empresas_model extends CI_Model {

	function __construct(){
		$this->carerra = $this->load->database('carerra', TRUE);
	}

	function listar(){
		$query = $this->carerra->get('empresa');
		return $query->result();
	}
	
	function get($id){
		$this->carerra->where('id',$id);
		$query = $this->carerra->get('empresa');
		return $query->row();
	}
	



	function get_rut($rut){
		$this->carerra->where('rut',$rut);
		$query = $this->carerra->get('empresa');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->carerra->where('id', $id);
		$this->carerra->update('empresa', $data); 
	}
	
	function ingresar($data){
		$this->carerra->insert('empresa',$data); 
		return $this->carerra->insert_id();
	}
	
	function eliminar($id){
		$this->carerra->delete('empresa', array('id' => $id)); 
	}

}