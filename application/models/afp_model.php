<?php
class Afp_model extends CI_Model{

	function listar(){
		$query = $this->db->get('afp');
		return $query->result();
	}

	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('afp');
		return $query->row();
	}

	function buscar($palabra){
		$this->db->where("desc_afp",$palabra);
		$query = $this->db->get('afp');
		return $query->row();
	}
	
	function ingresar($data){
		$this->db->insert('afp',$data); 
	}
	
	function actualizar($data,$id){
		$this->db->where('id', $id);
		$this->db->update('afp', $data); 
	}
}