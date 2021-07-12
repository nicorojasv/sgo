<?php
class Pensiones_model extends CI_Model{

	function listar(){
		$query = $this->db->get('pensiones');
		return $query->result();
	}

	function listar_segun_cc($id_centro_costo){
		$this->db->select('*');
		$this->db->from('pensiones p');
		$this->db->join('pensiones_valores pv','pv.id_pension = p.id','left');
		$this->db->join('pensiones_requerimiento pr','pv.id = pr.id_pension_valores','inner');
		$this->db->where('p.id_centro_costo', $id_centro_costo);
		$query = $this->db->get();
		return $query->result();
	}

	function ingresar($data){
		$this->db->insert('pensiones',$data);
		return $this->db->insert_id();
	}

	function get_result($id){
		$this->db->where("id",$id);
		$query = $this->db->get('pensiones');
		return $query->result();
	}

	function get_row($id){
		$this->db->select('*');
		$this->db->from('pensiones');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	function get_pension_area_cargo($id_area_cargo){
		$this->db->where("id",$id_area_cargo);
		$query = $this->db->get('pensiones');
		return $query->result();
	}

	function actualizar($id, $data){
		$this->db->where('id', $id);
		$this->db->update('pensiones', $data); 
	}

}
?>