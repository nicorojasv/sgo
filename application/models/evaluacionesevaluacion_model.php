<?php
class Evaluacionesevaluacion_model extends CI_Model {
	
	function listar(){
		$query = $this->db->get('evaluaciones_evaluacion');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('evaluaciones_evaluacion');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('evaluaciones_evaluacion', $data); 
		return $id;
	}
	
	function ingresar($data){
		$this->db->insert('evaluaciones_evaluacion',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('evaluaciones_evaluacion', array('id' => $id)); 
	}
	function get_nombre($nb){
		$this->db->where('nombre',$nb);
		$query = $this->db->get('evaluaciones_evaluacion');
		return $query->row();
	}
	function get_tipo($id_tipo){
		$this->db->where('id_tipo',$id_tipo);
		$query = $this->db->get('evaluaciones_evaluacion');
		return $query->result();
	}
}
