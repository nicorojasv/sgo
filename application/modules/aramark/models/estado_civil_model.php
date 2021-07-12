<?php
class Estado_civil_model extends CI_Model {
	
	function __construct(){
		$this->aramark = $this->load->database('aramark', TRUE);
	}

	function listar(){
		$this->aramark->select('*');
		$this->aramark->from('estado_civil');
		$query = $this->aramark->get();
		return $query->result();
	}

	function get($id){
		$this->aramark->where('id', $id);
		$query = $this->aramark->get('estado_civil');
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