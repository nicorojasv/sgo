<?php
class Requerimiento_cargos_model extends CI_Model {
	function listar(){
		$this->db->where('flag_vigente', 1);
		$query = $this->db->get('requerimiento_cargos');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('requerimiento_cargos');
		return $query->row();
	}
	
	function get_area($id){
		$this->db->where('id_requerimiento_areas',$id);
		$query = $this->db->get('requerimiento_cargos');
		return $query->result();
	}
	
	function get_requerimiento($id){
		$this->db->select("*,rc.id AS cargo_id");
		$this->db->from('requerimiento as r');
		$this->db->join('requerimiento_areas as ra',"ra.id_requerimiento = r.id");
		$this->db->join('requerimiento_cargos as rc',"rc.id_requerimiento_areas = ra.id");
		//$this->db->join('requerimiento_trabajador as rt',"rt.id_requerimiento_cargos = rc.id");
		$this->db->where("r.id ",$id );
		$query = $this->db->get();
		return $query->result();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('requerimiento_cargos', $data); 
		return $id;
	}
	
	function ingresar($data){
		$this->db->insert('requerimiento_cargos',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('requerimiento_cargos', array('id' => $id)); 
	}
	
}
?>