<?php
class Solicitud_revision_examenes_previos_model extends CI_Model{
	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function guardar($datos){
		$this->wood->insert('solicitud_revision_examenes_previos',$datos);
	}

	function actualizar($id, $datos){
		$this->wood->where('id', $id);
		$this->wood->update('solicitud_revision_examenes_previos', $datos);
	}

	function eliminar($usuario_id){
		$this->wood->where('id_usuario', $usuario_id);
		$this->wood->delete('solicitud_revision_examenes_previos');
	}

	function eliminar_segun_id($id){
		$this->wood->where('id', $id);
		$this->wood->delete('solicitud_revision_examenes_previos');
	}

	function consultar_si_existe($id_usu){
		$this->wood->select('*');
		$this->wood->from('solicitud_revision_examenes_previos');
		$this->wood->where('id_usuario', $id_usu);
		$query = $this->wood->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return "NA";
		}
	}

	function get_result($id_solicitante){
		$this->wood->select('*');
		$this->wood->from('solicitud_revision_examenes_previos');
		$this->wood->where('id_solicitante', $id_solicitante);
		$query = $this->wood->get();
		return $query->result();
	}

}
?>