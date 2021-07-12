<?php
class Listanegra_model extends CI_Model {
		function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function listar(){
		$this->wood->order_by("id","desc");
		$query = $this->wood->get('lista_negra');
		return $query->result();
	}

	function listar_trabajador($id){
		$this->wood->select('*,lista_negra.id lista_id, lista_negra.fecha fecha_ln');
		$this->wood->from('lista_negra');
		$this->wood->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$this->wood->order_by("fecha_ln","desc");
		$this->wood->where("id_usuario",$id);
		$query = $this->wood->get();
		//$query = $this->wood->get('lista_negra');
		return $query->result();
	}

	function contar_anotaciones_trabajador($id){
		$this->wood->select('count(id) as total');
		$this->wood->from('lista_negra');
		$this->wood->where("id_usuario",$id);
		$query = $this->wood->get();
		return $query->row();
	}
	
	function get($id){
		$this->wood->where("id",$id);
		$query = $this->wood->get('lista_negra');
		return $query->row();
	}
	
	function ingresar($data){
		$this->wood->insert('lista_negra',$data);
		return $this->wood->insert_id();
	}
	
	function eliminar($id){
		$this->wood->delete('lista_negra', array('id' => $id)); 
	}
	
	function editar($id,$data){
		$this->wood->where('id', $id);
		$this->wood->update('lista_negra', $data); 
	}

	function listado_usuario(){
		$this->wood->select('*,lista_negra.fecha fecha_ln');
		$this->wood->from('lista_negra');
		$this->wood->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$query = $this->wood->get();
		return $query->result();
	}
	
}