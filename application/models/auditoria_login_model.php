<?php
class Auditoria_Login_model extends CI_Model {
	
	function guardar($datos){
		$this->db->insert('auditoria_login',$datos);
		return $this->db->insert_id();
	}

	function actualizar($id, $datos){
		$this->db->where('id', $id);
		$this->db->update('auditoria_login', $datos);
	}

}
?>