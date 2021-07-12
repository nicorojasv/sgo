<?php
class Asignarequerimiento_model extends CI_Model {
	
	function get_trabajador($id_trabajador){
		$this->db->where("id_usuarios",$id_trabajador);
		$query = $this->db->get('asigna_requerimiento');
		return $query->row();
	}
	
	function ger_trabajador_subreq($id_trabajador, $id_subreq){
		$this->db->where("id_usuarios",$id_trabajador);
		$this->db->where("id_requerimientotrabajador",$id_subreq);
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
		$this->db->where('ar.fecha_termino >', date('Y-m-d'));
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_despues2($id){
		$this->db->select('*,ar.fecha_termino as termino_real,ar.id as id_ar');
		$this->db->from('asigna_requerimiento AS ar');
		$this->db->join('requerimiento_trabajador AS rt','ar.id_requerimientotrabajador = rt.id');
		$this->db->join('requerimiento_cargos AS rc','rt.id_requerimiento_cargos = rc.id');
		$this->db->join('requerimiento_areas AS ra', 'rc.id_requerimiento_areas = ra.id');
		$this->db->join('requerimiento AS r','ra.id_requerimiento = r.id');
		$this->db->where('ar.id_usuarios',$id);
		$this->db->where('ar.fecha_termino >', date('Y-m-d'));
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_anteriores($id){
		$this->db->select('*,ar.fecha_termino as termino_real');
		$this->db->from('asigna_requerimiento AS ar');
		$this->db->join('requerimiento_trabajador AS rt','ar.id_requerimientotrabajador = rt.id');
		$this->db->join('requerimiento AS r','rt.id_requerimiento = r.id');
		$this->db->where('ar.id_usuarios',$id);
		$this->db->where('ar.fecha_termino <', date('Y-m-d'));
		$query = $this->db->get();
		return $query->result();
	}

	function get_anteriores2($id){
		$this->db->select('*,ar.fecha_termino as termino_real');
		$this->db->from('asigna_requerimiento AS ar');
		$this->db->join('requerimiento_trabajador AS rt','ar.id_requerimientotrabajador = rt.id');
		$this->db->join('requerimiento_cargos AS rc','rt.id_requerimiento_cargos = rc.id');
		$this->db->join('requerimiento_areas AS ra', 'rc.id_requerimiento_areas = ra.id');
		$this->db->join('requerimiento AS r','ra.id_requerimiento = r.id');
		$this->db->where('ar.id_usuarios',$id);
		$this->db->where('ar.fecha_termino <', date('Y-m-d'));
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_actual($id_usr,$id_req,$fecha){
		$query = $this->db->query("SELECT * FROM `asigna_requerimiento` WHERE id_requerimientotrabajador != ".$id_req." AND id_usuarios = ".$id_usr." and '".$fecha."' BETWEEN fecha_inicio AND fecha_termino ");
		//echo $this->db->last_query();
		return $query->row();
	}
	
	function actualizar_leido($id){
		$this->db->where('id', $id);
		$this->db->update('asigna_requerimiento', array('flag_leido' => 1));
	}

	function actualiza_fecha($id){
		$this->db->where('id', $id);
		$this->db->update('asigna_requerimiento', array('fecha_termino' => date('Y-m-d')));
	}
	
	function existe_trab_requerimiento($id_trab,$id_req){
		$this->db->where("id_usuarios",$id_trab);
		$this->db->where("termino",0);
		$this->db->where("id_requerimientotrabajador",$id_req);
		$query = $this->db->get('asigna_requerimiento');
		return $query->row();
	}
	
	function actualizar($id_req,$id_usr,$data){
		$this->db->where("id_usuarios",$id_usr);
		$this->db->where("id_requerimientotrabajador",$id_req);
		$na = $this->db->update('asigna_requerimiento',$data);
	}
	
	function actualizar2($id,$data){
		$this->db->where("id",$id);
		$na = $this->db->update('asigna_requerimiento',$data);
	}
	
	function listado_requerimiento($id){
		$this->db->where('id_requerimientotrabajador',$id);
		$query = $this->db->get('asigna_requerimiento');
		return $query->result();
	}

}