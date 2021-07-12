<?php
class Requerimiento_area_cargo_model extends CI_Model {

	function __construct(){
		$this->aramark = $this->load->database('aramark', TRUE);
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
		$this->aramark->where('id',$id);
		$query = $this->aramark->get('r_requerimiento_area_cargo');
		return $query->row();
	}

	function get_result($id){
		$this->aramark->where('id',$id);
		$query = $this->aramark->get('r_requerimiento_area_cargo');
		return $query->result();
	}

	function get_requerimiento($id){
		$this->aramark->where('requerimiento_id',$id);
		$query = $this->aramark->get('r_requerimiento_area_cargo');
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
		$this->aramark->delete('r_requerimiento_area_cargo', array('id' => $id)); 
	}

	function ingresar($data){
		$this->aramark->insert('r_requerimiento_area_cargo',$data); 
		return $this->aramark->insert_id();
	}

	function actualizar($data,$id){
		$this->aramark->where('id', $id);
		$this->aramark->update('r_requerimiento_area_cargo', $data); 
	}

}
?>