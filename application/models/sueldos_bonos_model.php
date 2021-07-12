<?php
class Sueldos_bonos_model extends CI_Model {
	
	function listar(){
		$query = $this->db->get('sueldos_bonos');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('sueldos_bonos');
		return $query->row();
	}
	
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('sueldos_bonos', $data); 
		return $id;
	}
	
	function ingresar($data){
		$this->db->insert('sueldos_bonos',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('sueldos_bonos', array('id' => $id));
	}
}
?>