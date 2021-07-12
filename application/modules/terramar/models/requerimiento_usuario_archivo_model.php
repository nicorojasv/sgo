<?php
class Requerimiento_Usuario_Archivo_model extends CI_Model {

	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function ingresar_solicitud_contrato($data){
		$this->terramar->insert('r_requerimiento_usuario_archivo_solicitudes_contratos',$data); 
		return $this->terramar->insert_id();
	}

	function actualizar_solicitud_contrato($id_req_usu_arch, $datos){
		$this->terramar->where('id_req_usu_arch',$id_req_usu_arch);
		$this->terramar->update('r_requerimiento_usuario_archivo_solicitudes_contratos', $datos);
	}

	function get_solicitud_contrato_tipo_proceso($id_usu_arch, $tipo_proceso = FAlSE){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->terramar->where('id_req_usu_arch',$id_usu_arch);

		if($tipo_proceso != FAlSE)
			$this->terramar->where('estado',$tipo_proceso);

		$query = $this->terramar->get();
		return $query->row();
	}
	
	function ingresar_solicitud_contrato_historial($data){
		$this->terramar->insert('r_requerimiento_usuario_archivo_solicitudes_contratos_historial',$data); 
	}

	function get_proceso_contrato_tipo($id_usu_arch, $tipo_proceso = FAlSE){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_archivo');
		$this->terramar->where('id',$id_usu_arch);

		if($tipo_proceso != FAlSE)
			$this->terramar->where('estado_proceso',$tipo_proceso);

		$query = $this->terramar->get();
		return $query->row();
	}

	function get_solicitud_contrato($id_usu_arch, $tipo_proceso = FALSE){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->terramar->where('id_req_usu_arch',$id_usu_arch);/////////
		if($tipo_proceso != FAlSE)
			$this->terramar->where('estado',$tipo_proceso);
		$query = $this->terramar->get();
		return $query->row();
	}

