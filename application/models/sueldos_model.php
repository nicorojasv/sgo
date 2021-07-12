<?php
class Sueldos_model extends CI_Model {
	
	function listar(){
		$query = $this->db->get('sueldos');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('sueldos');
		return $query->row();
	}
	
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('sueldos', $data); 
		return $id;
	}
	
	function ingresar($data){
		$this->db->insert('sueldos',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('sueldos', array('id' => $id));
	}
}
?>