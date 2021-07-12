<?php
class Requerimiento_Usuario_Archivo_model extends CI_Model {

	function __construct(){
		$this->enjoy = $this->load->database('enjoy', TRUE);
	}

	function ingresar_solicitud_contrato($data){
		$this->enjoy->insert('r_requerimiento_usuario_archivo_solicitudes_contratos',$data); 
		return $this->enjoy->insert_id();
	}

	function actualizar_solicitud_contrato($id_req_usu_arch, $datos){
		$this->enjoy->where('id_req_usu_arch',$id_req_usu_arch);
		$this->enjoy->update('r_requerimiento_usuario_archivo_solicitudes_contratos', $datos);
	}

	function get_solicitud_contrato_tipo_proceso($id_usu_arch, $tipo_proceso = FAlSE){
		$this->enjoy->select('*');
		$this->enjoy->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->enjoy->where('id_req_usu_arch',$id_usu_arch);

		if($tipo_proceso != FAlSE)
			$this->enjoy->where('estado',$tipo_proceso);

		$query = $this->enjoy->get();
		return $query->row();
	}
	
	function ingresar_solicitud_contrato_historial($data){
		$this->enjoy->insert('r_requerimiento_usuario_archivo_solicitudes_contratos_historial',$data); 
	}

	function get_proceso_contrato_tipo($id_usu_arch, $tipo_proceso = FAlSE){
		$this->enjoy->select('*');
		$this->enjoy->from('r_requerimiento_usuario_archivo');
		$this->enjoy->where('id',$id_usu_arch);

		if($tipo_proceso != FAlSE)
			$this->enjoy->where('estado_proceso',$tipo_proceso);

		$query = $this->enjoy->get();
		return $query->row();
	}

	function get_solicitud_contrato($id, $tipo_proceso = FALSE){
		$this->enjoy->select('*');
		$this->enjoy->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->enjoy->where('id_req_usu_arch',$id);/////////
		if($tipo_proceso != FAlSE)
			$this->enjoy->where('estado',$tipo_proceso);
		$query = $this->enjoy->get();
		return $query->row();
	}

	function listar_solicitudes_pendientes(){
		$this->enjoy->select('*');
		$this->enjoy->from('r_requerimiento_usuario_archivo');
		$this->enjoy->where('estado_proceso',1);
		$query = $this->enjoy->get();
		return $query->result();
	}

	function listar_solicitudes_completas($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->enjoy->select('*');
		$this->enjoy->from('r_requerimiento_usuario_archivo');
		$this->enjoy->where('estado_proceso',2);
		if($fecha_inicio != FAlSE){
			$this->enjoy->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}
		//$this->enjoy->limit(10);
		$query = $this->enjoy->get();
		return $query->result();
	}

