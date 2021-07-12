<?php
class Asignarequerimiento_model extends CI_Model {
	
	function get_trabajador($id_trabajador){
		$this->db->where("id_usuarios",$id_trabajador);
		$query = $this->db->get('asigna_requerimiento');
		return $query->row();
	}
	
	function cant_asignados($id_trabajador){
		
		$this->db->select('*,ar.fecha_termino as termino_real');
		$this->db->from('asigna_requerimiento AS ar');
		$this->db->join('requerimiento_trabajador AS rt','ar.id_requerimientotrabajador = rt.id');
		$this->db->where('ar.id_usuarios',$id_trabajador);
		$this->db->where('rt.fecha_termino >', date('Y-m-d'));
		$this->db->where('ar.flag_leido',0);
		$query = $this->db->get();
		return count($query->result());
	}
	
	function get_despues($id){
		$this->db->select('*,ar.fecha_termino as termino_real,ar.id as id_ar');
		$this->db->from('asigna_requerimiento AS ar');
		$this->db->join('requerimiento_trabajador AS rt','ar.id_requerimientotrabajador = rt.id');
		$this->db->join('requerimiento AS r','rt.id_requerimiento = r.id');
		$this->db->where('ar.id_usuarios',$id);
		$this->db->where('rt.fecha_termino >', date('Y-m-d'));
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_anteriores($id){
		$this->db->select('*,ar.fecha_termino as termino_real');
		$this->db->from('asigna_requerimiento AS ar');
		$this->db->join('requerimiento_trabajador AS rt','ar.id_requerimientotrabajador = rt.id');
		$this->db->join('requerimiento AS r','rt.id_requerimiento = r.id');
		$this->db->where('ar.id_usuarios',$id);
		$this->db->where('rt.fecha_termino <', date('Y-m-d'));
		$query = $this->db->get();
		return $query->result();
	}
	
	function actualizar_leido($id){
		$this->db->where('id', $id);
		$this->db->update('asigna_requerimiento', array('flag_leido' => 1));
	}
}