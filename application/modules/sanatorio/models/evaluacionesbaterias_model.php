<?php
class Evaluacionesbaterias_model extends CI_Model {
	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}
	
	function listar(){
		$query = $this->sanatorio->get('evaluaciones_baterias');
		return $query->result();
	}
	
	function get($id){
		$this->sanatorio->where('id',$id);
		$query = $this->sanatorio->get('evaluaciones_baterias');
		return $query->row();
	}

	function get_eval($id){
		$this->sanatorio->where('evaluaciones_id',$id);
		$query = $this->sanatorio->get('evaluaciones_baterias');
		return $query->result();
	}
	
	function editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('evaluaciones_baterias', $data); 
	}
	
	function ingresar($data){
		$this->sanatorio->insert('evaluaciones_baterias',$data); 
		return $this->sanatorio->insert_id();
	}
	
	function eliminar($id){
		$this->sanatorio->delete('evaluaciones_baterias', array('id' => $id)); 
	}

	function eliminar_eval($id){
		$this->sanatorio->delete('evaluaciones_baterias', array('evaluaciones_id' => $id)); 
	}

	function get_nombre($nb){
		$this->sanatorio->where('nombre',$nb);
		$query = $this->sanatorio->get('evaluaciones_baterias');
		return $query->row();
	}
}
