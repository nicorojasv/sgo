<?php
class Requerimiento_Usuario_Archivo_model extends CI_Model {

	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function ingresar_solicitud_contrato($data){
		$this->wood->insert('r_requerimiento_usuario_archivo_solicitudes_contratos',$data); 
		return $this->wood->insert_id();
	}

	function actualizar_solicitud_contrato($id_req_usu_arch, $datos){
		$this->wood->where('id_req_usu_arch',$id_req_usu_arch);
		$this->wood->update('r_requerimiento_usuario_archivo_solicitudes_contratos', $datos);
	}

	function get_solicitud_contrato_tipo_proceso($id_usu_arch, $tipo_proceso = FAlSE){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->wood->where('id_req_usu_arch',$id_usu_arch);

		if($tipo_proceso != FAlSE)
			$this->wood->where('estado',$tipo_proceso);

		$query = $this->wood->get();
		return $query->row();
	}
	
	function ingresar_solicitud_contrato_historial($data){
		$this->wood->insert('r_requerimiento_usuario_archivo_solicitudes_contratos_historial',$data); 
	}

	function get_proceso_contrato_tipo($id_usu_arch, $tipo_proceso = FAlSE){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_archivo');
		$this->wood->where('id',$id_usu_arch);

		if($tipo_proceso != FAlSE)
			$this->wood->where('estado_proceso',$tipo_proceso);

		$query = $this->wood->get();
		return $query->row();
	}

	function get_solicitud_contrato($id_usu_arch, $tipo_proceso = FALSE){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->wood->where('id_req_usu_arch',$id_usu_arch);/////////
		if($tipo_proceso != FAlSE)
			$this->wood->where('estado',$tipo_proceso);
		$query = $this->wood->get();
		return $query->row();
	}

