<?php
class Pensiones_Requerimiento_model extends CI_Model{

	function get_pension_area_cargo($id_area_cargo, $usuario){
		$this->db->select('*');
		$this->db->from('pensiones_requerimiento');
		$this->db->where("id_requerimiento_area_cargo",$id_area_cargo);
		$this->db->where('id_usuario', $usuario);
		$query = $this->db->get();
		return $query->result();
	}

	function get_pension_row($id_area_cargo, $usuario){
		$this->db->where("id_requerimiento_area_cargo",$id_area_cargo);
		$this->db->where('id_usuario', $usuario);
		$query = $this->db->get('pensiones_requerimiento');
		return $query->row();
	}

	function get_pension_req($id){
		$this->db->where("id",$id);
		$query = $this->db->get('pensiones_requerimiento');
		return $query->result();
	}

	function existe_registro_pension($id_registro_valores, $id_area_cargo, $usuario){
		$this->db->select('*');
		$this->db->from('pensiones_requerimiento');
		$this->db->where("id_requerimiento_area_cargo",$id_area_cargo);
		$this->db->where('id_pension_valores', $id_registro_valores);
		$this->db->where('id_usuario', $usuario);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function guardar($data){
		$this->db->insert('pensiones_requerimiento',$data);
	}

	function actualizar($data, $id_registro_valores, $id_area_cargo, $usuario){
		$this->db->where('id_requerimiento_area_cargo', $id_area_cargo);
		$this->db->where('id_pension_valores', $id_registro_valores);
		$this->db->where('id_usuario', $usuario);
		$this->db->update('pensiones_requerimiento', $data); 
	}

	function actualizar_id($data, $id){
		$this->db->where('id', $id);
		$this->db->update('pensiones_requerimiento', $data); 
	}

}
?>