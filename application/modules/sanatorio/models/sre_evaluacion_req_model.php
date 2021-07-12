<?php
class Sre_evaluacion_req_model extends CI_Model{
	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function get_row($id_solicitud, $id_examen){//37111428 monto 100739
		$this->sanatorio->select('*');
		$this->sanatorio->from('sre_evaluacion_req');
		$this->sanatorio->where('id_solicitud_revision', $id_solicitud);
		$this->sanatorio->where('id_evaluacion', $id_examen);
		$query = $this->sanatorio->get();
		return $query->row();
	}

	function get_id_solicitud($id_solicitud){
		$this->sanatorio->select('*');
		$this->sanatorio->from('sre_evaluacion_req');
		$this->sanatorio->where('id_solicitud_revision', $id_solicitud);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function get_row_por_tipo($id_solicitud, $id_examen, $tipo){
		$this->sanatorio->select('*');
		$this->sanatorio->from('sre_evaluacion_req');
		$this->sanatorio->where('id_solicitud_revision', $id_solicitud);
		$this->sanatorio->where('id_evaluacion', $id_examen);
		$this->sanatorio->where('tipo_examen', $tipo);
		$query = $this->sanatorio->get();
		return $query->row();
	}

	function get_result($id){
		$this->sanatorio->select('*');
		$this->sanatorio->from('sre_evaluacion_req');
		$this->sanatorio->where('id', $id);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function get_registro($id){
		$this->sanatorio->select('*');
		$this->sanatorio->from('sre_evaluacion_req');
		$this->sanatorio->where('id', $id);
		$query = $this->sanatorio->get();
		return $query->row();
	}

	function guardar($datos){
		$this->sanatorio->insert('sre_evaluacion_req',$datos);
	}

	function actualizar($id, $datos){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('sre_evaluacion_req', $datos);
	}

	function get_examen_req($id){
		$this->sanatorio->select('*');
		$this->sanatorio->from('sre_evaluacion_req');
		$this->sanatorio->where('id', $id);
		$query = $this->sanatorio->get();
		return $query->row();
	}

}
?>