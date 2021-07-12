<?php
class Requerimiento_Usuario_Archivo_model extends CI_Model {

	function __construct(){
		$this->general = $this->load->database('general', TRUE);
	}
	
	function ingresar_solicitud_contrato($data){
		$this->db->insert('r_requerimiento_usuario_archivo_solicitudes_contratos',$data); 
	}

	function ingresar_solicitud_contrato_historial($data){
		$this->db->insert('r_requerimiento_usuario_archivo_solicitudes_contratos_historial',$data); 
	}

	
     function actualizar_solicitud_contrato($id_req_usu_arch, $datos){
		$this->db->where('id_req_usu_arch',$id_req_usu_arch);
		$this->db->update('r_requerimiento_usuario_archivo_solicitudes_contratos', $datos);
	} 
	

 /*   funcion actualizar contrato
 function actualizar_solicitud_contrato($id, $datos){
		$this->db->where('id',$id);
		$this->db->update('r_requerimiento_usuario_archivo', $datos);
	} 
*/

	function get_solicitud_contrato($id_usu_arch){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->db->where('id_req_usu_arch',$id_usu_arch);
		$query = $this->db->get();
		return $query->row();
	}

function listar_solicitudes_pendientes_baja($id_planta = FALSE){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo_solicitudes_contratos req_usu_arch_cont');
		$this->db->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->db->join('r_requerimiento_asc_trabajadores req_asc','req_usu_arch.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->db->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->db->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->db->where('req_usu_arch.estado_proceso', 3);

		if($id_planta != FALSE)
			$this->db->where('req.planta_id', $id_planta);

		$query = $this->db->get();
		return $query->result();
	}
	

	function listar_solicitudes_completas($id_planta = FALSE){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo_solicitudes_contratos req_usu_arch_cont');
		$this->db->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->db->join('r_requerimiento_asc_trabajadores req_asc','req_usu_arch.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->db->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->db->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->db->where('req_usu_arch_cont.estado', 1);
//$this->db->limit(10);
		if($id_planta != FALSE)
			$this->db->where('req.planta_id', $id_planta);

		$query = $this->db->get();
		return $query->result();
	}
	
	function listar_solicitudes_pendientes($id_planta = FALSE){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo_solicitudes_contratos req_usu_arch_cont');
		$this->db->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->db->join('r_requerimiento_asc_trabajadores req_asc','req_usu_arch.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->db->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->db->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->db->where('req_usu_arch_cont.estado', 0);

		if($id_planta != FALSE)
			$this->db->where('req.planta_id', $id_planta);

		$query = $this->db->get();
		return $query->result();
	}

	function listar_solicitudes_completas2($fecha_inicio = FAlSE, $fecha_termino = FAlSE){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo_solicitudes_contratos req_usu_arch_cont');
		$this->db->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->db->join('r_requerimiento_asc_trabajadores req_asc','req_usu_arch.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->db->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->db->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->db->where('req_usu_arch_cont.estado', 1);
//$this->db->limit(10);
		if($fecha_inicio != FAlSE){
			$this->db->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}

		$query = $this->db->get();
		return $query->result();
	}

	function mis_solicitudes_completas( $fecha_inicio = false, $fecha_termino = false,$id_solicitante = false){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo_solicitudes_contratos req_usu_arch_cont');
		$this->db->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->db->join('r_requerimiento_asc_trabajadores req_asc','req_usu_arch.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->db->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->db->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->db->where('req_usu_arch_cont.estado', 1);
//$this->db->limit(10);
		if($fecha_inicio != false){
			$this->db->where('fecha_inicio BETWEEN "'.$fecha_inicio. '" and "'. $fecha_termino.'"');
		}
		if ($id_solicitante != false) {
			$this->db->where('req_usu_arch_cont.id_solicitante', $id_solicitante);
		}

		$query = $this->db->get();
		return $query->result();
	}


	

	function listar_solicitudes_completas_baja($id_planta = FALSE){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo_solicitudes_contratos req_usu_arch_cont');
		$this->db->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->db->join('r_requerimiento_asc_trabajadores req_asc','req_usu_arch.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->db->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->db->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->db->where('req_usu_arch_cont.estado', 5);

		if($id_planta != FALSE)
			$this->db->where('req.planta_id', $id_planta);

		$query = $this->db->get();
		return $query->result();
	}

	function get($id){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}


	function get_result($id){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->result();
	}

	function get_archivos_req($id_asc_trab){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo');
		$this->db->where('requerimiento_asc_trabajadores_id',$id_asc_trab);
		$this->db->where('tipo_archivo_requerimiento_id', '1');
		//$this->db->where('tipo_archivo_requerimiento_id', '1'.' or tipo_archivo_requerimiento_id', '2');
		$query = $this->db->get();
		return $query->row();
	}

	function get_usuario_requerimiento($usuario,$requerimiento){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo');
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$query = $this->db->get();
		return $query->result();
	}

	function get_usuario_requerimiento_archivo($usuario,$requerimiento,$archivo){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo');
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->db->get();
		return $query->result();
	}

	function get_usuario_requerimiento_anexo($usuario,$requerimiento){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_anexo');
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$query = $this->db->get();
		return $query->result();
	}
	function get_usuario_requerimiento_archivo_limit($usuario,$requerimiento,$archivo){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo');
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where('tipo_archivo_requerimiento_id',$archivo);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->result();
	}

	function get_usuario_requerimiento_archivo_limit_row($usuario,$requerimiento,$archivo){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo');
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where('tipo_archivo_requerimiento_id',$archivo);
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}

	function get_usuario_archivos($usuario,$tipo_archivo){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo');
		$this->db->where('usuario_id',$usuario);
		$this->db->where('tipo_archivo_requerimiento_id',$tipo_archivo);
		$query = $this->db->get();
		return $query->result();
	}

	function existe_registro_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo');
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function get_result_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo');
		$this->db->where('r_requerimiento_usuario_archivo.usuario_id',$usuario);
		$this->db->where('r_requerimiento_usuario_archivo.requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where('r_requerimiento_usuario_archivo.tipo_archivo_requerimiento_id',$archivo);
		$this->db->where('fecha_aprobacion_baja',null);

		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return $query->result();
		}else{
		   return 0;
		}
	}

	function get_area_cargo($idArea){
		$this->db->select('*');
		$this->db->from('r_requerimiento_asc_trabajadores');
		$this->db->where('r_requerimiento_asc_trabajadores.id',$idArea);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}	
	}

	function get_usuario_requerimiento_datos($usuario,$requerimiento, $archivo){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo');
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->db->get();
		return $query->row();
	}

	function consultar_si_existe_req($usuario, $requerimiento, $archivo){
		$this->db->SELECT('*');
		$this->db->from('r_requerimiento_usuario_archivo');
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function actualizar_usu_arch($id, $datos){
		$this->db->where('id',$id);
		$this->db->update('r_requerimiento_usuario_archivo', $datos);
	}

	function actualizar_req($usuario, $requerimiento, $archivo, $datos){
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where('tipo_archivo_requerimiento_id',$archivo);
		$this->db->update('r_requerimiento_usuario_archivo', $datos);
	}

	function get_requerimiento($id){
		$this->db->select("");
		$this->db->from("r_requerimiento_usuario_archivo rua");
		$this->db->join("r_requerimiento_asc_trabajadores rat","rua.requerimiento_asc_trabajadores_id = rat.id");
		$this->db->join("r_requerimiento_area_cargo rac","rac.id = rat.requerimiento_area_cargo_id");
		$this->db->where('rua.id',$id);
		$query = $this->db->get();
		return $query->row();
	}
	function quitarContrato($id,$data){
		$this->db->where('id',$id);
		$this->db->update('r_requerimiento_usuario_archivo', $data);
	}

	function quitarAnexo($id,$data){
		$this->db->where('id',$id);
		$this->db->update('r_requerimiento_usuario_anexo', $data);
	}

	function listar(){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo');
		$query = $this->db->get();
		return $query->result();
	}

	function ingresar($data){
		$this->db->insert('r_requerimiento_usuario_archivo',$data); 
	}

	function eliminar($id){
		$this->db->delete('r_requerimiento_usuario_archivo', array('id' => $id)); 
	}

	function eliminar_solicitudes_contratos($id){
		$this->db->delete('r_requerimiento_usuario_archivo_solicitudes_contratos', array('id_req_usu_arch' => $id)); 
	}

	function listar_usuarios_contrato_vencido(){
		$this->db->select("");
		$this->db->from("r_requerimiento_usuario_archivo");
		$this->db->where('tipo_archivo_requerimiento_id',1);
		$this->db->where('fecha_termino <', date('Y-m-d'));
		$query = $this->db->get();
		//return $query->result();
		return $query->result();
	}
	function listar_contratos_y_anexos(){
		$consulta =$this->db->query('select * from r_requerimiento_usuario_archivo as T1 where not exists (  select *  from r_requerimiento_usuario_archivo as T2  where T1.usuario_id = T2.usuario_id and T1.fecha_termino < T2.fecha_termino) ORDER BY usuario_id ASC');
		return $consulta->result();
	}

	#06-09-2018 grm
	function getNombreRequerimiento($idAreaCargo){
		$this->db->select('rr.nombre');
		$this->db->from('r_requerimiento_area_cargo as rac');
		$this->db->join("r_requerimiento rr","rac.requerimiento_id = rr.id");
		$this->db->where('rac.id',$idAreaCargo);
		$query = $this->db->get();
		return $query->row();
	}

	#20-09-2018 
	function guardarMotivoSolicitud($data){
		$this->db->insert('r_requerimiento_usuario_archivo_observacion',$data); 
	}

	function getMotivoSolicitud($idArchivo){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo_observacion');
		$this->db->where('id_r_requerimiento_usuario_archivo',$idArchivo);
		$query = $this->db->get();
		if ($query->num_rows >0){
		   return  $query->row();
		}else{
		   return false;
		}
	}

	function actualizarMotivoSolicitud($id, $data){
		$this->db->where('id',$id);
		$this->db->update('r_requerimiento_usuario_archivo_observacion', $data);
	}


	function ingresarAnexo($data){
		$this->db->insert('r_requerimiento_usuario_anexo',$data);
		return $this->db->insert_id();
	}

	#yayo 18-11-2019 
	function ingresarNuevoMotivoAnexo($data){
		$this->db->insert('motivos_de_anexos',$data);
	}

	function getMotivoAnexo($idAnexo){
		$this->db->select('*');
		$this->db->from('motivos_de_anexos');
		$this->db->where('id_anexo',$idAnexo);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return false;
		}
	}
	//

	function get_anexos($usuario,$requerimiento){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_anexo');
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where("(estado = 0 OR estado =1 OR estado = 2 OR estado = 3 OR estado = 4 OR estado = 6 )");
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return $query->result();
		}else{
		   return 0;
		}
	}
	function get_anexos_id($idAnexo){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_anexo');
		$this->db->where('id',$idAnexo);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}

	function getIdEmpresa($id){
		$this->db->select('id_centro_costo');
		$this->db->from('empresa_planta');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}

	function actualizarAnexo($id, $data){
		$this->db->where('id',$id);
		$this->db->update('r_requerimiento_usuario_anexo', $data);
		return $afftectedRows = $this->db->affected_rows();
	}

	function listar_solicitudes_pendientes_anexo($id_planta = FALSE){
		$this->db->select('*, anexo.id as idAnexo, anexo.nombres as nombreTrabajador, anexo.rut_usuario as rutTrabajador, anexo.nacionalidad as nacionalidadTrabajador, anexo.fecha_nac as nacimientoTrabajador, anexo.direccion as direccionTrabajador, anexo.ciudad as ciudadTrabajador, anexo.estado_civil as civilTrabajador, anexo.afp as afpTrabajador, anexo.salud as saludTrabajador, anexo.nombre_centro_costo as centroTrabajador, anexo.telefono as telefonoTrabajador, anexo.nivel_estudios as estudioTrabajador, anexo.nombre_banco as bancoTrabajador, anexo.tipo_cuenta as cuentaTrabajador, anexo.cuenta_banco as numeroCuentaTrabajador, anexo.nombre_planta as plantaTrabajador, anexo.fecha_inicio_contrato as fechaInicioContrato, anexo.fecha_termino_contrato_anterior as fechaTerminoContratoAnterior, anexo.fecha_termino_nuevo_anexo as fechaTerminoAnexo, anexo.causal as causalTrabajador');
		$this->db->from('r_requerimiento_usuario_anexo anexo');
		//$this->db->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->db->join('r_requerimiento_asc_trabajadores req_asc','anexo.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->db->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->db->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->db->where('anexo.estado', 1);
		if($id_planta != FALSE)
			$this->db->where('req.planta_id', $id_planta);

		$query = $this->db->get();
		return $query->result();
	}

	function listar_solicitudes_completas_anexo($id_planta = FALSE, $idUsuario = false){
		$this->db->select('*, anexo.id as idAnexo, anexo.nombres as nombreTrabajador, anexo.rut_usuario as rutTrabajador, anexo.nacionalidad as nacionalidadTrabajador, anexo.fecha_nac as nacimientoTrabajador, anexo.direccion as direccionTrabajador, anexo.ciudad as ciudadTrabajador, anexo.estado_civil as civilTrabajador, anexo.afp as afpTrabajador, anexo.salud as saludTrabajador, anexo.nombre_centro_costo as centroTrabajador, anexo.telefono as telefonoTrabajador, anexo.nivel_estudios as estudioTrabajador, anexo.nombre_banco as bancoTrabajador, anexo.tipo_cuenta as cuentaTrabajador, anexo.cuenta_banco as numeroCuentaTrabajador, anexo.nombre_planta as plantaTrabajador, anexo.fecha_inicio_contrato as fechaInicioContrato, anexo.fecha_termino_contrato_anterior as fechaTerminoContratoAnterior, anexo.fecha_termino_nuevo_anexo as fechaTerminoAnexo, anexo.causal as causalTrabajador');
		$this->db->from('r_requerimiento_usuario_anexo anexo');
		//$this->db->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->db->join('r_requerimiento_asc_trabajadores req_asc','anexo.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->db->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->db->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->db->where('anexo.estado', 2);
		if($id_planta != FALSE)
			$this->db->where('req.planta_id', $id_planta);
		if($idUsuario != FALSE)
			$this->db->where('anexo.id_quien_solicita', $idUsuario);
		$query = $this->db->get();
		return $query->result();
	}

	function existe_registro_de_anexo($usuario,$requerimiento,$archivo){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_anexo');
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where('tipo_archivo_requerimiento_id',$archivo);
		$this->db->where("(estado = 0 OR estado =1 OR estado = 2 OR estado = 3 OR estado = 4)");
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function get_ultimo_anexo($usuario,$requerimiento,$archivo){
		$this->db->select('*, fecha_inicio_contrato as fecha_inicio, fecha_termino_nuevo_anexo as fecha_termino');
		$this->db->from('r_requerimiento_usuario_anexo');
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where('tipo_archivo_requerimiento_id',$archivo);
		$this->db->where("(estado = 0 OR estado =1 OR estado = 2 OR estado = 3 OR estado = 4)");
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}

	function get_ultimo_anexo_carta_termino($usuario,$requerimiento,$archivo){
		$this->db->select('*, fecha_inicio_contrato as fecha_inicio, fecha_termino_nuevo_anexo as fecha_termino');
		$this->db->from('r_requerimiento_usuario_anexo');
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where('tipo_archivo_requerimiento_id',$archivo);
		$this->db->where("estado = 2");
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}

	function get_contrato($idContrato){
		$this->db->select('u.nombres, u.paterno, u.materno, u.rut_usuario, r.fecha_termino, ep.nombre as nombrePlanta, r.fecha_termino2');
		$this->db->from('r_requerimiento_usuario_archivo r');
		$this->db->join('usuarios u','r.usuario_id = u.id','left');
		$this->db->join('r_requerimiento_asc_trabajadores rat','r.requerimiento_asc_trabajadores_id = rat.id','left');
		$this->db->join('r_requerimiento_area_cargo rar','rat.requerimiento_area_cargo_id = rar.id','left');
		$this->db->join('r_requerimiento req','rar.requerimiento_id = req.id','left');
		$this->db->join('empresa_planta ep','req.planta_id = ep.id','left');
		$this->db->where('r.id',$idContrato);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}

	function get_anexo($idAnexo){
		$this->db->select('u.nombres, u.paterno, u.materno, u.rut_usuario, r.fecha_termino_nuevo_anexo as fecha_termino, r.nombre_planta as nombrePlanta, r.fecha_termino2');
		$this->db->from('r_requerimiento_usuario_anexo r');
		$this->db->join('usuarios u ','r.usuario_id = u.id','inner');
		$this->db->where('r.id',$idAnexo);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}
	

	function getAllAnexos(){
		$this->db->select(" ra.id as idArchivo, ra.usuario_id as idUsuario, ra.requerimiento_asc_trabajadores_id as reqAscTrabajador, ra.id_requerimiento_area_cargo as reqAreaCargo, ra.fecha_termino_nuevo_anexo as fTermino, ra.id_quien_solicita as id_solicitante, ra.nombres as nombreTrabajador");
		$this->db->from('r_requerimiento_usuario_anexo ra');
		$this->db->where('ra.fecha_termino_nuevo_anexo >=',date('Y-m-d'));
		$this->db->where('ra.fecha_termino_nuevo_anexo <',date("Y-m-d",strtotime(date('Y-m-d')."+ 3 days")));
		$this->db->where('estado',2);//estado 2 ->  que se encuentre Aprobado
		$this->db->where('existe_otro_anexo',null);
		$this->db->order_by('ra.id_quien_solicita');
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return $query->result();
		}else{
		   return 0;
		}
	}

	function getAllContratos(){
		$this->db->select(" ra.id as idArchivo, ra.usuario_id as idUsuario, ra.requerimiento_asc_trabajadores_id as reqAscTrabajador, rt.requerimiento_area_cargo_id as reqAreaCargo, ra.fecha_termino as fTermino, rs.id_solicitante, 
			CONCAT(u.nombres,' ', u.paterno,' ', u.materno) as nombreTrabajador, ra.motivo ",FALSE);
		$this->db->from('r_requerimiento_usuario_archivo ra');
		$this->db->join('r_requerimiento_usuario_archivo_solicitudes_contratos rs','ra.id = rs.id_req_usu_arch','left');
		$this->db->join('r_requerimiento_asc_trabajadores rt','ra.requerimiento_asc_trabajadores_id = rt.id','left');
		$this->db->join('usuarios u','ra.usuario_id = u.id','left');
		$this->db->where('ra.fecha_termino >=',date('Y-m-d'));
		$this->db->where('ra.fecha_termino <',date("Y-m-d",strtotime(date('Y-m-d')."+ 3 days")));
		$this->db->where('estado_aprobacion_revision',1);
		$this->db->where('anexogenerado',0);
		$this->db->order_by('rs.id_solicitante');
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return $query->result();
		}else{
		   return 0;
		}
	}

	function marcarAnexoAnteriorComoFinalizado($idUsuario,$idReqAscTrabajadores, $datos){
		$this->db->where('usuario_id',$idUsuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$idReqAscTrabajadores);
		$this->db->where('estado',2);
		$this->db->update('r_requerimiento_usuario_anexo', $datos);
	}

	function actualizarContrato($idUsuario,$idReqAscTrabajadores, $datos){
		$this->db->where('usuario_id',$idUsuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$idReqAscTrabajadores);
		$this->db->where('tipo_archivo_requerimiento_id',1);
		$this->db->update('r_requerimiento_usuario_archivo', $datos);
	}

	function getNombreTrabajador($idAnexo){
		$this->db->select("CONCAT(u.nombres,' ', u.paterno,' ', u.materno) as nombreTrabajador, u.nombres as name",FALSE);
		$this->db->from('r_requerimiento_usuario_archivo r');
		$this->db->join('usuarios u ','r.usuario_id = u.id','inner');
		$this->db->where('r.id',$idAnexo);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return 0;
		}
	}

	function verificar(){
		$this->db->select();
		$this->db->from('r_uarchivo_solicitudes_contratos_notificacion');
		//$this->db->where('estado',0);
		$query = $this->db->get();
		return $query->result();
	}

	function cambiarEstadoNotificacion($id){
		$this->db->where('id',$id);
		$this->db->set('estado',1);
		$this->db->update('r_uarchivo_solicitudes_contratos_notificacion');
	}
		#05-07-2018
	function getIdUsuarioContrato($id_usu_arch){
		$this->db->select("*");
		$this->db->from("r_requerimiento_usuario_archivo");
		$this->db->where('r_requerimiento_usuario_archivo.id',$id_usu_arch);
		$query = $this->db->get();
		return $query->row();
	}

	function insertarRD($data){
		$this->db->insert('carta_termino_descargada',$data); 
	}

	function updateRD($id, $data){
		$this->db->where('id',$id);
		$this->db->set('total_descargado', $data);
		$this->db->update('carta_termino_descargada');
	}

	function consultaRD($idPersona,$id_usuario,$idArchivo){
		$this->db->select('id, total_descargado');
		$this->db->from('carta_termino_descargada r');
		$this->db->where('usuario_descargo',$idPersona);
		$this->db->where('id_trabajador',$id_usuario);
		$this->db->where('id_archivo',$idArchivo);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return false;
		}
	}

	function getCartasTermino($idUsuario){
		$this->db->select('ctd.id ,ctd.usuario_descargo, ctd.id_trabajador, ctd.id_archivo, ctd.tipo_archivo, ctd.fecha_descarga, u.nombres, u.paterno, u.materno, u.rut_usuario, ctd.total_descargado, 
			aaaa.requerimiento_asc_trabajadores_id as contratoAscTrab ,
			rrat.requerimiento_area_cargo_id as contratoAreaCargo, 
			rrc.nombre as contratoNombreRequerimiento,
			eps.nombre as contratoNombrePlantas,
			rrac.requerimiento_id,
			eeee.requerimiento_asc_trabajadores_id as anexoAscTrab, 
			eeee.id_requerimiento_area_cargo as anexoAreaCargo, 
			rr.nombre as anexoNombreRequerimiento,
			ep.nombre as anexoNombrePlanta,
			');
		$this->db->from('carta_termino_descargada ctd');
		$this->db->join('usuarios u','ctd.id_trabajador = u.id','inner');
		//Contratos
		$this->db->join('r_requerimiento_usuario_archivo aaaa','ctd.id_archivo = aaaa.id and ctd.tipo_archivo = 1','left');
		$this->db->join('r_requerimiento_asc_trabajadores rrat','aaaa.requerimiento_asc_trabajadores_id = rrat.id and ctd.tipo_archivo = 1','left');
		$this->db->join('r_requerimiento_area_cargo rrac','rrat.requerimiento_area_cargo_id = rrac.id and ctd.tipo_archivo = 1','left');
		$this->db->join('r_requerimiento rrc','rrac.requerimiento_id = rrc.id and ctd.tipo_archivo = 1','left');
		$this->db->join('empresa_planta eps','rrc.planta_id = eps.id and ctd.tipo_archivo = 1','left');
		//Anexos
		$this->db->join('r_requerimiento_usuario_anexo eeee','ctd.id_archivo = eeee.id and ctd.tipo_archivo = 2','left');
		$this->db->join('r_requerimiento_area_cargo rac','eeee.id_requerimiento_area_cargo = rac.id and ctd.tipo_archivo = 2','left');
		$this->db->join('r_requerimiento rr','rac.requerimiento_id = rr.id and ctd.tipo_archivo = 2','left');
		$this->db->join('empresa_planta ep','rr.planta_id = ep.id and ctd.tipo_archivo = 2','left');

		$this->db->where('usuario_descargo',$idUsuario);
		$this->db->where('ctd.anulacion',null);
		$query = $this->db->get();
		return $query->result();
	}
	function getCartasTerminosAll(){
		$this->db->select('ctd.id ,ctd.usuario_descargo, ctd.id_trabajador, ctd.id_archivo, ctd.tipo_archivo, ctd.fecha_descarga, u.nombres, u.paterno, u.materno, u.rut_usuario, ciudad.codigo,ctd.total_descargado, 
			aaaa.requerimiento_asc_trabajadores_id as contratoAscTrab ,
			rrat.requerimiento_area_cargo_id as contratoAreaCargo, 
			rrc.nombre as contratoNombreRequerimiento,
			eps.nombre as contratoNombrePlantas,
			rrac.requerimiento_id,
			eeee.requerimiento_asc_trabajadores_id as anexoAscTrab, 
			eeee.id_requerimiento_area_cargo as anexoAreaCargo, 
			rr.nombre as anexoNombreRequerimiento,
			ep.nombre as anexoNombrePlanta,
			');
		$this->db->from('carta_termino_descargada ctd');
		$this->db->join('usuarios u','ctd.id_trabajador = u.id','inner');
		//Contratos
		$this->db->join('r_requerimiento_usuario_archivo aaaa','ctd.id_archivo = aaaa.id and ctd.tipo_archivo = 1','left');
		$this->db->join('r_requerimiento_asc_trabajadores rrat','aaaa.requerimiento_asc_trabajadores_id = rrat.id and ctd.tipo_archivo = 1','left');
		$this->db->join('r_requerimiento_area_cargo rrac','rrat.requerimiento_area_cargo_id = rrac.id and ctd.tipo_archivo = 1','left');
		$this->db->join('r_requerimiento rrc','rrac.requerimiento_id = rrc.id and ctd.tipo_archivo = 1','left');
		$this->db->join('empresa_planta eps','rrc.planta_id = eps.id and ctd.tipo_archivo = 1','left');
		$this->db->join('ciudades ciudad','u.id_ciudades = ciudad.id','left');
		//Anexos
		$this->db->join('r_requerimiento_usuario_anexo eeee','ctd.id_archivo = eeee.id and ctd.tipo_archivo = 2','left');
		$this->db->join('r_requerimiento_area_cargo rac','eeee.id_requerimiento_area_cargo = rac.id and ctd.tipo_archivo = 2','left');
		$this->db->join('r_requerimiento rr','rac.requerimiento_id = rr.id and ctd.tipo_archivo = 2','left');
		$this->db->join('empresa_planta ep','rr.planta_id = ep.id and ctd.tipo_archivo = 2','left');
		$this->db->where('ctd.anulacion',null);
		$this->db->group_by('ctd.id_archivo');
		$query = $this->db->get();
		return $query->result();
	}

	function anularCT($id,$motivo){
		$this->db->where('id',$id);
		$this->db->set('anulacion',1);
		$this->db->set('fecha_anulacion',date('Y-m-d H:i:s'));
		$this->db->set('motivo',$motivo);
		$this->db->update('carta_termino_descargada');
	}

	function getInformacionDT($idTrabajador){
		$this->db->select('nombres, paterno, materno, rut_usuario, desc_ciudades, sexo');
		$this->db->from('usuarios u');
		$this->db->join('ciudades c','c.id = u.id_ciudades','join');
		$this->db->where('u.id',$idTrabajador);
		$query = $this->db->get();
		return $query->result();
	}

	function getInformacionContrato($id){
		$this->db->select('fecha_inicio, fecha_termino');
		$this->db->from('r_requerimiento_usuario_archivo');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	function getInformacionAnexo($id){
		$this->db->select('fecha_inicio_contrato as fecha_inicio, fecha_termino_nuevo_anexo as fecha_termino');
		$this->db->from('r_requerimiento_usuario_anexo');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	function insertXML($data){
		$this->db->insert('xml_generados',$data); 
	}

	#yayo 23-09-2019 funcionar para verificar si el nuevo contrato a crear tiene fecha mayor a uno vigente
	function buscarContrato($idPersona,$fecha){
		$sql = "SELECT t1.* FROM r_requerimiento_usuario_archivo t1 WHERE t1.fecha_termino2 = (SELECT MAX(t2.fecha_termino2) FROM  r_requerimiento_usuario_archivo t2 WHERE t2.usuario_id = t1.usuario_id AND estado_aprobacion_revision =1 AND fecha_aprobacion_baja = NULL AND usuario_id= ".$idPersona.")";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return false;
		}
	}

	function buscarAnexo($idPersona,$fecha){
		$sql = "SELECT t1.* FROM r_requerimiento_usuario_anexo t1 WHERE t1.fecha_termino2 = (SELECT MAX(t2.fecha_termino2) FROM  r_requerimiento_usuario_anexo t2 WHERE t2.usuario_id = t1.usuario_id AND estado =2 AND usuario_id= ".$idPersona.")";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
		   return $query->row();
		}else{
		   return false;
		}
	}

	#yayo 25-09-2019
	function finiquitarContrato($id, $datos){
		$this->db->where('id',$id);
		$this->db->update('r_requerimiento_usuario_archivo', $datos);
	}

	function guardarAuditoria($data){
		$this->db->insert('registro_finiquitos',$data); 
	}

	function finiquitarAnexo($id, $datos){
		$this->db->where('id',$id);
		$this->db->update('r_requerimiento_usuario_anexo', $datos);
	}

	function getNameTrabajador($id){
		$this->db->select('nombres, paterno, materno, rut_usuario');
		$this->db->from('usuarios');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}
	function reqla($limit_start=FALSE,$limit_lenght=FALSE,$busqueda=FALSE){
		   		$this->db->select("u.id id_user, e_examen_pre.id_preo, e_examen_pre.indice_ganancia, u.estado, u.id_tipo_usuarios, u.nombres, u.paterno, u.materno, u.rut_usuario, u.fono, IFNULL(DATE_FORMAT(u.fecha_nac, '%d/%m/%Y'),'00/00/0000' ) fecha_nacimiento, IFNULL(c.desc_ciudades,'No Ingresada') desc_ciudades, a_afp.url afp, a_salud.url salud, a_estudios.url estudios, a_cv.url cv, et1.desc_especialidad especialidad1, et2.desc_especialidad especialidad2, et3.desc_especialidad especialidad3, DATE_FORMAT(e_masso.fecha_v, '%d/%m/%Y') masso, DATE_FORMAT(e_examen_pre.fecha_v, '%d/%m/%Y') examen_pre, rec.id requerimiento, rec.status, rec.requerimiento_area_cargo requerimiento_area_cargo, rec.nombre_req nombre_req,(CASE WHEN DATEDIFF(e_masso.fecha_v,now()) >= 0 && DATEDIFF(e_masso.fecha_v,now()) <= 30 THEN 'falta' WHEN DATEDIFF(e_masso.fecha_v,now()) < 0 THEN 'vencida' WHEN DATEDIFF(e_masso.fecha_v,now()) > 30 THEN 'vigente' END) estado_masso, (CASE WHEN DATEDIFF(e_examen_pre.fecha_v,now()) >= 0 && DATEDIFF(e_examen_pre.fecha_v,now()) <= 30 THEN 'falta' WHEN DATEDIFF(e_examen_pre.fecha_v,now()) < 0 THEN 'vencida' WHEN DATEDIFF(e_examen_pre.fecha_v,now()) > 30 THEN 'vigente' END) estado_examen,IF(ln_guion.guion <= 3, 1,IF(ln_guion.guion > 4 or ln_ln.ln >=1,2,IF((ln_guion.guion <= 3 and ln_ln.ln >=1)or ln_lnp.lnp >=1,3,0))) ln, DATE_FORMAT(psicologico.fecha_vigencia, '%d/%m/%Y') vigencia_psicologico, psicologico.resultado resultado_pisocologico, psicologico.tecnico_supervisor, conocimiento.resultado as nota_conocimiento", FALSE);
		$this->db->from('usuarios u');
		$this->db->join('(SELECT * FROM archivos_trab arch WHERE id = (SELECT MAX(id) FROM archivos_trab WHERE id_usuarios = arch.id_usuarios and id_tipoarchivo = 11 GROUP BY id_usuarios) ORDER BY id DESC) a_afp','u.id = a_afp.id_usuarios','left');
		$this->db->join('(SELECT * FROM archivos_trab arch WHERE id = (SELECT MAX(id) FROM archivos_trab WHERE id_usuarios = arch.id_usuarios and id_tipoarchivo = 12 GROUP BY id_usuarios) ORDER BY id DESC) a_salud','u.id = a_salud.id_usuarios','left');
		$this->db->join('(SELECT * FROM archivos_trab arch WHERE id = (SELECT MAX(id) FROM archivos_trab WHERE id_usuarios = arch.id_usuarios and id_tipoarchivo = 9 GROUP BY id_usuarios) ORDER BY id DESC) a_estudios','u.id = a_estudios.id_usuarios','left');
		$this->db->join('(SELECT * FROM archivos_trab arch WHERE id = (SELECT MAX(id) FROM archivos_trab WHERE id_usuarios = arch.id_usuarios and id_tipoarchivo = 13 GROUP BY id_usuarios) ORDER BY id DESC) a_cv','u.id = a_cv.id_usuarios','left');
		$this->db->join('ciudades c','c.id = u.id_ciudades','left');
		$this->db->join('especialidad_trabajador et1','et1.id = u.id_especialidad_trabajador','left');
		$this->db->join('especialidad_trabajador et2','et2.id = u.id_especialidad_trabajador_2','left');
		$this->db->join('especialidad_trabajador et3','et3.id = u.id_especialidad_trabajador_3','left');
		$this->db->join('(select id_usuarios, fecha_v from evaluaciones where id_evaluacion = 4 and estado_ultima_evaluacion = 1 group by id_usuarios) e_masso','e_masso.id_usuarios = u.id','left');
		$this->db->join('(select id as id_preo, id_usuarios, fecha_v, indice_ganancia from evaluaciones where id_evaluacion = 3 and estado_ultima_evaluacion = 1 group by id_usuarios) e_examen_pre','e_examen_pre.id_usuarios = u.id','left');
		$this->db->join('(select usuario_id, fecha_vigencia, resultado, tecnico_supervisor from examenes_psicologicos where estado_ultimo_examen = 1 group by usuario_id) psicologico','psicologico.usuario_id = u.id','left');
		$this->db->join('(select ev.id_usuarios, ev.resultado from evaluaciones ev left join evaluaciones_evaluacion ev_eval on ev.id_evaluacion = ev_eval.id where ev_eval.id_tipo = 3 and estado_ultima_evaluacion = 1 group by id_usuarios) conocimiento','conocimiento.id_usuarios = u.id','left');
		//$this->db->join('(select r.id, rat.usuario_id usuario_id, rac.id requerimiento_area_cargo, r.nombre nombre_req FROM r_requerimiento r INNER JOIN r_requerimiento_area_cargo rac ON r.id = rac.requerimiento_id INNER JOIN r_requerimiento_asc_trabajadores rat ON rac.id = rat.requerimiento_area_cargo_id WHERE DATE( r.f_fin ) > NOW( ) group by rat.usuario_id) rec','rec.usuario_id = u.id','left');
		$this->db->join('(select req.id, r_asc.status, r_asc.usuario_id, r_area_cargo.id requerimiento_area_cargo, req.nombre as nombre_req from r_requerimiento_asc_trabajadores r_asc left join r_requerimiento_area_cargo r_area_cargo on r_asc.requerimiento_area_cargo_id = r_area_cargo.id left join r_requerimiento req on r_area_cargo.requerimiento_id = req.id where req.estado = 1 and r_asc.status != 6) rec','rec.usuario_id = u.id','left');
		$this->db->join("(select id_usuario, if(tipo='-',count(tipo),NULL) guion FROM lista_negra group by id_usuario) ln_guion",'ln_guion.id_usuario = u.id','left');
		$this->db->join("(select id_usuario, if(tipo='LNP',count(tipo),NULL) lnp FROM lista_negra group by id_usuario) ln_lnp",'ln_lnp.id_usuario = u.id','left');
		$this->db->join("(select id_usuario, if(tipo='LN',count(tipo),NULL) ln FROM lista_negra group by id_usuario) ln_ln",'ln_ln.id_usuario = u.id','left');
		$this->db->where('u.estado', 1);
		$this->db->where('u.id_tipo_usuarios', 2);

		if(!empty($busqueda)){
			$this->db->like('u.rut_usuario', $busqueda, 'after');
			$this->db->or_like('u.nombres', $busqueda, 'after'); 
			$this->db->or_like('u.paterno', $busqueda, 'after'); 
			$this->db->or_like('u.materno', $busqueda, 'after'); 
			$this->db->or_like('et1.desc_especialidad', $busqueda, 'after'); 
			$this->db->or_like('et2.desc_especialidad', $busqueda, 'after'); 
			$this->db->or_like('et3.desc_especialidad', $busqueda, 'after'); 
			$this->db->or_like('u.fono', $busqueda); 
			$this->db->or_like('desc_ciudades', $busqueda); 
		}
		if(!empty($limit_start))
			$this->db->limit($limit_lenght,$limit_start);

		$query = $this->db->get();
		return $query->result();
	}
	
	function getRequerimienton($id_req){
		$this->db->where("id",$id_req);
		$query = $this->db->get('r_requerimiento_area_cargo');
		return $query->row();
	}
	#yayo 10-10-2019
	function insertarContratoAprobado($data){
		$this->db->insert('contratos_masivos',$data); 
	}
	#yayo 14-10-2019
	function insertarAnexoAprobado($data){
		$this->db->insert('anexos_masivos',$data); 
	}
	#yayo 11-12-2019
	function getContrato($id){
		$this->db->where("id",$id);
		$query = $this->db->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	#yayo 14-01-2020

	function verContratoAprobado($idRequerimiento, $idTrabajador){
		$this->db->select('*');
		$this->db->from('contratos_masivos');
		$this->db->where('id_requerimiento',$idRequerimiento);
		$this->db->where('id_trabajador',$idTrabajador);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return true;
		}else{
		   return false;
		}
	}

	function updateContratoAprobado($idRequerimiento, $idTrabajador, $datos){
		$this->db->where('id_requerimiento',$idRequerimiento);
		$this->db->where('id_trabajador',$idTrabajador);
		$this->db->update('contratos_masivos', $datos);
	}

}