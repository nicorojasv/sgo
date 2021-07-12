<?php
class Solicitud_revision_examenes_previos_model extends CI_Model{
	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function guardar($datos){
		$this->terramar->insert('solicitud_revision_examenes_previos',$datos);
	}

	function actualizar($id, $datos){
		$this->terramar->where('id', $id);
		$this->terramar->update('solicitud_revision_examenes_previos', $datos);
	}

	function eliminar($usuario_id){
		$this->terramar->where('id_usuario', $usuario_id);
		$this->terramar->delete('solicitud_revision_examenes_previos');
	}

	function eliminar_segun_id($id){
		$this->terramar->where('id', $id);
		$this->terramar->delete('solicitud_revision_examenes_previos');
	}

	function consultar_si_existe($id_usu){
		$this->terramar->select('*');
		$this->terramar->from('solicitud_revision_examenes_previos');
		$this->terramar->where('id_usuario', $id_usu);
		$query = $this->terramar->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return "NA";
		}
	}

	function get_result($id_solicitante){
		$this->terramar->select('*');
		$this->terramar->from('solicitud_revision_examenes_previos');
		$this->terramar->where('id_solicitante', $id_solicitante);
		$query = $this->terramar->get();
		return $query->result();
	}

}
?>