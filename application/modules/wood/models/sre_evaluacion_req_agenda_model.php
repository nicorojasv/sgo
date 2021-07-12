<?php
class Sre_evaluacion_req_agenda_model extends CI_Model{
	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function guardar($datos){
		$this->wood->insert('sre_evaluacion_req_agenda',$datos);
	}

	function get_tipo($id_solicitud, $id_tipo){
		$this->wood->select('*');
		$this->wood->from('sre_evaluacion_req_agenda');
		$this->wood->where('id_sre', $id_solicitud);
		$this->wood->where('id_tipo_examen', $id_tipo);
		$query = $this->wood->get();
		return $query->row();
	}

	function actualizar($id, $datos){
		$this->wood->where('id', $id);
		$this->wood->update('sre_evaluacion_req_agenda', $datos);
	}


	/*

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

	*/

}
?>