	function listar_solicitudes_pendientes($get_id_planta = FALSE){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_archivo_solicitudes_contratos req_usu_arch_cont');
		$this->wood->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->wood->join('r_requerimiento_asc_trabajadores req_asc','req_usu_arch.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->wood->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->wood->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->wood->where('req_usu_arch_cont.estado', 0);

		if($get_id_planta != FALSE)
			$this->wood->where('req.planta_id', $get_id_planta);

		$query = $this->wood->get();
		return $query->result();
	}

	function listar_solicitudes_completas($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_archivo');
		$this->wood->where('estado_proceso',2);
		if($fecha_inicio != FAlSE){
			$this->wood->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}
		//$this->wood->limit(10);
		$query = $this->wood->get();
		return $query->result();
	}

	function get($id_usu_arch){
		$this->wood->where('id',$id_usu_arch);
		$query = $this->wood->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function get_result($id_usu_arch){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_archivo');
		$this->wood->where('id',$id_usu_arch);
		$query = $this->wood->get();
		return $query->result();
	}

	function get_archivos_req($id_asc_trab){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_archivo');
		$this->wood->where('requerimiento_asc_trabajadores_id',$id_asc_trab);
		$this->wood->where('tipo_archivo_requerimiento_id', '1');
		//$this->wood->where('tipo_archivo_requerimiento_id', '1'.' or tipo_archivo_requerimiento_id', '2');
		$query = $this->wood->get();
		return $query->row();
	}

	function get_usuario_requerimiento($usuario,$requerimiento){
		$this->wood->where('usuario_id',$usuario);
		$this->wood->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$query = $this->wood->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_requerimiento_archivo($usuario,$requerimiento,$archivo){
		$this->wood->where('usuario_id',$usuario);
		$this->wood->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->wood->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->wood->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_requerimiento_archivo_limit_row($usuario,$requerimiento,$archivo){
		$this->wood->where('usuario_id',$usuario);
		$this->wood->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->wood->where('tipo_archivo_requerimiento_id',$archivo);
		$this->wood->order_by('id','desc');
		$this->wood->limit(1);
		$query = $this->wood->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function get_usuario_requerimiento_archivo_limit($usuario,$requerimiento,$archivo){
		$this->wood->where('usuario_id',$usuario);
		$this->wood->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->wood->where('tipo_archivo_requerimiento_id',$archivo);
		$this->wood->limit(1);
		$query = $this->wood->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_archivos($usuario,$tipo_archivo){
		$this->wood->where('usuario_id',$usuario);
		$this->wood->where('tipo_archivo_requerimiento_id',$tipo_archivo);
		$query = $this->wood->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function existe_registro_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_archivo');
		$this->wood->where('usuario_id',$usuario);
		$this->wood->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->wood->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->wood->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function get_result_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_archivo');
		$this->wood->where('usuario_id',$usuario);
		$this->wood->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->wood->where('tipo_archivo_requerimiento_id',$archivo);
		$this->wood->where('fecha_aprobacion_baja',null);// si posee esta fecha es porque ya se a dado de baja 
		$query = $this->wood->get();
		if ($query->num_rows >0){
		   return $query->result();
		}else{
		   return 0;
		}
	}

	function get_usuario_requerimiento_datos($usuario,$requerimiento, $archivo){
		$this->wood->where('usuario_id',$usuario);
		$this->wood->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->wood->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->wood->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function consultar_si_existe_req($usuario, $requerimiento, $archivo){
		$this->wood->SELECT('*');
		$this->wood->from('r_requerimiento_usuario_archivo');
		$this->wood->where('usuario_id',$usuario);
		$this->wood->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->wood->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->wood->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function actualizar_usu_arch($id, $datos){
		$this->wood->where('id',$id);
		$this->wood->update('r_requerimiento_usuario_archivo', $datos);
	}

	function actualizar_req($usuario, $requerimiento, $archivo, $datos){
		$this->wood->where('usuario_id',$usuario);
		$this->wood->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->wood->where('tipo_archivo_requerimiento_id',$archivo);
		$this->wood->update('r_requerimiento_usuario_archivo', $datos);
	}

	function get_requerimiento($id){
		$this->wood->select("");
		$this->wood->from("r_requerimiento_usuario_archivo rua");
		$this->wood->join("r_requerimiento_asc_trabajadores rat","rua.requerimiento_asc_trabajadores_id = rat.id");
		$this->wood->join("r_requerimiento_area_cargo rac","rac.id = rat.requerimiento_area_cargo_id");
		$this->wood->where('rua.id',$id);
		$query = $this->wood->get();
		return $query->row();
	}

	function listar(){
		$query = $this->wood->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function ingresar($data){
		$this->wood->insert('r_requerimiento_usuario_archivo',$data); 
	}

	function eliminar($id){
		$this->wood->delete('r_requerimiento_usuario_archivo', array('id' => $id)); 
	}

	function listar_usuarios_contrato_vencido(){
		$this->wood->select("");
		$this->wood->from("r_requerimiento_usuario_archivo");
		$this->wood->where('tipo_archivo_requerimiento_id',1);
		$this->wood->where('fecha_termino <', date('Y-m-d'));
		$query = $this->wood->get();
		return $query->result();
	}

	#05-07-2018
	function getIdUsuarioContrato($id_usu_arch){
		$this->wood->select("*");
		$this->wood->from("r_requerimiento_usuario_archivo");
		$this->wood->where('r_requerimiento_usuario_archivo.id',$id_usu_arch);
		$query = $this->wood->get();
		return $query->row();
	}

	#06-05-2018 
	function getCodigoContrato($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda){
		$this->wood->select('*');
		$this->wood->from("r_requerimiento_usuario_archivo");
		$this->wood->where('usuario_id',$idUsuario);
		$this->wood->where('(estado_proceso = 2 OR estado_proceso = 3)');// donde 2 significa contratos ya generados
		$this->wood->where('id_tipo_contrato',1);// donde 1 significa contrato diario
		$this->wood->where('fecha_inicio BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$query = $this->wood->get();
		if ($query->num_rows >0){
			return $query->result();
		}else{
		   return false;
		}
	}

	function getCodigoDisponible($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda ){
		$this->wood->select('id, codigoLibre');
		$this->wood->from('codigo_libre');
		$this->wood->where('usuario_id',$idUsuario);
		$this->wood->where('estado',0);//0 disponible para usar 
		$this->wood->where('fechaRegistro BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$query = $this->wood->get();
		if ($query->num_rows >0){
		   return $query->row();
		}else{
		   return false;
		}
	}

	function actualizarCodigoLibre($id , $data){
		$this->wood->where('id',$id);
		$this->wood->update('codigo_libre', $data);
	}

	function getLetraAbecedario($id){
		$this->wood->select('id , letraAbecedario as letra');
		$this->wood->from('abecedario');
		$this->wood->where('id',$id);
		$query = $this->wood->get();
		return $query->row();
	}

	function listar_solicitudes_pendientes_baja(){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_archivo');
		$this->wood->where('estado_proceso',3);
		$query = $this->wood->get();
		return $query->result();
	}

	function guardar_codigo_libre($data){
		$this->wood->insert('codigo_libre',$data); 

	}

	function listar_solicitudes_completas_baja($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_archivo');
		$this->wood->where('estado_proceso',5);
		if($fecha_inicio != FAlSE){
			$this->wood->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}
		$query = $this->wood->get();
		return $query->result();
	}
	#13-08-2018 grm 

	function verificarPendienteDeBaja($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_archivo');
		$this->wood->where('usuario_id',$idUsuario);
		$this->wood->where('fecha_termino BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$this->wood->where('estado_proceso',3);
		$query = $this->wood->get();
		if ($query->num_rows >0){
		   return true;
		}else{
		   return false;
		}
	}
	#06-09-2018 // 17-12-18 update grm
	function getNombreRequerimiento($idAreaCargo){
		$this->wood->select('rr.nombre, rr.regimen, rr.f_solicitud, rr.comentario');
		$this->wood->from('r_requerimiento_area_cargo as rac');
		$this->wood->join("r_requerimiento rr","rac.requerimiento_id = rr.id");
		$this->wood->where('rac.id',$idAreaCargo);
		$query = $this->wood->get();
		return $query->row();
	}
	#20-09-2018 
	function guardarMotivoSolicitud($data){
		$this->wood->insert('r_requerimiento_usuario_archivo_observacion',$data); 
	}

	function getMotivoSolicitud($idArchivo){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_archivo_observacion');
		$this->wood->where('id_r_requerimiento_usuario_archivo',$idArchivo);
		$query = $this->wood->get();
		if ($query->num_rows >0){
		   return  $query->row();
		}else{
		   return false;
		}
	}

	function actualizarMotivoSolicitud($id, $data){
		$this->wood->where('id',$id);
		$this->wood->update('r_requerimiento_usuario_archivo_observacion', $data);
	}

	function getDiasTotal($idUsuario,$fecha,$fechaAtras){
		$this->wood->select('id, fecha_inicio');
		$this->wood->from('r_requerimiento_usuario_archivo');
		$this->wood->where('usuario_id',$idUsuario);
		$this->wood->where('id_solicita_bajar',null);
		$this->wood->where('fecha_inicio BETWEEN "'.$fechaAtras. '" and "'. $fecha.'"');
		$this->wood->where('estado_proceso',2);
		$query = $this->wood->get();
		//return $query->result();
		if ($query->num_rows ==7){
		   return  false;
		}else{
		   return true;
		}
	}

	function get_anexos($usuario,$requerimiento){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_anexo');
		$this->wood->where('usuario_id',$usuario);
		$this->wood->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->wood->where("(estado = 0 OR estado =1 OR estado = 2 OR estado = 3 OR estado = 4 OR estado = 6 )");
		$query = $this->wood->get();
		if ($query->num_rows() > 0){
		   return $query->result();
		}else{
		   return 0;
		}
	}

	function verificarSitieneMasDeUnContrato($idUsuario,$fecha){
		$this->wood->select('r_requerimiento_usuario_archivo.id as idArchivo, r_requerimiento_usuario_archivo.fecha_inicio, r_requerimiento_usuario_archivo.usuario_id as idUsuario, rat.requerimiento_area_cargo_id as idAreaCargo, rat.id');
		$this->wood->from('r_requerimiento_usuario_archivo');
		$this->wood->join('r_requerimiento_asc_trabajadores rat','r_requerimiento_usuario_archivo.requerimiento_asc_trabajadores_id = rat.id');
		$this->wood->where('r_requerimiento_usuario_archivo.usuario_id',$idUsuario);
		$this->wood->where('r_requerimiento_usuario_archivo.estado_proceso',2);
		$this->wood->where('r_requerimiento_usuario_archivo.fecha_inicio', $fecha);
		$query = $this->wood->get();
		if ($query->num_rows >=1){
		   return  $query->result();
		}else{
		   return false;
		}
	}
	function get_area_cargo($idArea){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_asc_trabajadores');
		$this->wood->where('r_requerimiento_asc_trabajadores.id',$idArea);
		$query = $this->wood->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}	
	}

	function existe_registro_de_anexo($usuario,$requerimiento,$archivo){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_anexo');
		$this->wood->where('usuario_id',$usuario);
		$this->wood->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->wood->where('tipo_archivo_requerimiento_id',$archivo);
		$this->wood->where("(estado = 0 OR estado =1 OR estado = 2 OR estado = 3 OR estado = 4)");
		$query = $this->wood->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function listar_solicitudes_completas2($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_archivo_solicitudes_contratos req_usu_arch_cont');
		$this->wood->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->wood->join('r_requerimiento_asc_trabajadores req_asc','req_usu_arch.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->wood->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->wood->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->wood->where('req_usu_arch_cont.estado', 1);
//$this->wood->limit(10);
		if($fecha_inicio != FAlSE){
			$this->wood->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}

		$query = $this->wood->get();
		return $query->result();
	}
	function get_contrato($idContrato){
		$this->wood->select('u.nombres, u.paterno, u.materno, u.rut_usuario, r.fecha_termino, ep.nombre as nombrePlanta, r.fecha_termino2');
		$this->wood->from('r_requerimiento_usuario_archivo r');
		$this->wood->join('usuarios u','r.usuario_id = u.id','left');
		$this->wood->join('r_requerimiento_asc_trabajadores rat','r.requerimiento_asc_trabajadores_id = rat.id','left');
		$this->wood->join('r_requerimiento_area_cargo rar','rat.requerimiento_area_cargo_id = rar.id','left');
		$this->wood->join('r_requerimiento req','rar.requerimiento_id = req.id','left');
		$this->wood->join('empresa_planta ep','req.planta_id = ep.id','left');
		$this->wood->where('r.id',$idContrato);
		$query = $this->wood->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}
	function getRequerimienton($id_req){
		$this->wood->where("id",$id_req);
		$query = $this->wood->get('r_requerimiento_area_cargo');
		return $query->row();
	}
	function listar_solicitudes_pendientes_anexo($id_planta = FALSE){
		$this->wood->select('*, anexo.id as idAnexo, anexo.nombres as nombreTrabajador, anexo.rut_usuario as rutTrabajador, anexo.nacionalidad as nacionalidadTrabajador, anexo.fecha_nac as nacimientoTrabajador, anexo.direccion as direccionTrabajador, anexo.ciudad as ciudadTrabajador, anexo.estado_civil as civilTrabajador, anexo.afp as afpTrabajador, anexo.salud as saludTrabajador, anexo.nombre_centro_costo as centroTrabajador, anexo.telefono as telefonoTrabajador, anexo.nivel_estudios as estudioTrabajador, anexo.nombre_banco as bancoTrabajador, anexo.tipo_cuenta as cuentaTrabajador, anexo.cuenta_banco as numeroCuentaTrabajador, anexo.nombre_planta as plantaTrabajador, anexo.fecha_inicio_contrato as fechaInicioContrato, anexo.fecha_termino_contrato_anterior as fechaTerminoContratoAnterior, anexo.fecha_termino_nuevo_anexo as fechaTerminoAnexo, anexo.causal as causalTrabajador');
		$this->wood->from('r_requerimiento_usuario_anexo anexo');
		//$this->wood->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');

		$this->wood->join('r_requerimiento_asc_trabajadores req_asc','anexo.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->wood->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->wood->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->wood->where('anexo.estado', 1);
		if($id_planta != FALSE)
			$this->wood->where('req.planta_id', $id_planta);

		$query = $this->wood->get();
		return $query->result();
	}
	function ingresarAnexo($data){
		$this->wood->insert('r_requerimiento_usuario_anexo',$data); 
	}
	function get_anexos_id($idAnexo){
		$this->wood->select('*');
		$this->wood->from('r_requerimiento_usuario_anexo');
		$this->wood->where('id',$idAnexo);
		$query = $this->wood->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}
	function getIdEmpresa($id){
		$this->wood->select('id_centro_costo');
		$this->wood->from('empresa_planta');
		$this->wood->where('id',$id);
		$query = $this->wood->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}
	function actualizarAnexo($id, $data){
		$this->wood->where('id',$id);
		$this->wood->update('r_requerimiento_usuario_anexo', $data);
		return $afftectedRows = $this->wood->affected_rows();
	}
	function marcarAnexoAnteriorComoFinalizado($idUsuario,$idReqAscTrabajadores, $datos){
		$this->wood->where('usuario_id',$idUsuario);
		$this->wood->where('requerimiento_asc_trabajadores_id',$idReqAscTrabajadores);
		$this->wood->where('estado',2);
		$this->wood->update('r_requerimiento_usuario_anexo', $datos);
	}
	function actualizarContrato($idUsuario,$idReqAscTrabajadores, $datos){
		$this->wood->where('usuario_id',$idUsuario);
		$this->wood->where('requerimiento_asc_trabajadores_id',$idReqAscTrabajadores);
		$this->wood->where('tipo_archivo_requerimiento_id',1);
		$this->wood->update('r_requerimiento_usuario_archivo', $datos);
	}
	function insertarAnexoAprobado($data){
		$this->wood->insert('anexos_masivos',$data); 
	}
	function get_ultimo_anexo($usuario,$requerimiento,$archivo){
		$this->wood->select('*, fecha_inicio_contrato as fecha_inicio, fecha_termino_nuevo_anexo as fecha_termino');
		$this->wood->from('r_requerimiento_usuario_anexo');
		$this->wood->where('usuario_id',$usuario);
		$this->wood->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->wood->where('tipo_archivo_requerimiento_id',$archivo);
		$this->wood->where("(estado = 0 OR estado =1 OR estado = 2 OR estado = 3 OR estado = 4)");
		$this->wood->order_by('id','desc');
		$this->wood->limit(1);
		$query = $this->wood->get();
		return $query->row();
	}
	function listar_solicitudes_completas_anexo($id_planta = FALSE, $idUsuario = false){
		$this->wood->select('*, anexo.id as idAnexo, anexo.nombres as nombreTrabajador, anexo.rut_usuario as rutTrabajador, anexo.nacionalidad as nacionalidadTrabajador, anexo.fecha_nac as nacimientoTrabajador, anexo.direccion as direccionTrabajador, anexo.ciudad as ciudadTrabajador, anexo.estado_civil as civilTrabajador, anexo.afp as afpTrabajador, anexo.salud as saludTrabajador, anexo.nombre_centro_costo as centroTrabajador, anexo.telefono as telefonoTrabajador, anexo.nivel_estudios as estudioTrabajador, anexo.nombre_banco as bancoTrabajador, anexo.tipo_cuenta as cuentaTrabajador, anexo.cuenta_banco as numeroCuentaTrabajador, anexo.nombre_planta as plantaTrabajador, anexo.fecha_inicio_contrato as fechaInicioContrato, anexo.fecha_termino_contrato_anterior as fechaTerminoContratoAnterior, anexo.fecha_termino_nuevo_anexo as fechaTerminoAnexo, anexo.causal as causalTrabajador');
		$this->wood->from('r_requerimiento_usuario_anexo anexo');
		//$this->wood->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->wood->join('r_requerimiento_asc_trabajadores req_asc','anexo.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->wood->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->wood->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->wood->where('anexo.estado', 2);
		if($id_planta != FALSE)
			$this->wood->where('req.planta_id', $id_planta);
		if($idUsuario != FALSE)
			$this->wood->where('anexo.id_quien_solicita', $idUsuario);
		$query = $this->wood->get();
		return $query->result();
	}
	function get_anexo($idAnexo){
		$this->wood->select('u.nombres, u.paterno, u.materno, u.rut_usuario, r.fecha_termino_nuevo_anexo as fecha_termino, r.nombre_planta as nombrePlanta, r.fecha_termino2');
		$this->wood->from('r_requerimiento_usuario_anexo r');
		$this->wood->join('usuarios u ','r.usuario_id = u.id','inner');
		$this->wood->where('r.id',$idAnexo);
		$query = $this->wood->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}
	function insertarContratoAprobado($data){
		$this->wood->insert('contratos_masivos',$data); 
	}
	function getNombreTrabajador($idAnexo){
		$this->wood->select("CONCAT(u.nombres,' ', u.paterno,' ', u.materno) as nombreTrabajador, u.nombres as name",FALSE);
		$this->wood->from('r_requerimiento_usuario_archivo r');
		$this->wood->join('usuarios u ','r.usuario_id = u.id','inner');
		$this->wood->where('r.id',$idAnexo);
		$query = $this->wood->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}

}
?>