<?php
class Solicitud_revision_examenes_previos_model extends CI_Model{
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function guardar($datos){
		$this->carrera->insert('solicitud_revision_examenes_previos',$datos);
	}

	function actualizar($id, $datos){
		$this->carrera->where('id', $id);
		$this->carrera->update('solicitud_revision_examenes_previos', $datos);
	}

	function eliminar($usuario_id){
		$this->carrera->where('id_usuario', $usuario_id);
		$this->carrera->delete('solicitud_revision_examenes_previos');
	}

	function eliminar_segun_id($id){
		$this->carrera->where('id', $id);
		$this->carrera->delete('solicitud_revision_examenes_previos');
	}

	function consultar_si_existe($id_usu){
		$this->carrera->select('*');
		$this->carrera->from('solicitud_revision_examenes_previos');
		$this->carrera->where('id_usuario', $id_usu);
		$query = $this->carrera->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return "NA";
		}
	}

	function get_result($id_solicitante){
		$this->carrera->select('*');
		$this->carrera->from('solicitud_revision_examenes_previos');
		$this->carrera->where('id_solicitante', $id_solicitante);
		$query = $this->carrera->get();
		return $query->result();
	}

}
?>