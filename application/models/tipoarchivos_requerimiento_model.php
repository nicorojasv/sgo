<?php
class TipoArchivos_requerimiento_model extends CI_Model {
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('tipo_archivos_requerimiento');
		return $query->row();
	}

	function listar(){
		$query = $this->db->get('tipo_archivos_requerimiento');
		return $query->result();
	}
}