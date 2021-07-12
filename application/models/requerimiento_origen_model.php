<?php
class Requerimiento_origen_model extends CI_Model {
	function listar(){
		$query = $this->db->get('r_requerimiento_origen');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('r_requerimiento_origen');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('r_requerimiento_origen', $data); 
	}
	
	function ingresar($data){
		$this->db->insert('r_requerimiento_origen',$data); 
	}
	function eliminar($id){
		$this->db->delete('r_requerimiento_origen', array('id' => $id)); 
	}
}