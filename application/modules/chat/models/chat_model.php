<?php
class Chat_model extends CI_Model {
	
	function __construct(){
		$this->general = $this->load->database('general', TRUE);
	}

 
	function listar_usuario($yo){
		$this->general->where('chat',1);
		$this->general->where('id !=', $yo);
		$query = $this->general->get('usuarios');
		return $query->result();
	}

	function listar(){
		$query = $this->general->get('chat');
		return $query->result();
	}

	function conversacion($usuario,$yo){
		$query = $this->general->query("SELECT * FROM chat WHERE ( from_id = $yo AND to_id = $usuario ) OR ( from_id = $usuario AND to_id = $yo ) ORDER BY sent DESC");
		return $query->result();
	}

	function get($id){
		$this->general->where("id",$id);
		$query = $this->general->get('chat');
		return $query->row();
	}

	function buscar($palabra){
		$this->general->where("desc_afp",$palabra);
		$query = $this->general->get('chat');
		return $query->row();
	}
	
	function ingresar($data){
		$this->general->insert('chat',$data); 
		if($this->general->affected_rows() > 0){
			// Code here after successful insert
			return true; // to the controller
		}
	}
	
	function actualizar($data,$id){
		$this->general->where('id', $id);
		$this->general->update('chat', $data); 
	}
}