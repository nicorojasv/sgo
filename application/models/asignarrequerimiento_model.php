<?php
class Asignarrequerimiento_model extends CI_Model {
	
	function ingresar($data){
		$this->db->insert('asigna_r_requerimiento',$data); 
	}

	function contar($id){
		$this->db->where('id_r_requerimiento', $id);
		$this->db->from('asigna_r_requerimiento');
		return $this->db->count_all_results();
	}

	function listar_req($id_req){
		$this->db->where("id_r_requerimiento", $id_req);
		$query = $this->db->get('asigna_r_requerimiento');
		return $query->result();
	}

	function eliminar_usr($id_req,$id_usr){
		$this->db->delete('asigna_r_requerimiento', array('id_r_requerimiento' => $id_req,'id_usuarios'=> $id_usr)); 
	}

	function historial($id){
		$this->db->select("*");
		$this->db->from("asigna_r_requerimiento ar");
		$this->db->join("r_requerimiento rr","ar.id_r_requerimiento = rr.id");
		$this->db->where("ar.id_usuarios", $id);
		$query = $this->db->get();
		return $query->result();
	}

	function actualizar($data,$id){
		$this->db->where('id', $id);
		$this->db->update('asigna_r_requerimiento', $data); 
	}
}