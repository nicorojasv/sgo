<?php
class Tipoarchivos_model extends CI_Model {
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}
	function listar(){
		$this->carrera->order_by("desc_tipoarchivo");
		$query = $this->carrera->get('tipo_archivos');
		return $query->result();
	}

	function listar_2(){
		$this->carrera->order_by("id desc");
		$query = $this->carrera->get('tipo_archivos');
		return $query->result();
	}
	
	function get($id){
		$this->carrera->where("id",$id);
		$query = $this->carrera->get('tipo_archivos');
		return $query->row();
	}
	
	function ingresar($data){
		$this->carrera->insert('tipo_archivos',$data);
		return $this->carrera->insert_id();
	}
	
	function actualizar($data,$id){
		$this->carrera->where('id', $id);
		$this->carrera->update('tipo_archivos', $data); 
	}
}