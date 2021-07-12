<?php
class Evaluacionesevaluacion_model extends CI_Model {
	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}
	
	function listar(){
		$query = $this->sanatorio->get('evaluaciones_evaluacion');
		return $query->result();
	}
	
	function get($id){
		$this->sanatorio->where('id',$id);
		$query = $this->sanatorio->get('evaluaciones_evaluacion');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('evaluaciones_evaluacion', $data); 
		return $id;
	}
	
	function ingresar($data){
		$this->sanatorio->insert('evaluaciones_evaluacion',$data); 
		return $this->sanatorio->insert_id();
	}
	
	function eliminar($id){
		$this->sanatorio->delete('evaluaciones_evaluacion', array('id' => $id)); 
	}
	function get_nombre($nb){
		$this->sanatorio->where('nombre',$nb);
		$query = $this->sanatorio->get('evaluaciones_evaluacion');
		return $query->row();
	}
	function get_tipo($id_tipo){
		$this->sanatorio->where('id_tipo',$id_tipo);
		$query = $this->sanatorio->get('evaluaciones_evaluacion');
		return $query->result();
	}
}
