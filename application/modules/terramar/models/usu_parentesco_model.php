<?php
class Usu_parentesco_model extends CI_Model {
	
	function __construct(){
		$this->enjoy = $this->load->database('enjoy', TRUE);
	}

	function listar(){
		$this->enjoy->select('*');
		$this->enjoy->from('usu_parentesco');
		$query = $this->enjoy->get();
		return $query->result();
	}

	function get($id){
		$this->enjoy->where('id', $id);
		$query = $this->enjoy->get('usu_parentesco');
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