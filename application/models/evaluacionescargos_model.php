<?php
class Evaluacionescargos_model extends CI_Model {
	
	function ingresar($data){
		$this->db->insert('evaluaciones_cargos',$data); 
		return $this->db->insert_id();
	}

	function eliminar_eval($id){
		$this->db->delete('evaluaciones_cargos', array('id_evaluacion' => $id)); 
	}

	function get_eval($id){
		$this->db->where('id_evaluacion',$id);
		$query = $this->db->get('evaluaciones_cargos');
		return $query->result();
	}

	function get($cargo_id, $id_evaluacion = FALSE){
		$this->db->where('id_r_cargo',$cargo_id);
		$this->db->where('id_evaluacion',$id_evaluacion);
		$query = $this->db->get('evaluaciones_cargos');
		return $query->row();
	}




	/*
	function listar(){
		$query = $this->db->get('evaluaciones_baterias');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('evaluaciones_baterias');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('evaluaciones_baterias', $data); 
	}
	
	function eliminar($id){
		$this->db->delete('evaluaciones_baterias', array('id' => $id)); 
	}

	function get_nombre($nb){
		$this->db->where('nombre',$nb);
		$query = $this->db->get('evaluaciones_baterias');
		return $query->row();
	}
	*/

}
?>