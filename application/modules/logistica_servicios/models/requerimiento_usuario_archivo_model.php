<?php
class Requerimiento_Usuario_Archivo_model extends CI_Model {

	function __construct(){
		$this->log_serv = $this->load->database('log_serv', TRUE);
	}

	function ingresar_solicitud_contrato($data){
		$this->log_serv->insert('r_requerimiento_usuario_archivo_solicitudes_contratos',$data); 
		return $this->log_serv->insert_id();
	}

	function ingresar_solicitud_contrato_historial($data){
		$this->log_serv->insert('r_requerimiento_usuario_archivo_solicitudes_contratos_historial',$data); 
	}


	function actualizar_solicitud_contrato($id_req_usu_arch, $datos){
		$this->log_serv->where('id_req_usu_arch',$id_req_usu_arch);
		$this->log_serv->update('r_requerimiento_usuario_archivo_solicitudes_contratos', $datos);
	}

	function get_solicitud_contrato_tipo_proceso($id_usu_arch, $tipo_proceso = FAlSE){
		$this->log_serv->select('*');
		$this->log_serv->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->log_serv->where('id_req_usu_arch',$id_usu_arch);

		if($tipo_proceso != FAlSE)
			$this->log_serv->where('estado',$tipo_proceso);

		$query = $this->log_serv->get();
		return $query->row();
	}

	function get_proceso_contrato_tipo($id_usu_arch, $tipo_proceso = FAlSE){
		$this->log_serv->select('*');
		$this->log_serv->from('r_requerimiento_usuario_archivo');
		$this->log_serv->where('id',$id_usu_arch);

		if($tipo_proceso != FAlSE)
			$this->log_serv->where('estado_proceso',$tipo_proceso);

		$query = $this->log_serv->get();
		return $query->row();
	}

	function get_solicitud_contrato($id){
		$this->log_serv->select('*');
		$this->log_serv->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->log_serv->where('id_req_usu_arch',$id);
		$query = $this->log_serv->get();
		return $query->row();
	}




	function listar_solicitudes_pendientes(){
		$this->log_serv->select('*');
		$this->log_serv->from('r_requerimiento_usuario_archivo');
		$this->log_serv->where('estado_proceso',1);
		$query = $this->log_serv->get();
		return $query->result();
	}

	function listar_solicitudes_validadas(){
		$this->log_serv->select('*');
		$this->log_serv->from('r_requerimiento_usuario_archivo');
		$this->log_serv->where('estado_proceso',2);
		$query = $this->log_serv->get();
		return $query->result();
	}

	function listar_solicitudes_completas(){
		$this->log_serv->select('*');
		$this->log_serv->from('r_requerimiento_usuario_archivo');
		$this->log_serv->where('estado_proceso',3);
		$query = $this->log_serv->get();
		return $query->result();
	}

	function get($id){
		$this->log_serv->where('id',$id);
		$query = $this->log_serv->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function get_result($id){
		$this->log_serv->where('id',$id);
		$query = $this->log_serv->get('r_requerimiento_usuario_archivo');
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
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$query = $this->db->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_requerimiento_archivo($usuario,$requerimiento,$archivo){
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->db->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}




	function get_usuario_requerimiento_archivo_limit($usuario,$requerimiento,$archivo){
		$this->log_serv->where('usuario_id',$usuario);
		$this->log_serv->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->log_serv->where('tipo_archivo_requerimiento_id',$archivo);
		$this->log_serv->limit(1);
		$query = $this->log_serv->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_requerimiento_archivo_limit_row($usuario,$requerimiento,$archivo){
		$this->log_serv->where('usuario_id',$usuario);
		$this->log_serv->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->log_serv->where('tipo_archivo_requerimiento_id',$archivo);
		$this->db->order_by('id','desc');
		$this->log_serv->limit(1);
		$query = $this->log_serv->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}




	function get_usuario_archivos($usuario,$tipo_archivo){
		$this->db->where('usuario_id',$usuario);
		$this->db->where('tipo_archivo_requerimiento_id',$tipo_archivo);
		$query = $this->db->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}




	function existe_registro_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->log_serv->select('*');
		$this->log_serv->from('r_requerimiento_usuario_archivo');
		$this->log_serv->where('usuario_id',$usuario);
		$this->log_serv->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->log_serv->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->log_serv->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function get_result_tipo_archivo_usuario($usuario,$requerimiento,$archivo){
		$this->log_serv->select('*');
		$this->log_serv->from('r_requerimiento_usuario_archivo');
		$this->log_serv->where('usuario_id',$usuario);
		$this->log_serv->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->log_serv->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->log_serv->get();
		if ($query->num_rows >0){
		   return $query->result();
		}else{
		   return 0;
		}
	}




	function get_usuario_requerimiento_datos($usuario,$requerimiento, $archivo){
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->db->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function consultar_si_existe_req($usuario, $requerimiento, $archivo){
		$this->db->SELECT('*');
		$this->db->from('r_requerimiento_usuario_archivo');
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->db->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function actualizar_usu_arch($id, $datos){
		$this->log_serv->where('id',$id);
		$this->log_serv->update('r_requerimiento_usuario_archivo', $datos);
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

	function listar(){
		$query = $this->db->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}
	




	function ingresar($data){
		$this->log_serv->insert('r_requerimiento_usuario_archivo',$data); 
	}

	function eliminar($id){
		$this->log_serv->delete('r_requerimiento_usuario_archivo', array('id' => $id)); 
	}




	function listar_usuarios_contrato_vencido(){
		$this->db->select("");
		$this->db->from("r_requerimiento_usuario_archivo");
		$this->db->where('tipo_archivo_requerimiento_id',1);
		$this->db->where('fecha_termino <', date('Y-m-d'));
		$query = $this->db->get();
		return $query->result();
	}
}