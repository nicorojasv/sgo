<?php
class Mensajesresp_model extends CI_Model {
	function listar(){
		$this->db->order_by("id","desc");
		$query = $this->db->get('mensajes_resp');
		return $query->result();
	}
	
	function listar_usuario($id){
		$this->db->where("id_usuarios",$id);
		$this->db->group_by("id_mensaje");
		$query = $this->db->get('mensajes_resp');
		return $query->result();
	}
	function listar_respuestas($id){
		$this->db->where("id_mensaje",$id);
		$query = $this->db->get('mensajes_resp');
		return $query->result();
	}
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('mensajes_resp');
		return $query->row();
	}
	
	function ingresar($data){
		$this->db->insert('mensajes_resp',$data);
		return $this->db->insert_id();
	}
	function eliminar($id){
		$this->db->delete('mensajes_resp', array('id' => $id)); 
	}
	
	function cantidad_noleidas($id_msj,$id_usr){
		$this->db->where("id_mensaje", $id_msj);
		$this->db->where("id_usuarios !=", $id_usr);
		$this->db->where("flag_leido",0);
		$query = $this->db->get('mensajes_resp');
		return count($query->result());
	}
	
	function leido($id_mj,$id_usr){
		$data = array( 'flag_leido' => 1 );
		$this->db->where("id_mensaje", $id_mj);
		$this->db->where("id_usuarios !=", $id_usr);
		$this->db->update('mensajes_resp', $data); 
	}
	
}