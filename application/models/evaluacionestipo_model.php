<?php
class Evaluacionestipo_model extends CI_Model {
	
	function listar(){
		$query = $this->db->get('evaluaciones_tipo');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('evaluaciones_tipo');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('evaluaciones_tipo', $data); 
	}
	
	function ingresar($data){
		$this->db->insert('evaluaciones_tipo',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('evaluaciones_tipo', array('id' => $id)); 
	}
	
	function get_nombre($nb){
		$this->db->where('nombre',$nb);
		$query = $this->db->get('evaluaciones_tipo');
		return $query->row();
	}
	
	function get_eval($id){
		$this->db->select('*,ee.id as id_eval, ee.nombre as nombre_eval');
		$this->db->from('evaluaciones_tipo et');
		$this->db->join('evaluaciones_evaluacion ee','ee.id_tipo = et.id');
		$this->db->where('et.id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	function get_examen($id){
		$this->db->select('*,ee.id as id_eval, ee.nombre as nombre_eval');
		$this->db->from('evaluaciones_tipo et');
		$this->db->join('evaluaciones_evaluacion ee','ee.id_tipo = et.id');
		$this->db->where('ee.id',$id);
		$query = $this->db->get();
		return $query->row();
	}
}
