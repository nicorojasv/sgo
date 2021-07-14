<?php
class Requerimiento_asc_trabajadores_model extends CI_Model{

	function __construct(){
		$this->general = $this->load->database('general', TRUE);
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function listar(){
		$query = $this->carrera->get('r_requerimiento_asc_trabajadores');
		return $query->result();
	}

	function get_requerimiento_usu($id_usuario){
		$this->carrera->select('rasc.referido, rasc.status, ar.nombre nombre_area, car.nombre nombre_cargo, req.codigo_requerimiento, req.nombre nombre_req, req.f_solicitud, ep.nombre empresa_planta, req.regimen, req.f_inicio, req.f_fin, req.causal, req.motivo, req.comentario');
		$this->carrera->from('r_requerimiento_asc_trabajadores rasc');
		$this->carrera->join('r_requerimiento_area_cargo rac','rasc.requerimiento_area_cargo_id = rac.id','inner');
		$this->carrera->join('r_areas ar','rac.areas_id = ar.id','inner');
		$this->carrera->join('r_cargos car','rac.cargos_id = car.id','inner');
		$this->carrera->join('r_requerimiento req','rac.requerimiento_id = req.id','inner');
		$this->carrera->join('empresa_planta ep','req.planta_id = ep.id','inner');
		$this->carrera->where('rasc.usuario_id',$id_usuario);
		$query = $this->carrera->get();
		return $query->result();
	}




	function get($id){
		$this->carrera->where('id',$id);
		$query = $this->carrera->get('r_requerimiento_asc_trabajadores');
		return $query->row();
	}





	function get_usu_area_cargo($id_usuario, $id_area){
		$this->carrera->select('id');
		$this->carrera->where('usuario_id',$id_usuario);
		$this->carrera->where('requerimiento_area_cargo_id',$id_area);
		$query = $this->carrera->get('r_requerimiento_asc_trabajadores');
		return $query->row();
	}

	function get_historial_requerimientos($usuario_id){
		$this->carrera->select('rat.id rat_id, rat.requerimiento_area_cargo_id rac_id, rat.usuario_id, rac.areas_id ,rac.cargos_id, ra.nombre nombre_area, rc.nombre nombre_cargo');
		$this->carrera->from('r_requerimiento_asc_trabajadores rat');
		$this->carrera->join('r_requerimiento_area_cargo rac','rat.requerimiento_area_cargo_id = rac.id','left');
		$this->carrera->join('r_areas ra','rac.areas_id = ra.id','left');
		$this->carrera->join('r_cargos rc','rac.cargos_id = rc.id','left');
		$this->carrera->where('rat.usuario_id', $usuario_id);
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_usuarios_area_cargo_req_activos($id_usuario){
		$this->carrera->select('*');
		//$this->carrera->select('req.f_inicio as fi_req');
		//$this->carrera->select('req.f_fin as ft_req');
		$this->carrera->select('req.nombre as nombre_req');
		$this->carrera->select('r_a.nombre as nombre_area');
		$this->carrera->select('r_c.nombre as nombre_cargo');
		$this->carrera->select('r_asc.status');
		$this->carrera->from('r_requerimiento_asc_trabajadores r_asc');
		$this->carrera->join('r_requerimiento_area_cargo r_area_cargo','r_asc.requerimiento_area_cargo_id = r_area_cargo.id','left');
		$this->carrera->join('r_areas r_a','r_area_cargo.areas_id = r_a.id','left');
		$this->carrera->join('r_cargos r_c','r_area_cargo.cargos_id = r_c.id','left');
		$this->carrera->join('r_requerimiento req','r_area_cargo.requerimiento_id = req.id','left');
		$this->carrera->where('r_asc.usuario_id',$id_usuario);
		$this->carrera->where('req.estado', 1);
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_usuarios_area_cargo_asc_req_usu_row($id_usuario, $id_req){
		$this->carrera->select('r_a.id as id_area');
		$this->carrera->select('r_a.nombre as nombre_area');
		$this->carrera->select('r_c.id as id_cargo');
		$this->carrera->select('r_c.nombre as nombre_cargo');
		$this->carrera->select('r_asc.referido');
		$this->carrera->select('r_asc.status');
		$this->carrera->select('r_asc.id as id_asc_trab');
		$this->carrera->select('req.id as id_req');
		$this->carrera->select('req.nombre as nombre_req');
		$this->carrera->select('req.empresa_id');
		$this->carrera->select('req.planta_id');
		$this->carrera->select('req.f_inicio');
		$this->carrera->select('req.f_fin');
		$this->carrera->select('emp.nombre as empresa_planta');
		$this->carrera->from('r_requerimiento_asc_trabajadores r_asc');
		$this->carrera->join('r_requerimiento_area_cargo r_area_cargo','r_asc.requerimiento_area_cargo_id = r_area_cargo.id','left');
		$this->carrera->join('r_areas r_a','r_area_cargo.areas_id = r_a.id','left');
		$this->carrera->join('r_cargos r_c','r_area_cargo.cargos_id = r_c.id','left');
		$this->carrera->join('r_requerimiento req','r_area_cargo.requerimiento_id = req.id','left');
		$this->carrera->join('empresa_planta emp','req.planta_id = emp.id','left');
		$this->carrera->where('r_asc.usuario_id',$id_usuario);
		$this->carrera->where('req.id', $id_req);
		$query = $this->carrera->get();
		return $query->row();
	}

	function get_usuarios_area_cargo_req_activos_row($id_usuario){
		$this->carrera->select('r_a.id as id_area');
		$this->carrera->select('r_a.nombre as nombre_area');
		$this->carrera->select('r_c.id as id_cargo');
		$this->carrera->select('r_c.nombre as nombre_cargo');
		$this->carrera->select('r_asc.referido');
		$this->carrera->select('r_asc.status');
		$this->carrera->select('r_asc.id as id_asc_trab');
		$this->carrera->select('req.id as id_req');
		$this->carrera->select('req.nombre as nombre_req');
		$this->carrera->select('req.empresa_id');
		$this->carrera->select('req.planta_id');
		$this->carrera->select('req.f_inicio');
		$this->carrera->select('req.f_fin');
		$this->carrera->select('emp.nombre as empresa_planta');
		$this->carrera->from('r_requerimiento_asc_trabajadores r_asc');
		$this->carrera->join('r_requerimiento_area_cargo r_area_cargo','r_asc.requerimiento_area_cargo_id = r_area_cargo.id','left');
		$this->carrera->join('r_areas r_a','r_area_cargo.areas_id = r_a.id','left');
		$this->carrera->join('r_cargos r_c','r_area_cargo.cargos_id = r_c.id','left');
		$this->carrera->join('r_requerimiento req','r_area_cargo.requerimiento_id = req.id','left');
		$this->carrera->join('empresa_planta emp','req.planta_id = emp.id','left');
		$this->carrera->where('r_asc.usuario_id',$id_usuario);
		$this->carrera->where('req.estado', 1);
		$query = $this->carrera->get();
		return $query->row();
	}

	function get_usuarios_area_cargo_req_activos_result($id_usuario){
		$this->carrera->select('r_a.id as id_area');
		$this->carrera->select('r_a.nombre as nombre_area');
		$this->carrera->select('r_c.id as id_cargo');
		$this->carrera->select('r_c.nombre as nombre_cargo');
		$this->carrera->select('r_asc.referido');
		$this->carrera->select('r_asc.status');
		$this->carrera->select('r_asc.id as id_asc_trab');
		$this->carrera->select('req.id as id_req');
		$this->carrera->select('req.nombre as nombre_req');
		$this->carrera->select('req.empresa_id');
		$this->carrera->select('req.planta_id');
		$this->carrera->select('req.f_inicio');
		$this->carrera->select('req.f_fin');
		$this->carrera->select('emp.nombre as empresa_planta');
		$this->carrera->from('r_requerimiento_asc_trabajadores r_asc');
		$this->carrera->join('r_requerimiento_area_cargo r_area_cargo','r_asc.requerimiento_area_cargo_id = r_area_cargo.id','left');
		$this->carrera->join('r_areas r_a','r_area_cargo.areas_id = r_a.id','left');
		$this->carrera->join('r_cargos r_c','r_area_cargo.cargos_id = r_c.id','left');
		$this->carrera->join('r_requerimiento req','r_area_cargo.requerimiento_id = req.id','left');
		$this->carrera->join('empresa_planta emp','req.planta_id = emp.id','left');
		$this->carrera->where('r_asc.usuario_id',$id_usuario);
		$this->carrera->where('req.estado', 1);
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_area_cargo_req_row($id_asc){
		$this->carrera->select('r_a.id as id_area');
		$this->carrera->select('r_a.nombre as nombre_area');
		$this->carrera->select('r_c.id as id_cargo');
		$this->carrera->select('r_c.nombre as nombre_cargo');
		$this->carrera->select('r_asc.referido');
		$this->carrera->select('r_asc.status');
		$this->carrera->select('r_asc.id as id_asc_trab');
		$this->carrera->select('req.id as id_req');
		$this->carrera->select('req.nombre as nombre_req');
		$this->carrera->select('req.empresa_id');
		$this->carrera->select('req.planta_id');
		$this->carrera->select('emp.nombre as empresa_planta');
		$this->carrera->from('r_requerimiento_asc_trabajadores r_asc');
		$this->carrera->join('r_requerimiento_area_cargo r_area_cargo','r_asc.requerimiento_area_cargo_id = r_area_cargo.id','left');
		$this->carrera->join('r_areas r_a','r_area_cargo.areas_id = r_a.id','left');
		$this->carrera->join('r_cargos r_c','r_area_cargo.cargos_id = r_c.id','left');
		$this->carrera->join('r_requerimiento req','r_area_cargo.requerimiento_id = req.id','left');
		$this->carrera->join('empresa_planta emp','req.planta_id = emp.id','left');
		$this->carrera->where('r_asc.id',$id_asc);
		$query = $this->carrera->get();
		return $query->row();
	}



	function get_cargo_area($id){
		$this->carrera->where('requerimiento_area_cargo_id',$id);
		$query = $this->carrera->get('r_requerimiento_asc_trabajadores');
		return $query->result();
	}


	function get_requerimiento($id){
		$this->carrera->select("*,rat.id id_asc_trabajadores");
		$this->carrera->from("r_requerimiento_asc_trabajadores rat");
		$this->carrera->join('r_requerimiento_area_cargo rac','rat.requerimiento_area_cargo_id = rac.id');
		$this->carrera->where('rac.requerimiento_id',$id);
		$query = $this->carrera->get();
		return $query->result();
	}


	function contador($id){
		$this->carrera->where('requerimiento_area_cargo_id',$id);
		$query = $this->carrera->get('r_requerimiento_asc_trabajadores');
		return $query->num_rows();
	}

	function eliminar($id){
		$this->carrera->delete('r_requerimiento_asc_trabajadores', array('id' => $id)); 
	}

	function editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('r_requerimiento_asc_trabajadores', $data); 
	}

	function ingresar($data){
		$this->carrera->insert('r_requerimiento_asc_trabajadores',$data); 
		return $this->carrera->insert_id();
	}




	function consultar_actualizacion($id,$fecha){
		$this->general->select('*');
		$this->general->from('sgo_est.r_requerimiento_asc_trabajadores rat');
		$this->general->join('usuarios', 'usuarios.id = rat.quien','inner');
		$this->general->where('rat.quien !='.$id);
		$this->general->where('rat.actualizacion >',$fecha);
		$query = $this->general->get();
		return $query->result();
	}

}
?>