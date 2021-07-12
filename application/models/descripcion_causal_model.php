<?php
class Descripcion_causal_model extends CI_Model {

	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('descripcion_causal');
		return $query->row();
	}
	
	function traer_descripcion($cargo){
		$this->db->select('*');
		$this->db->from('r_cargos');
		$this->db->join('descripcion_cargo','descripcion_cargo.id_cargo = r_cargos.id','left');
		$query = $this->db->get();
		return $query->row();
	}

}
?>