<?php
class Reemplazos_requerimiento_model extends CI_Model {
	function listar(){
		$query = $this->db->get('reemplazos_requerimiento');
		return $query->result();
	}
	
	function listar_requerimiento($id_asigna_req){
		$this->db->where('id_asigna_requerimiento',$id_asigna_req);
		$query = $this->db->get('reemplazos_requerimiento');
		return $query->row();
	}
	
	function listar_asigna_requerimiento($id_requerimiento){
		$this->db->select('*,ar.id_usuarios as ar_usuarios, rr.id_usuarios as rr_usuarios, ar.id as ar_id, rr.id as rr_id');
		$this->db->from('asigna_requerimiento ar');
		$this->db->join('reemplazos_requerimiento rr', 'ar.id = rr.id_asigna_requerimiento');
		$this->db->where('ar.id_requerimientotrabajador',$id_requerimiento);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('reemplazos_requerimiento');
		return $query->row();
	}
	
	function get_usuario($id_usr,$id_asigna){
		$this->db->where('id_usuarios',$id_usr);
		$this->db->where('id_asigna_requerimiento',$id_asigna);
		$query = $this->db->get('reemplazos_requerimiento');
		return $query->result();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('reemplazos_requerimiento', $data); 
	}
	
	function ingresar($data){
		$this->db->insert('reemplazos_requerimiento',$data); 
		return $this->db->insert_id();
	}
	
	function borrar($id){
		$this->db->where('id', $id);
		$this->db->delete('reemplazos_requerimiento');
	}
}