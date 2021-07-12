<?php
class Origen_trabajador_requerimiento_model extends CI_Model {
	
	function listar(){
		$query = $this->db->get('origen_trabajador_requerimiento');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('origen_trabajador_requerimiento');
		return $query->row();
	}
	
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('origen_trabajador_requerimiento', $data); 
		return $id;
	}
	
	function ingresar($data){
		$this->db->insert('origen_trabajador_requerimiento',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('origen_trabajador_requerimiento', array('id' => $id));
	}
}
?>