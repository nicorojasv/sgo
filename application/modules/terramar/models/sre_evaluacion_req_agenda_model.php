<?php
class Sre_evaluacion_req_agenda_model extends CI_Model{
	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function guardar($datos){
		$this->terramar->insert('sre_evaluacion_req_agenda',$datos);
	}

	function get_tipo($id_solicitud, $id_tipo){
		$this->terramar->select('*');
		$this->terramar->from('sre_evaluacion_req_agenda');
		$this->terramar->where('id_sre', $id_solicitud);
		$this->terramar->where('id_tipo_examen', $id_tipo);
		$query = $this->terramar->get();
		return $query->row();
	}

	function actualizar($id, $datos){
		$this->terramar->where('id', $id);
		$this->terramar->update('sre_evaluacion_req_agenda', $datos);
	}


	/*

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

	*/

}
?>