	function get($id){
		$this->enjoy->where('id',$id);
		$query = $this->enjoy->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function get_result($id){
		$this->enjoy->where('id',$id);
		$query = $this->enjoy->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_archivos_req($id_asc_trab){
		$this->enjoy->select('*');
		$this->enjoy->from('r_requerimiento_usuario_archivo');
		$this->enjoy->where('requerimiento_asc_trabajadores_id',$id_asc_trab);
		$this->enjoy->where('tipo_archivo_requerimiento_id', '1');
		//$this->enjoy->where('tipo_archivo_requerimiento_id', '1'.' or tipo_archivo_requerimiento_id', '2');
		$query = $this->enjoy->get();
		return $query->row();
	}

	function get_usuario_requerimiento($usuario,$requerimiento){
		$this->enjoy->where('usuario_id',$usuario);
		$this->enjoy->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$query = $this->enjoy->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_requerimiento_archivo($usuario,$requerimiento,$archivo){
		$this->enjoy->where('usuario_id',$usuario);
		$this->enjoy->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->enjoy->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->enjoy->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_requerimiento_archivo_limit_row($usuario,$requerimiento,$archivo){
		$this->enjoy->where('usuario_id',$usuario);
		$this->enjoy->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->enjoy->where('tipo_archivo_requerimiento_id',$archivo);
		$this->enjoy->order_by('id','desc');
		$this->enjoy->limit(1);
		$query = $this->enjoy->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function get_usuario_requerimiento_archivo_limit($usuario,$requerimiento,$archivo){
		$this->enjoy->where('usuario_id',$usuario);
		$this->enjoy->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->enjoy->where('tipo_archivo_requerimiento_id',$archivo);
		$this->enjoy->limit(1);
		$query = $this->enjoy->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_archivos($usuario,$tipo_archivo){
		$this->enjoy->where('usuario_id',$usuario);
		$this->enjoy->where('tipo_archivo_requerimiento_id',$tipo_archivo);
		$query = $this->enjoy->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function existe_registro_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->enjoy->select('*');
		$this->enjoy->from('r_requerimiento_usuario_archivo');
		$this->enjoy->where('usuario_id',$usuario);
		$this->enjoy->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->enjoy->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->enjoy->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function get_result_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->enjoy->select('*');
		$this->enjoy->from('r_requerimiento_usuario_archivo');
		$this->enjoy->where('usuario_id',$usuario);
		$this->enjoy->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->enjoy->where('tipo_archivo_requerimiento_id',$archivo);
		$this->enjoy->where('fecha_aprobacion_baja',null);// si posee esta fecha es porque ya se a dado de baja 
		$query = $this->enjoy->get();
		if ($query->num_rows >0){
		   return $query->result();
		}else{
		   return 0;
		}
	}

	function get_usuario_requerimiento_datos($usuario,$requerimiento, $archivo){
		$this->enjoy->where('usuario_id',$usuario);
		$this->enjoy->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->enjoy->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->enjoy->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function consultar_si_existe_req($usuario, $requerimiento, $archivo){
		$this->enjoy->SELECT('*');
		$this->enjoy->from('r_requerimiento_usuario_archivo');
		$this->enjoy->where('usuario_id',$usuario);
		$this->enjoy->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->enjoy->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->enjoy->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function actualizar_usu_arch($id, $datos){
		$this->enjoy->where('id',$id);
		$this->enjoy->update('r_requerimiento_usuario_archivo', $datos);
	}

	function actualizar_req($usuario, $requerimiento, $archivo, $datos){
		$this->enjoy->where('usuario_id',$usuario);
		$this->enjoy->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->enjoy->where('tipo_archivo_requerimiento_id',$archivo);
		$this->enjoy->update('r_requerimiento_usuario_archivo', $datos);
	}

	function get_requerimiento($id){
		$this->enjoy->select("");
		$this->enjoy->from("r_requerimiento_usuario_archivo rua");
		$this->enjoy->join("r_requerimiento_asc_trabajadores rat","rua.requerimiento_asc_trabajadores_id = rat.id");
		$this->enjoy->join("r_requerimiento_area_cargo rac","rac.id = rat.requerimiento_area_cargo_id");
		$this->enjoy->where('rua.id',$id);
		$query = $this->enjoy->get();
		return $query->row();
	}

	function listar(){
		$query = $this->enjoy->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function ingresar($data){
		$this->enjoy->insert('r_requerimiento_usuario_archivo',$data); 
	}

	function eliminar($id){
		$this->enjoy->delete('r_requerimiento_usuario_archivo', array('id' => $id)); 
	}

	function listar_usuarios_contrato_vencido(){
		$this->enjoy->select("");
		$this->enjoy->from("r_requerimiento_usuario_archivo");
		$this->enjoy->where('tipo_archivo_requerimiento_id',1);
		$this->enjoy->where('fecha_termino <', date('Y-m-d'));
		$query = $this->enjoy->get();
		return $query->result();
	}

	#05-07-2018
	function getIdUsuarioContrato($id_usu_arch){
		$this->enjoy->select("*");
		$this->enjoy->from("r_requerimiento_usuario_archivo");
		$this->enjoy->where('r_requerimiento_usuario_archivo.id',$id_usu_arch);
		$query = $this->enjoy->get();
		return $query->row();
	}

	#06-05-2018 
	function getCodigoContrato($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda){
		$this->enjoy->select('*');
		$this->enjoy->from("r_requerimiento_usuario_archivo");
		$this->enjoy->where('usuario_id',$idUsuario);
		$this->enjoy->where('(estado_proceso = 2 OR estado_proceso = 3)');// donde 2 significa contratos ya generados
		$this->enjoy->where('id_tipo_contrato',1);// donde 1 significa contrato diario
		$this->enjoy->where('fecha_inicio BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$query = $this->enjoy->get();
		if ($query->num_rows >0){
			return $query->result();
		}else{
		   return false;
		}
	}

	function getCodigoDisponible($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda ){
		$this->enjoy->select('id, codigoLibre');
		$this->enjoy->from('codigo_libre');
		$this->enjoy->where('usuario_id',$idUsuario);
		$this->enjoy->where('estado',0);//0 disponible para usar 
		$this->enjoy->where('fechaRegistro BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$query = $this->enjoy->get();
		if ($query->num_rows >0){
		   return $query->row();
		}else{
		   return false;
		}
	}

	function actualizarCodigoLibre($id , $data){
		$this->enjoy->where('id',$id);
		$this->enjoy->update('codigo_libre', $data);
	}

	function getLetraAbecedario($id){
		$this->enjoy->select('id , letraAbecedario as letra');
		$this->enjoy->from('abecedario');
		$this->enjoy->where('id',$id);
		$query = $this->enjoy->get();
		return $query->row();
	}

	function listar_solicitudes_pendientes_baja(){
		$this->enjoy->select('*');
		$this->enjoy->from('r_requerimiento_usuario_archivo');
		$this->enjoy->where('estado_proceso',3);
		$query = $this->enjoy->get();
		return $query->result();
	}

	function guardar_codigo_libre($data){
		$this->enjoy->insert('codigo_libre',$data); 

	}

	function listar_solicitudes_completas_baja($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->enjoy->select('*');
		$this->enjoy->from('r_requerimiento_usuario_archivo');
		$this->enjoy->where('estado_proceso',5);
		if($fecha_inicio != FAlSE){
			$this->enjoy->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}
		$query = $this->enjoy->get();
		return $query->result();
	}
	#13-08-2018 grm 

	function verificarPendienteDeBaja($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda){
		$this->enjoy->select('*');
		$this->enjoy->from('r_requerimiento_usuario_archivo');
		$this->enjoy->where('usuario_id',$idUsuario);
		$this->enjoy->where('fecha_termino BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$this->enjoy->where('estado_proceso',3);
		$query = $this->enjoy->get();
		if ($query->num_rows >0){
		   return true;
		}else{
		   return false;
		}
	}
	#06-09-2018 // 17-12-18 update grm
	function getNombreRequerimiento($idAreaCargo){
		$this->enjoy->select('rr.nombre, rr.regimen, rr.f_solicitud, rr.comentario');
		$this->enjoy->from('r_requerimiento_area_cargo as rac');
		$this->enjoy->join("r_requerimiento rr","rac.requerimiento_id = rr.id");
		$this->enjoy->where('rac.id',$idAreaCargo);
		$query = $this->enjoy->get();
		return $query->row();
	}
	#20-09-2018 
	function guardarMotivoSolicitud($data){
		$this->enjoy->insert('r_requerimiento_usuario_archivo_observacion',$data); 
	}

	function getMotivoSolicitud($idArchivo){
		$this->enjoy->select('*');
		$this->enjoy->from('r_requerimiento_usuario_archivo_observacion');
		$this->enjoy->where('id_r_requerimiento_usuario_archivo',$idArchivo);
		$query = $this->enjoy->get();
		if ($query->num_rows >0){
		   return  $query->row();
		}else{
		   return false;
		}
	}

	function actualizarMotivoSolicitud($id, $data){
		$this->enjoy->where('id',$id);
		$this->enjoy->update('r_requerimiento_usuario_archivo_observacion', $data);
	}

	function getDiasTotal($idUsuario,$fecha,$fechaAtras){
		$this->enjoy->select('id, fecha_inicio');
		$this->enjoy->from('r_requerimiento_usuario_archivo');
		$this->enjoy->where('usuario_id',$idUsuario);
		$this->enjoy->where('id_solicita_bajar',null);
		$this->enjoy->where('fecha_inicio BETWEEN "'.$fechaAtras. '" and "'. $fecha.'"');
		$this->enjoy->where('estado_proceso',2);
		$query = $this->enjoy->get();
		//return $query->result();
		if ($query->num_rows ==7){
		   return  false;
		}else{
		   return true;
		}
	}

	function verificarSitieneMasDeUnContrato($idUsuario,$fecha){
		$this->enjoy->select('r_requerimiento_usuario_archivo.id as idArchivo, r_requerimiento_usuario_archivo.fecha_inicio, r_requerimiento_usuario_archivo.usuario_id as idUsuario, rat.requerimiento_area_cargo_id as idAreaCargo, rat.id');
		$this->enjoy->from('r_requerimiento_usuario_archivo');
		$this->enjoy->join('r_requerimiento_asc_trabajadores rat','r_requerimiento_usuario_archivo.requerimiento_asc_trabajadores_id = rat.id');
		$this->enjoy->where('r_requerimiento_usuario_archivo.usuario_id',$idUsuario);
		$this->enjoy->where('r_requerimiento_usuario_archivo.estado_proceso',2);
		$this->enjoy->where('r_requerimiento_usuario_archivo.fecha_inicio', $fecha);
		$query = $this->enjoy->get();
		if ($query->num_rows >=1){
		   return  $query->result();
		}else{
		   return false;
		}
	}

}
?>