<?php
class R_Requerimiento_Evaluacion_model extends CI_Model {
	
	function guardar_evaluacion($datos){
		$this->db->insert('r_requerimiento_evaluacion',$datos);
	}

	function get_evaluacion($usuario, $id_req){
		$this->db->select('*');
		$this->db->from('r_requerimiento_evaluacion');
		$this->db->where('usuario_id', $usuario);
		$this->db->where('requerimiento_id', $id_req);
		$query = $this->db->get();
		return $query->result();
	}

	function get_evaluacion_row($usuario, $area_cargo){
		$this->db->select('*');
		$this->db->from('r_requerimiento_evaluacion');
		$this->db->where('usuario_id', $usuario);
		$this->db->where('requerimiento_id', $area_cargo);
		$query = $this->db->get();
		return $query->row();
	}

	function get_si_existe_requerimiento($usuario, $area_cargo){
		$this->db->SELECT('*');
		$this->db->from('r_requerimiento_evaluacion');
		$this->db->where('usuario_id', $usuario);
		$this->db->where('requerimiento_id', $area_cargo);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function actualizar_r_requerimiento($usuario, $area_cargo, $datos){
		$this->db->where('usuario_id', $usuario);
		$this->db->where('requerimiento_id', $area_cargo);
		$this->db->update('r_requerimiento_evaluacion', $datos);
	}


}
?>