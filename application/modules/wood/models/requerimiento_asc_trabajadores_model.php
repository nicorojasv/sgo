<?php
class Requerimiento_asc_trabajadores_model extends CI_Model{

	function __construct(){
		$this->general = $this->load->database('general', TRUE);
		$this->wood = $this->load->database('wood', TRUE);
	}

	function listar(){
		$query = $this->wood->get('r_requerimiento_asc_trabajadores');
		return $query->result();
	}

	function get_requerimiento_usu($id_usuario){
		$this->wood->select('rasc.referido, rasc.status, ar.nombre nombre_area, car.nombre nombre_cargo, req.codigo_requerimiento, req.nombre nombre_req, req.f_solicitud, ep.nombre empresa_planta, req.regimen, req.f_inicio, req.f_fin, req.causal, req.motivo, req.comentario');
		$this->wood->from('r_requerimiento_asc_trabajadores rasc');
		$this->wood->join('r_requerimiento_area_cargo rac','rasc.requerimiento_area_cargo_id = rac.id','inner');
		$this->wood->join('r_areas ar','rac.areas_id = ar.id','inner');
		$this->wood->join('r_cargos car','rac.cargos_id = car.id','inner');
		$this->wood->join('r_requerimiento req','rac.requerimiento_id = req.id','inner');
		$this->wood->join('empresa_planta ep','req.planta_id = ep.id','inner');
		$this->wood->where('rasc.usuario_id',$id_usuario);
		$query = $this->wood->get();
		return $query->result();
	}




	function get($id){
		$this->wood->where('id',$id);
		$query = $this->wood->get('r_requerimiento_asc_trabajadores');
		return $query->row();
	}





	function get_usu_area_cargo($id_usuario, $id_area){
		$this->wood->select('id');
		$this->wood->where('usuario_id',$id_usuario);
		$this->wood->where('requerimiento_area_cargo_id',$id_area);
		$query = $this->wood->get('r_requerimiento_asc_trabajadores');
		return $query->row();
	}

	function get_historial_requerimientos($usuario_id){
		$this->wood->select('rat.id rat_id, rat.requerimiento_area_cargo_id rac_id, rat.usuario_id, rac.areas_id ,rac.cargos_id, ra.nombre nombre_area, rc.nombre nombre_cargo');
		$this->wood->from('r_requerimiento_asc_trabajadores rat');
		$this->wood->join('r_requerimiento_area_cargo rac','rat.requerimiento_area_cargo_id = rac.id','left');
		$this->wood->join('r_areas ra','rac.areas_id = ra.id','left');
		$this->wood->join('r_cargos rc','rac.cargos_id = rc.id','left');
		$this->wood->where('rat.usuario_id', $usuario_id);
		$query = $this->wood->get();
		return $query->result();
	}

	function get_usuarios_area_cargo_req_activos($id_usuario){
		$this->wood->select('*');
		//$this->wood->select('req.f_inicio as fi_req');
		//$this->wood->select('req.f_fin as ft_req');
		$this->wood->select('req.nombre as nombre_req');
		$this->wood->select('r_a.nombre as nombre_area');
		$this->wood->select('r_c.nombre as nombre_cargo');
		$this->wood->select('r_asc.status');
		$this->wood->from('r_requerimiento_asc_trabajadores r_asc');
		$this->wood->join('r_requerimiento_area_cargo r_area_cargo','r_asc.requerimiento_area_cargo_id = r_area_cargo.id','left');
		$this->wood->join('r_areas r_a','r_area_cargo.areas_id = r_a.id','left');
		$this->wood->join('r_cargos r_c','r_area_cargo.cargos_id = r_c.id','left');
		$this->wood->join('r_requerimiento req','r_area_cargo.requerimiento_id = req.id','left');
		$this->wood->where('r_asc.usuario_id',$id_usuario);
		$this->wood->where('req.estado', 1);
		$query = $this->wood->get();
		return $query->result();
	}

	function get_usuarios_area_cargo_asc_req_usu_row($id_usuario, $id_req){
		$this->wood->select('r_a.id as id_area');
		$this->wood->select('r_a.nombre as nombre_area');
		$this->wood->select('r_c.id as id_cargo');
		$this->wood->select('r_c.nombre as nombre_cargo');
		$this->wood->select('r_asc.referido');
		$this->wood->select('r_asc.status');
		$this->wood->select('r_asc.id as id_asc_trab');
		$this->wood->select('req.id as id_req');
		$this->wood->select('req.nombre as nombre_req');
		$this->wood->select('req.empresa_id');
		$this->wood->select('req.planta_id');
		$this->wood->select('req.f_inicio');
		$this->wood->select('req.f_fin');
		$this->wood->select('emp.nombre as empresa_planta');
		$this->wood->from('r_requerimiento_asc_trabajadores r_asc');
		$this->wood->join('r_requerimiento_area_cargo r_area_cargo','r_asc.requerimiento_area_cargo_id = r_area_cargo.id','left');
		$this->wood->join('r_areas r_a','r_area_cargo.areas_id = r_a.id','left');
		$this->wood->join('r_cargos r_c','r_area_cargo.cargos_id = r_c.id','left');
		$this->wood->join('r_requerimiento req','r_area_cargo.requerimiento_id = req.id','left');
		$this->wood->join('empresa_planta emp','req.planta_id = emp.id','left');
		$this->wood->where('r_asc.usuario_id',$id_usuario);
		$this->wood->where('req.id', $id_req);
		$query = $this->wood->get();
		return $query->row();
	}

