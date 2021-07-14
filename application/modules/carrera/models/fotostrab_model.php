<?php
class Fotostrab_model extends CI_Model {

	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function listar(){
		$query = $this->carrera->get('fotos_trab');
		return $query->result();
	}
	
	function get($id){
		$this->carrera->where('id',$id);
		$query = $this->carrera->get('fotos_trab');
		return $query->row();
	}
	function get_usuario($id){
		$this->carrera->where('id_usuarios',$id);
		$query = $this->carrera->get('fotos_trab');
		return $query->row();
	}
	
	function ingresar($data){
		$this->carrera->insert('fotos_trab',$data); 
	}
	
	function editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('fotos_trab', $data); 
	}
	
	function borrar($id){
		$this->carrera->where('id_usuarios', $id);
		$this->carrera->delete('fotos_trab');
	}
}