<?php
class Excajas_model extends CI_Model {
	function listar(){
		$query = $this->db->get('ex_caja');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('ex_caja');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('ex_caja', $data); 
	}
	function buscar($palabra){
		$this->db->where("desc_excaja",$palabra);
		$query = $this->db->get('ex_caja');
		return $query->row();
	}
}