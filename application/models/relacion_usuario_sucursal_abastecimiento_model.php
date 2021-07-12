<?php
class Relacion_usuario_sucursal_abastecimiento_model extends CI_Model {
	
	function get_usuario_sucursal($usuario_id, $id_sucursal){
		$this->db->select('id');
		$this->db->from('relacion_usuario_sucursal_abastecimiento');
		$this->db->where('id_usuario', $usuario_id);
		$this->db->where('id_sucursal', $id_sucursal);
		$query = $this->db->get();
		return $query->row();
	}

	function eliminar_relacion_sucursal_usuario($usuario){
		$this->db->delete('relacion_usuario_sucursal_abastecimiento', array('id_sucursal' => $usuario));
	}

	function ver_relacion_sucursal_usuario($id_usuario, $id_sucursal){
		$this->db->SELECT('*');
		$this->db->from('relacion_usuario_sucursal_abastecimiento');
		$this->db->where('id_usuario', $id_usuario);
		$this->db->where('id_sucursal', $id_sucursal);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function guardar_relacion($data){
		$this->db->insert('relacion_usuario_sucursal_abastecimiento',$data); 
	}

	function actualizar_relacion($usuario_id, $data){
		$this->db->where('id_usuario', $usuario_id);
		$this->db->update('relacion_usuario_sucursal_abastecimiento', $data);
	}

	function get_usuario_sucursal_result($usuario_id){
		$this->db->select('*');
		$this->db->from('relacion_usuario_sucursal_abastecimiento');
		$this->db->where('id_usuario', $usuario_id);
		$query = $this->db->get();
		return $query->result();
	}

}
?>