	function get_usuarios_area_cargo_req_activos_row($id_usuario){
		$this->wood->select('r_a.id as id_area');
		$this->wood->select('r_a.nombre as nombre_area');
		$this->wood->select('r_c.id as id_cargo');
		$this->wood->select('r_c.nombre as nombre_cargo');
		$this->wood->select('r_asc.referido');
		$this->wood->select('r_asc.status');
		$this->wood->select('r_asc.id as id_asc_trab');
		$this->wood->select('req.id as id_req');
		$this->wood->select('req.nombre as nombre_req');
		$this->wood->select('req.empresa_id');
		$this->wood->select('req.planta_id');
		$this->wood->select('req.f_inicio');
		$this->wood->select('req.f_fin');
		$this->wood->select('emp.nombre as empresa_planta');
		$this->wood->from('r_requerimiento_asc_trabajadores r_asc');
		$this->wood->join('r_requerimiento_area_cargo r_area_cargo','r_asc.requerimiento_area_cargo_id = r_area_cargo.id','left');
		$this->wood->join('r_areas r_a','r_area_cargo.areas_id = r_a.id','left');
		$this->wood->join('r_cargos r_c','r_area_cargo.cargos_id = r_c.id','left');
		$this->wood->join('r_requerimiento req','r_area_cargo.requerimiento_id = req.id','left');
		$this->wood->join('empresa_planta emp','req.planta_id = emp.id','left');
		$this->wood->where('r_asc.usuario_id',$id_usuario);
		$this->wood->where('req.estado', 1);
		$query = $this->wood->get();
		return $query->row();
	}

	function get_usuarios_area_cargo_req_activos_result($id_usuario){
		$this->wood->select('r_a.id as id_area');
		$this->wood->select('r_a.nombre as nombre_area');
		$this->wood->select('r_c.id as id_cargo');
		$this->wood->select('r_c.nombre as nombre_cargo');
		$this->wood->select('r_asc.referido');
		$this->wood->select('r_asc.status');
		$this->wood->select('r_asc.id as id_asc_trab');
		$this->wood->select('req.id as id_req');
		$this->wood->select('req.nombre as nombre_req');
		$this->wood->select('req.empresa_id');
		$this->wood->select('req.planta_id');
		$this->wood->select('req.f_inicio');
		$this->wood->select('req.f_fin');
		$this->wood->select('emp.nombre as empresa_planta');
		$this->wood->from('r_requerimiento_asc_trabajadores r_asc');
		$this->wood->join('r_requerimiento_area_cargo r_area_cargo','r_asc.requerimiento_area_cargo_id = r_area_cargo.id','left');
		$this->wood->join('r_areas r_a','r_area_cargo.areas_id = r_a.id','left');
		$this->wood->join('r_cargos r_c','r_area_cargo.cargos_id = r_c.id','left');
		$this->wood->join('r_requerimiento req','r_area_cargo.requerimiento_id = req.id','left');
		$this->wood->join('empresa_planta emp','req.planta_id = emp.id','left');
		$this->wood->where('r_asc.usuario_id',$id_usuario);
		$this->wood->where('req.estado', 1);
		$query = $this->wood->get();
		return $query->result();
	}

	function get_area_cargo_req_row($id_asc){
		$this->wood->select('r_a.id as id_area');
		$this->wood->select('r_a.nombre as nombre_area');
		$this->wood->select('r_c.id as id_cargo');
		$this->wood->select('r_c.nombre as nombre_cargo');
		$this->wood->select('r_asc.referido');
		$this->wood->select('r_asc.status');
		$this->wood->select('r_asc.id as id_asc_trab');
		$this->wood->select('req.id as id_req');
		$this->wood->select('req.nombre as nombre_req');
		$this->wood->select('req.empresa_id');
		$this->wood->select('req.planta_id');
		$this->wood->select('emp.nombre as empresa_planta');
		$this->wood->from('r_requerimiento_asc_trabajadores r_asc');
		$this->wood->join('r_requerimiento_area_cargo r_area_cargo','r_asc.requerimiento_area_cargo_id = r_area_cargo.id','left');
		$this->wood->join('r_areas r_a','r_area_cargo.areas_id = r_a.id','left');
		$this->wood->join('r_cargos r_c','r_area_cargo.cargos_id = r_c.id','left');
		$this->wood->join('r_requerimiento req','r_area_cargo.requerimiento_id = req.id','left');
		$this->wood->join('empresa_planta emp','req.planta_id = emp.id','left');
		$this->wood->where('r_asc.id',$id_asc);
		$query = $this->wood->get();
		return $query->row();
	}



	function get_cargo_area($id){
		$this->wood->where('requerimiento_area_cargo_id',$id);
		$query = $this->wood->get('r_requerimiento_asc_trabajadores');
		return $query->result();
	}


	function get_requerimiento($id){
		$this->wood->select("*,rat.id id_asc_trabajadores");
		$this->wood->from("r_requerimiento_asc_trabajadores rat");
		$this->wood->join('r_requerimiento_area_cargo rac','rat.requerimiento_area_cargo_id = rac.id');
		$this->wood->where('rac.requerimiento_id',$id);
		$query = $this->wood->get();
		return $query->result();
	}


	function contador($id){
		$this->wood->where('requerimiento_area_cargo_id',$id);
		$query = $this->wood->get('r_requerimiento_asc_trabajadores');
		return $query->num_rows();
	}

	function eliminar($id){
		$this->wood->delete('r_requerimiento_asc_trabajadores', array('id' => $id)); 
	}

	function editar($id,$data){
		$this->wood->where('id', $id);
		$this->wood->update('r_requerimiento_asc_trabajadores', $data); 
	}

	function ingresar($data){
		$this->wood->insert('r_requerimiento_asc_trabajadores',$data); 
		return $this->wood->insert_id();
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