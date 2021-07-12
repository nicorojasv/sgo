<?php
class Sre_evaluacion_req_model extends CI_Model{
	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function get_row($id_solicitud, $id_examen){//37111428 monto 100739
		$this->terramar->select('*');
		$this->terramar->from('sre_evaluacion_req');
		$this->terramar->where('id_solicitud_revision', $id_solicitud);
		$this->terramar->where('id_evaluacion', $id_examen);
		$query = $this->terramar->get();
		return $query->row();
	}

	function get_id_solicitud($id_solicitud){
		$this->terramar->select('*');
		$this->terramar->from('sre_evaluacion_req');
		$this->terramar->where('id_solicitud_revision', $id_solicitud);
		$query = $this->terramar->get();
		return $query->result();
	}

	function get_row_por_tipo($id_solicitud, $id_examen, $tipo){
		$this->terramar->select('*');
		$this->terramar->from('sre_evaluacion_req');
		$this->terramar->where('id_solicitud_revision', $id_solicitud);
		$this->terramar->where('id_evaluacion', $id_examen);
		$this->terramar->where('tipo_examen', $tipo);
		$query = $this->terramar->get();
		return $query->row();
	}

	function get_result($id){
		$this->terramar->select('*');
		$this->terramar->from('sre_evaluacion_req');
		$this->terramar->where('id', $id);
		$query = $this->terramar->get();
		return $query->result();
	}

	function get_registro($id){
		$this->terramar->select('*');
		$this->terramar->from('sre_evaluacion_req');
		$this->terramar->where('id', $id);
		$query = $this->terramar->get();
		return $query->row();
	}

	function guardar($datos){
		$this->terramar->insert('sre_evaluacion_req',$datos);
	}

	function actualizar($id, $datos){
		$this->terramar->where('id', $id);
		$this->terramar->update('sre_evaluacion_req', $datos);
	}

	function get_examen_req($id){
		$this->terramar->select('*');
		$this->terramar->from('sre_evaluacion_req');
		$this->terramar->where('id', $id);
		$query = $this->terramar->get();
		return $query->row();
	}

}
?>