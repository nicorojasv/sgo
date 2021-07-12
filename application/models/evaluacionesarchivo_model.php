<?php
class Evaluacionesarchivo_model extends CI_Model{

	function get($id_eval){
		$this->db->where("id_evaluacion",$id_eval);
		$query = $this->db->get("evaluaciones_archivo");
		return $query->row();
	}

	function result_group(){
		$this->db->select('*');
		$this->db->from('evaluaciones_archivo');
		$this->db->group_by('id_evaluacion');
		$query = $this->db->get();
		return $query->result();
	}

	function contar_cantidad_archivo_eval($id_eval){
		$this->db->select('count(id) total');
		$this->db->from('evaluaciones_archivo');
		$this->db->where('id_evaluacion', $id_eval);
		$query = $this->db->get();
		return $query->row();

	}

	function ingresar($data){
		$this->db->insert('evaluaciones_archivo',$data);
		return $this->db->insert_id();
	}
	
	function editar($id,$data){
		$this->db->where('id_evaluacion', $id);
		$this->db->update('evaluaciones_archivo', $data); 
	}

	function eliminar($id){
		$this->db->delete('evaluaciones_archivo', array('id' => $id));
	}

}