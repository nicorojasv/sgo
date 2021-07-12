<?php
class Grupo_trabajadores_model extends CI_Model {

	function listar(){
		$query = $this->db->get('grupo_trabajadores');
		return $query->result();
	}

	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('grupo_trabajadores');
		return $query->row();
	}

	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('grupo_trabajadores', $data); 
	}

	function ingresar($data){
		$this->db->insert('grupo_trabajadores',$data); 
		return $this->db->insert_id();
	}

	function eliminar($id){
		$this->db->delete('grupo_trabajadores', array('id' => $id)); 
	}
}