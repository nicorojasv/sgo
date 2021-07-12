<?php
class Sre_evaluacion_req_model extends CI_Model{

	function get_row($id_solicitud, $id_examen){//37111428 monto 100739
		$this->db->select('*');
		$this->db->from('sre_evaluacion_req');
		$this->db->where('id_solicitud_revision', $id_solicitud);
		$this->db->where('id_evaluacion', $id_examen);
		$query = $this->db->get();
		return $query->row();
	}

	function get_id_solicitud($id_solicitud){
		$this->db->select('*');
		$this->db->from('sre_evaluacion_req');
		$this->db->where('id_solicitud_revision', $id_solicitud);
		$query = $this->db->get();
		return $query->result();
	}

	function get_row_por_tipo($id_solicitud, $id_examen, $tipo){
		$this->db->select('*');
		$this->db->from('sre_evaluacion_req');
		$this->db->where('id_solicitud_revision', $id_solicitud);
		$this->db->where('id_evaluacion', $id_examen);
		$this->db->where('tipo_examen', $tipo);
		$query = $this->db->get();
		return $query->row();
	}

	function get_result($id){
		$this->db->select('*');
		$this->db->from('sre_evaluacion_req');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	function get_registro($id){
		$this->db->select('*');
		$this->db->from('sre_evaluacion_req');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	function guardar($datos){
		$this->db->insert('sre_evaluacion_req',$datos);
	}

	function actualizar($id, $datos){
		$this->db->where('id', $id);
		$this->db->update('sre_evaluacion_req', $datos);
	}

	function get_examen_req($id){
		$this->db->select('*');
		$this->db->from('sre_evaluacion_req');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}

}
?>