<?php
class Fotostrab_model extends CI_Model {

	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function listar(){
		$query = $this->terramar->get('fotos_trab');
		return $query->result();
	}
	
	function get($id){
		$this->terramar->where('id',$id);
		$query = $this->terramar->get('fotos_trab');
		return $query->row();
	}
	function get_usuario($id){
		$this->terramar->where('id_usuarios',$id);
		$query = $this->terramar->get('fotos_trab');
		return $query->row();
	}
	
	function ingresar($data){
		$this->terramar->insert('fotos_trab',$data); 
	}
	
	function editar($id,$data){
		$this->terramar->where('id', $id);
		$this->terramar->update('fotos_trab', $data); 
	}
	
	function borrar($id){
		$this->terramar->where('id_usuarios', $id);
		$this->terramar->delete('fotos_trab');
	}
}