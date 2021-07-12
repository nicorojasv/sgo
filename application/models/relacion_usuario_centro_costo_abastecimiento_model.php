<?php
class Relacion_usuario_centro_costo_abastecimiento_model extends CI_Model {
	
	function get_usuario_centro_costo($usuario_id, $id_centro_costo){
		$this->db->select('id');
		$this->db->from('relacion_usuario_centro_costo_abastecimiento');
		$this->db->where('id_usuario', $usuario_id);
		$this->db->where('id_centro_costo', $id_centro_costo);
		$query = $this->db->get();
		return $query->row();
	}

	function eliminar_relacion_centro_costo_usuario($usuario){
		$this->db->delete('relacion_usuario_centro_costo_abastecimiento', array('id_usuario' => $usuario));
	}

	function ver_relacion_centro_costo_usuario($id_usuario, $id_centro_costo){
		$this->db->SELECT('*');
		$this->db->from('relacion_usuario_centro_costo_abastecimiento');
		$this->db->where('id_usuario', $id_usuario);
		$this->db->where('id_centro_costo', $id_centro_costo);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function guardar_relacion($data){
		$this->db->insert('relacion_usuario_centro_costo_abastecimiento',$data); 
	}

	function actualizar_relacion($usuario_id, $data){
		$this->db->where('id_usuario', $usuario_id);
		$this->db->update('relacion_usuario_centro_costo_abastecimiento', $data);
	}

	function get_usuario_centro_costo_result($usuario_id){
		$this->db->select('*');
		$this->db->from('relacion_usuario_centro_costo_abastecimiento');
		$this->db->where('id_usuario', $usuario_id);
		$query = $this->db->get();
		return $query->result();
	}

}
?>