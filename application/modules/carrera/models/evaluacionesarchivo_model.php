<?php
class Evaluacionesarchivo_model extends CI_Model{
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function get($id_eval){
		$this->carrera->where("id_evaluacion",$id_eval);
		$query = $this->carrera->get("evaluaciones_archivo");
		return $query->row();
	}

	function result_group(){
		$this->carrera->select('*');
		$this->carrera->from('evaluaciones_archivo');
		$this->carrera->group_by('id_evaluacion');
		$query = $this->carrera->get();
		return $query->result();
	}

	function contar_cantidad_archivo_eval($id_eval){
		$this->carrera->select('count(id) total');
		$this->carrera->from('evaluaciones_archivo');
		$this->carrera->where('id_evaluacion', $id_eval);
		$query = $this->carrera->get();
		return $query->row();

	}

	function ingresar($data){
		$this->carrera->insert('evaluaciones_archivo',$data);
		return $this->carrera->insert_id();
	}
	
	function editar($id,$data){
		$this->carrera->where('id_evaluacion', $id);
		$this->carrera->update('evaluaciones_archivo', $data); 
	}

	function eliminar($id){
		$this->carrera->delete('evaluaciones_archivo', array('id' => $id));
	}

}