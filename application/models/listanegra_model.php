<?php
class Listanegra_model extends CI_Model {

	function listar(){
		$this->db->order_by("id","desc");
		$query = $this->db->get('lista_negra');
		return $query->result();
	}

	function listar_trabajador($id){
		$this->db->select('*,lista_negra.id lista_id, lista_negra.fecha fecha_ln');
		$this->db->from('lista_negra');
		$this->db->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$this->db->order_by("fecha_ln","desc");
		$this->db->where("id_usuario",$id);
		$query = $this->db->get();
		//$query = $this->db->get('lista_negra');
		return $query->result();
	}

	function contar_anotaciones_trabajador($id){
		$this->db->select('count(id) as total');
		$this->db->from('lista_negra');
		$this->db->where("id_usuario",$id);
		$query = $this->db->get();
		return $query->row();
	}
	
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('lista_negra');
		return $query->row();
	}
	
	function ingresar($data){
		$this->db->insert('lista_negra',$data);
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('lista_negra', array('id' => $id)); 
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('lista_negra', $data); 
	}

	function listado_usuario(){
		$this->db->select('*,lista_negra.fecha fecha_ln');
		$this->db->from('lista_negra');
		$this->db->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$query = $this->db->get();
		return $query->result();
	}
	
}