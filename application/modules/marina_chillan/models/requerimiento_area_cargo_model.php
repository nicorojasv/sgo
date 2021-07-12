<?php
class Requerimiento_area_cargo_model extends CI_Model {

	function __construct(){
		$this->marina_chillan = $this->load->database('marina_chillan', TRUE);
	}

	function listar(){
		$this->db->where('flag_vigente', 1);
		$query = $this->db->get('r_requerimiento_area_cargo');
		return $query->result();
	}

	function listar_usuarios_requerimiento($id_req){
		$this->db->select('rac.id id_area_cargo, rac.requerimiento_id, usu.id, usu.nombres, usu.paterno, usu.materno, usu.email, usu.rut_usuario');
		$this->db->from('r_requerimiento_area_cargo rac');
		$this->db->join('r_requerimiento_asc_trabajadores rat','rac.id = rat.requerimiento_area_cargo_id','left');
		$this->db->join('usuarios usu','rat.usuario_id = usu.id','left');
		$this->db->where('rac.requerimiento_id', $id_req);
		$this->db->where('usu.estado', 1);
		$query = $this->db->get();
		return $query->result();
	}



	function get($id){
		$this->marina_chillan->where('id',$id);
		$query = $this->marina_chillan->get('r_requerimiento_area_cargo');
		return $query->row();
	}

	function get_result($id){
		$this->marina_chillan->where('id',$id);
		$query = $this->marina_chillan->get('r_requerimiento_area_cargo');
		return $query->result();
	}

	function get_requerimiento($id){
		$this->marina_chillan->where('requerimiento_id',$id);
		$query = $this->marina_chillan->get('r_requerimiento_area_cargo');
		return $query->result();
	}






	function r_get_requerimiento($id_req_area_cargo){
		$this->db->select('*');
		$this->db->from('r_requerimiento_area_cargo r_req_ac');
		$this->db->where('r_req_ac.id',$id_req_area_cargo);
		$this->db->join('r_requerimiento r_req','r_req_ac.requerimiento_id = r_req.id','left');
		$query = $this->db->get();
		return $query->row();
	}

	function r_get_area_cargo($id_area_cargo){
		$this->db->select('*, r_a.nombre as nombre_area, r_c.nombre as nombre_cargo');
		$this->db->from('r_requerimiento_area_cargo r_req_ac');
		$this->db->join('r_areas r_a','r_req_ac.areas_id = r_a.id','left');
		$this->db->join('r_cargos r_c','r_req_ac.cargos_id = r_c.id','left');
		$this->db->where('r_req_ac.id',$id_area_cargo);
		$query = $this->db->get();
		return $query->row();
	}



	function eliminar($id){
		$this->marina_chillan->delete('r_requerimiento_area_cargo', array('id' => $id)); 
	}

	function ingresar($data){
		$this->marina_chillan->insert('r_requerimiento_area_cargo',$data); 
		return $this->marina_chillan->insert_id();
	}

	function actualizar($data,$id){
		$this->marina_chillan->where('id', $id);
		$this->marina_chillan->update('r_requerimiento_area_cargo', $data); 
	}
		#29-11-2018

	function getReqContratoPuestoDisposicion($id){
		$this->marina_chillan->select('r_requerimiento_area_cargo.id as idAreaCargo, r_requerimiento_area_cargo.cantidad as cantidadTrabajadores, r_cargos.nombre as nombreCargo, r_areas.nombre as nombreArea, r_requerimiento_area_cargo.valor_aprox as valor');
		$this->marina_chillan->from('r_requerimiento_area_cargo ');
		$this->marina_chillan->join('r_cargos ','r_cargos.id = r_requerimiento_area_cargo.cargos_id','inner');
		$this->marina_chillan->join('r_areas ','r_areas.id = r_requerimiento_area_cargo.areas_id','inner');
		$this->marina_chillan->where('requerimiento_id',$id);
		$query = $this->marina_chillan->get();
		return $query->result();
	}

}
?>