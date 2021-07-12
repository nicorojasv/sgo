<?php
class Requerimiento_Usuario_Archivo_model extends CI_Model {

	function __construct(){
		$this->marina = $this->load->database('marina', TRUE);
	}

	function ingresar_solicitud_contrato($data){
		$this->marina->insert('r_requerimiento_usuario_archivo_solicitudes_contratos',$data); 
		return $this->marina->insert_id();
	}

	function actualizar_solicitud_contrato($id_req_usu_arch, $datos){
		$this->marina->where('id_req_usu_arch',$id_req_usu_arch);
		$this->marina->update('r_requerimiento_usuario_archivo_solicitudes_contratos', $datos);
	}

	function get_solicitud_contrato_tipo_proceso($id_usu_arch, $tipo_proceso = FAlSE){
		$this->marina->select('*');
		$this->marina->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->marina->where('id_req_usu_arch',$id_usu_arch);

		if($tipo_proceso != FAlSE)
			$this->marina->where('estado',$tipo_proceso);

		$query = $this->marina->get();
		return $query->row();
	}
	
	function ingresar_solicitud_contrato_historial($data){
		$this->marina->insert('r_requerimiento_usuario_archivo_solicitudes_contratos_historial',$data); 
	}

	function get_proceso_contrato_tipo($id_usu_arch, $tipo_proceso = FAlSE){
		$this->marina->select('*');
		$this->marina->from('r_requerimiento_usuario_archivo');
		$this->marina->where('id',$id_usu_arch);

		if($tipo_proceso != FAlSE)
			$this->marina->where('estado_proceso',$tipo_proceso);

		$query = $this->marina->get();
		return $query->row();
	}

	function get_solicitud_contrato($id, $tipo_proceso = FALSE){
		$this->marina->select('*');
		$this->marina->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->marina->where('id_req_usu_arch',$id);/////////
		if($tipo_proceso != FAlSE)
			$this->marina->where('estado',$tipo_proceso);
		$query = $this->marina->get();
		return $query->row();
	}

	function listar_solicitudes_pendientes(){
		$this->marina->select('*');
		$this->marina->from('r_requerimiento_usuario_archivo');
		$this->marina->where('estado_proceso',1);
		$query = $this->marina->get();
		return $query->result();
	}

	function listar_solicitudes_completas($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->marina->select('*');
		$this->marina->from('r_requerimiento_usuario_archivo');
		$this->marina->where('estado_proceso',2);
		if($fecha_inicio != FAlSE){
			$this->marina->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}
		//$this->marina->limit(10);
		$query = $this->marina->get();
		return $query->result();
	}

