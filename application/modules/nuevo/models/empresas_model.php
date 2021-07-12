<?php
class Empresas_model extends CI_Model {

	function __construct(){
		$this->enjoy = $this->load->database('enjoy', TRUE);
	}

	function listar(){
		$query = $this->enjoy->get('empresa');
		return $query->result();
	}
	
	function get($id){
		$this->enjoy->where('id',$id);
		$query = $this->enjoy->get('empresa');
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