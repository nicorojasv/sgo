<?php
class Empresas_model extends CI_Model {

	function __construct(){
		$this->marina_chillan = $this->load->database('marina_chillan', TRUE);
	}

	function listar(){
		$query = $this->marina_chillan->get('empresa');
		return $query->result();
	}
	
	function get($id){
		$this->marina_chillan->where('id',$id);
		$query = $this->marina_chillan->get('empresa');
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