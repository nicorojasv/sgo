<?php
class Tipoarchivos_model extends CI_Model {
	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}
	function listar(){
		$this->sanatorio->order_by("desc_tipoarchivo");
		$query = $this->sanatorio->get('tipo_archivos');
		return $query->result();
	}

	function listar_2(){
		$this->sanatorio->order_by("id desc");
		$query = $this->sanatorio->get('tipo_archivos');
		return $query->result();
	}
	
	function get($id){
		$this->sanatorio->where("id",$id);
		$query = $this->sanatorio->get('tipo_archivos');
		return $query->row();
	}
	
	function ingresar($data){
		$this->sanatorio->insert('tipo_archivos',$data);
		return $this->sanatorio->insert_id();
	}
	
	function actualizar($data,$id){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('tipo_archivos', $data); 
	}
}