<?php
class Asistencia_model extends CI_Model {
	
	function __construct(){
		$this->marina_chillan = $this->load->database('marina_chillan', TRUE);
	}

	function listar_activos(){
		$this->marina_chillan->select('*');
		$this->marina_chillan->from('usuarios');
		$this->marina_chillan->where('estado', 1);
		$this->marina_chillan->order_by('id','asc');
		//$this->marina_chillan->limit(30, 1);
		$query = $this->marina_chillan->get();
		return $query->result();
	}

	function get_trabajadores_activo_asistencia(){
		$this->marina_chillan->select('*');
		$this->marina_chillan->from('usuarios');
		$this->marina_chillan->where('estadoAsistencia', 1);
		$this->marina_chillan->order_by('id','asc');
		$query = $this->marina_chillan->get();
		return $query->result();
	}

	function get($id){
		$this->marina_chillan->where('id', $id);
		$query = $this->marina_chillan->get('usuarios');
		return $query->row();
	}

	function get_rut($rut){
		$this->marina_chillan->where('rut_usuario', $rut);
		$query = $this->marina_chillan->get('usuarios');
		return $query->row();
	}

	function eliminar($id){
		$this->marina_chillan->delete('usuarios', array('id' => $id)); 
	}

	function editar($id,$data){
		$this->marina_chillan->where('id', $id);
		$this->marina_chillan->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->marina_chillan->insert('usuarios',$data); 
		return $this->marina_chillan->insert_id();
	}

	function listar_trabajadores_orden_paterno_activos(){
		$this->marina_chillan->where("estado", 1);
		$this->marina_chillan->order_by("paterno","asc");
		$query = $this->marina_chillan->get("usuarios");
		return $query->result();
	}

	function todos_los_contratos(){
		$this->marina_chillan->select(' rua.usuario_id, tipo_archivo_requerimiento_id as tipo_archivo, rua.url, rua.causal, rua.motivo, rua.fecha_inicio, fecha_termino, rua.jornada, rua.renta_imponible,  rua.asignacion_colacion, rua.seguro_vida_arauco, usu.nombres as nombre_usuario, usu.paterno, usu.materno, usu.rut_usuario, rasc.referido, req.codigo_requerimiento, req.nombre as nombre_req, req.f_solicitud, req.f_inicio as fecha_inicio_req, req.f_fin as f_fin_req, ep.nombre as nombre_empresa, ra.nombre as nombre_area, rc.nombre as nombre_cargo, rua.requerimiento_asc_trabajadores_id as idRequerimientoAsociado');
		$this->marina_chillan->from('r_requerimiento_usuario_archivo rua');
		$this->marina_chillan->join('usuarios usu','rua.usuario_id = usu.id','left');
		$this->marina_chillan->join('r_requerimiento_asc_trabajadores rasc','rua.requerimiento_asc_trabajadores_id = rasc.id','left');
		$this->marina_chillan->join('r_requerimiento_area_cargo rac','rasc.requerimiento_area_cargo_id = rac.id','left');
		$this->marina_chillan->join('r_requerimiento req','rac.requerimiento_id = req.id','left');
		$this->marina_chillan->join('r_areas ra','rac.areas_id = ra.id','left');
		$this->marina_chillan->join('r_cargos rc','rac.cargos_id = rc.id','left');
		$this->marina_chillan->join('empresa_planta ep','req.planta_id = ep.id','left');
		$this->marina_chillan->where('rua.tipo_archivo_requerimiento_id = 1 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 1)');
		$this->marina_chillan->group_by('rua.usuario_id', 'ASC');
		$this->marina_chillan->order_by('rua.usuario_id', 'ASC');
		$query = $this->marina_chillan->get();
		return $query->result();
	}

