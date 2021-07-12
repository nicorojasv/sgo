<?php
class Usuarios_model extends CI_Model {
	
	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function listar_activos(){
		$this->wood->select('*');
		$this->wood->from('usuarios');
		$this->wood->where('estado', 1);
		$this->wood->order_by('id','asc');
		$query = $this->wood->get();
		return $query->result();
	}

	function get($id){
		$this->wood->where('id', $id);
		$query = $this->wood->get('usuarios');
		return $query->row();
	}

	function get_rut($rut){
		$this->wood->where('rut_usuario', $rut);
		$query = $this->wood->get('usuarios');
		return $query->row();
	}

	function eliminar($id){
		$this->wood->delete('usuarios', array('id' => $id)); 
	}

	function editar($id,$data){
		$this->wood->where('id', $id);
		$this->wood->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->wood->insert('usuarios',$data); 
		return $this->wood->insert_id();
	}

	function listar_trabajadores_orden_paterno_activos(){
		$this->wood->where("estado", 1);
		$this->wood->order_by("paterno","asc");
		$query = $this->wood->get("usuarios");
		return $query->result();
	}

	function todos_los_contratos(){
		$this->wood->select(' rua.usuario_id, tipo_archivo_requerimiento_id as tipo_archivo, rua.url, rua.causal, rua.motivo, rua.fecha_inicio, fecha_termino, rua.jornada, rua.renta_imponible,  rua.asignacion_colacion, rua.seguro_vida_arauco, usu.nombres as nombre_usuario, usu.paterno, usu.materno, usu.rut_usuario, rasc.referido, req.codigo_requerimiento, req.nombre as nombre_req, req.f_solicitud, req.f_inicio as fecha_inicio_req, req.f_fin as f_fin_req, ep.nombre as nombre_empresa, ra.nombre as nombre_area, rc.nombre as nombre_cargo, rua.requerimiento_asc_trabajadores_id as idRequerimientoAsociado');
		$this->wood->from('r_requerimiento_usuario_archivo rua');
		$this->wood->join('usuarios usu','rua.usuario_id = usu.id','left');
		$this->wood->join('r_requerimiento_asc_trabajadores rasc','rua.requerimiento_asc_trabajadores_id = rasc.id','left');
		$this->wood->join('r_requerimiento_area_cargo rac','rasc.requerimiento_area_cargo_id = rac.id','left');
		$this->wood->join('r_requerimiento req','rac.requerimiento_id = req.id','left');
		$this->wood->join('r_areas ra','rac.areas_id = ra.id','left');
		$this->wood->join('r_cargos rc','rac.cargos_id = rc.id','left');
		$this->wood->join('empresa_planta ep','req.planta_id = ep.id','left');
		$this->wood->where('rua.tipo_archivo_requerimiento_id = 1 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 1)');
		$this->wood->group_by('rua.usuario_id', 'ASC');
		$this->wood->order_by('rua.usuario_id', 'ASC');
		$query = $this->wood->get();
		return $query->result();
	}

	function todos_los_anexos($id_usuario=false , $idRequerimientoAsociado){
		$this->wood->select(' *');
		$this->wood->from('r_requerimiento_usuario_archivo rua');
		$this->wood->where('rua.tipo_archivo_requerimiento_id = 2 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 2)');
		$this->wood->where('rua.usuario_id',$id_usuario);
		$this->wood->where('rua.requerimiento_asc_trabajadores_id',$idRequerimientoAsociado);
		//$this->wood->or_where('rua.tipo_archivo_requerimiento_id = 2');
		$this->wood->group_by('rua.usuario_id', 'ASC');
		$this->wood->order_by('rua.usuario_id', 'ASC');
		$query = $this->wood->get();
		return $query->row();
	}
		
	function getListaNegraTrabajador($id){
		$this->wood->select('*,lista_negra.id lista_id, lista_negra.fecha fecha_ln');
		$this->wood->from('lista_negra');
		$this->wood->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$this->wood->order_by("fecha_ln","desc");
		$this->wood->where("id_usuario",$id);
		$query = $this->wood->get();
		return $query->result();
	}

	function ingresarListaNegra($data){
		$this->wood->insert('lista_negra',$data);
		return $this->wood->insert_id();
	}

	function eliminarListaNegra($id){
		$this->wood->delete('lista_negra', array('id' => $id)); 
	}

	function getBancos(){
		$this->wood->select('*');
		$this->wood->from('bancos');
		$this->wood->order_by("desc_bancos","asc");
		$query = $this->wood->get();
		return $query->result();
	}

	function getNombreBanco($id){
		$this->wood->select('*');
		$this->wood->from('bancos');
		$this->wood->where("id",$id);
		$query = $this->wood->get();
		return $query->row();
	}

	#26-07-2018 g.r.m
	function guardarAsistenciaTrabajador($data){
		$this->wood->insert('asistencia',$data);
	}

	function getAsistenciaPersona($id){
		$this->wood->select('*');
		$this->wood->from('asistencia');
		$this->wood->where("id_usuario",$id);
		$query = $this->wood->get();
		return $query->row();
	}

	function contar_evaluaciones_user($id_usuario, $id_tipo_eval){
		$this->wood->select('count(id) as total');
		$this->wood->from('evaluaciones');
		$this->wood->where('id_evaluacion', $id_tipo_eval);
		$this->wood->where('id_usuarios', $id_usuario);
		$query = $this->wood->get();
		return $query->row();
	}

	function id_maximo_examenes_user($id_usuario, $id_tipo_eval){
		$this->wood->select('max(id) as ultimo');
		$this->wood->from('evaluaciones');
		$this->wood->where('id_evaluacion', $id_tipo_eval);
		$this->wood->where('id_usuarios', $id_usuario);
		$query = $this->wood->get();
		return $query->row();
	}
	function actualizar_desactivo_estado_preo($id_usuario){
		$this->wood->set('estado_ultima_evaluacion', 0);
		$this->wood->where('id_usuarios', $id_usuario);
		$this->wood->where('id_evaluacion', 3);
		$this->wood->update('evaluaciones'); 
	}
	function actualizar_activo_estado_preo($id){
		$this->wood->set('estado_ultima_evaluacion', 1);
		$this->wood->where('id', $id);
		$this->wood->update('evaluaciones'); 
	}
	function get_rut2($rut){
		$this->wood->where('rut_usuario',$rut);
		$query = $this->wood->get('usuarios');
		return $query->row();
	}

}
?>