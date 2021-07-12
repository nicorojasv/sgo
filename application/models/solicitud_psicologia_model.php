<?php
class Solicitud_psicologia_model extends CI_Model {

	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('descripcion_horarios');
		return $query->row();
	}

	function guardar_solicitud($data){
		$this->db->insert('solicitud_psicologia',$data); 
		return $this->db->insert_id();
	}
	function getAllSolicitud(){
		$this->db->from('solicitud_psicologia');
		//$this->db->where('id_centro_costo', $id_centro_costo);
		$query = $this->db->get();
		return $query->result();
	}

	function getMiSolicitud($id){
		$this->db->from('solicitud_psicologia');
		$this->db->where('id_administrador', $id);
		$query = $this->db->get();
		return $query->result();
	}

	function getIdTtrabajador($id){
		$this->db->where("rut_usuario",$id);
		$query = $this->db->get('usuarios');
		return $query->row();
	}
}
?>