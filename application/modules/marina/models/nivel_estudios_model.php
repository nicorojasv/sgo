<?php
class Nivel_estudios_model extends CI_Model {
	
	function __construct(){
		$this->marina = $this->load->database('marina', TRUE);
	}

	function listar(){
		$this->marina->select('*');
		$this->marina->from('nivel_estudios');
		$query = $this->marina->get();
		return $query->result();
	}

	function get($id){
		$this->marina->where('id', $id);
		$query = $this->marina->get('nivel_estudios');
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