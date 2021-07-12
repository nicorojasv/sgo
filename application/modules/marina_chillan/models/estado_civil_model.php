<?php
class Estado_civil_model extends CI_Model {
	
	function __construct(){
		$this->marina_chillan = $this->load->database('marina_chillan', TRUE);
	}

	function listar(){
		$this->marina_chillan->select('*');
		$this->marina_chillan->from('estado_civil');
		$query = $this->marina_chillan->get();
		return $query->result();
	}

	function get($id){
		$this->marina_chillan->where('id', $id);
		$query = $this->marina_chillan->get('estado_civil');
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