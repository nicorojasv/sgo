<?php
class Asistencia_model extends CI_Model {
	
	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function listar_activos(){
		$this->terramar->select('*');
		$this->terramar->from('usuarios');
		$this->terramar->where('estado', 1);
		$this->terramar->order_by('id','asc');
		//$this->terramar->limit(30, 1);
		$query = $this->terramar->get();
		return $query->result();
	}

	function get_trabajadores_activo_asistencia(){
		$this->terramar->select('*');
		$this->terramar->from('usuarios');
		$this->terramar->where('estadoAsistencia', 1);
		$this->terramar->order_by('id','asc');
		$query = $this->terramar->get();
		return $query->result();
	}

	function get($id){
		$this->terramar->where('id', $id);
		$query = $this->terramar->get('usuarios');
		return $query->row();
	}

	function get_rut($rut){
		$this->terramar->where('rut_usuario', $rut);
		$query = $this->terramar->get('usuarios');
		return $query->row();
	}

	function eliminar($id){
		$this->terramar->delete('usuarios', array('id' => $id)); 
	}

	function editar($id,$data){
		$this->terramar->where('id', $id);
		$this->terramar->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->terramar->insert('usuarios',$data); 
		return $this->terramar->insert_id();
	}

	function listar_trabajadores_orden_paterno_activos(){
		$this->terramar->where("estado", 1);
		$this->terramar->order_by("paterno","asc");
		$query = $this->terramar->get("usuarios");
		return $query->result();
	}

	function todos_los_contratos(){
		$this->terramar->select(' rua.usuario_id, tipo_archivo_requerimiento_id as tipo_archivo, rua.url, rua.causal, rua.motivo, rua.fecha_inicio, fecha_termino, rua.jornada, rua.renta_imponible,  rua.asignacion_colacion, rua.seguro_vida_arauco, usu.nombres as nombre_usuario, usu.paterno, usu.materno, usu.rut_usuario, rasc.referido, req.codigo_requerimiento, req.nombre as nombre_req, req.f_solicitud, req.f_inicio as fecha_inicio_req, req.f_fin as f_fin_req, ep.nombre as nombre_empresa, ra.nombre as nombre_area, rc.nombre as nombre_cargo, rua.requerimiento_asc_trabajadores_id as idRequerimientoAsociado');
		$this->terramar->from('r_requerimiento_usuario_archivo rua');
		$this->terramar->join('usuarios usu','rua.usuario_id = usu.id','left');
		$this->terramar->join('r_requerimiento_asc_trabajadores rasc','rua.requerimiento_asc_trabajadores_id = rasc.id','left');
		$this->terramar->join('r_requerimiento_area_cargo rac','rasc.requerimiento_area_cargo_id = rac.id','left');
		$this->terramar->join('r_requerimiento req','rac.requerimiento_id = req.id','left');
		$this->terramar->join('r_areas ra','rac.areas_id = ra.id','left');
		$this->terramar->join('r_cargos rc','rac.cargos_id = rc.id','left');
		$this->terramar->join('empresa_planta ep','req.planta_id = ep.id','left');
		$this->terramar->where('rua.tipo_archivo_requerimiento_id = 1 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 1)');
		$this->terramar->group_by('rua.usuario_id', 'ASC');
		$this->terramar->order_by('rua.usuario_id', 'ASC');
		$query = $this->terramar->get();
		return $query->result();
	}

	function todos_los_anexos($id_usuario=false , $idRequerimientoAsociado){
		$this->terramar->select(' *');
		$this->terramar->from('r_requerimiento_usuario_archivo rua');
		$this->terramar->where('rua.tipo_archivo_requerimiento_id = 2 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 2)');
		$this->terramar->where('rua.usuario_id',$id_usuario);
		$this->terramar->where('rua.requerimiento_asc_trabajadores_id',$idRequerimientoAsociado);
		//$this->terramar->or_where('rua.tipo_archivo_requerimiento_id = 2');
		$this->terramar->group_by('rua.usuario_id', 'ASC');
		$this->terramar->order_by('rua.usuario_id', 'ASC');
		$query = $this->terramar->get();
		return $query->row();
	}
		
	function getListaNegraTrabajador($id){
		$this->terramar->select('*,lista_negra.id lista_id, lista_negra.fecha fecha_ln');
		$this->terramar->from('lista_negra');
		$this->terramar->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$this->terramar->order_by("fecha_ln","desc");
		$this->terramar->where("id_usuario",$id);
		$query = $this->terramar->get();
		return $query->result();
	}

	function ingresarListaNegra($data){
		$this->terramar->insert('lista_negra',$data);
		return $this->terramar->insert_id();
	}

	function eliminarListaNegra($id){
		$this->terramar->delete('lista_negra', array('id' => $id)); 
	}

	function getBancos(){
		$this->terramar->select('*');
		$this->terramar->from('bancos');
		$this->terramar->order_by("desc_bancos","asc");
		$query = $this->terramar->get();
		return $query->result();
	}

	function getNombreBanco($id){
		$this->terramar->select('*');
		$this->terramar->from('bancos');
		$this->terramar->where("id",$id);
		$query = $this->terramar->get();
		return $query->row();
	}

	#26-07-2018 g.r.m
	function guardarAsistenciaTrabajador($data){
		$this->terramar->insert('asistencia',$data);
	}

	function getAsistenciaPersona($id, $fecha){
		$this->terramar->select('*');
		$this->terramar->from('asistencia');
		$this->terramar->where("id_usuario",$id);
		$this->terramar->where("fecha",$fecha);
		$query = $this->terramar->get();
		return $query->row();
	}
	#27-07-2018

	function cambiarEstadoAsistencia($id_usuario, $data){
		$this->terramar->where('id', $id_usuario);
		$this->terramar->update('usuarios', $data); 
	}

	function verificarSiYaGuardadoAsistenciaDelMes($fecha){
		$this->terramar->select('*');
		$this->terramar->from('asistencia');
		$this->terramar->where("fecha",$fecha);
		$query = $this->terramar->get();
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}

	function actualizarAsistenciaTrabajador($idTrabajador, $data, $fechaSeleccionada){
		$this->terramar->where('id_usuario', $idTrabajador);
		$this->terramar->where('fecha', $fechaSeleccionada);
		$this->terramar->update('asistencia', $data); 
	}
	#30-07-2018
	function verificarSiYaGuardadoBonoDelMes($fecha){
		$this->terramar->select('*');
		$this->terramar->from('bonos_anticipos');
		$this->terramar->where("fecha",$fecha);
		$query = $this->terramar->get();
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}

	function guardarBonoTrabajador($data){
		$this->terramar->insert('bonos_anticipos',$data);
	}

	function getBonoPersona($id, $fecha){
		$this->terramar->select('*');
		$this->terramar->from('bonos_anticipos');
		$this->terramar->where("id_usuario",$id);
		$this->terramar->where("fecha",$fecha);
		$query = $this->terramar->get();
		return $query->row();
	}

	function actualizarBonoTrabajador($idTrabajador, $data, $fechaSeleccionada){
		$this->terramar->where('id_usuario', $idTrabajador);
		$this->terramar->where('fecha', $fechaSeleccionada);
		$this->terramar->update('bonos_anticipos', $data); 
	}
}
?>