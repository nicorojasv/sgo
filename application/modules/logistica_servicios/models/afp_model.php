<?php
class Afp_model extends CI_Model {
	
	function __construct(){
		$this->log_serv = $this->load->database('log_serv', TRUE);
	}

	function listar(){
		$this->log_serv->select('*');
		$this->log_serv->from('afp');
		$query = $this->log_serv->get();
		return $query->result();
	}

	function get($id){
		$this->log_serv->where('id', $id);
		$query = $this->log_serv->get('afp');
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