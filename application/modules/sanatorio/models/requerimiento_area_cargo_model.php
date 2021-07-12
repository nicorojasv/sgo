<?php
class Requerimiento_area_cargo_model extends CI_Model {

	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function listar(){
		$this->sanatorio->where('flag_vigente', 1);
		$query = $this->sanatorio->get('r_requerimiento_area_cargo');
		return $query->result();
	}

	function listar_usuarios_requerimiento($id_req){
		$this->sanatorio->select('rac.id id_area_cargo, rac.requerimiento_id, usu.id, usu.nombres, usu.paterno, usu.materno, usu.email, usu.rut_usuario');
		$this->sanatorio->from('r_requerimiento_area_cargo rac');
		$this->sanatorio->join('r_requerimiento_asc_trabajadores rat','rac.id = rat.requerimiento_area_cargo_id','left');
		$this->sanatorio->join('usuarios usu','rat.usuario_id = usu.id','left');
		$this->sanatorio->where('rac.requerimiento_id', $id_req);
		$this->sanatorio->where('usu.estado', 1);
		$query = $this->sanatorio->get();
		return $query->result();
	}



	function get($id){
		$this->sanatorio->where('id',$id);
		$query = $this->sanatorio->get('r_requerimiento_area_cargo');
		return $query->row();
	}

	function get_result($id){
		$this->sanatorio->where('id',$id);
		$query = $this->sanatorio->get('r_requerimiento_area_cargo');
		return $query->result();
	}

	function get_requerimiento($id){
		$this->sanatorio->where('requerimiento_id',$id);
		$query = $this->sanatorio->get('r_requerimiento_area_cargo');
		return $query->result();
	}


	function r_get_requerimiento($id_req_area_cargo){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_requerimiento_area_cargo r_req_ac');
		$this->sanatorio->where('r_req_ac.id',$id_req_area_cargo);
		$this->sanatorio->join('r_requerimiento r_req','r_req_ac.requerimiento_id = r_req.id','left');
		$query = $this->sanatorio->get();
		return $query->row();
	}

	function r_get_area_cargo($id_area_cargo){
		$this->sanatorio->select('*, r_a.nombre as nombre_area, r_c.nombre as nombre_cargo');
		$this->sanatorio->from('r_requerimiento_area_cargo r_req_ac');
		$this->sanatorio->join('r_areas r_a','r_req_ac.areas_id = r_a.id','left');
		$this->sanatorio->join('r_cargos r_c','r_req_ac.cargos_id = r_c.id','left');
		$this->sanatorio->where('r_req_ac.id',$id_area_cargo);
		$query = $this->sanatorio->get();
		return $query->row();
	}



	function eliminar($id){
		$this->sanatorio->delete('r_requerimiento_area_cargo', array('id' => $id)); 
	}

	function ingresar($data){
		$this->sanatorio->insert('r_requerimiento_area_cargo',$data); 
		return $this->sanatorio->insert_id();
	}

	function actualizar($data,$id){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('r_requerimiento_area_cargo', $data); 
	}
		#29-11-2018

	function getReqContratoPuestoDisposicion($id){
		$this->sanatorio->select('r_requerimiento_area_cargo.id as idAreaCargo, r_requerimiento_area_cargo.cantidad as cantidadTrabajadores, r_cargos.nombre as nombreCargo, r_areas.nombre as nombreArea, r_requerimiento_area_cargo.valor_aprox as valor');
		$this->sanatorio->from('r_requerimiento_area_cargo ');
		$this->sanatorio->join('r_cargos ','r_cargos.id = r_requerimiento_area_cargo.cargos_id','inner');
		$this->sanatorio->join('r_areas ','r_areas.id = r_requerimiento_area_cargo.areas_id','inner');
		$this->sanatorio->where('requerimiento_id',$id);
		$query = $this->sanatorio->get();
		return $query->result();
	}

}
?>