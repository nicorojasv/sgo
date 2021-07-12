<?php
class Usuarios_model extends CI_Model {
	
	function __construct(){
		$this->marina = $this->load->database('marina', TRUE);
	}

	function listar_activos(){
		$this->marina->select('*');
		$this->marina->from('usuarios');
		$this->marina->where('estado', 1);
		$this->marina->order_by('id','asc');
		$query = $this->marina->get();
		return $query->result();
	}

	function get($id){
		$this->marina->where('id', $id);
		$query = $this->marina->get('usuarios');
		return $query->row();
	}

	function get_rut($rut){
		$this->marina->where('rut_usuario', $rut);
		$query = $this->marina->get('usuarios');
		return $query->row();
	}

	function eliminar($id){
		$this->marina->delete('usuarios', array('id' => $id)); 
	}

	function editar($id,$data){
		$this->marina->where('id', $id);
		$this->marina->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->marina->insert('usuarios',$data); 
		return $this->marina->insert_id();
	}

	function listar_trabajadores_orden_paterno_activos(){
		$this->marina->where("estado", 1);
		$this->marina->order_by("paterno","asc");
		$query = $this->marina->get("usuarios");
		return $query->result();
	}

	function todos_los_contratos(){
		$this->marina->select(' rua.usuario_id, tipo_archivo_requerimiento_id as tipo_archivo, rua.url, rua.causal, rua.motivo, rua.fecha_inicio, fecha_termino, rua.jornada, rua.renta_imponible,  rua.asignacion_colacion, rua.seguro_vida_arauco, usu.nombres as nombre_usuario, usu.paterno, usu.materno, usu.rut_usuario, rasc.referido, req.codigo_requerimiento, req.nombre as nombre_req, req.f_solicitud, req.f_inicio as fecha_inicio_req, req.f_fin as f_fin_req, ep.nombre as nombre_empresa, ra.nombre as nombre_area, rc.nombre as nombre_cargo, rua.requerimiento_asc_trabajadores_id as idRequerimientoAsociado');
		$this->marina->from('r_requerimiento_usuario_archivo rua');
		$this->marina->join('usuarios usu','rua.usuario_id = usu.id','left');
		$this->marina->join('r_requerimiento_asc_trabajadores rasc','rua.requerimiento_asc_trabajadores_id = rasc.id','left');
		$this->marina->join('r_requerimiento_area_cargo rac','rasc.requerimiento_area_cargo_id = rac.id','left');
		$this->marina->join('r_requerimiento req','rac.requerimiento_id = req.id','left');
		$this->marina->join('r_areas ra','rac.areas_id = ra.id','left');
		$this->marina->join('r_cargos rc','rac.cargos_id = rc.id','left');
		$this->marina->join('empresa_planta ep','req.planta_id = ep.id','left');
		$this->marina->where('rua.tipo_archivo_requerimiento_id = 1 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 1)');
		$this->marina->group_by('rua.usuario_id', 'ASC');
		$this->marina->order_by('rua.usuario_id', 'ASC');
		$query = $this->marina->get();
		return $query->result();
	}

	function todos_los_anexos($id_usuario=false , $idRequerimientoAsociado){
		$this->marina->select(' *');
		$this->marina->from('r_requerimiento_usuario_archivo rua');
		$this->marina->where('rua.tipo_archivo_requerimiento_id = 2 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 2)');
		$this->marina->where('rua.usuario_id',$id_usuario);
		$this->marina->where('rua.requerimiento_asc_trabajadores_id',$idRequerimientoAsociado);
		//$this->marina->or_where('rua.tipo_archivo_requerimiento_id = 2');
		$this->marina->group_by('rua.usuario_id', 'ASC');
		$this->marina->order_by('rua.usuario_id', 'ASC');
		$query = $this->marina->get();
		return $query->row();
	}
		
	function getListaNegraTrabajador($id){
		$this->marina->select('*,lista_negra.id lista_id, lista_negra.fecha fecha_ln');
		$this->marina->from('lista_negra');
		$this->marina->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$this->marina->order_by("fecha_ln","desc");
		$this->marina->where("id_usuario",$id);
		$query = $this->marina->get();
		return $query->result();
	}

	function ingresarListaNegra($data){
		$this->marina->insert('lista_negra',$data);
		return $this->marina->insert_id();
	}

	function eliminarListaNegra($id){
		$this->marina->delete('lista_negra', array('id' => $id)); 
	}

	function getBancos(){
		$this->marina->select('*');
		$this->marina->from('bancos');
		$this->marina->order_by("desc_bancos","asc");
		$query = $this->marina->get();
		return $query->result();
	}

	function getNombreBanco($id){
		$this->marina->select('*');
		$this->marina->from('bancos');
		$this->marina->where("id",$id);
		$query = $this->marina->get();
		return $query->row();
	}

	#26-07-2018 g.r.m
	function guardarAsistenciaTrabajador($data){
		$this->marina->insert('asistencia',$data);
	}

	function getAsistenciaPersona($id){
		$this->marina->select('*');
		$this->marina->from('asistencia');
		$this->marina->where("id_usuario",$id);
		$query = $this->marina->get();
		return $query->row();
	}

	function guardarAnotacion($id, $valor){
		$this->marina->where('id', $id);
		$this->marina->update('usuarios', $valor); 
		return $afftectedRows = $this->marina->affected_rows();
	}

	function getCargos(){
		$this->marina->select();
		$this->marina->from('r_cargos');
		$query = $this->marina->get();
		return $query->result();
	}
	
	#yayo 18-12-2019
	function verficarListaNegra($id){
		$this->marina->select('*');
		$this->marina->from('lista_negra');
		$this->marina->where("id_usuario",$id);
		$this->marina->where("estado",NULL);//-> Edit 21-01-2019
		$query = $this->marina->get();
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	#yayo 21-01-2020

	function getAllListaNegra(){
		$this->marina->select('*');
		$this->marina->from('lista_negra');
		$this->marina->where('estado',NULL);
		$query = $this->marina->get();
		return $query->result();
	}
	function updateListaNegra($id,$data){
		$this->marina->where('id', $id);
		$this->marina->update('lista_negra', $data); 
		return $afftectedRows = $this->marina->affected_rows();
	}


}
?>