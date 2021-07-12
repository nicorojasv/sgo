<?php
class Requerimiento_representante_model extends CI_Model {
	function listar(){
		$query = $this->db->get('r_requerimiento_jefe_area');
		return $query->result();
	}
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('r_requerimiento_jefe_area');
		return $query->row();
	}
	
	function ingresar($data){
		$this->db->insert('r_requerimiento_jefe_area',$data); 
	}
	
	function actualizar($data,$id){
		$this->db->where('id', $id);
		$this->db->update('r_requerimiento_jefe_area', $data); 
	}
	
	function eliminar($id){
		$this->db->delete('r_requerimiento_jefe_area', array('id' => $id)); 
	}
}