<?php
class Motivosfalta_model extends CI_Model {
	
	function listar(){
		$query = $this->db->get('motivos_falta');
		$this->db->order_by("id");
		return $query->result();
	}
	
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('motivos_falta');
		return $query->row();
	}
	
	function eliminar($id){
		$this->db->delete('motivos_falta', array('id' => $id)); 
	}
	
	function ingresar($data){
		$this->db->insert('motivos_falta',$data);
		return $this->db->insert_id();
	}
}