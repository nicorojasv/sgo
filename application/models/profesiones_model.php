<?php
class Profesiones_model extends CI_Model {
	function listar(){
		//$this->db->order_by("desc_profesiones");
		//$query = $this->db->get('profesiones');

		$query = $this->db->query('SELECT * FROM profesiones ORDER BY desc_profesiones');
		return $query->result();
	}
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('profesiones');
		return $query->row();
	}
	function buscar($palabra){
		$this->db->where("desc_profesiones",$palabra);
		$query = $this->db->get('profesiones');
		return $query->row();
	}
	
	function ingresar($data){
		$this->db->insert('profesiones',$data);
		return $this->db->insert_id();
	}
	
	function actualizar($data,$id){
		$this->db->where('id', $id);
		$this->db->update('profesiones', $data); 
	}
}