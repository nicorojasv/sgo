<?php
class Usuarios_model extends CI_Model {
	
	function __construct(){
		$this->aramark = $this->load->database('aramark', TRUE);
	}

	function listar_activos(){
		$this->aramark->select('*');
		$this->aramark->from('usuarios');
		$this->aramark->where('estado', 1);
		$this->aramark->order_by('id','asc');
		$query = $this->aramark->get();
		return $query->result();
	}

	function get($id){
		$this->aramark->where('id', $id);
		$query = $this->aramark->get('usuarios');
		return $query->row();
	}

	function get_rut($rut){
		$this->aramark->where('rut_usuario', $rut);
		$query = $this->aramark->get('usuarios');
		return $query->row();
	}

	function eliminar($id){
		$this->aramark->delete('usuarios', array('id' => $id)); 
	}

	function editar($id,$data){
		$this->aramark->where('id', $id);
		$this->aramark->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->aramark->insert('usuarios',$data); 
		return $this->aramark->insert_id();
	}

	function listar_trabajadores_orden_paterno_activos(){
		$this->aramark->where("estado", 1);
		$this->aramark->order_by("paterno","asc");
		$query = $this->aramark->get("usuarios");
		return $query->result();
	}

	function todos_los_contratos(){
		$this->aramark->select(' rua.usuario_id, tipo_archivo_requerimiento_id as tipo_archivo, rua.url, rua.causal, rua.motivo, rua.fecha_inicio, fecha_termino, rua.jornada, rua.renta_imponible,  rua.asignacion_colacion, rua.seguro_vida_arauco, usu.nombres as nombre_usuario, usu.paterno, usu.materno, usu.rut_usuario, rasc.referido, req.codigo_requerimiento, req.nombre as nombre_req, req.f_solicitud, req.f_inicio as fecha_inicio_req, req.f_fin as f_fin_req, ep.nombre as nombre_empresa, ra.nombre as nombre_area, rc.nombre as nombre_cargo, rua.requerimiento_asc_trabajadores_id as idRequerimientoAsociado');
		$this->aramark->from('r_requerimiento_usuario_archivo rua');
		$this->aramark->join('usuarios usu','rua.usuario_id = usu.id','left');
		$this->aramark->join('r_requerimiento_asc_trabajadores rasc','rua.requerimiento_asc_trabajadores_id = rasc.id','left');
		$this->aramark->join('r_requerimiento_area_cargo rac','rasc.requerimiento_area_cargo_id = rac.id','left');
		$this->aramark->join('r_requerimiento req','rac.requerimiento_id = req.id','left');
		$this->aramark->join('r_areas ra','rac.areas_id = ra.id','left');
		$this->aramark->join('r_cargos rc','rac.cargos_id = rc.id','left');
		$this->aramark->join('empresa_planta ep','req.planta_id = ep.id','left');
		$this->aramark->where('rua.tipo_archivo_requerimiento_id = 1 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 1)');
		$this->aramark->group_by('rua.usuario_id', 'ASC');
		$this->aramark->order_by('rua.usuario_id', 'ASC');
		$query = $this->aramark->get();
		return $query->result();
	}

	function todos_los_anexos($id_usuario=false , $idRequerimientoAsociado){
		$this->aramark->select(' *');
		$this->aramark->from('r_requerimiento_usuario_archivo rua');
		$this->aramark->where('rua.tipo_archivo_requerimiento_id = 2 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 2)');
		$this->aramark->where('rua.usuario_id',$id_usuario);
		$this->aramark->where('rua.requerimiento_asc_trabajadores_id',$idRequerimientoAsociado);
		//$this->aramark->or_where('rua.tipo_archivo_requerimiento_id = 2');
		$this->aramark->group_by('rua.usuario_id', 'ASC');
		$this->aramark->order_by('rua.usuario_id', 'ASC');
		$query = $this->aramark->get();
		return $query->row();
	}
		
	function getListaNegraTrabajador($id){
		$this->aramark->select('*,lista_negra.id lista_id, lista_negra.fecha fecha_ln');
		$this->aramark->from('lista_negra');
		$this->aramark->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$this->aramark->order_by("fecha_ln","desc");
		$this->aramark->where("id_usuario",$id);
		$query = $this->aramark->get();
		return $query->result();
	}

	function ingresarListaNegra($data){
		$this->aramark->insert('lista_negra',$data);
		return $this->aramark->insert_id();
	}

	function eliminarListaNegra($id){
		$this->aramark->delete('lista_negra', array('id' => $id)); 
	}

	function getBancos(){
		$this->aramark->select('*');
		$this->aramark->from('bancos');
		$this->aramark->order_by("desc_bancos","asc");
		$query = $this->aramark->get();
		return $query->result();
	}

	function getNombreBanco($id){
		$this->aramark->select('*');
		$this->aramark->from('bancos');
		$this->aramark->where("id",$id);
		$query = $this->aramark->get();
		return $query->row();
	}

	#26-07-2018 g.r.m
	function guardarAsistenciaTrabajador($data){
		$this->aramark->insert('asistencia',$data);
	}

	function getAsistenciaPersona($id){
		$this->aramark->select('*');
		$this->aramark->from('asistencia');
		$this->aramark->where("id_usuario",$id);
		$query = $this->aramark->get();
		return $query->row();
	}


}
?>