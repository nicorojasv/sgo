<?php
class Evaluacionesevaluacion_model extends CI_Model {
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}
	
	function listar(){
		$query = $this->carrera->get('evaluaciones_evaluacion');
		return $query->result();
	}
	
	function get($id){
		$this->carrera->where('id',$id);
		$query = $this->carrera->get('evaluaciones_evaluacion');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('evaluaciones_evaluacion', $data); 
		return $id;
	}
	
	function ingresar($data){
		$this->carrera->insert('evaluaciones_evaluacion',$data); 
		return $this->carrera->insert_id();
	}
	
	function eliminar($id){
		$this->carrera->delete('evaluaciones_evaluacion', array('id' => $id)); 
	}
	function get_nombre($nb){
		$this->carrera->where('nombre',$nb);
		$query = $this->carrera->get('evaluaciones_evaluacion');
		return $query->row();
	}
	function get_tipo($id_tipo){
		$this->carrera->where('id_tipo',$id_tipo);
		$query = $this->carrera->get('evaluaciones_evaluacion');
		return $query->result();
	}
}
