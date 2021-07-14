<?php
class Solicitud_revision_examenes_model extends CI_Model{
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}
	function guardar($datos){
		$this->carrera->insert('solicitud_revision_examenes',$datos);
		return $this->carrera->insert_id();
	}

	function actualizar($id_registro, $datos){
		$this->carrera->where('id', $id_registro);
		$this->carrera->update('solicitud_revision_examenes', $datos); 
	}

	function get_result_en_proceso(){
		$this->carrera->select('*');
		$this->carrera->from('solicitud_revision_examenes');
		$this->carrera->where('estado', 0);
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_result_completas(){
		$this->carrera->select('*');
		$this->carrera->from('solicitud_revision_examenes');
		$this->carrera->where('estado', 1);
		$query = $this->carrera->get();
		return $query->result();
	}
//INSERT IGNORE INTO tabla_destino (campo1, campo2) SELECT tabla_origen.campo1, tabla_origen.campo2 FROM tabla_origen
	function get_result_solicitudes_usu($id_usu){
		$this->carrera->select('*');
		$this->carrera->from('solicitud_revision_examenes');
		$this->carrera->where('solicitante_id', $id_usu);
		$query = $this->carrera->get();
		return $query->result();
	}
//INSERT IGNORE INTO afpnew (id, desc_afp) SELECT afp.id, afp.desc_afp from afp
//INSERT INTO base_destino.tabla_destino (campo1, campo2) SELECT tabla_origen.campo1, tabla_origen.campo2 FROM base_origen.tabla_origen
	/*//Respaldando  r_requerimiento_area_cargo
INSERT IGNORE INTO ntgraest_sgo_est.r_requerimiento_area_cargo (id, requerimiento_id, areas_id, cargos_id, cantidad, valor_aprox) SELECT r_requerimiento_area_cargo.id, r_requerimiento_area_cargo.requerimiento_id, r_requerimiento_area_cargo.areas_id, r_requerimiento_area_cargo.cargos_id, r_requerimiento_area_cargo.cantidad, r_requerimiento_area_cargo.valor_aprox FROM ntgraest_respaldo_sgo_est.r_requerimiento_area_cargo

# requerimiento _asc
INSERT IGNORE INTO ntgraest_sgo_est.r_requerimiento_asc_trabajadores () SELECT * FROM ntgraest_respaldo_sgo_est.r_requerimiento_asc_trabajadores

c23392039cc0aca751095dc4e963bcec892163b7a689a6a1589a5a6fbe9b58a25a34a6a74b419fd100fb300aa60b639a7c6e10ca21e85afc0246f67d4d3d839f
r_requerimiento_usuario_archivo
*/

	function get_usu_req($id_usu, $id_req, $id_asc){
		$this->carrera->select('*');
		$this->carrera->from('solicitud_revision_examenes');
		$this->carrera->where('usuario_id', $id_usu);
		$this->carrera->where('id_requerimiento', $id_req);
		$this->carrera->where('id_asc_trabajador', $id_asc);
		$query = $this->carrera->get();
		return $query->row();
	}

	function get_solicitud_usu_req($id_usu, $id_asc){
		$this->carrera->select('*');
		$this->carrera->from('solicitud_revision_examenes');
		$this->carrera->where('usuario_id', $id_usu);
		$this->carrera->where('id_asc_trabajador', $id_asc);
		$query = $this->carrera->get();
		return $query->row();
	}

	function get_usu_req_aprobados_result($id_usu, $id_req, $id_asc){
		$this->carrera->select('*');
		$this->carrera->from('solicitud_revision_examenes');
		$this->carrera->where('usuario_id', $id_usu);
		$this->carrera->where('id_requerimiento', $id_req);
		$this->carrera->where('id_asc_trabajador', $id_asc);
		$this->carrera->where('estado', 1);
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_row($id){
		$this->carrera->select('*');
		$this->carrera->from('solicitud_revision_examenes');
		$this->carrera->where('id', $id);
		$query = $this->carrera->get();
		return $query->row();
	}

	function get_result(){
		$this->carrera->select('*');
		$this->carrera->from('solicitud_revision_examenes');
		$query = $this->carrera->get();
		return $query->result();
	}

}
?>