<?php
class Empresas_model extends CI_Model {

	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function listar(){
		$query = $this->terramar->get('empresa');
		return $query->result();
	}
	
	function get($id){
		$this->terramar->where('id',$id);
		$query = $this->terramar->get('empresa');
		return $query->row();
	}
	



	function get_rut($rut){
		$this->terramar->where('rut',$rut);
		$query = $this->terramar->get('empresa');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->terramar->where('id', $id);
		$this->terramar->update('empresa', $data); 
	}
	
	function ingresar($data){
		$this->terramar->insert('empresa',$data); 
		return $this->terramar->insert_id();
	}
	
	function eliminar($id){
		$this->terramar->delete('empresa', array('id' => $id)); 
	}

}