	function listar_solicitudes_pendientes($get_id_planta = FALSE){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_archivo_solicitudes_contratos req_usu_arch_cont');
		$this->terramar->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->terramar->join('r_requerimiento_asc_trabajadores req_asc','req_usu_arch.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->terramar->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->terramar->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->terramar->where('req_usu_arch_cont.estado', 0);

		if($get_id_planta != FALSE)
			$this->terramar->where('req.planta_id', $get_id_planta);

		$query = $this->terramar->get();
		return $query->result();
	}

	function listar_solicitudes_completas($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_archivo');
		$this->terramar->where('estado_proceso',2);
		if($fecha_inicio != FAlSE){
			$this->terramar->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}
		//$this->terramar->limit(10);
		$query = $this->terramar->get();
		return $query->result();
	}

	function get($id_usu_arch){
		$this->terramar->where('id',$id_usu_arch);
		$query = $this->terramar->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function get_result($id_usu_arch){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_archivo');
		$this->terramar->where('id',$id_usu_arch);
		$query = $this->terramar->get();
		return $query->result();
	}

	function get_archivos_req($id_asc_trab){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_archivo');
		$this->terramar->where('requerimiento_asc_trabajadores_id',$id_asc_trab);
		$this->terramar->where('tipo_archivo_requerimiento_id', '1');
		//$this->terramar->where('tipo_archivo_requerimiento_id', '1'.' or tipo_archivo_requerimiento_id', '2');
		$query = $this->terramar->get();
		return $query->row();
	}

	function get_usuario_requerimiento($usuario,$requerimiento){
		$this->terramar->where('usuario_id',$usuario);
		$this->terramar->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$query = $this->terramar->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_requerimiento_archivo($usuario,$requerimiento,$archivo){
		$this->terramar->where('usuario_id',$usuario);
		$this->terramar->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->terramar->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->terramar->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_requerimiento_archivo_limit_row($usuario,$requerimiento,$archivo){
		$this->terramar->where('usuario_id',$usuario);
		$this->terramar->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->terramar->where('tipo_archivo_requerimiento_id',$archivo);
		$this->terramar->order_by('id','desc');
		$this->terramar->limit(1);
		$query = $this->terramar->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function get_usuario_requerimiento_archivo_limit($usuario,$requerimiento,$archivo){
		$this->terramar->where('usuario_id',$usuario);
		$this->terramar->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->terramar->where('tipo_archivo_requerimiento_id',$archivo);
		$this->terramar->limit(1);
		$query = $this->terramar->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_archivos($usuario,$tipo_archivo){
		$this->terramar->where('usuario_id',$usuario);
		$this->terramar->where('tipo_archivo_requerimiento_id',$tipo_archivo);
		$query = $this->terramar->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function existe_registro_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_archivo');
		$this->terramar->where('usuario_id',$usuario);
		$this->terramar->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->terramar->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->terramar->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function get_result_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_archivo');
		$this->terramar->where('usuario_id',$usuario);
		$this->terramar->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->terramar->where('tipo_archivo_requerimiento_id',$archivo);
		$this->terramar->where('fecha_aprobacion_baja',null);// si posee esta fecha es porque ya se a dado de baja 
		$query = $this->terramar->get();
		if ($query->num_rows >0){
		   return $query->result();
		}else{
		   return 0;
		}
	}

	function get_usuario_requerimiento_datos($usuario,$requerimiento, $archivo){
		$this->terramar->where('usuario_id',$usuario);
		$this->terramar->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->terramar->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->terramar->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function consultar_si_existe_req($usuario, $requerimiento, $archivo){
		$this->terramar->SELECT('*');
		$this->terramar->from('r_requerimiento_usuario_archivo');
		$this->terramar->where('usuario_id',$usuario);
		$this->terramar->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->terramar->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->terramar->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function actualizar_usu_arch($id, $datos){
		$this->terramar->where('id',$id);
		$this->terramar->update('r_requerimiento_usuario_archivo', $datos);
	}

	function actualizar_req($usuario, $requerimiento, $archivo, $datos){
		$this->terramar->where('usuario_id',$usuario);
		$this->terramar->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->terramar->where('tipo_archivo_requerimiento_id',$archivo);
		$this->terramar->update('r_requerimiento_usuario_archivo', $datos);
	}

	function get_requerimiento($id){
		$this->terramar->select("");
		$this->terramar->from("r_requerimiento_usuario_archivo rua");
		$this->terramar->join("r_requerimiento_asc_trabajadores rat","rua.requerimiento_asc_trabajadores_id = rat.id");
		$this->terramar->join("r_requerimiento_area_cargo rac","rac.id = rat.requerimiento_area_cargo_id");
		$this->terramar->where('rua.id',$id);
		$query = $this->terramar->get();
		return $query->row();
	}

	function listar(){
		$query = $this->terramar->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function ingresar($data){
		$this->terramar->insert('r_requerimiento_usuario_archivo',$data); 
	}

	function eliminar($id){
		$this->terramar->delete('r_requerimiento_usuario_archivo', array('id' => $id)); 
	}

	function listar_usuarios_contrato_vencido(){
		$this->terramar->select("");
		$this->terramar->from("r_requerimiento_usuario_archivo");
		$this->terramar->where('tipo_archivo_requerimiento_id',1);
		$this->terramar->where('fecha_termino <', date('Y-m-d'));
		$query = $this->terramar->get();
		return $query->result();
	}

	#05-07-2018
	function getIdUsuarioContrato($id_usu_arch){
		$this->terramar->select("*");
		$this->terramar->from("r_requerimiento_usuario_archivo");
		$this->terramar->where('r_requerimiento_usuario_archivo.id',$id_usu_arch);
		$query = $this->terramar->get();
		return $query->row();
	}

	#06-05-2018 
	function getCodigoContrato($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda){
		$this->terramar->select('*');
		$this->terramar->from("r_requerimiento_usuario_archivo");
		$this->terramar->where('usuario_id',$idUsuario);
		$this->terramar->where('(estado_proceso = 2 OR estado_proceso = 3)');// donde 2 significa contratos ya generados
		$this->terramar->where('id_tipo_contrato',1);// donde 1 significa contrato diario
		$this->terramar->where('fecha_inicio BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$query = $this->terramar->get();
		if ($query->num_rows >0){
			return $query->result();
		}else{
		   return false;
		}
	}

	function getCodigoDisponible($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda ){
		$this->terramar->select('id, codigoLibre');
		$this->terramar->from('codigo_libre');
		$this->terramar->where('usuario_id',$idUsuario);
		$this->terramar->where('estado',0);//0 disponible para usar 
		$this->terramar->where('fechaRegistro BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$query = $this->terramar->get();
		if ($query->num_rows >0){
		   return $query->row();
		}else{
		   return false;
		}
	}

	function actualizarCodigoLibre($id , $data){
		$this->terramar->where('id',$id);
		$this->terramar->update('codigo_libre', $data);
	}

	function getLetraAbecedario($id){
		$this->terramar->select('id , letraAbecedario as letra');
		$this->terramar->from('abecedario');
		$this->terramar->where('id',$id);
		$query = $this->terramar->get();
		return $query->row();
	}

	function listar_solicitudes_pendientes_baja(){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_archivo');
		$this->terramar->where('estado_proceso',3);
		$query = $this->terramar->get();
		return $query->result();
	}

	function guardar_codigo_libre($data){
		$this->terramar->insert('codigo_libre',$data); 

	}

	function listar_solicitudes_completas_baja($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_archivo');
		$this->terramar->where('estado_proceso',5);
		if($fecha_inicio != FAlSE){
			$this->terramar->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}
		$query = $this->terramar->get();
		return $query->result();
	}
	#13-08-2018 grm 

	function verificarPendienteDeBaja($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_archivo');
		$this->terramar->where('usuario_id',$idUsuario);
		$this->terramar->where('fecha_termino BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$this->terramar->where('estado_proceso',3);
		$query = $this->terramar->get();
		if ($query->num_rows >0){
		   return true;
		}else{
		   return false;
		}
	}
	#06-09-2018 // 17-12-18 update grm
	function getNombreRequerimiento($idAreaCargo){
		$this->terramar->select('rr.nombre, rr.regimen, rr.f_solicitud, rr.comentario');
		$this->terramar->from('r_requerimiento_area_cargo as rac');
		$this->terramar->join("r_requerimiento rr","rac.requerimiento_id = rr.id");
		$this->terramar->where('rac.id',$idAreaCargo);
		$query = $this->terramar->get();
		return $query->row();
	}
	#20-09-2018 
	function guardarMotivoSolicitud($data){
		$this->terramar->insert('r_requerimiento_usuario_archivo_observacion',$data); 
	}

	function getMotivoSolicitud($idArchivo){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_archivo_observacion');
		$this->terramar->where('id_r_requerimiento_usuario_archivo',$idArchivo);
		$query = $this->terramar->get();
		if ($query->num_rows >0){
		   return  $query->row();
		}else{
		   return false;
		}
	}

	function actualizarMotivoSolicitud($id, $data){
		$this->terramar->where('id',$id);
		$this->terramar->update('r_requerimiento_usuario_archivo_observacion', $data);
	}

	function getDiasTotal($idUsuario,$fecha,$fechaAtras){
		$this->terramar->select('id, fecha_inicio');
		$this->terramar->from('r_requerimiento_usuario_archivo');
		$this->terramar->where('usuario_id',$idUsuario);
		$this->terramar->where('id_solicita_bajar',null);
		$this->terramar->where('fecha_inicio BETWEEN "'.$fechaAtras. '" and "'. $fecha.'"');
		$this->terramar->where('estado_proceso',2);
		$query = $this->terramar->get();
		//return $query->result();
		if ($query->num_rows ==7){
		   return  false;
		}else{
		   return true;
		}
	}

	function get_anexos($usuario,$requerimiento){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_anexo');
		$this->terramar->where('usuario_id',$usuario);
		$this->terramar->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->terramar->where("(estado = 0 OR estado =1 OR estado = 2 OR estado = 3 OR estado = 4 OR estado = 6 )");
		$query = $this->terramar->get();
		if ($query->num_rows() > 0){
		   return $query->result();
		}else{
		   return 0;
		}
	}

	function verificarSitieneMasDeUnContrato($idUsuario,$fecha){
		$this->terramar->select('r_requerimiento_usuario_archivo.id as idArchivo, r_requerimiento_usuario_archivo.fecha_inicio, r_requerimiento_usuario_archivo.usuario_id as idUsuario, rat.requerimiento_area_cargo_id as idAreaCargo, rat.id');
		$this->terramar->from('r_requerimiento_usuario_archivo');
		$this->terramar->join('r_requerimiento_asc_trabajadores rat','r_requerimiento_usuario_archivo.requerimiento_asc_trabajadores_id = rat.id');
		$this->terramar->where('r_requerimiento_usuario_archivo.usuario_id',$idUsuario);
		$this->terramar->where('r_requerimiento_usuario_archivo.estado_proceso',2);
		$this->terramar->where('r_requerimiento_usuario_archivo.fecha_inicio', $fecha);
		$query = $this->terramar->get();
		if ($query->num_rows >=1){
		   return  $query->result();
		}else{
		   return false;
		}
	}
	function get_area_cargo($idArea){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_asc_trabajadores');
		$this->terramar->where('r_requerimiento_asc_trabajadores.id',$idArea);
		$query = $this->terramar->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}	
	}

	function existe_registro_de_anexo($usuario,$requerimiento,$archivo){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_anexo');
		$this->terramar->where('usuario_id',$usuario);
		$this->terramar->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->terramar->where('tipo_archivo_requerimiento_id',$archivo);
		$this->terramar->where("(estado = 0 OR estado =1 OR estado = 2 OR estado = 3 OR estado = 4)");
		$query = $this->terramar->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function listar_solicitudes_completas2($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_archivo_solicitudes_contratos req_usu_arch_cont');
		$this->terramar->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->terramar->join('r_requerimiento_asc_trabajadores req_asc','req_usu_arch.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->terramar->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->terramar->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->terramar->where('req_usu_arch_cont.estado', 1);
//$this->terramar->limit(10);
		if($fecha_inicio != FAlSE){
			$this->terramar->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}

		$query = $this->terramar->get();
		return $query->result();
	}
	function get_contrato($idContrato){
		$this->terramar->select('u.nombres, u.paterno, u.materno, u.rut_usuario, r.fecha_termino, ep.nombre as nombrePlanta, r.fecha_termino2');
		$this->terramar->from('r_requerimiento_usuario_archivo r');
		$this->terramar->join('usuarios u','r.usuario_id = u.id','left');
		$this->terramar->join('r_requerimiento_asc_trabajadores rat','r.requerimiento_asc_trabajadores_id = rat.id','left');
		$this->terramar->join('r_requerimiento_area_cargo rar','rat.requerimiento_area_cargo_id = rar.id','left');
		$this->terramar->join('r_requerimiento req','rar.requerimiento_id = req.id','left');
		$this->terramar->join('empresa_planta ep','req.planta_id = ep.id','left');
		$this->terramar->where('r.id',$idContrato);
		$query = $this->terramar->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}
	function getRequerimienton($id_req){
		$this->terramar->where("id",$id_req);
		$query = $this->terramar->get('r_requerimiento_area_cargo');
		return $query->row();
	}
	function listar_solicitudes_pendientes_anexo($id_planta = FALSE){
		$this->terramar->select('*, anexo.id as idAnexo, anexo.nombres as nombreTrabajador, anexo.rut_usuario as rutTrabajador, anexo.nacionalidad as nacionalidadTrabajador, anexo.fecha_nac as nacimientoTrabajador, anexo.direccion as direccionTrabajador, anexo.ciudad as ciudadTrabajador, anexo.estado_civil as civilTrabajador, anexo.afp as afpTrabajador, anexo.salud as saludTrabajador, anexo.nombre_centro_costo as centroTrabajador, anexo.telefono as telefonoTrabajador, anexo.nivel_estudios as estudioTrabajador, anexo.nombre_banco as bancoTrabajador, anexo.tipo_cuenta as cuentaTrabajador, anexo.cuenta_banco as numeroCuentaTrabajador, anexo.nombre_planta as plantaTrabajador, anexo.fecha_inicio_contrato as fechaInicioContrato, anexo.fecha_termino_contrato_anterior as fechaTerminoContratoAnterior, anexo.fecha_termino_nuevo_anexo as fechaTerminoAnexo, anexo.causal as causalTrabajador');
		$this->terramar->from('r_requerimiento_usuario_anexo anexo');
		//$this->terramar->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');

		$this->terramar->join('r_requerimiento_asc_trabajadores req_asc','anexo.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->terramar->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->terramar->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->terramar->where('anexo.estado', 1);
		if($id_planta != FALSE)
			$this->terramar->where('req.planta_id', $id_planta);

		$query = $this->terramar->get();
		return $query->result();
	}
	function ingresarAnexo($data){
		$this->terramar->insert('r_requerimiento_usuario_anexo',$data); 
	}
	function get_anexos_id($idAnexo){
		$this->terramar->select('*');
		$this->terramar->from('r_requerimiento_usuario_anexo');
		$this->terramar->where('id',$idAnexo);
		$query = $this->terramar->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}
	function getIdEmpresa($id){
		$this->terramar->select('id_centro_costo');
		$this->terramar->from('empresa_planta');
		$this->terramar->where('id',$id);
		$query = $this->terramar->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}


	function getMotivoAnexo($idAnexo){
		$this->terramar->select('*');
		$this->terramar->from('motivos_de_anexos');
		$this->terramar->where('id_anexo',$idAnexo);
		$query = $this->terramar->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return false;
		}
	}

	function actualizarAnexo($id, $data){
		$this->terramar->where('id',$id);
		$this->terramar->update('r_requerimiento_usuario_anexo', $data);
		return $afftectedRows = $this->terramar->affected_rows();
	}
	function marcarAnexoAnteriorComoFinalizado($idUsuario,$idReqAscTrabajadores, $datos){
		$this->terramar->where('usuario_id',$idUsuario);
		$this->terramar->where('requerimiento_asc_trabajadores_id',$idReqAscTrabajadores);
		$this->terramar->where('estado',2);
		$this->terramar->update('r_requerimiento_usuario_anexo', $datos);
	}
	function actualizarContrato($idUsuario,$idReqAscTrabajadores, $datos){
		$this->terramar->where('usuario_id',$idUsuario);
		$this->terramar->where('requerimiento_asc_trabajadores_id',$idReqAscTrabajadores);
		$this->terramar->where('tipo_archivo_requerimiento_id',1);
		$this->terramar->update('r_requerimiento_usuario_archivo', $datos);
	}
	function insertarAnexoAprobado($data){
		$this->terramar->insert('anexos_masivos',$data); 
	}
	function get_ultimo_anexo($usuario,$requerimiento,$archivo){
		$this->terramar->select('*, fecha_inicio_contrato as fecha_inicio, fecha_termino_nuevo_anexo as fecha_termino');
		$this->terramar->from('r_requerimiento_usuario_anexo');
		$this->terramar->where('usuario_id',$usuario);
		$this->terramar->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->terramar->where('tipo_archivo_requerimiento_id',$archivo);
		$this->terramar->where("(estado = 0 OR estado =1 OR estado = 2 OR estado = 3 OR estado = 4)");
		$this->terramar->order_by('id','desc');
		$this->terramar->limit(1);
		$query = $this->terramar->get();
		return $query->row();
	}
	function listar_solicitudes_completas_anexo($id_planta = FALSE, $idUsuario = false){
		$this->terramar->select('*, anexo.id as idAnexo, anexo.nombres as nombreTrabajador, anexo.rut_usuario as rutTrabajador, anexo.nacionalidad as nacionalidadTrabajador, anexo.fecha_nac as nacimientoTrabajador, anexo.direccion as direccionTrabajador, anexo.ciudad as ciudadTrabajador, anexo.estado_civil as civilTrabajador, anexo.afp as afpTrabajador, anexo.salud as saludTrabajador, anexo.nombre_centro_costo as centroTrabajador, anexo.telefono as telefonoTrabajador, anexo.nivel_estudios as estudioTrabajador, anexo.nombre_banco as bancoTrabajador, anexo.tipo_cuenta as cuentaTrabajador, anexo.cuenta_banco as numeroCuentaTrabajador, anexo.nombre_planta as plantaTrabajador, anexo.fecha_inicio_contrato as fechaInicioContrato, anexo.fecha_termino_contrato_anterior as fechaTerminoContratoAnterior, anexo.fecha_termino_nuevo_anexo as fechaTerminoAnexo, anexo.causal as causalTrabajador');
		$this->terramar->from('r_requerimiento_usuario_anexo anexo');
		//$this->terramar->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->terramar->join('r_requerimiento_asc_trabajadores req_asc','anexo.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->terramar->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->terramar->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->terramar->where('anexo.estado', 2);
		if($id_planta != FALSE)
			$this->terramar->where('req.planta_id', $id_planta);
		if($idUsuario != FALSE)
			$this->terramar->where('anexo.id_quien_solicita', $idUsuario);
		$query = $this->terramar->get();
		return $query->result();
	}
	function get_anexo($idAnexo){
		$this->terramar->select('u.nombres, u.paterno, u.materno, u.rut_usuario, r.fecha_termino_nuevo_anexo as fecha_termino, r.nombre_planta as nombrePlanta, r.fecha_termino2');
		$this->terramar->from('r_requerimiento_usuario_anexo r');
		$this->terramar->join('usuarios u ','r.usuario_id = u.id','inner');
		$this->terramar->where('r.id',$idAnexo);
		$query = $this->terramar->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}
	function insertarContratoAprobado($data){
		$this->terramar->insert('contratos_masivos',$data); 
	}
	function getNombreTrabajador($idAnexo){
		$this->terramar->select("CONCAT(u.nombres,' ', u.paterno,' ', u.materno) as nombreTrabajador, u.nombres as name",FALSE);
		$this->terramar->from('r_requerimiento_usuario_archivo r');
		$this->terramar->join('usuarios u ','r.usuario_id = u.id','inner');
		$this->terramar->where('r.id',$idAnexo);
		$query = $this->terramar->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}

}
?>