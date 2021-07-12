<?php
class Bancos_model extends CI_Model {
	function listar(){
		$query = $this->db->get('bancos');
		return $query->result();
	}
	function buscar($palabra){
		$this->db->where("desc_bancos",$palabra);
		$query = $this->db->get('bancos');
		return $query->row();
	}
	function ingresar($data){
		$this->db->insert('bancos',$data);
		return $this->db->insert_id();
	}
	
	function actualizar($data,$id){
		$this->db->where('id', $id);
		$this->db->update('bancos', $data); 
	}
}