<?php
class Salud_model extends CI_Model {
	
	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function listar(){
		$this->wood->select('*');
		$this->wood->from('salud');
		$query = $this->wood->get();
		return $query->result();
	}

	function get($id){
		$this->wood->where('id', $id);
		$query = $this->wood->get('salud');
		return $query->row();
	}





	
	function editar($id,$data){
		//$this->db->cache_delete_all();
		$this->db->where('id', $id);
		$this->db->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->general->insert('usuarios',$data); 
		return $this->general->insert_id();
	}

	function eliminar($id){
		//$this->db->cache_delete_all();
		$this->db->delete('usuarios', array('id' => $id)); 
	}

}
?>