<?php
class Requerimiento_Usuario_Archivo_model extends CI_Model {

	function __construct(){
		$this->aramark = $this->load->database('aramark', TRUE);
	}

	function ingresar_solicitud_contrato($data){
		$this->aramark->insert('r_requerimiento_usuario_archivo_solicitudes_contratos',$data); 
		return $this->aramark->insert_id();
	}

	function actualizar_solicitud_contrato($id_req_usu_arch, $datos){
		$this->aramark->where('id_req_usu_arch',$id_req_usu_arch);
		$this->aramark->update('r_requerimiento_usuario_archivo_solicitudes_contratos', $datos);
	}

	function get_solicitud_contrato_tipo_proceso($id_usu_arch, $tipo_proceso = FAlSE){
		$this->aramark->select('*');
		$this->aramark->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->aramark->where('id_req_usu_arch',$id_usu_arch);

		if($tipo_proceso != FAlSE)
			$this->aramark->where('estado',$tipo_proceso);

		$query = $this->aramark->get();
		return $query->row();
	}
	
	function ingresar_solicitud_contrato_historial($data){
		$this->aramark->insert('r_requerimiento_usuario_archivo_solicitudes_contratos_historial',$data); 
	}

	function get_proceso_contrato_tipo($id_usu_arch, $tipo_proceso = FAlSE){
		$this->aramark->select('*');
		$this->aramark->from('r_requerimiento_usuario_archivo');
		$this->aramark->where('id',$id_usu_arch);

		if($tipo_proceso != FAlSE)
			$this->aramark->where('estado_proceso',$tipo_proceso);

		$query = $this->aramark->get();
		return $query->row();
	}

	function get_solicitud_contrato($id, $tipo_proceso = FALSE){
		$this->aramark->select('*');
		$this->aramark->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->aramark->where('id_req_usu_arch',$id);/////////
		if($tipo_proceso != FAlSE)
			$this->aramark->where('estado',$tipo_proceso);
		$query = $this->aramark->get();
		return $query->row();
	}

	function listar_solicitudes_pendientes(){
		$this->aramark->select('*');
		$this->aramark->from('r_requerimiento_usuario_archivo');
		$this->aramark->where('estado_proceso',1);
		$query = $this->aramark->get();
		return $query->result();
	}

	function listar_solicitudes_completas($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->aramark->select('*');
		$this->aramark->from('r_requerimiento_usuario_archivo');
		$this->aramark->where('estado_proceso',2);
		if($fecha_inicio != FAlSE){
			$this->aramark->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}
		//$this->aramark->limit(20);
		$query = $this->aramark->get();
		return $query->result();
	}

