<?php
class Pensiones_Valores_model extends CI_Model{

	function get_valores($id = FALSE){
		$this->db->select('*');
		$this->db->from('pensiones_valores');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}

	function listar_valores($id_pension = FALSE){
		$this->db->select('*');
		$this->db->from('pensiones_valores');
		$this->db->where('id_pension', $id_pension);
		$this->db->order_by('fecha_contrato', 'DESC');
		$query = $this->db->get();
		return $query->row();
	}

	function listar_trabajadores_pension($id_pension = FALSE){
		$this->db->select('*');
		$this->db->from('pensiones_valores');
		$this->db->where('id_pension', $id_pension);
		$query = $this->db->get();
		return $query->result();
	}

	function ingresar($data){
		$this->db->insert('pensiones_valores',$data); 
	}

	function existe_registro_pension($id_pension, $fecha_contrato){
		$this->db->select('id');
		$this->db->from('pensiones_valores');
		$this->db->where("id_pension",$id_pension);
		$this->db->where('fecha_contrato', $fecha_contrato);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 'N/E';
		}
	}

	function actualizar($id, $data){
		$this->db->where('id', $id);
		$this->db->update('pensiones_valores', $data); 
	}

}
?>