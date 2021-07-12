<?php
class Requerimiento_Usuario_Archivo_model extends CI_Model {

	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function ingresar_solicitud_contrato($data){
		$this->sanatorio->insert('r_requerimiento_usuario_archivo_solicitudes_contratos',$data); 
		return $this->sanatorio->insert_id();
	}

	function actualizar_solicitud_contrato($id_req_usu_arch, $datos){
		$this->sanatorio->where('id_req_usu_arch',$id_req_usu_arch);
		$this->sanatorio->update('r_requerimiento_usuario_archivo_solicitudes_contratos', $datos);
	}

	function get_solicitud_contrato_tipo_proceso($id_usu_arch, $tipo_proceso = FAlSE){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->sanatorio->where('id_req_usu_arch',$id_usu_arch);

		if($tipo_proceso != FAlSE)
			$this->sanatorio->where('estado',$tipo_proceso);

		$query = $this->sanatorio->get();
		return $query->row();
	}
	
	function ingresar_solicitud_contrato_historial($data){
		$this->sanatorio->insert('r_requerimiento_usuario_archivo_solicitudes_contratos_historial',$data); 
	}

	function get_proceso_contrato_tipo($id_usu_arch, $tipo_proceso = FAlSE){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_archivo');
		$this->sanatorio->where('id',$id_usu_arch);

		if($tipo_proceso != FAlSE)
			$this->sanatorio->where('estado_proceso',$tipo_proceso);

		$query = $this->sanatorio->get();
		return $query->row();
	}

	function get_solicitud_contrato($id_usu_arch, $tipo_proceso = FALSE){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->sanatorio->where('id_req_usu_arch',$id_usu_arch);/////////
		if($tipo_proceso != FAlSE)
			$this->sanatorio->where('estado',$tipo_proceso);
		$query = $this->sanatorio->get();
		return $query->row();
	}

