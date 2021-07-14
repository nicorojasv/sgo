<?php
class Evaluacionestipo_model extends CI_Model {
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}
	
	function listar(){
		$query = $this->carrera->get('evaluaciones_tipo');
		return $query->result();
	}
	
	function get($id){
		$this->carrera->where('id',$id);
		$query = $this->carrera->get('evaluaciones_tipo');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('evaluaciones_tipo', $data); 
	}
	
	function ingresar($data){
		$this->carrera->insert('evaluaciones_tipo',$data); 
		return $this->carrera->insert_id();
	}
	
	function eliminar($id){
		$this->carrera->delete('evaluaciones_tipo', array('id' => $id)); 
	}
	
	function get_nombre($nb){
		$this->carrera->where('nombre',$nb);
		$query = $this->carrera->get('evaluaciones_tipo');
		return $query->row();
	}
	
	function get_eval($id){
		$this->carrera->select('*,ee.id as id_eval, ee.nombre as nombre_eval');
		$this->carrera->from('evaluaciones_tipo et');
		$this->carrera->join('evaluaciones_evaluacion ee','ee.id_tipo = et.id');
		$this->carrera->where('et.id',$id);
		$query = $this->carrera->get();
		return $query->result();
	}
	function get_examen($id){
		$this->carrera->select('*,ee.id as id_eval, ee.nombre as nombre_eval');
		$this->carrera->from('evaluaciones_tipo et');
		$this->carrera->join('evaluaciones_evaluacion ee','ee.id_tipo = et.id');
		$this->carrera->where('ee.id',$id);
		$query = $this->carrera->get();
		return $query->row();
	}
}
