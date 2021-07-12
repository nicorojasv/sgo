<?php
class Usuarios_model extends CI_Model {
	
	function __construct(){
		$this->log_serv = $this->load->database('log_serv', TRUE);
	}

	function listar_activos(){
		$this->log_serv->select('*');
		$this->log_serv->from('usuarios');
		$this->log_serv->where('estado', 1);
		$query = $this->log_serv->get();
		return $query->result();
	}

	function get($id){
		$this->log_serv->where('id', $id);
		$query = $this->log_serv->get('usuarios');
		return $query->row();
	}

	function eliminar($id){
		$this->log_serv->delete('usuarios', array('id' => $id)); 
	}

	function editar($id,$data){
		$this->log_serv->where('id', $id);
		$this->log_serv->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->log_serv->insert('usuarios',$data); 
		return $this->log_serv->insert_id();
	}

	function listar_trabajadores_orden_paterno_activos(){
		$this->log_serv->where("estado", 1);
		$this->log_serv->order_by("paterno","asc");
		$query = $this->log_serv->get("usuarios");
		return $query->result();
	}

	function todos_los_contratos(){
		$this->log_serv->select(' rua.usuario_id, tipo_archivo_requerimiento_id as tipo_archivo, rua.url, rua.causal, rua.motivo, rua.fecha_inicio, fecha_termino, rua.jornada, rua.renta_imponible,  rua.asignacion_colacion, rua.seguro_vida_arauco, usu.nombres as nombre_usuario, usu.paterno, usu.materno, usu.rut_usuario, rasc.referido, req.codigo_requerimiento, req.nombre as nombre_req, req.f_solicitud, req.f_inicio as fecha_inicio_req, req.f_fin as f_fin_req, ep.nombre as nombre_empresa, ra.nombre as nombre_area, rc.nombre as nombre_cargo, rua.requerimiento_asc_trabajadores_id as idRequerimientoAsociado');
		$this->log_serv->from('r_requerimiento_usuario_archivo rua');
		$this->log_serv->join('usuarios usu','rua.usuario_id = usu.id','left');
		$this->log_serv->join('r_requerimiento_asc_trabajadores rasc','rua.requerimiento_asc_trabajadores_id = rasc.id','left');
		$this->log_serv->join('r_requerimiento_area_cargo rac','rasc.requerimiento_area_cargo_id = rac.id','left');
		$this->log_serv->join('r_requerimiento req','rac.requerimiento_id = req.id','left');
		$this->log_serv->join('r_areas ra','rac.areas_id = ra.id','left');
		$this->log_serv->join('r_cargos rc','rac.cargos_id = rc.id','left');
		$this->log_serv->join('empresa_planta ep','req.planta_id = ep.id','left');
		$this->log_serv->where('rua.tipo_archivo_requerimiento_id = 1 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 1)');
		$this->log_serv->group_by('rua.usuario_id', 'ASC');
		$this->log_serv->order_by('rua.usuario_id', 'ASC');
		$query = $this->log_serv->get();
		return $query->result();
	}

	function todos_los_anexos($id_usuario=false, $idRequerimientoAsociado){
		$this->log_serv->select(' *');
		$this->log_serv->from('r_requerimiento_usuario_archivo rua');
		$this->log_serv->where('rua.tipo_archivo_requerimiento_id = 2 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 2)');
		$this->log_serv->where('rua.usuario_id',$id_usuario);
		$this->log_serv->where('rua.requerimiento_asc_trabajadores_id',$idRequerimientoAsociado);
		//$this->log_serv->or_where('rua.tipo_archivo_requerimiento_id = 2');
		$this->log_serv->group_by('rua.usuario_id', 'ASC');
		$this->log_serv->order_by('rua.usuario_id', 'ASC');
		$query = $this->log_serv->get();
		return $query->row();
	}

	function getBancos(){
		$this->log_serv->select('*');
		$this->log_serv->from('bancos');
		$this->log_serv->order_by("desc_bancos","asc");
		$query = $this->log_serv->get();
		return $query->result();
	}

	function getNombreBanco($id){
		$this->log_serv->select('*');
		$this->log_serv->from('bancos');
		$this->log_serv->where("id",$id);
		$query = $this->log_serv->get();
		return $query->row();
	}
}
?>