	function get($id){
		$this->aramark->where('id',$id);
		$query = $this->aramark->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function get_result($id){
		$this->aramark->where('id',$id);
		$query = $this->aramark->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_archivos_req($id_asc_trab){
		$this->aramark->select('*');
		$this->aramark->from('r_requerimiento_usuario_archivo');
		$this->aramark->where('requerimiento_asc_trabajadores_id',$id_asc_trab);
		$this->aramark->where('tipo_archivo_requerimiento_id', '1');
		//$this->aramark->where('tipo_archivo_requerimiento_id', '1'.' or tipo_archivo_requerimiento_id', '2');
		$query = $this->aramark->get();
		return $query->row();
	}

	function get_usuario_requerimiento($usuario,$requerimiento){
		$this->aramark->where('usuario_id',$usuario);
		$this->aramark->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$query = $this->aramark->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_requerimiento_archivo($usuario,$requerimiento,$archivo){
		$this->aramark->where('usuario_id',$usuario);
		$this->aramark->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->aramark->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->aramark->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_requerimiento_archivo_limit_row($usuario,$requerimiento,$archivo){
		$this->aramark->where('usuario_id',$usuario);
		$this->aramark->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->aramark->where('tipo_archivo_requerimiento_id',$archivo);
		$this->aramark->order_by('id','desc');
		$this->aramark->limit(1);
		$query = $this->aramark->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function get_usuario_requerimiento_archivo_limit($usuario,$requerimiento,$archivo){
		$this->aramark->where('usuario_id',$usuario);
		$this->aramark->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->aramark->where('tipo_archivo_requerimiento_id',$archivo);
		$this->aramark->limit(1);
		$query = $this->aramark->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_archivos($usuario,$tipo_archivo){
		$this->aramark->where('usuario_id',$usuario);
		$this->aramark->where('tipo_archivo_requerimiento_id',$tipo_archivo);
		$query = $this->aramark->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function existe_registro_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->aramark->select('*');
		$this->aramark->from('r_requerimiento_usuario_archivo');
		$this->aramark->where('usuario_id',$usuario);
		$this->aramark->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->aramark->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->aramark->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function get_result_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->aramark->select('*');
		$this->aramark->from('r_requerimiento_usuario_archivo');
		$this->aramark->where('usuario_id',$usuario);
		$this->aramark->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->aramark->where('tipo_archivo_requerimiento_id',$archivo);
		$this->aramark->where('fecha_aprobacion_baja',null);// si posee esta fecha es porque ya se a dado de baja 
		$query = $this->aramark->get();
		if ($query->num_rows >0){
		   return $query->result();
		}else{
		   return 0;
		}
	}

	function get_usuario_requerimiento_datos($usuario,$requerimiento, $archivo){
		$this->aramark->where('usuario_id',$usuario);
		$this->aramark->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->aramark->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->aramark->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function consultar_si_existe_req($usuario, $requerimiento, $archivo){
		$this->aramark->SELECT('*');
		$this->aramark->from('r_requerimiento_usuario_archivo');
		$this->aramark->where('usuario_id',$usuario);
		$this->aramark->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->aramark->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->aramark->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function actualizar_usu_arch($id, $datos){
		$this->aramark->where('id',$id);
		$this->aramark->update('r_requerimiento_usuario_archivo', $datos);
	}

	function actualizar_req($usuario, $requerimiento, $archivo, $datos){
		$this->aramark->where('usuario_id',$usuario);
		$this->aramark->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->aramark->where('tipo_archivo_requerimiento_id',$archivo);
		$this->aramark->update('r_requerimiento_usuario_archivo', $datos);
	}

	function get_requerimiento($id){
		$this->aramark->select("");
		$this->aramark->from("r_requerimiento_usuario_archivo rua");
		$this->aramark->join("r_requerimiento_asc_trabajadores rat","rua.requerimiento_asc_trabajadores_id = rat.id");
		$this->aramark->join("r_requerimiento_area_cargo rac","rac.id = rat.requerimiento_area_cargo_id");
		$this->aramark->where('rua.id',$id);
		$query = $this->aramark->get();
		return $query->row();
	}

	function listar(){
		$query = $this->aramark->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function ingresar($data){
		$this->aramark->insert('r_requerimiento_usuario_archivo',$data); 
	}

	function eliminar($id){
		$this->aramark->delete('r_requerimiento_usuario_archivo', array('id' => $id)); 
	}

	function listar_usuarios_contrato_vencido(){
		$this->aramark->select("");
		$this->aramark->from("r_requerimiento_usuario_archivo");
		$this->aramark->where('tipo_archivo_requerimiento_id',1);
		$this->aramark->where('fecha_termino <', date('Y-m-d'));
		$query = $this->aramark->get();
		return $query->result();
	}

	#05-07-2018
	function getIdUsuarioContrato($id_usu_arch){
		$this->aramark->select("*");
		$this->aramark->from("r_requerimiento_usuario_archivo");
		$this->aramark->where('r_requerimiento_usuario_archivo.id',$id_usu_arch);
		$query = $this->aramark->get();
		return $query->row();
	}

	#06-05-2018 
	function getCodigoContrato($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda){
		$this->aramark->select('*');
		$this->aramark->from("r_requerimiento_usuario_archivo");
		$this->aramark->where('usuario_id',$idUsuario);
		$this->aramark->where('(estado_proceso = 2 OR estado_proceso = 3)');// donde 2 significa contratos ya generados
		$this->aramark->where('id_tipo_contrato',1);// donde 1 significa contrato diario
		$this->aramark->where('fecha_inicio BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$query = $this->aramark->get();
		if ($query->num_rows >0){
			return $query->result();
		}else{
		   return false;
		}
	}

	function getCodigoDisponible($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda ){
		$this->aramark->select('id, codigoLibre');
		$this->aramark->from('codigo_libre');
		$this->aramark->where('usuario_id',$idUsuario);
		$this->aramark->where('estado',0);//0 disponible para usar 
		$this->aramark->where('fechaRegistro BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$query = $this->aramark->get();
		if ($query->num_rows >0){
		   return $query->row();
		}else{
		   return false;
		}
	}

	function actualizarCodigoLibre($id , $data){
		$this->aramark->where('id',$id);
		$this->aramark->update('codigo_libre', $data);
	}

	function getLetraAbecedario($id){
		$this->aramark->select('id , letraAbecedario as letra');
		$this->aramark->from('abecedario');
		$this->aramark->where('id',$id);
		$query = $this->aramark->get();
		return $query->row();
	}

	function listar_solicitudes_pendientes_baja(){
		$this->aramark->select('*');
		$this->aramark->from('r_requerimiento_usuario_archivo');
		$this->aramark->where('estado_proceso',3);
		$query = $this->aramark->get();
		return $query->result();
	}

	function guardar_codigo_libre($data){
		$this->aramark->insert('codigo_libre',$data); 

	}

	function listar_solicitudes_completas_baja(){
		$this->aramark->select('*');
		$this->aramark->from('r_requerimiento_usuario_archivo');
		$this->aramark->where('estado_proceso',5);
		$query = $this->aramark->get();
		return $query->result();
	}
	#13-08-2018 grm 

	function verificarPendienteDeBaja($idUsuario, $fechaInicioBusqueda, $fechaTerminoBusqueda){
		$this->aramark->select('*');
		$this->aramark->from('r_requerimiento_usuario_archivo');
		$this->aramark->where('usuario_id',$idUsuario);
		$this->aramark->where('fecha_termino BETWEEN "'.$fechaInicioBusqueda. '" and "'. $fechaTerminoBusqueda.'"');
		$this->aramark->where('estado_proceso',3);
		$query = $this->aramark->get();
		if ($query->num_rows >0){
		   return true;
		}else{
		   return false;
		}
	}
	#06-09-2018 grm
	function getNombreRequerimiento($idAreaCargo){
		$this->aramark->select('rr.nombre');
		$this->aramark->from('r_requerimiento_area_cargo as rac');
		$this->aramark->join("r_requerimiento rr","rac.requerimiento_id = rr.id");
		$this->aramark->where('rac.id',$idAreaCargo);
		$query = $this->aramark->get();
		return $query->row();
	}
	#20-09-2018 
	function guardarMotivoSolicitud($data){
		$this->aramark->insert('r_requerimiento_usuario_archivo_observacion',$data); 
	}

	function getMotivoSolicitud($idArchivo){
		$this->aramark->select('*');
		$this->aramark->from('r_requerimiento_usuario_archivo_observacion');
		$this->aramark->where('id_r_requerimiento_usuario_archivo',$idArchivo);
		$query = $this->aramark->get();
		if ($query->num_rows >0){
		   return  $query->row();
		}else{
		   return false;
		}
	}

	function actualizarMotivoSolicitud($id, $data){
		$this->aramark->where('id',$id);
		$this->aramark->update('r_requerimiento_usuario_archivo_observacion', $data);
	}

}
?>