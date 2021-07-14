<?php
class Sre_evaluacion_req_model extends CI_Model{
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function get_row($id_solicitud, $id_examen){//37111428 monto 100739
		$this->carrera->select('*');
		$this->carrera->from('sre_evaluacion_req');
		$this->carrera->where('id_solicitud_revision', $id_solicitud);
		$this->carrera->where('id_evaluacion', $id_examen);
		$query = $this->carrera->get();
		return $query->row();
	}

	function get_id_solicitud($id_solicitud){
		$this->carrera->select('*');
		$this->carrera->from('sre_evaluacion_req');
		$this->carrera->where('id_solicitud_revision', $id_solicitud);
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_row_por_tipo($id_solicitud, $id_examen, $tipo){
		$this->carrera->select('*');
		$this->carrera->from('sre_evaluacion_req');
		$this->carrera->where('id_solicitud_revision', $id_solicitud);
		$this->carrera->where('id_evaluacion', $id_examen);
		$this->carrera->where('tipo_examen', $tipo);
		$query = $this->carrera->get();
		return $query->row();
	}

	function get_result($id){
		$this->carrera->select('*');
		$this->carrera->from('sre_evaluacion_req');
		$this->carrera->where('id', $id);
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_registro($id){
		$this->carrera->select('*');
		$this->carrera->from('sre_evaluacion_req');
		$this->carrera->where('id', $id);
		$query = $this->carrera->get();
		return $query->row();
	}

	function guardar($datos){
		$this->carrera->insert('sre_evaluacion_req',$datos);
	}

	function actualizar($id, $datos){
		$this->carrera->where('id', $id);
		$this->carrera->update('sre_evaluacion_req', $datos);
	}

	function get_examen_req($id){
		$this->carrera->select('*');
		$this->carrera->from('sre_evaluacion_req');
		$this->carrera->where('id', $id);
		$query = $this->carrera->get();
		return $query->row();
	}

}
?>