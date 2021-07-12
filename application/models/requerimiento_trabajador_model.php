<?php
class Requerimiento_trabajador_model extends CI_Model {
	function listar(){
		$this->db->where('flag_vigente', 1);
		$query = $this->db->get('requerimiento_trabajador');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('requerimiento_trabajador');
		return $query->row();
	}
	
	function get_cargos($id){
		$this->db->where('id_requerimiento_cargos',$id);
		$query = $this->db->get('requerimiento_trabajador');
		return $query->result();
	}
	
	function get_requerimiento($id){
		$this->db->select("*,rt.id AS trabajador_id");
		$this->db->from('requerimiento as r');
		$this->db->join('requerimiento_areas as ra',"ra.id_requerimiento = r.id");
		$this->db->join('requerimiento_cargos as rc',"rc.id_requerimiento_areas = ra.id");
		$this->db->join('requerimiento_trabajador as rt',"rt.id_requerimiento_cargos = rc.id");
		$this->db->where("r.id ",$id );
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_trabajador($id){
		$this->db->select("*,rt.fecha_inicio AS fecha_inicio,rt.fecha_termino as fecha_termino");
		$this->db->from('requerimiento as r');
		$this->db->join('requerimiento_areas as ra',"ra.id_requerimiento = r.id");
		$this->db->join('requerimiento_cargos as rc',"rc.id_requerimiento_areas = ra.id");
		$this->db->join('requerimiento_trabajador as rt',"rt.id_requerimiento_cargos = rc.id");
		$this->db->where("rt.id ",$id );
		$query = $this->db->get();
		return $query->row();
	}
	
	function get_trabajador_subreq($id){
		$this->db->select('ar.id, u.nombres,u.paterno,u.materno,u.rut_usuario,u.id as id_usuario');
		$this->db->from('requerimiento_trabajador as rt');
		$this->db->join('asigna_requerimiento as ar',"rt.id = ar.id_requerimientotrabajador");
		$this->db->join('usuarios as u', 'u.id = ar.id_usuarios');
		$this->db->where('rt.id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('requerimiento_trabajador', $data); 
		return $id;
	}
	
	function ingresar($data){
		$this->db->insert('requerimiento_trabajador',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('requerimiento_trabajador', array('id' => $id));
	}
	
}
?>