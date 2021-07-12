<?php
class Centrocostos_model extends CI_Model {

	function listar(){
		$this->db->order_by("desc_centrocosto");
		$query = $this->db->get('centro_costos');
		return $query->result();
	}

	function listar_planta($id){
		$this->db->where("id_planta",$id);
		$this->db->order_by("desc_centrocosto");
		$query = $this->db->get('centro_costos');
		return $query->result();
	}
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('centro_costos');
		return $query->row();
	}
	function ingresar($data){
		$this->db->insert('centro_costos', $data); 
	}
	function eliminar($id){
		$this->db->delete('centro_costos', array('id' => $id)); 
	}
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('centro_costos', $data); 
	}
}