<?php
class Evaluacionesarchivo_model extends CI_Model{
	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function get($id_eval){
		$this->terramar->where("id_evaluacion",$id_eval);
		$query = $this->terramar->get("evaluaciones_archivo");
		return $query->row();
	}

	function result_group(){
		$this->terramar->select('*');
		$this->terramar->from('evaluaciones_archivo');
		$this->terramar->group_by('id_evaluacion');
		$query = $this->terramar->get();
		return $query->result();
	}

	function contar_cantidad_archivo_eval($id_eval){
		$this->terramar->select('count(id) total');
		$this->terramar->from('evaluaciones_archivo');
		$this->terramar->where('id_evaluacion', $id_eval);
		$query = $this->terramar->get();
		return $query->row();

	}

	function ingresar($data){
		$this->terramar->insert('evaluaciones_archivo',$data);
		return $this->terramar->insert_id();
	}
	
	function editar($id,$data){
		$this->terramar->where('id_evaluacion', $id);
		$this->terramar->update('evaluaciones_archivo', $data); 
	}

	function eliminar($id){
		$this->terramar->delete('evaluaciones_archivo', array('id' => $id));
	}

}