	function get($id){
		$this->marina->where('id',$id);
		$query = $this->marina->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function get_result($id){
		$this->marina->where('id',$id);
		$query = $this->marina->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_archivos_req($id_asc_trab){
		$this->marina->select('*');
		$this->marina->from('r_requerimiento_usuario_archivo');
		$this->marina->where('requerimiento_asc_trabajadores_id',$id_asc_trab);
		$this->marina->where('tipo_archivo_requerimiento_id', '1');
		//$this->marina->where('tipo_archivo_requerimiento_id', '1'.' or tipo_archivo_requerimiento_id', '2');
		$query = $this->marina->get();
		return $query->row();
	}

	function get_usuario_requerimiento($usuario,$requerimiento){
		$this->marina->where('usuario_id',$usuario);
		$this->marina->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$query = $this->marina->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_requerimiento_archivo($usuario,$requerimiento,$archivo){
		$this->marina->where('usuario_id',$usuario);
		$this->marina->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->marina->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->marina->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_requerimiento_archivo_limit_row($usuario,$requerimiento,$archivo){
		$this->marina->where('usuario_id',$usuario);
		$this->marina->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->marina->where('tipo_archivo_requerimiento_id',$archivo);
		$this->marina->order_by('id','desc');
		$this->marina->limit(1);
		$query = $this->marina->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function get_usuario_requerimiento_archivo_limit($usuario,$requerimiento,$archivo){
		$this->marina->where('usuario_id',$usuario);
		$this->marina->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->marina->where('tipo_archivo_requerimiento_id',$archivo);
		$this->marina->limit(1);
		$query = $this->marina->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_archivos($usuario,$tipo_archivo){
		$this->marina->where('usuario_id',$usuario);
		$this->marina->where('tipo_archivo_requerimiento_id',$tipo_archivo);
		$query = $this->marina->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function existe_registro_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->marina->select('*');
		$this->marina->from('r_requerimiento_usuario_archivo');
		$this->marina->where('usuario_id',$usuario);
		$this->marina->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->marina->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->marina->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function get_result_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->marina->select('*');
		$this->marina->from('r_requerimiento_usuario_archivo');
		$this->marina->where('usuario_id',$usuario);
		$this->marina->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->marina->where('tipo_archivo_requerimiento_id',$archivo);
		$this->marina->where('fecha_aprobacion_baja',null);// si posee esta fecha es porque ya se a dado de baja 
		$query = $this->marina->get();
		if ($query->num_rows >0){
		   return $query->result();
		}else{
		   return 0;
		}
	}

	function get_usuario_requerimiento_datos($usuario,$requerimiento, $archivo){
		$this->marina->where('usuario_id',$usuario);
		$this->marina->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->marina->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->marina->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function consultar_si_existe_req($usuario, $requerimiento, $archivo){
		$this->marina->SELECT('*');
		$this->marina->from('r_requerimiento_usuario_archivo');
		$this->marina->where('usuario_id',$usuario);
		$this->marina->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->marina->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->marina->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function actualizar_usu_arch($id, $datos){
		$this->marina->where('id',$id);
		$this->marina->update('r_requerimiento_usuario_archivo', $datos);
	}

	function actualizar_req($usuario, $requerimiento, $archivo, $datos){
		$this->marina->where('usuario_id',$usuario);
		$this->marina->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->marina->where('tipo_archivo_requerimiento_id',$archivo);
		$this->marina->update('r_requerimiento_usuario_archivo', $datos);
	}

	function get_requerimiento($id){
		$this->marina->select("");
		$this->marina->from("r_requerimiento_usuario_archivo rua");
		$this->marina->join("r_requerimiento_asc_trabajadores rat","rua.requerimiento_asc_trabajadores_id = rat.id");
		$this->marina->join("r_requerimiento_area_cargo rac","rac.id = rat.requerimiento_area_cargo_id");
		$this->marina->where('rua.id',$id);
		$query = $this->marina->get();
		return $query->row();
	}

	function listar(){
		$query = $this->marina->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function ingresar($data){
		$this->marina->insert('r_requerimiento_usuario_archivo',$data); 
	}

	function eliminar($id){
		$this->marina->delete('r_requerimiento_usuario_archivo', array('id' => $id)); 
	}

	function listar_usuarios_contrato_vencido(){
		$this->marina->select("");
		$this->marina->from("r_requerimiento_usuario_archivo");
		$this->marina->where('tipo_archivo_requerimiento_id',1);
		$this->marina->where('fecha_termino <', date('Y-m-d'));
		$query = $this->marina->get();
		return $query->result();
	}

	#05-07-2018
	function getIdUsuarioContrato($id_usu_arch){
		$this->marina->select("*");
		$this->marina->from("r_requerimiento_usuario_archivo");
		$this->marina->where('r_requerimiento_usuario_archivo.id',$id_usu_arch);
		$query = $this->marina->get();
		return $query->row();
	}

	#06-05-2018 
	function getCodigoContrato($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda){
		$this->marina->select('*');
		$this->marina->from("r_requerimiento_usuario_archivo");
		$this->marina->where('usuario_id',$idUsuario);
		$this->marina->where('(estado_proceso = 2 OR estado_proceso = 3)');// donde 2 significa contratos ya generados
		$this->marina->where('id_tipo_contrato',1);// donde 1 significa contrato diario
		$this->marina->where('fecha_inicio BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$query = $this->marina->get();
		if ($query->num_rows >0){
			return $query->result();
		}else{
		   return false;
		}
	}

	function getCodigoDisponible($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda ){
		$this->marina->select('id, codigoLibre');
		$this->marina->from('codigo_libre');
		$this->marina->where('usuario_id',$idUsuario);
		$this->marina->where('estado',0);//0 disponible para usar 
		$this->marina->where('fechaRegistro BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$query = $this->marina->get();
		if ($query->num_rows >0){
		   return $query->row();
		}else{
		   return false;
		}
	}

	function actualizarCodigoLibre($id , $data){
		$this->marina->where('id',$id);
		$this->marina->update('codigo_libre', $data);
	}

	function getLetraAbecedario($id){
		$this->marina->select('id , letraAbecedario as letra');
		$this->marina->from('abecedario');
		$this->marina->where('id',$id);
		$query = $this->marina->get();
		return $query->row();
	}

	function listar_solicitudes_pendientes_baja(){
		$this->marina->select('*');
		$this->marina->from('r_requerimiento_usuario_archivo');
		$this->marina->where('estado_proceso',3);
		$query = $this->marina->get();
		return $query->result();
	}

	function guardar_codigo_libre($data){
		$this->marina->insert('codigo_libre',$data); 

	}

	function listar_solicitudes_completas_baja($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->marina->select('*');
		$this->marina->from('r_requerimiento_usuario_archivo');
		$this->marina->where('estado_proceso',5);
		if($fecha_inicio != FAlSE){
			$this->marina->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}
		$query = $this->marina->get();
		return $query->result();
	}
	#13-08-2018 grm 

	function verificarPendienteDeBaja($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda){
		$this->marina->select('*');
		$this->marina->from('r_requerimiento_usuario_archivo');
		$this->marina->where('usuario_id',$idUsuario);
		$this->marina->where('fecha_termino BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$this->marina->where('estado_proceso',3);
		$query = $this->marina->get();
		if ($query->num_rows >0){
		   return true;
		}else{
		   return false;
		}
	}
	#06-09-2018 // 17-12-18 update grm
	function getNombreRequerimiento($idAreaCargo){
		$this->marina->select('rr.nombre, rr.regimen, rr.f_solicitud, rr.comentario');
		$this->marina->from('r_requerimiento_area_cargo as rac');
		$this->marina->join("r_requerimiento rr","rac.requerimiento_id = rr.id");
		$this->marina->where('rac.id',$idAreaCargo);
		$query = $this->marina->get();
		return $query->row();
	}
	#20-09-2018 
	function guardarMotivoSolicitud($data){
		$this->marina->insert('r_requerimiento_usuario_archivo_observacion',$data); 
	}

	function getMotivoSolicitud($idArchivo){
		$this->marina->select('*');
		$this->marina->from('r_requerimiento_usuario_archivo_observacion');
		$this->marina->where('id_r_requerimiento_usuario_archivo',$idArchivo);
		$query = $this->marina->get();
		if ($query->num_rows >0){
		   return  $query->row();
		}else{
		   return false;
		}
	}

	function actualizarMotivoSolicitud($id, $data){
		$this->marina->where('id',$id);
		$this->marina->update('r_requerimiento_usuario_archivo_observacion', $data);
	}

	function getDiasTotal($idUsuario,$fecha,$fechaAtras){
		$this->marina->select('id, fecha_inicio');
		$this->marina->from('r_requerimiento_usuario_archivo');
		$this->marina->where('usuario_id',$idUsuario);
		$this->marina->where('estado_proceso',2);
		$this->marina->where('fecha_inicio BETWEEN "'.$fechaAtras. '" and "'. $fecha.'"');
		$query = $this->marina->get();
		//return $query->result();
		if ($query->num_rows ==7){
		   return  false;
		}else{
		   return true;
		}
	}

	function verificarSitieneMasDeUnContrato($idUsuario,$fecha){
		$this->marina->select('r_requerimiento_usuario_archivo.id as idArchivo, r_requerimiento_usuario_archivo.fecha_inicio, r_requerimiento_usuario_archivo.usuario_id as idUsuario, rat.requerimiento_area_cargo_id as idAreaCargo, rat.id');
		$this->marina->from('r_requerimiento_usuario_archivo');
		$this->marina->join('r_requerimiento_asc_trabajadores rat','r_requerimiento_usuario_archivo.requerimiento_asc_trabajadores_id = rat.id');
		$this->marina->where('r_requerimiento_usuario_archivo.usuario_id',$idUsuario);
		$this->marina->where('r_requerimiento_usuario_archivo.estado_proceso',2);
		$this->marina->where('r_requerimiento_usuario_archivo.fecha_inicio', $fecha);
		$query = $this->marina->get();
		//return $query->result();
		if ($query->num_rows >=1){
		   return  $query->result();
		}else{
		   return false;
		}
	}

}
?>