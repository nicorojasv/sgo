<?php
class Evaluacionesbaterias_model extends CI_Model {
	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}
	
	function listar(){
		$query = $this->wood->get('evaluaciones_baterias');
		return $query->result();
	}
	
	function get($id){
		$this->wood->where('id',$id);
		$query = $this->wood->get('evaluaciones_baterias');
		return $query->row();
	}

	function get_eval($id){
		$this->wood->where('evaluaciones_id',$id);
		$query = $this->wood->get('evaluaciones_baterias');
		return $query->result();
	}
	
	function editar($id,$data){
		$this->wood->where('id', $id);
		$this->wood->update('evaluaciones_baterias', $data); 
	}
	
	function ingresar($data){
		$this->wood->insert('evaluaciones_baterias',$data); 
		return $this->wood->insert_id();
	}
	
	function eliminar($id){
		$this->wood->delete('evaluaciones_baterias', array('id' => $id)); 
	}

	function eliminar_eval($id){
		$this->wood->delete('evaluaciones_baterias', array('evaluaciones_id' => $id)); 
	}

	function get_nombre($nb){
		$this->wood->where('nombre',$nb);
		$query = $this->wood->get('evaluaciones_baterias');
		return $query->row();
	}
}
