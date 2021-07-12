<?php
class Tipo_gratificacion_model extends CI_Model {

	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('tipo_gratificacion');
		return $query->row();
	}

}
?>