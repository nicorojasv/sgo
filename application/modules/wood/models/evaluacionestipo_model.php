<?php
class Evaluacionestipo_model extends CI_Model {
	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}
	
	function listar(){
		$query = $this->wood->get('evaluaciones_tipo');
		return $query->result();
	}
	
	function get($id){
		$this->wood->where('id',$id);
		$query = $this->wood->get('evaluaciones_tipo');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->wood->where('id', $id);
		$this->wood->update('evaluaciones_tipo', $data); 
	}
	
	function ingresar($data){
		$this->wood->insert('evaluaciones_tipo',$data); 
		return $this->wood->insert_id();
	}
	
	function eliminar($id){
		$this->wood->delete('evaluaciones_tipo', array('id' => $id)); 
	}
	
	function get_nombre($nb){
		$this->wood->where('nombre',$nb);
		$query = $this->wood->get('evaluaciones_tipo');
		return $query->row();
	}
	
	function get_eval($id){
		$this->wood->select('*,ee.id as id_eval, ee.nombre as nombre_eval');
		$this->wood->from('evaluaciones_tipo et');
		$this->wood->join('evaluaciones_evaluacion ee','ee.id_tipo = et.id');
		$this->wood->where('et.id',$id);
		$query = $this->wood->get();
		return $query->result();
	}
	function get_examen($id){
		$this->wood->select('*,ee.id as id_eval, ee.nombre as nombre_eval');
		$this->wood->from('evaluaciones_tipo et');
		$this->wood->join('evaluaciones_evaluacion ee','ee.id_tipo = et.id');
		$this->wood->where('ee.id',$id);
		$query = $this->wood->get();
		return $query->row();
	}
}
