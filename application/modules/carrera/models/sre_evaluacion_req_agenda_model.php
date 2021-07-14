<?php
class Sre_evaluacion_req_agenda_model extends CI_Model{
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function guardar($datos){
		$this->carrera->insert('sre_evaluacion_req_agenda',$datos);
	}

	function get_tipo($id_solicitud, $id_tipo){
		$this->carrera->select('*');
		$this->carrera->from('sre_evaluacion_req_agenda');
		$this->carrera->where('id_sre', $id_solicitud);
		$this->carrera->where('id_tipo_examen', $id_tipo);
		$query = $this->carrera->get();
		return $query->row();
	}

	function actualizar($id, $datos){
		$this->carrera->where('id', $id);
		$this->carrera->update('sre_evaluacion_req_agenda', $datos);
	}


	/*

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

	*/

}
?>