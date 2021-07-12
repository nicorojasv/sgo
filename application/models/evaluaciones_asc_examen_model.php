<?php
class Evaluaciones_asc_examen_model extends CI_Model {
	function listar(){
		$query = $this->db->get('evaluaciones_asc_examen');
		return $query->result();
	}
	
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('evaluaciones_asc_examen');
		return $query->row();
	}
	
	function ingresar($data){
		$this->db->insert('evaluaciones_asc_examen',$data); 
	}
	
	function actualizar($data,$id){
		$this->db->where('id', $id);
		$this->db->update('evaluaciones_asc_examen', $data); 
	}
}