<?php
class Listado_datos_trabajadores_model extends CI_Model {

	function listar_trabajadores(){
		//$this->db->select('usu.id as id, usu.rut_usuario, usu.nombres, usu.paterno, usu.materno, usu.estado, espec_t1.desc_especialidad as especialida1, espec_t2.desc_especialidad as especialidad2,  espec_t3.desc_especialidad as especialidad3');
		$this->db->select('usu.id as id, usu.rut_usuario, usu.nombres, usu.paterno, usu.materno, usu.estado');
		$this->db->from('usuarios usu');
		//$this->db->join('especialidad_trabajador espec_t1','usu.id_especialidad_trabajador = espec_t1.id','left');
		//$this->db->join('especialidad_trabajador espec_t2','usu.id_especialidad_trabajador_2 = espec_t1.id','left');
		//$this->db->join('especialidad_trabajador espec_t3','usu.id_especialidad_trabajador_3 = espec_t1.id','left');
		$this->db->where('usu.id_tipo_usuarios', 2);
		$this->db->order_by('usu.paterno', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	function get_masso_usu($id_usuario){
		$this->db->select('(CASE WHEN DATEDIFF(e_masso.fecha_v,now()) >= 0 && DATEDIFF(e_masso.fecha_v,now()) <= 30 THEN "#FF8000" WHEN DATEDIFF(e_masso.fecha_v,now()) < 0 THEN "red" WHEN DATEDIFF(e_masso.fecha_v,now()) > 30 THEN "green" END) color_masso, e_masso.fecha_v as fecha_vigencia_masso');
		$this->db->from('usuarios usu');
		$this->db->join('(select id_usuarios, max(fecha_v) fecha_v from evaluaciones where id_evaluacion = 4 group by id_usuarios order by evaluaciones.id desc) e_masso', 'e_masso.id_usuarios = usu.id', 'left');
		$this->db->where('usu.id', $id_usuario);
		$query = $this->db->get();
		return $query->result();
	}

	function get_preocupacional_usu($id_usuario){
		$this->db->select('(CASE WHEN DATEDIFF(e_masso.fecha_v,now()) >= 0 && DATEDIFF(e_masso.fecha_v,now()) <= 30 THEN "#FF8000" WHEN DATEDIFF(e_masso.fecha_v,now()) < 0 THEN "red" WHEN DATEDIFF(e_masso.fecha_v,now()) > 30 THEN "green" END) color_masso, e_masso.fecha_v as fecha_vigencia_masso');
		$this->db->from('usuarios usu');
		$this->db->join('(select id_usuarios, max(fecha_v) fecha_v from evaluaciones where id_evaluacion = 3 group by id_usuarios order by evaluaciones.id desc) e_masso', 'e_masso.id_usuarios = usu.id', 'left');
		$this->db->where('usu.id', $id_usuario);
		$query = $this->db->get();
		return $query->result();
	}

	

	function consulta_grande(){
		$query = $this->db->query("(CASE WHEN DATEDIFF(e_examen_pre.fecha_v,now()) >= 0 && DATEDIFF(e_examen_pre.fecha_v,now()) <= 30 THEN '#FF8000' WHEN DATEDIFF(e_examen_pre.fecha_v,now()) < 0 THEN 'red' WHEN DATEDIFF(e_examen_pre.fecha_v,now()) > 30 THEN 'green' END) color_e_preo, e_examen_pre.fecha_v as fecha_vigencia_examen_preo
from usuarios usu

left join (select id_usuarios, max(fecha_v) fecha_v from evaluaciones where id_evaluacion = 3 group by id_usuarios order by evaluaciones.id desc) e_examen_pre on e_examen_pre.id_usuarios = usu.id");

return $query->result();
}



	function ver_usuarios_masso($id_usuario){
		$this->db->where('id_usuario', $id_usuario);
		$query = $this->db->get('usuario_masso');
		return $query->row();
	}

	function ver_usuarios_examen_preocupacional($id_usuario){
		$this->db->where('id_usuario', $id_usuario);
		$query = $this->db->get('usuario_e_preocupacional');
		return $query->row();
	}


	

}