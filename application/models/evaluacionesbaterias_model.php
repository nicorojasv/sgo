<?php
class Evaluacionesbaterias_model extends CI_Model {
	
	function listar(){
		$query = $this->db->get('evaluaciones_baterias');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('evaluaciones_baterias');
		return $query->row();
	}

	function get_eval($id){
		$this->db->where('evaluaciones_id',$id);
		$query = $this->db->get('evaluaciones_baterias');
		return $query->result();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('evaluaciones_baterias', $data); 
	}
	
	function ingresar($data){
		$this->db->insert('evaluaciones_baterias',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('evaluaciones_baterias', array('id' => $id)); 
	}

	function eliminar_eval($id){
		$this->db->delete('evaluaciones_baterias', array('evaluaciones_id' => $id)); 
	}

	function get_nombre($nb){
		$this->db->where('nombre',$nb);
		$query = $this->db->get('evaluaciones_baterias');
		return $query->row();
	}
}
