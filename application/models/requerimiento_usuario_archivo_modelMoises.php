<?php
class Requerimiento_Usuario_Archivo_model extends CI_Model {
	
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

	function get_solicitud_contrato($id_usu_arch){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo_solicitudes_contratos');
		$this->db->where('id_req_usu_arch',$id_usu_arch);
		$query = $this->db->get();
		return $query->row();
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

	function listar_solicitudes_completas($id_planta = FALSE){
		$this->db->select('*');
		$this->db->from('r_requerimiento_usuario_archivo_solicitudes_contratos req_usu_arch_cont');
		$this->db->join('r_requerimiento_usuario_archivo req_usu_arch','req_usu_arch_cont.id_req_usu_arch = req_usu_arch.id','inner');
		$this->db->join('r_requerimiento_asc_trabajadores req_asc','req_usu_arch.requerimiento_asc_trabajadores_id = req_asc.id','inner');
		$this->db->join('r_requerimiento_area_cargo req_area_cargo','req_asc.requerimiento_area_cargo_id = req_area_cargo.id','inner');
		$this->db->join('r_requerimiento req','req_area_cargo.requerimiento_id = req.id','inner');
		$this->db->where('req_usu_arch_cont.estado', 1);

		if($id_planta != FALSE)
			$this->db->where('req.planta_id', $id_planta);

		$query = $this->db->get();
		return $query->result();
	}

	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('r_requerimiento_usuario_archivo');
		return $query->row();
	}

	function get_result($id){
		$this->db->where('id',$id);
		$query = $this->db->get('r_requerimiento_usuario_archivo');
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
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where('tipo_archivo_requerimiento_id',$archivo);
		$this->db->limit(1);
		$query = $this->db->get('r_requerimiento_usuario_archivo');
		return $query->result();
	}

	function get_usuario_archivos($usuario,$tipo_archivo){
		$this->db->where('usuario_id',$usuario);
		$this->db->where('tipo_archivo_requerimiento_id',$tipo_archivo);
		$query = $this->db->get('r_requerimiento_usuario_archivo');
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
		$this->db->where('usuario_id',$usuario);
		$this->db->where('requerimiento_asc_trabajadores_id',$requerimiento);
		$this->db->where('tipo_archivo_requerimiento_id',$archivo);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
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

	function listar(){
		$query = $this->db->get('r_requerimiento_usuario_archivo');
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
		return $query->result();
	}
}