<?php
class Usuarios_desactivar_previos_model extends CI_Model{

	function consultar_si_existe($id_usu){
		$this->db->select('*');
		$this->db->from('usuarios_desactivar_previos');
		$this->db->where('id_usuario', $id_usu);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return "NA";
		}
	}

	function guardar($datos){
		$this->db->insert('usuarios_desactivar_previos',$datos);
	}

	function actualizar($id, $datos){
		$this->db->where('id', $id);
		$this->db->update('usuarios_desactivar_previos', $datos);
	}

	function get_result(){
		$this->db->select('*');
		$this->db->from('usuarios_desactivar_previos');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return NULL;
		}
	}

	function eliminar($usuario_id){
		$this->db->where('id_usuario', $usuario_id);
		$this->db->delete('usuarios_desactivar_previos');
	}

}
?>