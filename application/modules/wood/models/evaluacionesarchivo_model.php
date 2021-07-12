<?php
class Evaluacionesarchivo_model extends CI_Model{
	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function get($id_eval){
		$this->wood->where("id_evaluacion",$id_eval);
		$query = $this->wood->get("evaluaciones_archivo");
		return $query->row();
	}

	function result_group(){
		$this->wood->select('*');
		$this->wood->from('evaluaciones_archivo');
		$this->wood->group_by('id_evaluacion');
		$query = $this->wood->get();
		return $query->result();
	}

	function contar_cantidad_archivo_eval($id_eval){
		$this->wood->select('count(id) total');
		$this->wood->from('evaluaciones_archivo');
		$this->wood->where('id_evaluacion', $id_eval);
		$query = $this->wood->get();
		return $query->row();

	}

	function ingresar($data){
		$this->wood->insert('evaluaciones_archivo',$data);
		return $this->wood->insert_id();
	}
	
	function editar($id,$data){
		$this->wood->where('id_evaluacion', $id);
		$this->wood->update('evaluaciones_archivo', $data); 
	}

	function eliminar($id){
		$this->wood->delete('evaluaciones_archivo', array('id' => $id));
	}

}