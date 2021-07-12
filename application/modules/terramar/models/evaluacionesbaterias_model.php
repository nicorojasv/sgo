<?php
class Evaluacionesbaterias_model extends CI_Model {
	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}
	
	function listar(){
		$query = $this->terramar->get('evaluaciones_baterias');
		return $query->result();
	}
	
	function get($id){
		$this->terramar->where('id',$id);
		$query = $this->terramar->get('evaluaciones_baterias');
		return $query->row();
	}

	function get_eval($id){
		$this->terramar->where('evaluaciones_id',$id);
		$query = $this->terramar->get('evaluaciones_baterias');
		return $query->result();
	}
	
	function editar($id,$data){
		$this->terramar->where('id', $id);
		$this->terramar->update('evaluaciones_baterias', $data); 
	}
	
	function ingresar($data){
		$this->terramar->insert('evaluaciones_baterias',$data); 
		return $this->terramar->insert_id();
	}
	
	function eliminar($id){
		$this->terramar->delete('evaluaciones_baterias', array('id' => $id)); 
	}

	function eliminar_eval($id){
		$this->terramar->delete('evaluaciones_baterias', array('evaluaciones_id' => $id)); 
	}

	function get_nombre($nb){
		$this->terramar->where('nombre',$nb);
		$query = $this->terramar->get('evaluaciones_baterias');
		return $query->row();
	}
}
