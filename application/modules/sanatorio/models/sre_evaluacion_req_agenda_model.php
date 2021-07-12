<?php
class Sre_evaluacion_req_agenda_model extends CI_Model{
	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function guardar($datos){
		$this->sanatorio->insert('sre_evaluacion_req_agenda',$datos);
	}

	function get_tipo($id_solicitud, $id_tipo){
		$this->sanatorio->select('*');
		$this->sanatorio->from('sre_evaluacion_req_agenda');
		$this->sanatorio->where('id_sre', $id_solicitud);
		$this->sanatorio->where('id_tipo_examen', $id_tipo);
		$query = $this->sanatorio->get();
		return $query->row();
	}

	function actualizar($id, $datos){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('sre_evaluacion_req_agenda', $datos);
	}


	/*

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

	*/

}
?>