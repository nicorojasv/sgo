<?php
class Empresas_model extends CI_Model {

	function __construct(){
		$this->aramark = $this->load->database('aramark', TRUE);
	}

	function listar(){
		$query = $this->aramark->get('empresa');
		return $query->result();
	}
	
	function get($id){
		$this->aramark->where('id',$id);
		$query = $this->aramark->get('empresa');
		return $query->row();
	}
	



	function get_rut($rut){
		$this->db->where('rut',$rut);
		$query = $this->db->get('empresa');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('empresa', $data); 
	}
	
	function ingresar($data){
		$this->db->insert('empresa',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('empresa', array('id' => $id)); 
	}

}