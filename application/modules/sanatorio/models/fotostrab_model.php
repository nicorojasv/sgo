<?php
class Fotostrab_model extends CI_Model {

	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function listar(){
		$query = $this->sanatorio->get('fotos_trab');
		return $query->result();
	}
	
	function get($id){
		$this->sanatorio->where('id',$id);
		$query = $this->sanatorio->get('fotos_trab');
		return $query->row();
	}
	function get_usuario($id){
		$this->sanatorio->where('id_usuarios',$id);
		$query = $this->sanatorio->get('fotos_trab');
		return $query->row();
	}
	
	function ingresar($data){
		$this->sanatorio->insert('fotos_trab',$data); 
	}
	
	function editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('fotos_trab', $data); 
	}
	
	function borrar($id){
		$this->sanatorio->where('id_usuarios', $id);
		$this->sanatorio->delete('fotos_trab');
	}
}