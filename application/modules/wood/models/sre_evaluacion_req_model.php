<?php
class Sre_evaluacion_req_model extends CI_Model{
	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function get_row($id_solicitud, $id_examen){//37111428 monto 100739
		$this->wood->select('*');
		$this->wood->from('sre_evaluacion_req');
		$this->wood->where('id_solicitud_revision', $id_solicitud);
		$this->wood->where('id_evaluacion', $id_examen);
		$query = $this->wood->get();
		return $query->row();
	}

	function get_id_solicitud($id_solicitud){
		$this->wood->select('*');
		$this->wood->from('sre_evaluacion_req');
		$this->wood->where('id_solicitud_revision', $id_solicitud);
		$query = $this->wood->get();
		return $query->result();
	}

	function get_row_por_tipo($id_solicitud, $id_examen, $tipo){
		$this->wood->select('*');
		$this->wood->from('sre_evaluacion_req');
		$this->wood->where('id_solicitud_revision', $id_solicitud);
		$this->wood->where('id_evaluacion', $id_examen);
		$this->wood->where('tipo_examen', $tipo);
		$query = $this->wood->get();
		return $query->row();
	}

	function get_result($id){
		$this->wood->select('*');
		$this->wood->from('sre_evaluacion_req');
		$this->wood->where('id', $id);
		$query = $this->wood->get();
		return $query->result();
	}

	function get_registro($id){
		$this->wood->select('*');
		$this->wood->from('sre_evaluacion_req');
		$this->wood->where('id', $id);
		$query = $this->wood->get();
		return $query->row();
	}

	function guardar($datos){
		$this->wood->insert('sre_evaluacion_req',$datos);
	}

	function actualizar($id, $datos){
		$this->wood->where('id', $id);
		$this->wood->update('sre_evaluacion_req', $datos);
	}

	function get_examen_req($id){
		$this->wood->select('*');
		$this->wood->from('sre_evaluacion_req');
		$this->wood->where('id', $id);
		$query = $this->wood->get();
		return $query->row();
	}

}
?>