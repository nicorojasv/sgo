<?php
class Requerimiento_Usuario_Archivo_model extends CI_Model {

	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function ingresar_solicitud_contrato($data){
		$this->carrera->insert('r_requerimiento_usuario_archivo_solicitudes_contratos',$data); 
		return $this->carrera->insert_id();
	}

	function actualizar_solicitud_contrato($id_req_usu_arch, $datos){
		$this->carrera->where('id_req_usu_arch',$id_req_usu_arch);
		$this->carrera->update('r_requerimiento_usuario_archivo_solicitudes_contratos', $datos);
	}

	function get_solicitud_contrato_tipo_proceso($id_usu_arch, $tipo_proceso = FAlSE){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->carrera->where('id_req_usu_arch',$id_usu_arch);

		if($tipo_proceso != FAlSE)
			$this->carrera->where('estado',$tipo_proceso);

		$query = $this->carrera->get();
		return $query->row();
	}
	
	function ingresar_solicitud_contrato_historial($data){
		$this->carrera->insert('r_requerimiento_usuario_archivo_solicitudes_contratos_historial',$data); 
	}

	function get_proceso_contrato_tipo($id_usu_arch, $tipo_proceso = FAlSE){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_archivo');
		$this->carrera->where('id',$id_usu_arch);

		if($tipo_proceso != FAlSE)
			$this->carrera->where('estado_proceso',$tipo_proceso);

		$query = $this->carrera->get();
		return $query->row();
	}

	function get_solicitud_contrato($id_usu_arch, $tipo_proceso = FALSE){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->carrera->where('id_req_usu_arch',$id_usu_arch);/////////
		if($tipo_proceso != FAlSE)
			$this->carrera->where('estado',$tipo_proceso);
		$query = $this->carrera->get();
		return $query->row();
	}

