<?php
class Examenes_psicologicos_previos_model extends CI_Model{

	function guardar($datos){
		$this->db->insert('examenes_psicologicos_previos',$datos);
	}

	function actualizar($id, $datos){
		$this->db->where('id', $id);
		$this->db->update('examenes_psicologicos_previos', $datos);
	}

	function eliminar($usuario_id){
		$this->db->where('id_usuario', $usuario_id);
		$this->db->delete('examenes_psicologicos_previos');
	}

	function consultar_si_existe($id_usu){
		$this->db->select('*');
		$this->db->from('examenes_psicologicos_previos');
		$this->db->where('id_usuario', $id_usu);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return FALSE;
		}
	}

	function get_result($id_solicitante){
		$this->db->select('*');
		$this->db->from('examenes_psicologicos_previos');
		$this->db->where('id_solicitante', $id_solicitante);
		$query = $this->db->get();
		return $query->result();
	}

}