<?php
class Solicitud_revision_examenes_previos_model extends CI_Model{

	function guardar($datos){
		$this->db->insert('solicitud_revision_examenes_previos',$datos);
	}

	function actualizar($id, $datos){
		$this->db->where('id', $id);
		$this->db->update('solicitud_revision_examenes_previos', $datos);
	}

	function eliminar($usuario_id){
		$this->db->where('id_usuario', $usuario_id);
		$this->db->delete('solicitud_revision_examenes_previos');
	}

	function eliminar_segun_id($id){
		$this->db->where('id', $id);
		$this->db->delete('solicitud_revision_examenes_previos');
	}

	function consultar_si_existe($id_usu){
		$this->db->select('*');
		$this->db->from('solicitud_revision_examenes_previos');
		$this->db->where('id_usuario', $id_usu);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return "NA";
		}
	}

	function get_result($id_solicitante){
		$this->db->select('*');
		$this->db->from('solicitud_revision_examenes_previos');
		$this->db->where('id_solicitante', $id_solicitante);
		$query = $this->db->get();
		return $query->result();
	}

}
?>