	function listar_solicitudes_pendientes($get_id_planta = FALSE){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_archivo_solicitudes_contratos req_usu_arch_cont');
		$this->carrera->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->carrera->join('r_requerimiento_asc_trabajadores req_asc','req_usu_arch.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->carrera->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->carrera->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->carrera->where('req_usu_arch_cont.estado', 0);

		if($get_id_planta != FALSE)
			$this->carrera->where('req.planta_id', $get_id_planta);

		$query = $this->carrera->get();
		return $query->result();
	}

	function listar_solicitudes_completas($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_archivo');
		$this->carrera->where('estado_proceso',2);
		if($fecha_inicio != FAlSE){
			$this->carrera->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}
		//$this->carrera->limit(10);
		$query = $this->carrera->get();
		return $query->result();
	}

	function get($id_usu_arch){
		$this->carrera->where('id',$id_usu_arch);
		$query = $this->carrera->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function get_result($id_usu_arch){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_archivo');
		$this->carrera->where('id',$id_usu_arch);
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_archivos_req($id_asc_trab){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_archivo');
		$this->carrera->where('requerimiento_asc_trabajadores_id',$id_asc_trab);
		$this->carrera->where('tipo_archivo_requerimiento_id', '1');
		//$this->carrera->where('tipo_archivo_requerimiento_id', '1'.' or tipo_archivo_requerimiento_id', '2');
		$query = $this->carrera->get();
		return $query->row();
	}

	function get_usuario_requerimiento($usuario,$requerimiento){
		$this->carrera->where('usuario_id',$usuario);
		$this->carrera->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$query = $this->carrera->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_requerimiento_archivo($usuario,$requerimiento,$archivo){
		$this->carrera->where('usuario_id',$usuario);
		$this->carrera->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->carrera->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->carrera->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_requerimiento_archivo_limit_row($usuario,$requerimiento,$archivo){
		$this->carrera->where('usuario_id',$usuario);
		$this->carrera->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->carrera->where('tipo_archivo_requerimiento_id',$archivo);
		$this->carrera->order_by('id','desc');
		$this->carrera->limit(1);
		$query = $this->carrera->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function get_usuario_requerimiento_archivo_limit($usuario,$requerimiento,$archivo){
		$this->carrera->where('usuario_id',$usuario);
		$this->carrera->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->carrera->where('tipo_archivo_requerimiento_id',$archivo);
		$this->carrera->limit(1);
		$query = $this->carrera->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_archivos($usuario,$tipo_archivo){
		$this->carrera->where('usuario_id',$usuario);
		$this->carrera->where('tipo_archivo_requerimiento_id',$tipo_archivo);
		$query = $this->carrera->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function existe_registro_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_archivo');
		$this->carrera->where('usuario_id',$usuario);
		$this->carrera->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->carrera->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->carrera->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function get_result_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_archivo');
		$this->carrera->where('usuario_id',$usuario);
		$this->carrera->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->carrera->where('tipo_archivo_requerimiento_id',$archivo);
		$this->carrera->where('fecha_aprobacion_baja',null);// si posee esta fecha es porque ya se a dado de baja 
		$query = $this->carrera->get();
		if ($query->num_rows >0){
		   return $query->result();
		}else{
		   return 0;
		}
	}

	function get_usuario_requerimiento_datos($usuario,$requerimiento, $archivo){
		$this->carrera->where('usuario_id',$usuario);
		$this->carrera->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->carrera->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->carrera->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function consultar_si_existe_req($usuario, $requerimiento, $archivo){
		$this->carrera->SELECT('*');
		$this->carrera->from('r_requerimiento_usuario_archivo');
		$this->carrera->where('usuario_id',$usuario);
		$this->carrera->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->carrera->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->carrera->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function actualizar_usu_arch($id, $datos){
		$this->carrera->where('id',$id);
		$this->carrera->update('r_requerimiento_usuario_archivo', $datos);
	}

	function actualizar_req($usuario, $requerimiento, $archivo, $datos){
		$this->carrera->where('usuario_id',$usuario);
		$this->carrera->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->carrera->where('tipo_archivo_requerimiento_id',$archivo);
		$this->carrera->update('r_requerimiento_usuario_archivo', $datos);
	}

	function get_requerimiento($id){
		$this->carrera->select("");
		$this->carrera->from("r_requerimiento_usuario_archivo rua");
		$this->carrera->join("r_requerimiento_asc_trabajadores rat","rua.requerimiento_asc_trabajadores_id = rat.id");
		$this->carrera->join("r_requerimiento_area_cargo rac","rac.id = rat.requerimiento_area_cargo_id");
		$this->carrera->where('rua.id',$id);
		$query = $this->carrera->get();
		return $query->row();
	}

	function listar(){
		$query = $this->carrera->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function ingresar($data){
		$this->carrera->insert('r_requerimiento_usuario_archivo',$data); 
	}

	function eliminar($id){
		$this->carrera->delete('r_requerimiento_usuario_archivo', array('id' => $id)); 
	}

	function listar_usuarios_contrato_vencido(){
		$this->carrera->select("");
		$this->carrera->from("r_requerimiento_usuario_archivo");
		$this->carrera->where('tipo_archivo_requerimiento_id',1);
		$this->carrera->where('fecha_termino <', date('Y-m-d'));
		$query = $this->carrera->get();
		return $query->result();
	}

	#05-07-2018
	function getIdUsuarioContrato($id_usu_arch){
		$this->carrera->select("*");
		$this->carrera->from("r_requerimiento_usuario_archivo");
		$this->carrera->where('r_requerimiento_usuario_archivo.id',$id_usu_arch);
		$query = $this->carrera->get();
		return $query->row();
	}

	#06-05-2018 
	function getCodigoContrato($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda){
		$this->carrera->select('*');
		$this->carrera->from("r_requerimiento_usuario_archivo");
		$this->carrera->where('usuario_id',$idUsuario);
		$this->carrera->where('(estado_proceso = 2 OR estado_proceso = 3)');// donde 2 significa contratos ya generados
		$this->carrera->where('id_tipo_contrato',1);// donde 1 significa contrato diario
		$this->carrera->where('fecha_inicio BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$query = $this->carrera->get();
		if ($query->num_rows >0){
			return $query->result();
		}else{
		   return false;
		}
	}

	function getCodigoDisponible($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda ){
		$this->carrera->select('id, codigoLibre');
		$this->carrera->from('codigo_libre');
		$this->carrera->where('usuario_id',$idUsuario);
		$this->carrera->where('estado',0);//0 disponible para usar 
		$this->carrera->where('fechaRegistro BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$query = $this->carrera->get();
		if ($query->num_rows >0){
		   return $query->row();
		}else{
		   return false;
		}
	}

	function actualizarCodigoLibre($id , $data){
		$this->carrera->where('id',$id);
		$this->carrera->update('codigo_libre', $data);
	}

	function getLetraAbecedario($id){
		$this->carrera->select('id , letraAbecedario as letra');
		$this->carrera->from('abecedario');
		$this->carrera->where('id',$id);
		$query = $this->carrera->get();
		return $query->row();
	}

	function listar_solicitudes_pendientes_baja(){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_archivo');
		$this->carrera->where('estado_proceso',3);
		$query = $this->carrera->get();
		return $query->result();
	}

	function guardar_codigo_libre($data){
		$this->carrera->insert('codigo_libre',$data); 

	}

	function listar_solicitudes_completas_baja($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_archivo');
		$this->carrera->where('estado_proceso',5);
		if($fecha_inicio != FAlSE){
			$this->carrera->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}
		$query = $this->carrera->get();
		return $query->result();
	}
	#13-08-2018 grm 

	function verificarPendienteDeBaja($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_archivo');
		$this->carrera->where('usuario_id',$idUsuario);
		$this->carrera->where('fecha_termino BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$this->carrera->where('estado_proceso',3);
		$query = $this->carrera->get();
		if ($query->num_rows >0){
		   return true;
		}else{
		   return false;
		}
	}
	#06-09-2018 // 17-12-18 update grm
	function getNombreRequerimiento($idAreaCargo){
		$this->carrera->select('rr.nombre, rr.regimen, rr.f_solicitud, rr.comentario');
		$this->carrera->from('r_requerimiento_area_cargo as rac');
		$this->carrera->join("r_requerimiento rr","rac.requerimiento_id = rr.id");
		$this->carrera->where('rac.id',$idAreaCargo);
		$query = $this->carrera->get();
		return $query->row();
	}
	#20-09-2018 
	function guardarMotivoSolicitud($data){
		$this->carrera->insert('r_requerimiento_usuario_archivo_observacion',$data); 
	}

	function getMotivoSolicitud($idArchivo){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_archivo_observacion');
		$this->carrera->where('id_r_requerimiento_usuario_archivo',$idArchivo);
		$query = $this->carrera->get();
		if ($query->num_rows >0){
		   return  $query->row();
		}else{
		   return false;
		}
	}

	function actualizarMotivoSolicitud($id, $data){
		$this->carrera->where('id',$id);
		$this->carrera->update('r_requerimiento_usuario_archivo_observacion', $data);
	}

	function getDiasTotal($idUsuario,$fecha,$fechaAtras){
		$this->carrera->select('id, fecha_inicio');
		$this->carrera->from('r_requerimiento_usuario_archivo');
		$this->carrera->where('usuario_id',$idUsuario);
		$this->carrera->where('id_solicita_bajar',null);
		$this->carrera->where('fecha_inicio BETWEEN "'.$fechaAtras. '" and "'. $fecha.'"');
		$this->carrera->where('estado_proceso',2);
		$query = $this->carrera->get();
		//return $query->result();
		if ($query->num_rows ==7){
		   return  false;
		}else{
		   return true;
		}
	}

	function get_anexos($usuario,$requerimiento){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_anexo');
		$this->carrera->where('usuario_id',$usuario);
		$this->carrera->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->carrera->where("(estado = 0 OR estado =1 OR estado = 2 OR estado = 3 OR estado = 4 OR estado = 6 )");
		$query = $this->carrera->get();
		if ($query->num_rows() > 0){
		   return $query->result();
		}else{
		   return 0;
		}
	}

	function verificarSitieneMasDeUnContrato($idUsuario,$fecha){
		$this->carrera->select('r_requerimiento_usuario_archivo.id as idArchivo, r_requerimiento_usuario_archivo.fecha_inicio, r_requerimiento_usuario_archivo.usuario_id as idUsuario, rat.requerimiento_area_cargo_id as idAreaCargo, rat.id');
		$this->carrera->from('r_requerimiento_usuario_archivo');
		$this->carrera->join('r_requerimiento_asc_trabajadores rat','r_requerimiento_usuario_archivo.requerimiento_asc_trabajadores_id = rat.id');
		$this->carrera->where('r_requerimiento_usuario_archivo.usuario_id',$idUsuario);
		$this->carrera->where('r_requerimiento_usuario_archivo.estado_proceso',2);
		$this->carrera->where('r_requerimiento_usuario_archivo.fecha_inicio', $fecha);
		$query = $this->carrera->get();
		if ($query->num_rows >=1){
		   return  $query->result();
		}else{
		   return false;
		}
	}
	function get_area_cargo($idArea){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_asc_trabajadores');
		$this->carrera->where('r_requerimiento_asc_trabajadores.id',$idArea);
		$query = $this->carrera->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}	
	}

	function existe_registro_de_anexo($usuario,$requerimiento,$archivo){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_anexo');
		$this->carrera->where('usuario_id',$usuario);
		$this->carrera->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->carrera->where('tipo_archivo_requerimiento_id',$archivo);
		$this->carrera->where("(estado = 0 OR estado =1 OR estado = 2 OR estado = 3 OR estado = 4)");
		$query = $this->carrera->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function listar_solicitudes_completas2($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_archivo_solicitudes_contratos req_usu_arch_cont');
		$this->carrera->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->carrera->join('r_requerimiento_asc_trabajadores req_asc','req_usu_arch.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->carrera->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->carrera->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->carrera->where('req_usu_arch_cont.estado', 1);
//$this->carrera->limit(10);
		if($fecha_inicio != FAlSE){
			$this->carrera->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}

		$query = $this->carrera->get();
		return $query->result();
	}
	function get_contrato($idContrato){
		$this->carrera->select('u.nombres, u.paterno, u.materno, u.rut_usuario, r.fecha_termino, ep.nombre as nombrePlanta, r.fecha_termino2');
		$this->carrera->from('r_requerimiento_usuario_archivo r');
		$this->carrera->join('usuarios u','r.usuario_id = u.id','left');
		$this->carrera->join('r_requerimiento_asc_trabajadores rat','r.requerimiento_asc_trabajadores_id = rat.id','left');
		$this->carrera->join('r_requerimiento_area_cargo rar','rat.requerimiento_area_cargo_id = rar.id','left');
		$this->carrera->join('r_requerimiento req','rar.requerimiento_id = req.id','left');
		$this->carrera->join('empresa_planta ep','req.planta_id = ep.id','left');
		$this->carrera->where('r.id',$idContrato);
		$query = $this->carrera->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}
	function getRequerimienton($id_req){
		$this->carrera->where("id",$id_req);
		$query = $this->carrera->get('r_requerimiento_area_cargo');
		return $query->row();
	}
	function listar_solicitudes_pendientes_anexo($id_planta = FALSE){
		$this->carrera->select('*, anexo.id as idAnexo, anexo.nombres as nombreTrabajador, anexo.rut_usuario as rutTrabajador, anexo.nacionalidad as nacionalidadTrabajador, anexo.fecha_nac as nacimientoTrabajador, anexo.direccion as direccionTrabajador, anexo.ciudad as ciudadTrabajador, anexo.estado_civil as civilTrabajador, anexo.afp as afpTrabajador, anexo.salud as saludTrabajador, anexo.nombre_centro_costo as centroTrabajador, anexo.telefono as telefonoTrabajador, anexo.nivel_estudios as estudioTrabajador, anexo.nombre_banco as bancoTrabajador, anexo.tipo_cuenta as cuentaTrabajador, anexo.cuenta_banco as numeroCuentaTrabajador, anexo.nombre_planta as plantaTrabajador, anexo.fecha_inicio_contrato as fechaInicioContrato, anexo.fecha_termino_contrato_anterior as fechaTerminoContratoAnterior, anexo.fecha_termino_nuevo_anexo as fechaTerminoAnexo, anexo.causal as causalTrabajador');
		$this->carrera->from('r_requerimiento_usuario_anexo anexo');
		//$this->carrera->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');

		$this->carrera->join('r_requerimiento_asc_trabajadores req_asc','anexo.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->carrera->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->carrera->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->carrera->where('anexo.estado', 1);
		if($id_planta != FALSE)
			$this->carrera->where('req.planta_id', $id_planta);

		$query = $this->carrera->get();
		return $query->result();
	}
	function ingresarAnexo($data){
		$this->carrera->insert('r_requerimiento_usuario_anexo',$data); 
	}
	function get_anexos_id($idAnexo){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_usuario_anexo');
		$this->carrera->where('id',$idAnexo);
		$query = $this->carrera->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}
	function getIdEmpresa($id){
		$this->carrera->select('id_centro_costo');
		$this->carrera->from('empresa_planta');
		$this->carrera->where('id',$id);
		$query = $this->carrera->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}
	function actualizarAnexo($id, $data){
		$this->carrera->where('id',$id);
		$this->carrera->update('r_requerimiento_usuario_anexo', $data);
		return $afftectedRows = $this->carrera->affected_rows();
	}
	function marcarAnexoAnteriorComoFinalizado($idUsuario,$idReqAscTrabajadores, $datos){
		$this->carrera->where('usuario_id',$idUsuario);
		$this->carrera->where('requerimiento_asc_trabajadores_id',$idReqAscTrabajadores);
		$this->carrera->where('estado',2);
		$this->carrera->update('r_requerimiento_usuario_anexo', $datos);
	}
	function actualizarContrato($idUsuario,$idReqAscTrabajadores, $datos){
		$this->carrera->where('usuario_id',$idUsuario);
		$this->carrera->where('requerimiento_asc_trabajadores_id',$idReqAscTrabajadores);
		$this->carrera->where('tipo_archivo_requerimiento_id',1);
		$this->carrera->update('r_requerimiento_usuario_archivo', $datos);
	}
	function insertarAnexoAprobado($data){
		$this->carrera->insert('anexos_masivos',$data); 
	}
	function get_ultimo_anexo($usuario,$requerimiento,$archivo){
		$this->carrera->select('*, fecha_inicio_contrato as fecha_inicio, fecha_termino_nuevo_anexo as fecha_termino');
		$this->carrera->from('r_requerimiento_usuario_anexo');
		$this->carrera->where('usuario_id',$usuario);
		$this->carrera->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->carrera->where('tipo_archivo_requerimiento_id',$archivo);
		$this->carrera->where("(estado = 0 OR estado =1 OR estado = 2 OR estado = 3 OR estado = 4)");
		$this->carrera->order_by('id','desc');
		$this->carrera->limit(1);
		$query = $this->carrera->get();
		return $query->row();
	}
	function listar_solicitudes_completas_anexo($id_planta = FALSE, $idUsuario = false){
		$this->carrera->select('*, anexo.id as idAnexo, anexo.nombres as nombreTrabajador, anexo.rut_usuario as rutTrabajador, anexo.nacionalidad as nacionalidadTrabajador, anexo.fecha_nac as nacimientoTrabajador, anexo.direccion as direccionTrabajador, anexo.ciudad as ciudadTrabajador, anexo.estado_civil as civilTrabajador, anexo.afp as afpTrabajador, anexo.salud as saludTrabajador, anexo.nombre_centro_costo as centroTrabajador, anexo.telefono as telefonoTrabajador, anexo.nivel_estudios as estudioTrabajador, anexo.nombre_banco as bancoTrabajador, anexo.tipo_cuenta as cuentaTrabajador, anexo.cuenta_banco as numeroCuentaTrabajador, anexo.nombre_planta as plantaTrabajador, anexo.fecha_inicio_contrato as fechaInicioContrato, anexo.fecha_termino_contrato_anterior as fechaTerminoContratoAnterior, anexo.fecha_termino_nuevo_anexo as fechaTerminoAnexo, anexo.causal as causalTrabajador');
		$this->carrera->from('r_requerimiento_usuario_anexo anexo');
		//$this->carrera->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->carrera->join('r_requerimiento_asc_trabajadores req_asc','anexo.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->carrera->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->carrera->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->carrera->where('anexo.estado', 2);
		if($id_planta != FALSE)
			$this->carrera->where('req.planta_id', $id_planta);
		if($idUsuario != FALSE)
			$this->carrera->where('anexo.id_quien_solicita', $idUsuario);
		$query = $this->carrera->get();
		return $query->result();
	}
	function get_anexo($idAnexo){
		$this->carrera->select('u.nombres, u.paterno, u.materno, u.rut_usuario, r.fecha_termino_nuevo_anexo as fecha_termino, r.nombre_planta as nombrePlanta, r.fecha_termino2');
		$this->carrera->from('r_requerimiento_usuario_anexo r');
		$this->carrera->join('usuarios u ','r.usuario_id = u.id','inner');
		$this->carrera->where('r.id',$idAnexo);
		$query = $this->carrera->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}
	function insertarContratoAprobado($data){
		$this->carrera->insert('contratos_masivos',$data); 
	}
	function getNombreTrabajador($idAnexo){
		$this->carrera->select("CONCAT(u.nombres,' ', u.paterno,' ', u.materno) as nombreTrabajador, u.nombres as name",FALSE);
		$this->carrera->from('r_requerimiento_usuario_archivo r');
		$this->carrera->join('usuarios u ','r.usuario_id = u.id','inner');
		$this->carrera->where('r.id',$idAnexo);
		$query = $this->carrera->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}

}
?>