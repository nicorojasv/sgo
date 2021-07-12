<?php
class Publicaciones_requerimientos_adjuntos_model extends CI_Model {
	
	function listar(){
		$query = $this->db->get('publicaciones_requerimientos_adjuntos');
		return $query->result();
	}
	
	function listar_adjuntos($id){
		$this->db->where('id_publicaciones_requerimientos',$id);
		$query = $this->db->get('publicaciones_requerimientos_adjuntos');
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('publicaciones_requerimientos_adjuntos');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('publicaciones_requerimientos_adjuntos', $data);
		return $id;
	}
	
	function ingresar($data){
		$this->db->insert('publicaciones_requerimientos_adjuntos',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('publicaciones_requerimientos_adjuntos', array('id' => $id)); 
	}
	
}
?>