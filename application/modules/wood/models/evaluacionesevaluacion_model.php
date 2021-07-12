<?php
class Evaluacionesevaluacion_model extends CI_Model {
	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}
	
	function listar(){
		$query = $this->wood->get('evaluaciones_evaluacion');
		return $query->result();
	}
	
	function get($id){
		$this->wood->where('id',$id);
		$query = $this->wood->get('evaluaciones_evaluacion');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->wood->where('id', $id);
		$this->wood->update('evaluaciones_evaluacion', $data); 
		return $id;
	}
	
	function ingresar($data){
		$this->wood->insert('evaluaciones_evaluacion',$data); 
		return $this->wood->insert_id();
	}
	
	function eliminar($id){
		$this->wood->delete('evaluaciones_evaluacion', array('id' => $id)); 
	}
	function get_nombre($nb){
		$this->wood->where('nombre',$nb);
		$query = $this->wood->get('evaluaciones_evaluacion');
		return $query->row();
	}
	function get_tipo($id_tipo){
		$this->wood->where('id_tipo',$id_tipo);
		$query = $this->wood->get('evaluaciones_evaluacion');
		return $query->result();
	}
}
