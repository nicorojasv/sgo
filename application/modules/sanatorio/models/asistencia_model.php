<?php
class Asistencia_model extends CI_Model {
	
	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function listar_activos(){
		$this->sanatorio->select('*');
		$this->sanatorio->from('usuarios');
		$this->sanatorio->where('estado', 1);
		$this->sanatorio->order_by('id','asc');
		//$this->sanatorio->limit(30, 1);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function get_trabajadores_activo_asistencia(){
		$this->sanatorio->select('*');
		$this->sanatorio->from('usuarios');
		$this->sanatorio->where('estadoAsistencia', 1);
		$this->sanatorio->order_by('id','asc');
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function get($id){
		$this->sanatorio->where('id', $id);
		$query = $this->sanatorio->get('usuarios');
		return $query->row();
	}

	function get_rut($rut){
		$this->sanatorio->where('rut_usuario', $rut);
		$query = $this->sanatorio->get('usuarios');
		return $query->row();
	}

	function eliminar($id){
		$this->sanatorio->delete('usuarios', array('id' => $id)); 
	}

	function editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->sanatorio->insert('usuarios',$data); 
		return $this->sanatorio->insert_id();
	}

	function listar_trabajadores_orden_paterno_activos(){
		$this->sanatorio->where("estado", 1);
		$this->sanatorio->order_by("paterno","asc");
		$query = $this->sanatorio->get("usuarios");
		return $query->result();
	}

	function todos_los_contratos(){
		$this->sanatorio->select(' rua.usuario_id, tipo_archivo_requerimiento_id as tipo_archivo, rua.url, rua.causal, rua.motivo, rua.fecha_inicio, fecha_termino, rua.jornada, rua.renta_imponible,  rua.asignacion_colacion, rua.seguro_vida_arauco, usu.nombres as nombre_usuario, usu.paterno, usu.materno, usu.rut_usuario, rasc.referido, req.codigo_requerimiento, req.nombre as nombre_req, req.f_solicitud, req.f_inicio as fecha_inicio_req, req.f_fin as f_fin_req, ep.nombre as nombre_empresa, ra.nombre as nombre_area, rc.nombre as nombre_cargo, rua.requerimiento_asc_trabajadores_id as idRequerimientoAsociado');
		$this->sanatorio->from('r_requerimiento_usuario_archivo rua');
		$this->sanatorio->join('usuarios usu','rua.usuario_id = usu.id','left');
		$this->sanatorio->join('r_requerimiento_asc_trabajadores rasc','rua.requerimiento_asc_trabajadores_id = rasc.id','left');
		$this->sanatorio->join('r_requerimiento_area_cargo rac','rasc.requerimiento_area_cargo_id = rac.id','left');
		$this->sanatorio->join('r_requerimiento req','rac.requerimiento_id = req.id','left');
		$this->sanatorio->join('r_areas ra','rac.areas_id = ra.id','left');
		$this->sanatorio->join('r_cargos rc','rac.cargos_id = rc.id','left');
		$this->sanatorio->join('empresa_planta ep','req.planta_id = ep.id','left');
		$this->sanatorio->where('rua.tipo_archivo_requerimiento_id = 1 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 1)');
		$this->sanatorio->group_by('rua.usuario_id', 'ASC');
		$this->sanatorio->order_by('rua.usuario_id', 'ASC');
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function todos_los_anexos($id_usuario=false , $idRequerimientoAsociado){
		$this->sanatorio->select(' *');
		$this->sanatorio->from('r_requerimiento_usuario_archivo rua');
		$this->sanatorio->where('rua.tipo_archivo_requerimiento_id = 2 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 2)');
		$this->sanatorio->where('rua.usuario_id',$id_usuario);
		$this->sanatorio->where('rua.requerimiento_asc_trabajadores_id',$idRequerimientoAsociado);
		//$this->sanatorio->or_where('rua.tipo_archivo_requerimiento_id = 2');
		$this->sanatorio->group_by('rua.usuario_id', 'ASC');
		$this->sanatorio->order_by('rua.usuario_id', 'ASC');
		$query = $this->sanatorio->get();
		return $query->row();
	}
		
	function getListaNegraTrabajador($id){
		$this->sanatorio->select('*,lista_negra.id lista_id, lista_negra.fecha fecha_ln');
		$this->sanatorio->from('lista_negra');
		$this->sanatorio->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$this->sanatorio->order_by("fecha_ln","desc");
		$this->sanatorio->where("id_usuario",$id);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function ingresarListaNegra($data){
		$this->sanatorio->insert('lista_negra',$data);
		return $this->sanatorio->insert_id();
	}

	function eliminarListaNegra($id){
		$this->sanatorio->delete('lista_negra', array('id' => $id)); 
	}

	function getBancos(){
		$this->sanatorio->select('*');
		$this->sanatorio->from('bancos');
		$this->sanatorio->order_by("desc_bancos","asc");
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function getNombreBanco($id){
		$this->sanatorio->select('*');
		$this->sanatorio->from('bancos');
		$this->sanatorio->where("id",$id);
		$query = $this->sanatorio->get();
		return $query->row();
	}

	#26-07-2018 g.r.m
	function guardarAsistenciaTrabajador($data){
		$this->sanatorio->insert('asistencia',$data);
	}

	function getAsistenciaPersona($id, $fecha){
		$this->sanatorio->select('*');
		$this->sanatorio->from('asistencia');
		$this->sanatorio->where("id_usuario",$id);
		$this->sanatorio->where("fecha",$fecha);
		$query = $this->sanatorio->get();
		return $query->row();
	}
	#27-07-2018

	function cambiarEstadoAsistencia($id_usuario, $data){
		$this->sanatorio->where('id', $id_usuario);
		$this->sanatorio->update('usuarios', $data); 
	}

	function verificarSiYaGuardadoAsistenciaDelMes($fecha){
		$this->sanatorio->select('*');
		$this->sanatorio->from('asistencia');
		$this->sanatorio->where("fecha",$fecha);
		$query = $this->sanatorio->get();
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}

	function actualizarAsistenciaTrabajador($idTrabajador, $data, $fechaSeleccionada){
		$this->sanatorio->where('id_usuario', $idTrabajador);
		$this->sanatorio->where('fecha', $fechaSeleccionada);
		$this->sanatorio->update('asistencia', $data); 
	}
	#30-07-2018
	function verificarSiYaGuardadoBonoDelMes($fecha){
		$this->sanatorio->select('*');
		$this->sanatorio->from('bonos_anticipos');
		$this->sanatorio->where("fecha",$fecha);
		$query = $this->sanatorio->get();
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}

	function guardarBonoTrabajador($data){
		$this->sanatorio->insert('bonos_anticipos',$data);
	}

	function getBonoPersona($id, $fecha){
		$this->sanatorio->select('*');
		$this->sanatorio->from('bonos_anticipos');
		$this->sanatorio->where("id_usuario",$id);
		$this->sanatorio->where("fecha",$fecha);
		$query = $this->sanatorio->get();
		return $query->row();
	}

	function actualizarBonoTrabajador($idTrabajador, $data, $fechaSeleccionada){
		$this->sanatorio->where('id_usuario', $idTrabajador);
		$this->sanatorio->where('fecha', $fechaSeleccionada);
		$this->sanatorio->update('bonos_anticipos', $data); 
	}
}
?>