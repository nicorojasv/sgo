<?php
class Asistencia_model extends CI_Model {
	
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function listar_activos(){
		$this->carrera->select('*');
		$this->carrera->from('usuarios');
		$this->carrera->where('estado', 1);
		$this->carrera->order_by('id','asc');
		//$this->carrera->limit(30, 1);
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_trabajadores_activo_asistencia(){
		$this->carrera->select('*');
		$this->carrera->from('usuarios');
		$this->carrera->where('estadoAsistencia', 1);
		$this->carrera->order_by('id','asc');
		$query = $this->carrera->get();
		return $query->result();
	}

	function get($id){
		$this->carrera->where('id', $id);
		$query = $this->carrera->get('usuarios');
		return $query->row();
	}

	function get_rut($rut){
		$this->carrera->where('rut_usuario', $rut);
		$query = $this->carrera->get('usuarios');
		return $query->row();
	}

	function eliminar($id){
		$this->carrera->delete('usuarios', array('id' => $id)); 
	}

	function editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->carrera->insert('usuarios',$data); 
		return $this->carrera->insert_id();
	}

	function listar_trabajadores_orden_paterno_activos(){
		$this->carrera->where("estado", 1);
		$this->carrera->order_by("paterno","asc");
		$query = $this->carrera->get("usuarios");
		return $query->result();
	}

	function todos_los_contratos(){
		$this->carrera->select(' rua.usuario_id, tipo_archivo_requerimiento_id as tipo_archivo, rua.url, rua.causal, rua.motivo, rua.fecha_inicio, fecha_termino, rua.jornada, rua.renta_imponible,  rua.asignacion_colacion, rua.seguro_vida_arauco, usu.nombres as nombre_usuario, usu.paterno, usu.materno, usu.rut_usuario, rasc.referido, req.codigo_requerimiento, req.nombre as nombre_req, req.f_solicitud, req.f_inicio as fecha_inicio_req, req.f_fin as f_fin_req, ep.nombre as nombre_empresa, ra.nombre as nombre_area, rc.nombre as nombre_cargo, rua.requerimiento_asc_trabajadores_id as idRequerimientoAsociado');
		$this->carrera->from('r_requerimiento_usuario_archivo rua');
		$this->carrera->join('usuarios usu','rua.usuario_id = usu.id','left');
		$this->carrera->join('r_requerimiento_asc_trabajadores rasc','rua.requerimiento_asc_trabajadores_id = rasc.id','left');
		$this->carrera->join('r_requerimiento_area_cargo rac','rasc.requerimiento_area_cargo_id = rac.id','left');
		$this->carrera->join('r_requerimiento req','rac.requerimiento_id = req.id','left');
		$this->carrera->join('r_areas ra','rac.areas_id = ra.id','left');
		$this->carrera->join('r_cargos rc','rac.cargos_id = rc.id','left');
		$this->carrera->join('empresa_planta ep','req.planta_id = ep.id','left');
		$this->carrera->where('rua.tipo_archivo_requerimiento_id = 1 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 1)');
		$this->carrera->group_by('rua.usuario_id', 'ASC');
		$this->carrera->order_by('rua.usuario_id', 'ASC');
		$query = $this->carrera->get();
		return $query->result();
	}

	function todos_los_anexos($id_usuario=false , $idRequerimientoAsociado){
		$this->carrera->select(' *');
		$this->carrera->from('r_requerimiento_usuario_archivo rua');
		$this->carrera->where('rua.tipo_archivo_requerimiento_id = 2 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 2)');
		$this->carrera->where('rua.usuario_id',$id_usuario);
		$this->carrera->where('rua.requerimiento_asc_trabajadores_id',$idRequerimientoAsociado);
		//$this->carrera->or_where('rua.tipo_archivo_requerimiento_id = 2');
		$this->carrera->group_by('rua.usuario_id', 'ASC');
		$this->carrera->order_by('rua.usuario_id', 'ASC');
		$query = $this->carrera->get();
		return $query->row();
	}
		
	function getListaNegraTrabajador($id){
		$this->carrera->select('*,lista_negra.id lista_id, lista_negra.fecha fecha_ln');
		$this->carrera->from('lista_negra');
		$this->carrera->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$this->carrera->order_by("fecha_ln","desc");
		$this->carrera->where("id_usuario",$id);
		$query = $this->carrera->get();
		return $query->result();
	}

	function ingresarListaNegra($data){
		$this->carrera->insert('lista_negra',$data);
		return $this->carrera->insert_id();
	}

	function eliminarListaNegra($id){
		$this->carrera->delete('lista_negra', array('id' => $id)); 
	}

	function getBancos(){
		$this->carrera->select('*');
		$this->carrera->from('bancos');
		$this->carrera->order_by("desc_bancos","asc");
		$query = $this->carrera->get();
		return $query->result();
	}

	function getNombreBanco($id){
		$this->carrera->select('*');
		$this->carrera->from('bancos');
		$this->carrera->where("id",$id);
		$query = $this->carrera->get();
		return $query->row();
	}

	#26-07-2018 g.r.m
	function guardarAsistenciaTrabajador($data){
		$this->carrera->insert('asistencia',$data);
	}

	function getAsistenciaPersona($id, $fecha){
		$this->carrera->select('*');
		$this->carrera->from('asistencia');
		$this->carrera->where("id_usuario",$id);
		$this->carrera->where("fecha",$fecha);
		$query = $this->carrera->get();
		return $query->row();
	}
	#27-07-2018

	function cambiarEstadoAsistencia($id_usuario, $data){
		$this->carrera->where('id', $id_usuario);
		$this->carrera->update('usuarios', $data); 
	}

	function verificarSiYaGuardadoAsistenciaDelMes($fecha){
		$this->carrera->select('*');
		$this->carrera->from('asistencia');
		$this->carrera->where("fecha",$fecha);
		$query = $this->carrera->get();
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}

	function actualizarAsistenciaTrabajador($idTrabajador, $data, $fechaSeleccionada){
		$this->carrera->where('id_usuario', $idTrabajador);
		$this->carrera->where('fecha', $fechaSeleccionada);
		$this->carrera->update('asistencia', $data); 
	}
	#30-07-2018
	function verificarSiYaGuardadoBonoDelMes($fecha){
		$this->carrera->select('*');
		$this->carrera->from('bonos_anticipos');
		$this->carrera->where("fecha",$fecha);
		$query = $this->carrera->get();
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}

	function guardarBonoTrabajador($data){
		$this->carrera->insert('bonos_anticipos',$data);
	}

	function getBonoPersona($id, $fecha){
		$this->carrera->select('*');
		$this->carrera->from('bonos_anticipos');
		$this->carrera->where("id_usuario",$id);
		$this->carrera->where("fecha",$fecha);
		$query = $this->carrera->get();
		return $query->row();
	}

	function actualizarBonoTrabajador($idTrabajador, $data, $fechaSeleccionada){
		$this->carrera->where('id_usuario', $idTrabajador);
		$this->carrera->where('fecha', $fechaSeleccionada);
		$this->carrera->update('bonos_anticipos', $data); 
	}
}
?>