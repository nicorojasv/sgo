<?php
class Asistencia_model extends CI_Model {
	
	function __construct(){
		$this->enjoy = $this->load->database('enjoy', TRUE);
	}

	function listar_activos(){
		$this->enjoy->select('*');
		$this->enjoy->from('usuarios');
		$this->enjoy->where('estado', 1);
		$this->enjoy->order_by('id','asc');
		//$this->enjoy->limit(30, 1);
		$query = $this->enjoy->get();
		return $query->result();
	}

	function get_trabajadores_activo_asistencia(){
		$this->enjoy->select('*');
		$this->enjoy->from('usuarios');
		$this->enjoy->where('estadoAsistencia', 1);
		$this->enjoy->order_by('id','asc');
		$query = $this->enjoy->get();
		return $query->result();
	}

	function get($id){
		$this->enjoy->where('id', $id);
		$query = $this->enjoy->get('usuarios');
		return $query->row();
	}

	function get_rut($rut){
		$this->enjoy->where('rut_usuario', $rut);
		$query = $this->enjoy->get('usuarios');
		return $query->row();
	}

	function eliminar($id){
		$this->enjoy->delete('usuarios', array('id' => $id)); 
	}

	function editar($id,$data){
		$this->enjoy->where('id', $id);
		$this->enjoy->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->enjoy->insert('usuarios',$data); 
		return $this->enjoy->insert_id();
	}

	function listar_trabajadores_orden_paterno_activos(){
		$this->enjoy->where("estado", 1);
		$this->enjoy->order_by("paterno","asc");
		$query = $this->enjoy->get("usuarios");
		return $query->result();
	}

	function todos_los_contratos(){
		$this->enjoy->select(' rua.usuario_id, tipo_archivo_requerimiento_id as tipo_archivo, rua.url, rua.causal, rua.motivo, rua.fecha_inicio, fecha_termino, rua.jornada, rua.renta_imponible,  rua.asignacion_colacion, rua.seguro_vida_arauco, usu.nombres as nombre_usuario, usu.paterno, usu.materno, usu.rut_usuario, rasc.referido, req.codigo_requerimiento, req.nombre as nombre_req, req.f_solicitud, req.f_inicio as fecha_inicio_req, req.f_fin as f_fin_req, ep.nombre as nombre_empresa, ra.nombre as nombre_area, rc.nombre as nombre_cargo, rua.requerimiento_asc_trabajadores_id as idRequerimientoAsociado');
		$this->enjoy->from('r_requerimiento_usuario_archivo rua');
		$this->enjoy->join('usuarios usu','rua.usuario_id = usu.id','left');
		$this->enjoy->join('r_requerimiento_asc_trabajadores rasc','rua.requerimiento_asc_trabajadores_id = rasc.id','left');
		$this->enjoy->join('r_requerimiento_area_cargo rac','rasc.requerimiento_area_cargo_id = rac.id','left');
		$this->enjoy->join('r_requerimiento req','rac.requerimiento_id = req.id','left');
		$this->enjoy->join('r_areas ra','rac.areas_id = ra.id','left');
		$this->enjoy->join('r_cargos rc','rac.cargos_id = rc.id','left');
		$this->enjoy->join('empresa_planta ep','req.planta_id = ep.id','left');
		$this->enjoy->where('rua.tipo_archivo_requerimiento_id = 1 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 1)');
		$this->enjoy->group_by('rua.usuario_id', 'ASC');
		$this->enjoy->order_by('rua.usuario_id', 'ASC');
		$query = $this->enjoy->get();
		return $query->result();
	}

	function todos_los_anexos($id_usuario=false , $idRequerimientoAsociado){
		$this->enjoy->select(' *');
		$this->enjoy->from('r_requerimiento_usuario_archivo rua');
		$this->enjoy->where('rua.tipo_archivo_requerimiento_id = 2 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 2)');
		$this->enjoy->where('rua.usuario_id',$id_usuario);
		$this->enjoy->where('rua.requerimiento_asc_trabajadores_id',$idRequerimientoAsociado);
		//$this->enjoy->or_where('rua.tipo_archivo_requerimiento_id = 2');
		$this->enjoy->group_by('rua.usuario_id', 'ASC');
		$this->enjoy->order_by('rua.usuario_id', 'ASC');
		$query = $this->enjoy->get();
		return $query->row();
	}
		
	function getListaNegraTrabajador($id){
		$this->enjoy->select('*,lista_negra.id lista_id, lista_negra.fecha fecha_ln');
		$this->enjoy->from('lista_negra');
		$this->enjoy->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$this->enjoy->order_by("fecha_ln","desc");
		$this->enjoy->where("id_usuario",$id);
		$query = $this->enjoy->get();
		return $query->result();
	}

	function ingresarListaNegra($data){
		$this->enjoy->insert('lista_negra',$data);
		return $this->enjoy->insert_id();
	}

	function eliminarListaNegra($id){
		$this->enjoy->delete('lista_negra', array('id' => $id)); 
	}

	function getBancos(){
		$this->enjoy->select('*');
		$this->enjoy->from('bancos');
		$this->enjoy->order_by("desc_bancos","asc");
		$query = $this->enjoy->get();
		return $query->result();
	}

	function getNombreBanco($id){
		$this->enjoy->select('*');
		$this->enjoy->from('bancos');
		$this->enjoy->where("id",$id);
		$query = $this->enjoy->get();
		return $query->row();
	}

	#26-07-2018 g.r.m
	function guardarAsistenciaTrabajador($data){
		$this->enjoy->insert('asistencia',$data);
	}

	function getAsistenciaPersona($id, $fecha){
		$this->enjoy->select('*');
		$this->enjoy->from('asistencia');
		$this->enjoy->where("id_usuario",$id);
		$this->enjoy->where("fecha",$fecha);
		$query = $this->enjoy->get();
		return $query->row();
	}
	#27-07-2018

	function cambiarEstadoAsistencia($id_usuario, $data){
		$this->enjoy->where('id', $id_usuario);
		$this->enjoy->update('usuarios', $data); 
	}

	function verificarSiYaGuardadoAsistenciaDelMes($fecha){
		$this->enjoy->select('*');
		$this->enjoy->from('asistencia');
		$this->enjoy->where("fecha",$fecha);
		$query = $this->enjoy->get();
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}

	function actualizarAsistenciaTrabajador($idTrabajador, $data, $fechaSeleccionada){
		$this->enjoy->where('id_usuario', $idTrabajador);
		$this->enjoy->where('fecha', $fechaSeleccionada);
		$this->enjoy->update('asistencia', $data); 
	}
	#30-07-2018
	function verificarSiYaGuardadoBonoDelMes($fecha){
		$this->enjoy->select('*');
		$this->enjoy->from('bonos_anticipos');
		$this->enjoy->where("fecha",$fecha);
		$query = $this->enjoy->get();
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}

	function guardarBonoTrabajador($data){
		$this->enjoy->insert('bonos_anticipos',$data);
	}

	function getBonoPersona($id, $fecha){
		$this->enjoy->select('*');
		$this->enjoy->from('bonos_anticipos');
		$this->enjoy->where("id_usuario",$id);
		$this->enjoy->where("fecha",$fecha);
		$query = $this->enjoy->get();
		return $query->row();
	}

	function actualizarBonoTrabajador($idTrabajador, $data, $fechaSeleccionada){
		$this->enjoy->where('id_usuario', $idTrabajador);
		$this->enjoy->where('fecha', $fechaSeleccionada);
		$this->enjoy->update('bonos_anticipos', $data); 
	}
}
?>