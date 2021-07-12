<?php
class Tipoarchivos_model extends CI_Model {
	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}
	function listar(){
		$this->wood->order_by("desc_tipoarchivo");
		$query = $this->wood->get('tipo_archivos');
		return $query->result();
	}

	function listar_2(){
		$this->wood->order_by("id desc");
		$query = $this->wood->get('tipo_archivos');
		return $query->result();
	}
	
	function get($id){
		$this->wood->where("id",$id);
		$query = $this->wood->get('tipo_archivos');
		return $query->row();
	}
	
	function ingresar($data){
		$this->wood->insert('tipo_archivos',$data);
		return $this->wood->insert_id();
	}
	
	function actualizar($data,$id){
		$this->wood->where('id', $id);
		$this->wood->update('tipo_archivos', $data); 
	}
}