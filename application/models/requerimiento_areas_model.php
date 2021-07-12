<?php
class Requerimiento_areas_model extends CI_Model {
	function listar(){
		$this->db->where('flag_vigente', 1);
		$query = $this->db->get('requerimiento_areas');
		return $query->result();
	}
	
	function listar_todo($id){
		$this->db->select("*");
		$this->db->from('requerimiento_areas as ra');
		$this->db->join('requerimiento_cargos as rc',"rc.id_requerimiento_areas = ra.id");
		$this->db->join('requerimiento_trabajador as rt',"rt.id_requerimiento_cargos = rc.id");
		$this->db->where('ra.id', $id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_validar($id,$id_req){
		$this->db->where('id',$id);
		$this->db->where('id_requerimiento',$id_req);
		$query = $this->db->get('requerimiento_areas');
		return $query->row();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('requerimiento_areas');
		return $query->row();
	}
	
	function get_area($id_req,$id_area){
		$this->db->select("*");
		$this->db->from('requerimiento_areas as ra');
		$this->db->join('requerimiento_cargos as rc',"rc.id_requerimiento_areas = ra.id");
		$this->db->join('requerimiento_trabajador as rt',"rt.id_requerimiento_cargos = rc.id");
		$this->db->where('ra.id_requerimiento', $id_req);
		$this->db->where('ra.id', $id_area);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_requerimiento($id){
		$this->db->where('id_requerimiento',$id);
		$query = $this->db->get('requerimiento_areas');
		return $query->result();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('requerimiento_areas', $data);
		return $id;
	}
	
	function cantidad_requerimiento($id){
		$this->db->select("SUM(rt.cantidad) as cantidad");
		$this->db->from('requerimiento_areas as ra');
		$this->db->join('requerimiento_cargos as rc',"rc.id_requerimiento_areas = ra.id");
		$this->db->join('requerimiento_trabajador as rt',"rt.id_requerimiento_cargos = rc.id");
		$this->db->where('ra.id_requerimiento', $id);
		$query = $this->db->get();
		return $query->row();
	}
	
	function cantidadok_requerimiento($id){
		$this->db->select("SUM(rt.cantidad_ok) as cantidad_ok");
		$this->db->from('requerimiento_areas as ra');
		$this->db->join('requerimiento_cargos as rc',"rc.id_requerimiento_areas = ra.id");
		$this->db->join('requerimiento_trabajador as rt',"rt.id_requerimiento_cargos = rc.id");
		$this->db->where('ra.id_requerimiento', $id);
		$query = $this->db->get();
		return $query->row();
	}
	
	function editar_requerimiento($id_req,$data){
		$this->db->where('id_requerimiento', $id);
		$this->db->update('requerimiento_areas', $data);
		return $this->db->insert_id();
	}
	
	
	
	function ingresar($data){
		$this->db->insert('requerimiento_areas',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('requerimiento_areas', array('id' => $id)); 
	}
	
	function eliminar_requerimiento($id){
		$this->db->delete('requerimiento_areas', array('id_requerimiento' => $id)); 
	}
	
}
?>