	function listar_solicitudes_pendientes($get_id_planta = FALSE){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_archivo_solicitudes_contratos req_usu_arch_cont');
		$this->sanatorio->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->sanatorio->join('r_requerimiento_asc_trabajadores req_asc','req_usu_arch.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->sanatorio->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->sanatorio->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->sanatorio->where('req_usu_arch_cont.estado', 0);

		if($get_id_planta != FALSE)
			$this->sanatorio->where('req.planta_id', $get_id_planta);

		$query = $this->sanatorio->get();
		return $query->result();
	}

	function listar_solicitudes_completas($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_archivo');
		$this->sanatorio->where('estado_proceso',2);
		if($fecha_inicio != FAlSE){
			$this->sanatorio->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}
		//$this->sanatorio->limit(10);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function get($id_usu_arch){
		$this->sanatorio->where('id',$id_usu_arch);
		$query = $this->sanatorio->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function get_result($id_usu_arch){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_archivo');
		$this->sanatorio->where('id',$id_usu_arch);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function get_archivos_req($id_asc_trab){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_archivo');
		$this->sanatorio->where('requerimiento_asc_trabajadores_id',$id_asc_trab);
		$this->sanatorio->where('tipo_archivo_requerimiento_id', '1');
		//$this->sanatorio->where('tipo_archivo_requerimiento_id', '1'.' or tipo_archivo_requerimiento_id', '2');
		$query = $this->sanatorio->get();
		return $query->row();
	}

	function get_usuario_requerimiento($usuario,$requerimiento){
		$this->sanatorio->where('usuario_id',$usuario);
		$this->sanatorio->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$query = $this->sanatorio->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_requerimiento_archivo($usuario,$requerimiento,$archivo){
		$this->sanatorio->where('usuario_id',$usuario);
		$this->sanatorio->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->sanatorio->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->sanatorio->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_requerimiento_archivo_limit_row($usuario,$requerimiento,$archivo){
		$this->sanatorio->where('usuario_id',$usuario);
		$this->sanatorio->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->sanatorio->where('tipo_archivo_requerimiento_id',$archivo);
		$this->sanatorio->order_by('id','desc');
		$this->sanatorio->limit(1);
		$query = $this->sanatorio->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function get_usuario_requerimiento_archivo_limit($usuario,$requerimiento,$archivo){
		$this->sanatorio->where('usuario_id',$usuario);
		$this->sanatorio->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->sanatorio->where('tipo_archivo_requerimiento_id',$archivo);
		$this->sanatorio->limit(1);
		$query = $this->sanatorio->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_archivos($usuario,$tipo_archivo){
		$this->sanatorio->where('usuario_id',$usuario);
		$this->sanatorio->where('tipo_archivo_requerimiento_id',$tipo_archivo);
		$query = $this->sanatorio->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function existe_registro_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_archivo');
		$this->sanatorio->where('usuario_id',$usuario);
		$this->sanatorio->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->sanatorio->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->sanatorio->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function get_result_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_archivo');
		$this->sanatorio->where('usuario_id',$usuario);
		$this->sanatorio->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->sanatorio->where('tipo_archivo_requerimiento_id',$archivo);
		$this->sanatorio->where('fecha_aprobacion_baja',null);// si posee esta fecha es porque ya se a dado de baja 
		$query = $this->sanatorio->get();
		if ($query->num_rows >0){
		   return $query->result();
		}else{
		   return 0;
		}
	}

	function get_usuario_requerimiento_datos($usuario,$requerimiento, $archivo){
		$this->sanatorio->where('usuario_id',$usuario);
		$this->sanatorio->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->sanatorio->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->sanatorio->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function consultar_si_existe_req($usuario, $requerimiento, $archivo){
		$this->sanatorio->SELECT('*');
		$this->sanatorio->from('r_requerimiento_usuario_archivo');
		$this->sanatorio->where('usuario_id',$usuario);
		$this->sanatorio->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->sanatorio->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->sanatorio->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function actualizar_usu_arch($id, $datos){
		$this->sanatorio->where('id',$id);
		$this->sanatorio->update('r_requerimiento_usuario_archivo', $datos);
	}

	function actualizar_req($usuario, $requerimiento, $archivo, $datos){
		$this->sanatorio->where('usuario_id',$usuario);
		$this->sanatorio->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->sanatorio->where('tipo_archivo_requerimiento_id',$archivo);
		$this->sanatorio->update('r_requerimiento_usuario_archivo', $datos);
	}

	function get_requerimiento($id){
		$this->sanatorio->select("");
		$this->sanatorio->from("r_requerimiento_usuario_archivo rua");
		$this->sanatorio->join("r_requerimiento_asc_trabajadores rat","rua.requerimiento_asc_trabajadores_id = rat.id");
		$this->sanatorio->join("r_requerimiento_area_cargo rac","rac.id = rat.requerimiento_area_cargo_id");
		$this->sanatorio->where('rua.id',$id);
		$query = $this->sanatorio->get();
		return $query->row();
	}

	function listar(){
		$query = $this->sanatorio->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function ingresar($data){
		$this->sanatorio->insert('r_requerimiento_usuario_archivo',$data); 
	}

	function eliminar($id){
		$this->sanatorio->delete('r_requerimiento_usuario_archivo', array('id' => $id)); 
	}

	function listar_usuarios_contrato_vencido(){
		$this->sanatorio->select("");
		$this->sanatorio->from("r_requerimiento_usuario_archivo");
		$this->sanatorio->where('tipo_archivo_requerimiento_id',1);
		$this->sanatorio->where('fecha_termino <', date('Y-m-d'));
		$query = $this->sanatorio->get();
		return $query->result();
	}

	#05-07-2018
	function getIdUsuarioContrato($id_usu_arch){
		$this->sanatorio->select("*");
		$this->sanatorio->from("r_requerimiento_usuario_archivo");
		$this->sanatorio->where('r_requerimiento_usuario_archivo.id',$id_usu_arch);
		$query = $this->sanatorio->get();
		return $query->row();
	}

	#06-05-2018 
	function getCodigoContrato($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda){
		$this->sanatorio->select('*');
		$this->sanatorio->from("r_requerimiento_usuario_archivo");
		$this->sanatorio->where('usuario_id',$idUsuario);
		$this->sanatorio->where('(estado_proceso = 2 OR estado_proceso = 3)');// donde 2 significa contratos ya generados
		$this->sanatorio->where('id_tipo_contrato',1);// donde 1 significa contrato diario
		$this->sanatorio->where('fecha_inicio BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$query = $this->sanatorio->get();
		if ($query->num_rows >0){
			return $query->result();
		}else{
		   return false;
		}
	}

	function getCodigoDisponible($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda ){
		$this->sanatorio->select('id, codigoLibre');
		$this->sanatorio->from('codigo_libre');
		$this->sanatorio->where('usuario_id',$idUsuario);
		$this->sanatorio->where('estado',0);//0 disponible para usar 
		$this->sanatorio->where('fechaRegistro BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$query = $this->sanatorio->get();
		if ($query->num_rows >0){
		   return $query->row();
		}else{
		   return false;
		}
	}

	function actualizarCodigoLibre($id , $data){
		$this->sanatorio->where('id',$id);
		$this->sanatorio->update('codigo_libre', $data);
	}

	function getLetraAbecedario($id){
		$this->sanatorio->select('id , letraAbecedario as letra');
		$this->sanatorio->from('abecedario');
		$this->sanatorio->where('id',$id);
		$query = $this->sanatorio->get();
		return $query->row();
	}

	function listar_solicitudes_pendientes_baja(){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_archivo');
		$this->sanatorio->where('estado_proceso',3);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function guardar_codigo_libre($data){
		$this->sanatorio->insert('codigo_libre',$data); 

	}

	function listar_solicitudes_completas_baja($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_archivo');
		$this->sanatorio->where('estado_proceso',5);
		if($fecha_inicio != FAlSE){
			$this->sanatorio->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}
		$query = $this->sanatorio->get();
		return $query->result();
	}
	#13-08-2018 grm 

	function verificarPendienteDeBaja($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_archivo');
		$this->sanatorio->where('usuario_id',$idUsuario);
		$this->sanatorio->where('fecha_termino BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$this->sanatorio->where('estado_proceso',3);
		$query = $this->sanatorio->get();
		if ($query->num_rows >0){
		   return true;
		}else{
		   return false;
		}
	}
	#06-09-2018 // 17-12-18 update grm
	function getNombreRequerimiento($idAreaCargo){
		$this->sanatorio->select('rr.nombre, rr.regimen, rr.f_solicitud, rr.comentario');
		$this->sanatorio->from('r_requerimiento_area_cargo as rac');
		$this->sanatorio->join("r_requerimiento rr","rac.requerimiento_id = rr.id");
		$this->sanatorio->where('rac.id',$idAreaCargo);
		$query = $this->sanatorio->get();
		return $query->row();
	}
	#20-09-2018 
	function guardarMotivoSolicitud($data){
		$this->sanatorio->insert('r_requerimiento_usuario_archivo_observacion',$data); 
	}

	function getMotivoSolicitud($idArchivo){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_archivo_observacion');
		$this->sanatorio->where('id_r_requerimiento_usuario_archivo',$idArchivo);
		$query = $this->sanatorio->get();
		if ($query->num_rows >0){
		   return  $query->row();
		}else{
		   return false;
		}
	}

	function actualizarMotivoSolicitud($id, $data){
		$this->sanatorio->where('id',$id);
		$this->sanatorio->update('r_requerimiento_usuario_archivo_observacion', $data);
	}

	function getDiasTotal($idUsuario,$fecha,$fechaAtras){
		$this->sanatorio->select('id, fecha_inicio');
		$this->sanatorio->from('r_requerimiento_usuario_archivo');
		$this->sanatorio->where('usuario_id',$idUsuario);
		$this->sanatorio->where('id_solicita_bajar',null);
		$this->sanatorio->where('fecha_inicio BETWEEN "'.$fechaAtras. '" and "'. $fecha.'"');
		$this->sanatorio->where('estado_proceso',2);
		$query = $this->sanatorio->get();
		//return $query->result();
		if ($query->num_rows ==7){
		   return  false;
		}else{
		   return true;
		}
	}

	function get_anexos($usuario,$requerimiento){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_anexo');
		$this->sanatorio->where('usuario_id',$usuario);
		$this->sanatorio->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->sanatorio->where("(estado = 0 OR estado =1 OR estado = 2 OR estado = 3 OR estado = 4 OR estado = 6 )");
		$query = $this->sanatorio->get();
		if ($query->num_rows() > 0){
		   return $query->result();
		}else{
		   return 0;
		}
	}

	function verificarSitieneMasDeUnContrato($idUsuario,$fecha){
		$this->sanatorio->select('r_requerimiento_usuario_archivo.id as idArchivo, r_requerimiento_usuario_archivo.fecha_inicio, r_requerimiento_usuario_archivo.usuario_id as idUsuario, rat.requerimiento_area_cargo_id as idAreaCargo, rat.id');
		$this->sanatorio->from('r_requerimiento_usuario_archivo');
		$this->sanatorio->join('r_requerimiento_asc_trabajadores rat','r_requerimiento_usuario_archivo.requerimiento_asc_trabajadores_id = rat.id');
		$this->sanatorio->where('r_requerimiento_usuario_archivo.usuario_id',$idUsuario);
		$this->sanatorio->where('r_requerimiento_usuario_archivo.estado_proceso',2);
		$this->sanatorio->where('r_requerimiento_usuario_archivo.fecha_inicio', $fecha);
		$query = $this->sanatorio->get();
		if ($query->num_rows >=1){
		   return  $query->result();
		}else{
		   return false;
		}
	}
	function get_area_cargo($idArea){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_asc_trabajadores');
		$this->sanatorio->where('r_requerimiento_asc_trabajadores.id',$idArea);
		$query = $this->sanatorio->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}	
	}

	function existe_registro_de_anexo($usuario,$requerimiento,$archivo){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_anexo');
		$this->sanatorio->where('usuario_id',$usuario);
		$this->sanatorio->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->sanatorio->where('tipo_archivo_requerimiento_id',$archivo);
		$this->sanatorio->where("(estado = 0 OR estado =1 OR estado = 2 OR estado = 3 OR estado = 4)");
		$query = $this->sanatorio->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function listar_solicitudes_completas2($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_archivo_solicitudes_contratos req_usu_arch_cont');
		$this->sanatorio->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->sanatorio->join('r_requerimiento_asc_trabajadores req_asc','req_usu_arch.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->sanatorio->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->sanatorio->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->sanatorio->where('req_usu_arch_cont.estado', 1);
//$this->sanatorio->limit(10);
		if($fecha_inicio != FAlSE){
			$this->sanatorio->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}

		$query = $this->sanatorio->get();
		return $query->result();
	}
	function get_contrato($idContrato){
		$this->sanatorio->select('u.nombres, u.paterno, u.materno, u.rut_usuario, r.fecha_termino, ep.nombre as nombrePlanta, r.fecha_termino2');
		$this->sanatorio->from('r_requerimiento_usuario_archivo r');
		$this->sanatorio->join('usuarios u','r.usuario_id = u.id','left');
		$this->sanatorio->join('r_requerimiento_asc_trabajadores rat','r.requerimiento_asc_trabajadores_id = rat.id','left');
		$this->sanatorio->join('r_requerimiento_area_cargo rar','rat.requerimiento_area_cargo_id = rar.id','left');
		$this->sanatorio->join('r_requerimiento req','rar.requerimiento_id = req.id','left');
		$this->sanatorio->join('empresa_planta ep','req.planta_id = ep.id','left');
		$this->sanatorio->where('r.id',$idContrato);
		$query = $this->sanatorio->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}
	function getRequerimienton($id_req){
		$this->sanatorio->where("id",$id_req);
		$query = $this->sanatorio->get('r_requerimiento_area_cargo');
		return $query->row();
	}
	function listar_solicitudes_pendientes_anexo($id_planta = FALSE){
		$this->sanatorio->select('*, anexo.id as idAnexo, anexo.nombres as nombreTrabajador, anexo.rut_usuario as rutTrabajador, anexo.nacionalidad as nacionalidadTrabajador, anexo.fecha_nac as nacimientoTrabajador, anexo.direccion as direccionTrabajador, anexo.ciudad as ciudadTrabajador, anexo.estado_civil as civilTrabajador, anexo.afp as afpTrabajador, anexo.salud as saludTrabajador, anexo.nombre_centro_costo as centroTrabajador, anexo.telefono as telefonoTrabajador, anexo.nivel_estudios as estudioTrabajador, anexo.nombre_banco as bancoTrabajador, anexo.tipo_cuenta as cuentaTrabajador, anexo.cuenta_banco as numeroCuentaTrabajador, anexo.nombre_planta as plantaTrabajador, anexo.fecha_inicio_contrato as fechaInicioContrato, anexo.fecha_termino_contrato_anterior as fechaTerminoContratoAnterior, anexo.fecha_termino_nuevo_anexo as fechaTerminoAnexo, anexo.causal as causalTrabajador');
		$this->sanatorio->from('r_requerimiento_usuario_anexo anexo');
		//$this->sanatorio->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');

		$this->sanatorio->join('r_requerimiento_asc_trabajadores req_asc','anexo.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->sanatorio->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->sanatorio->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->sanatorio->where('anexo.estado', 1);
		if($id_planta != FALSE)
			$this->sanatorio->where('req.planta_id', $id_planta);

		$query = $this->sanatorio->get();
		return $query->result();
	}
	function ingresarAnexo($data){
		$this->sanatorio->insert('r_requerimiento_usuario_anexo',$data); 
	}
	function get_anexos_id($idAnexo){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_usuario_anexo');
		$this->sanatorio->where('id',$idAnexo);
		$query = $this->sanatorio->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}
	function getIdEmpresa($id){
		$this->sanatorio->select('id_centro_costo');
		$this->sanatorio->from('empresa_planta');
		$this->sanatorio->where('id',$id);
		$query = $this->sanatorio->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}
	function actualizarAnexo($id, $data){
		$this->sanatorio->where('id',$id);
		$this->sanatorio->update('r_requerimiento_usuario_anexo', $data);
		return $afftectedRows = $this->sanatorio->affected_rows();
	}
	function marcarAnexoAnteriorComoFinalizado($idUsuario,$idReqAscTrabajadores, $datos){
		$this->sanatorio->where('usuario_id',$idUsuario);
		$this->sanatorio->where('requerimiento_asc_trabajadores_id',$idReqAscTrabajadores);
		$this->sanatorio->where('estado',2);
		$this->sanatorio->update('r_requerimiento_usuario_anexo', $datos);
	}
	function actualizarContrato($idUsuario,$idReqAscTrabajadores, $datos){
		$this->sanatorio->where('usuario_id',$idUsuario);
		$this->sanatorio->where('requerimiento_asc_trabajadores_id',$idReqAscTrabajadores);
		$this->sanatorio->where('tipo_archivo_requerimiento_id',1);
		$this->sanatorio->update('r_requerimiento_usuario_archivo', $datos);
	}
	function insertarAnexoAprobado($data){
		$this->sanatorio->insert('anexos_masivos',$data); 
	}
	function get_ultimo_anexo($usuario,$requerimiento,$archivo){
		$this->sanatorio->select('*, fecha_inicio_contrato as fecha_inicio, fecha_termino_nuevo_anexo as fecha_termino');
		$this->sanatorio->from('r_requerimiento_usuario_anexo');
		$this->sanatorio->where('usuario_id',$usuario);
		$this->sanatorio->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->sanatorio->where('tipo_archivo_requerimiento_id',$archivo);
		$this->sanatorio->where("(estado = 0 OR estado =1 OR estado = 2 OR estado = 3 OR estado = 4)");
		$this->sanatorio->order_by('id','desc');
		$this->sanatorio->limit(1);
		$query = $this->sanatorio->get();
		return $query->row();
	}
	function listar_solicitudes_completas_anexo($id_planta = FALSE, $idUsuario = false){
		$this->sanatorio->select('*, anexo.id as idAnexo, anexo.nombres as nombreTrabajador, anexo.rut_usuario as rutTrabajador, anexo.nacionalidad as nacionalidadTrabajador, anexo.fecha_nac as nacimientoTrabajador, anexo.direccion as direccionTrabajador, anexo.ciudad as ciudadTrabajador, anexo.estado_civil as civilTrabajador, anexo.afp as afpTrabajador, anexo.salud as saludTrabajador, anexo.nombre_centro_costo as centroTrabajador, anexo.telefono as telefonoTrabajador, anexo.nivel_estudios as estudioTrabajador, anexo.nombre_banco as bancoTrabajador, anexo.tipo_cuenta as cuentaTrabajador, anexo.cuenta_banco as numeroCuentaTrabajador, anexo.nombre_planta as plantaTrabajador, anexo.fecha_inicio_contrato as fechaInicioContrato, anexo.fecha_termino_contrato_anterior as fechaTerminoContratoAnterior, anexo.fecha_termino_nuevo_anexo as fechaTerminoAnexo, anexo.causal as causalTrabajador');
		$this->sanatorio->from('r_requerimiento_usuario_anexo anexo');
		//$this->sanatorio->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->sanatorio->join('r_requerimiento_asc_trabajadores req_asc','anexo.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->sanatorio->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->sanatorio->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->sanatorio->where('anexo.estado', 2);
		if($id_planta != FALSE)
			$this->sanatorio->where('req.planta_id', $id_planta);
		if($idUsuario != FALSE)
			$this->sanatorio->where('anexo.id_quien_solicita', $idUsuario);
		$query = $this->sanatorio->get();
		return $query->result();
	}
	function get_anexo($idAnexo){
		$this->sanatorio->select('u.nombres, u.paterno, u.materno, u.rut_usuario, r.fecha_termino_nuevo_anexo as fecha_termino, r.nombre_planta as nombrePlanta, r.fecha_termino2');
		$this->sanatorio->from('r_requerimiento_usuario_anexo r');
		$this->sanatorio->join('usuarios u ','r.usuario_id = u.id','inner');
		$this->sanatorio->where('r.id',$idAnexo);
		$query = $this->sanatorio->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}
	function insertarContratoAprobado($data){
		$this->sanatorio->insert('contratos_masivos',$data); 
	}
	function getNombreTrabajador($idAnexo){
		$this->sanatorio->select("CONCAT(u.nombres,' ', u.paterno,' ', u.materno) as nombreTrabajador, u.nombres as name",FALSE);
		$this->sanatorio->from('r_requerimiento_usuario_archivo r');
		$this->sanatorio->join('usuarios u ','r.usuario_id = u.id','inner');
		$this->sanatorio->where('r.id',$idAnexo);
		$query = $this->sanatorio->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}

}
?>