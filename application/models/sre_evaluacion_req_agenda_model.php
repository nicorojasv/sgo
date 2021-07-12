<?php
class Sre_evaluacion_req_agenda_model extends CI_Model{

	function guardar($datos){
		$this->db->insert('sre_evaluacion_req_agenda',$datos);
	}

	function get_tipo($id_solicitud, $id_tipo){
		$this->db->select('*');
		$this->db->from('sre_evaluacion_req_agenda');
		$this->db->where('id_sre', $id_solicitud);
		$this->db->where('id_tipo_examen', $id_tipo);
		$query = $this->db->get();
		return $query->row();
	}

	function actualizar($id, $datos){
		$this->db->where('id', $id);
		$this->db->update('sre_evaluacion_req_agenda', $datos);
	}




	/*

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

	*/

}
?>