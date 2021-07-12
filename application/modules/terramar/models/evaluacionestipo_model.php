<?php
class Evaluacionestipo_model extends CI_Model {
	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}
	
	function listar(){
		$query = $this->terramar->get('evaluaciones_tipo');
		return $query->result();
	}
	
	function get($id){
		$this->terramar->where('id',$id);
		$query = $this->terramar->get('evaluaciones_tipo');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->terramar->where('id', $id);
		$this->terramar->update('evaluaciones_tipo', $data); 
	}
	
	function ingresar($data){
		$this->terramar->insert('evaluaciones_tipo',$data); 
		return $this->terramar->insert_id();
	}
	
	function eliminar($id){
		$this->terramar->delete('evaluaciones_tipo', array('id' => $id)); 
	}
	
	function get_nombre($nb){
		$this->terramar->where('nombre',$nb);
		$query = $this->terramar->get('evaluaciones_tipo');
		return $query->row();
	}
	
	function get_eval($id){
		$this->terramar->select('*,ee.id as id_eval, ee.nombre as nombre_eval');
		$this->terramar->from('evaluaciones_tipo et');
		$this->terramar->join('evaluaciones_evaluacion ee','ee.id_tipo = et.id');
		$this->terramar->where('et.id',$id);
		$query = $this->terramar->get();
		return $query->result();
	}
	function get_examen($id){
		$this->terramar->select('*,ee.id as id_eval, ee.nombre as nombre_eval');
		$this->terramar->from('evaluaciones_tipo et');
		$this->terramar->join('evaluaciones_evaluacion ee','ee.id_tipo = et.id');
		$this->terramar->where('ee.id',$id);
		$query = $this->terramar->get();
		return $query->row();
	}
}