	function todos_los_anexos($id_usuario=false , $idRequerimientoAsociado){
		$this->marina_chillan->select(' *');
		$this->marina_chillan->from('r_requerimiento_usuario_archivo rua');
		$this->marina_chillan->where('rua.tipo_archivo_requerimiento_id = 2 and rua.fecha_termino = (select MAX(fecha_termino) from r_requerimiento_usuario_archivo t2 where rua.usuario_id = t2.usuario_id and t2.tipo_archivo_requerimiento_id = 2)');
		$this->marina_chillan->where('rua.usuario_id',$id_usuario);
		$this->marina_chillan->where('rua.requerimiento_asc_trabajadores_id',$idRequerimientoAsociado);
		//$this->marina_chillan->or_where('rua.tipo_archivo_requerimiento_id = 2');
		$this->marina_chillan->group_by('rua.usuario_id', 'ASC');
		$this->marina_chillan->order_by('rua.usuario_id', 'ASC');
		$query = $this->marina_chillan->get();
		return $query->row();
	}
		
	function getListaNegraTrabajador($id){
		$this->marina_chillan->select('*,lista_negra.id lista_id, lista_negra.fecha fecha_ln');
		$this->marina_chillan->from('lista_negra');
		$this->marina_chillan->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$this->marina_chillan->order_by("fecha_ln","desc");
		$this->marina_chillan->where("id_usuario",$id);
		$query = $this->marina_chillan->get();
		return $query->result();
	}

	function ingresarListaNegra($data){
		$this->marina_chillan->insert('lista_negra',$data);
		return $this->marina_chillan->insert_id();
	}

	function eliminarListaNegra($id){
		$this->marina_chillan->delete('lista_negra', array('id' => $id)); 
	}

	function getBancos(){
		$this->marina_chillan->select('*');
		$this->marina_chillan->from('bancos');
		$this->marina_chillan->order_by("desc_bancos","asc");
		$query = $this->marina_chillan->get();
		return $query->result();
	}

	function getNombreBanco($id){
		$this->marina_chillan->select('*');
		$this->marina_chillan->from('bancos');
		$this->marina_chillan->where("id",$id);
		$query = $this->marina_chillan->get();
		return $query->row();
	}

	#26-07-2018 g.r.m
	function guardarAsistenciaTrabajador($data){
		$this->marina_chillan->insert('asistencia',$data);
	}

	function getAsistenciaPersona($id, $fecha){
		$this->marina_chillan->select('*');
		$this->marina_chillan->from('asistencia');
		$this->marina_chillan->where("id_usuario",$id);
		$this->marina_chillan->where("fecha",$fecha);
		$query = $this->marina_chillan->get();
		return $query->row();
	}
	#27-07-2018

	function cambiarEstadoAsistencia($id_usuario, $data){
		$this->marina_chillan->where('id', $id_usuario);
		$this->marina_chillan->update('usuarios', $data); 
	}

	function verificarSiYaGuardadoAsistenciaDelMes($fecha){
		$this->marina_chillan->select('*');
		$this->marina_chillan->from('asistencia');
		$this->marina_chillan->where("fecha",$fecha);
		$query = $this->marina_chillan->get();
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}

	function actualizarAsistenciaTrabajador($idTrabajador, $data, $fechaSeleccionada){
		$this->marina_chillan->where('id_usuario', $idTrabajador);
		$this->marina_chillan->where('fecha', $fechaSeleccionada);
		$this->marina_chillan->update('asistencia', $data); 
	}
	#30-07-2018
	function verificarSiYaGuardadoBonoDelMes($fecha){
		$this->marina_chillan->select('*');
		$this->marina_chillan->from('bonos_anticipos');
		$this->marina_chillan->where("fecha",$fecha);
		$query = $this->marina_chillan->get();
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}	
	}

	function guardarBonoTrabajador($data){
		$this->marina_chillan->insert('bonos_anticipos',$data);
	}

	function getBonoPersona($id, $fecha){
		$this->marina_chillan->select('*');
		$this->marina_chillan->from('bonos_anticipos');
		$this->marina_chillan->where("id_usuario",$id);
		$this->marina_chillan->where("fecha",$fecha);
		$query = $this->marina_chillan->get();
		return $query->row();
	}

	function actualizarBonoTrabajador($idTrabajador, $data, $fechaSeleccionada){
		$this->marina_chillan->where('id_usuario', $idTrabajador);
		$this->marina_chillan->where('fecha', $fechaSeleccionada);
		$this->marina_chillan->update('bonos_anticipos', $data); 
	}
}
?>