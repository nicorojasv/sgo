<?php
class Subusuarios_model extends CI_Model {
	function listar(){
		$query = $this->db->get('subusuarios');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('subusuarios');
		return $query->row();
	}
	
	function get_usuario($id_usr){
		$this->db->where('id_usuarios',$id_usr);
		$query = $this->db->get('subusuarios');
		return $query->result();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('subusuarios', $data); 
	}
	
	function ingresar($data){
		$this->db->insert('subusuarios',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('subusuarios', array('id' => $id)); 
	}
}