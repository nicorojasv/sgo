<?php
class Evaluacionesevaluacion_model extends CI_Model {
	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}
	
	function listar(){
		$query = $this->terramar->get('evaluaciones_evaluacion');
		return $query->result();
	}
	
	function get($id){
		$this->terramar->where('id',$id);
		$query = $this->terramar->get('evaluaciones_evaluacion');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->terramar->where('id', $id);
		$this->terramar->update('evaluaciones_evaluacion', $data); 
		return $id;
	}
	
	function ingresar($data){
		$this->terramar->insert('evaluaciones_evaluacion',$data); 
		return $this->terramar->insert_id();
	}
	
	function eliminar($id){
		$this->terramar->delete('evaluaciones_evaluacion', array('id' => $id)); 
	}
	function get_nombre($nb){
		$this->terramar->where('nombre',$nb);
		$query = $this->terramar->get('evaluaciones_evaluacion');
		return $query->row();
	}
	function get_tipo($id_tipo){
		$this->terramar->where('id_tipo',$id_tipo);
		$query = $this->terramar->get('evaluaciones_evaluacion');
		return $query->result();
	}
}
