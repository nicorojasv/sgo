<?php
class Evaluacionestipo_model extends CI_Model {
	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}
	
	function listar(){
		$query = $this->sanatorio->get('evaluaciones_tipo');
		return $query->result();
	}
	
	function get($id){
		$this->sanatorio->where('id',$id);
		$query = $this->sanatorio->get('evaluaciones_tipo');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('evaluaciones_tipo', $data); 
	}
	
	function ingresar($data){
		$this->sanatorio->insert('evaluaciones_tipo',$data); 
		return $this->sanatorio->insert_id();
	}
	
	function eliminar($id){
		$this->sanatorio->delete('evaluaciones_tipo', array('id' => $id)); 
	}
	
	function get_nombre($nb){
		$this->sanatorio->where('nombre',$nb);
		$query = $this->sanatorio->get('evaluaciones_tipo');
		return $query->row();
	}
	
	function get_eval($id){
		$this->sanatorio->select('*,ee.id as id_eval, ee.nombre as nombre_eval');
		$this->sanatorio->from('evaluaciones_tipo et');
		$this->sanatorio->join('evaluaciones_evaluacion ee','ee.id_tipo = et.id');
		$this->sanatorio->where('et.id',$id);
		$query = $this->sanatorio->get();
		return $query->result();
	}
	function get_examen($id){
		$this->sanatorio->select('*,ee.id as id_eval, ee.nombre as nombre_eval');
		$this->sanatorio->from('evaluaciones_tipo et');
		$this->sanatorio->join('evaluaciones_evaluacion ee','ee.id_tipo = et.id');
		$this->sanatorio->where('ee.id',$id);
		$query = $this->sanatorio->get();
		return $query->row();
	}
}
