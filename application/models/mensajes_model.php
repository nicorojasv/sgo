<?php
class Mensajes_model extends CI_Model {

	function listar(){
		$this->db->order_by("fecha","desc");
		$query = $this->db->get('mensajes');
		return $query->result();
	}

	function listar_trabajador($id){
		$this->db->select('m.fecha,m.id,m.asunto,m.texto,m.id_usuario_resp,m.visto_resp,m.id_usuario_envio,m.visto_envio');
		$this->db->from('mensajes AS m');
		$this->db->join('mensajes_resp AS mr','m.id = mr.id_mensaje','left');
		$this->db->order_by("m.fecha desc, mr.fecha desc");
		$this->db->where("m.id_usuario_envio",$id);
		$this->db->or_where("m.id_usuario_resp",$id);
		$this->db->group_by("m.id"); 
		$query = $this->db->get();
//		echo $this->db->last_query();
		return $query->result();
	}
	
	function listar_admin($id){
		$this->db->order_by("fecha","desc");
		$this->db->where("id_usuario_envio",$id);
		$this->db->or_where("admin",1);
		$query = $this->db->get('mensajes');
		return $query->result();
	}
	
	function cantidad_noleidas_envio($id_usr){
		$this->db->where("id_usuario_envio",$id_usr);
		$this->db->where("visto_envio",0);
		$query = $this->db->get('mensajes');
		//echo $this->db->last_query();
		return count($query->result());
	}

	function cantidad_noleidas_resp($id_usr){
		$this->db->where("id_usuario_resp",$id_usr);
		$this->db->where("visto_resp",0);
		$query = $this->db->get('mensajes');
		return count($query->result());
	}
	
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('mensajes');
		return $query->row();
	}
	
	function ingresar($data){
		$this->db->insert('mensajes',$data);
		return $this->db->insert_id();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('mensajes', $data); 
	}

	function eliminar($id){
		$c = $this->get($id);
		if($c->borrado == 1){
			$this->db->delete('mensajes', array('id' => $id));
		} 
		else{
			$data = array(
				'borrado' => 1,
			);
			$this->editar($id,$data);
		}
	}
	
}