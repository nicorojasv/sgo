<?php
class Profesiones_model extends CI_Model {
	
	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function listar(){
		$this->terramar->select('*');
		$this->terramar->from('profesiones');
		$query = $this->terramar->get();
		return $query->result();
	}

	function get($id){
		$this->terramar->where('id', $id);
		$query = $this->terramar->get('profesiones');
		return $query->row();
	}


	
	function editar($id,$data){
		//$this->terramar->cache_delete_all();
		$this->terramar->where('id', $id);
		$this->terramar->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->terramar->insert('usuarios',$data); 
		return $this->terramar->insert_id();
	}

	function eliminar($id){
		//$this->terramar->cache_delete_all();
		$this->terramar->delete('usuarios', array('id' => $id)); 
	}

}
?>