<?php
class Evaluacionesarchivo_model extends CI_Model{
	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function get($id_eval){
		$this->sanatorio->where("id_evaluacion",$id_eval);
		$query = $this->sanatorio->get("evaluaciones_archivo");
		return $query->row();
	}

	function result_group(){
		$this->sanatorio->select('*');
		$this->sanatorio->from('evaluaciones_archivo');
		$this->sanatorio->group_by('id_evaluacion');
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function contar_cantidad_archivo_eval($id_eval){
		$this->sanatorio->select('count(id) total');
		$this->sanatorio->from('evaluaciones_archivo');
		$this->sanatorio->where('id_evaluacion', $id_eval);
		$query = $this->sanatorio->get();
		return $query->row();

	}

	function ingresar($data){
		$this->sanatorio->insert('evaluaciones_archivo',$data);
		return $this->sanatorio->insert_id();
	}
	
	function editar($id,$data){
		$this->sanatorio->where('id_evaluacion', $id);
		$this->sanatorio->update('evaluaciones_archivo', $data); 
	}

	function eliminar($id){
		$this->sanatorio->delete('evaluaciones_archivo', array('id' => $id));
	}

}