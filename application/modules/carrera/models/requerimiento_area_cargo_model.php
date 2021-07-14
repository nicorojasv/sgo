<?php
class Requerimiento_area_cargo_model extends CI_Model {

	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function listar(){
		$this->carrera->where('flag_vigente', 1);
		$query = $this->carrera->get('r_requerimiento_area_cargo');
		return $query->result();
	}

	function listar_usuarios_requerimiento($id_req){
		$this->carrera->select('rac.id id_area_cargo, rac.requerimiento_id, usu.id, usu.nombres, usu.paterno, usu.materno, usu.email, usu.rut_usuario');
		$this->carrera->from('r_requerimiento_area_cargo rac');
		$this->carrera->join('r_requerimiento_asc_trabajadores rat','rac.id = rat.requerimiento_area_cargo_id','left');
		$this->carrera->join('usuarios usu','rat.usuario_id = usu.id','left');
		$this->carrera->where('rac.requerimiento_id', $id_req);
		$this->carrera->where('usu.estado', 1);
		$query = $this->carrera->get();
		return $query->result();
	}



	function get($id){
		$this->carrera->where('id',$id);
		$query = $this->carrera->get('r_requerimiento_area_cargo');
		return $query->row();
	}

	function get_result($id){
		$this->carrera->where('id',$id);
		$query = $this->carrera->get('r_requerimiento_area_cargo');
		return $query->result();
	}

	function get_requerimiento($id){
		$this->carrera->where('requerimiento_id',$id);
		$query = $this->carrera->get('r_requerimiento_area_cargo');
		return $query->result();
	}


	function r_get_requerimiento($id_req_area_cargo){
		$this->carrera->select('*');
		$this->carrera->from('r_requerimiento_area_cargo r_req_ac');
		$this->carrera->where('r_req_ac.id',$id_req_area_cargo);
		$this->carrera->join('r_requerimiento r_req','r_req_ac.requerimiento_id = r_req.id','left');
		$query = $this->carrera->get();
		return $query->row();
	}

	function r_get_area_cargo($id_area_cargo){
		$this->carrera->select('*, r_a.nombre as nombre_area, r_c.nombre as nombre_cargo');
		$this->carrera->from('r_requerimiento_area_cargo r_req_ac');
		$this->carrera->join('r_areas r_a','r_req_ac.areas_id = r_a.id','left');
		$this->carrera->join('r_cargos r_c','r_req_ac.cargos_id = r_c.id','left');
		$this->carrera->where('r_req_ac.id',$id_area_cargo);
		$query = $this->carrera->get();
		return $query->row();
	}



	function eliminar($id){
		$this->carrera->delete('r_requerimiento_area_cargo', array('id' => $id)); 
	}

	function ingresar($data){
		$this->carrera->insert('r_requerimiento_area_cargo',$data); 
		return $this->carrera->insert_id();
	}

	function actualizar($data,$id){
		$this->carrera->where('id', $id);
		$this->carrera->update('r_requerimiento_area_cargo', $data); 
	}
		#29-11-2018

	function getReqContratoPuestoDisposicion($id){
		$this->carrera->select('r_requerimiento_area_cargo.id as idAreaCargo, r_requerimiento_area_cargo.cantidad as cantidadTrabajadores, r_cargos.nombre as nombreCargo, r_areas.nombre as nombreArea, r_requerimiento_area_cargo.valor_aprox as valor');
		$this->carrera->from('r_requerimiento_area_cargo ');
		$this->carrera->join('r_cargos ','r_cargos.id = r_requerimiento_area_cargo.cargos_id','inner');
		$this->carrera->join('r_areas ','r_areas.id = r_requerimiento_area_cargo.areas_id','inner');
		$this->carrera->where('requerimiento_id',$id);
		$query = $this->carrera->get();
		return $query->result();
	}

}
?>