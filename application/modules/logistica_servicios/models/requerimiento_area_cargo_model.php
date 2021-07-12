<?php
class Requerimiento_area_cargo_model extends CI_Model {

	function __construct(){
		$this->log_serv = $this->load->database('log_serv', TRUE);
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
		$this->log_serv->where('id',$id);
		$query = $this->log_serv->get('r_requerimiento_area_cargo');
		return $query->row();
	}

	function get_result($id){
		$this->log_serv->where('id',$id);
		$query = $this->log_serv->get('r_requerimiento_area_cargo');
		return $query->result();
	}

	function get_requerimiento($id){
		$this->log_serv->where('requerimiento_id',$id);
		$query = $this->log_serv->get('r_requerimiento_area_cargo');
		return $query->result();
	}

	function r_get_requerimiento($id_req_area_cargo){
		$this->log_serv->select('*');
		$this->log_serv->select('r_req.id as id_req');
		$this->log_serv->from('r_requerimiento_area_cargo r_req_ac');
		$this->log_serv->where('r_req_ac.id',$id_req_area_cargo);
		$this->log_serv->join('r_requerimiento r_req','r_req_ac.requerimiento_id = r_req.id','left');
		$query = $this->log_serv->get();
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
		$this->log_serv->delete('r_requerimiento_area_cargo', array('id' => $id)); 
	}

	function ingresar($data){
		$this->log_serv->insert('r_requerimiento_area_cargo',$data); 
		return $this->log_serv->insert_id();
	}

	function actualizar($data,$id){
		$this->log_serv->where('id', $id);
		$this->log_serv->update('r_requerimiento_area_cargo', $data); 
	}

}
?>