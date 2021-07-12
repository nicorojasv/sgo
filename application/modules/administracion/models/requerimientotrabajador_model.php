<?php
class Requerimientotrabajador_model extends CI_Model {
	function ingresar($data){
		$this->db->insert('requerimiento_trabajador',$data);
	}
	function actualizar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('requerimiento_trabajador', $data);
	}
	
	function eliminar($id){
		$this->db->delete('requerimiento_trabajador', array('id' => $id)); 
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('requerimiento_trabajador');
		return $query->row();
	}
	function get_req($id){
		$this->db->select('ra.id_areas id_areas,rc.id_cargos id_cargos, rt.id_centrocosto id_centrocosto, rc.id_especialidad id_especialidad_trabajador, rt.fecha_inicio fecha_inicio,, rt.fecha_termino fecha_termino, rt.cantidad cantidad, rt.id_estado id_estado');
		$this->db->from('requerimiento_trabajador rt');
		$this->db->join('requerimiento_cargos rc','rc.id = rt.id_requerimiento_cargos' );
		$this->db->join('requerimiento_areas ra','ra.id = rc.id_requerimiento_areas');
		$this->db->join('requerimiento r','ra.id_requerimiento = r.id');
		$this->db->where('r.id',$id);
		$query = $this->db->get();
		return $query->result();
	}
}