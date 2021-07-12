<?php
class Fotostrab_model extends CI_Model {

	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function listar(){
		$query = $this->wood->get('fotos_trab');
		return $query->result();
	}
	
	function get($id){
		$this->wood->where('id',$id);
		$query = $this->wood->get('fotos_trab');
		return $query->row();
	}
	function get_usuario($id){
		$this->wood->where('id_usuarios',$id);
		$query = $this->wood->get('fotos_trab');
		return $query->row();
	}
	
	function ingresar($data){
		$this->wood->insert('fotos_trab',$data); 
	}
	
	function editar($id,$data){
		$this->wood->where('id', $id);
		$this->wood->update('fotos_trab', $data); 
	}
	
	function borrar($id){
		$this->wood->where('id_usuarios', $id);
		$this->wood->delete('fotos_trab');
	}
}