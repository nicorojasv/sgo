<?php
class Evaluacionesbaterias_model extends CI_Model {
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}
	
	function listar(){
		$query = $this->carrera->get('evaluaciones_baterias');
		return $query->result();
	}
	
	function get($id){
		$this->carrera->where('id',$id);
		$query = $this->carrera->get('evaluaciones_baterias');
		return $query->row();
	}

	function get_eval($id){
		$this->carrera->where('evaluaciones_id',$id);
		$query = $this->carrera->get('evaluaciones_baterias');
		return $query->result();
	}
	
	function editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('evaluaciones_baterias', $data); 
	}
	
	function ingresar($data){
		$this->carrera->insert('evaluaciones_baterias',$data); 
		return $this->carrera->insert_id();
	}
	
	function eliminar($id){
		$this->carrera->delete('evaluaciones_baterias', array('id' => $id)); 
	}

	function eliminar_eval($id){
		$this->carrera->delete('evaluaciones_baterias', array('evaluaciones_id' => $id)); 
	}

	function get_nombre($nb){
		$this->carrera->where('nombre',$nb);
		$query = $this->carrera->get('evaluaciones_baterias');
		return $query->row();
	}
}
