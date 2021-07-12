<?php
class Solicitud_revision_examenes_previos_model extends CI_Model{
	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function guardar($datos){
		$this->sanatorio->insert('solicitud_revision_examenes_previos',$datos);
	}

	function actualizar($id, $datos){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('solicitud_revision_examenes_previos', $datos);
	}

	function eliminar($usuario_id){
		$this->sanatorio->where('id_usuario', $usuario_id);
		$this->sanatorio->delete('solicitud_revision_examenes_previos');
	}

	function eliminar_segun_id($id){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->delete('solicitud_revision_examenes_previos');
	}

	function consultar_si_existe($id_usu){
		$this->sanatorio->select('*');
		$this->sanatorio->from('solicitud_revision_examenes_previos');
		$this->sanatorio->where('id_usuario', $id_usu);
		$query = $this->sanatorio->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return "NA";
		}
	}

	function get_result($id_solicitante){
		$this->sanatorio->select('*');
		$this->sanatorio->from('solicitud_revision_examenes_previos');
		$this->sanatorio->where('id_solicitante', $id_solicitante);
		$query = $this->sanatorio->get();
		return $query->result();
	}

}
?>