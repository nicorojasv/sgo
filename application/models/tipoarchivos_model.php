<?php
class Tipoarchivos_model extends CI_Model {
	function listar(){
		$this->db->order_by("desc_tipoarchivo");
		$query = $this->db->get('tipo_archivos');
		return $query->result();
	}

	function listar_2(){
		$this->db->order_by("id desc");
		$query = $this->db->get('tipo_archivos');
		return $query->result();
	}
	
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('tipo_archivos');
		return $query->row();
	}
	
	function ingresar($data){
		$this->db->insert('tipo_archivos',$data);
		return $this->db->insert_id();
	}
	
	function actualizar($data,$id){
		$this->db->where('id', $id);
		$this->db->update('tipo_archivos', $data); 
	}
}