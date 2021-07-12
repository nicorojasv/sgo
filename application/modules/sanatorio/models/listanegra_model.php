<?php
class Listanegra_model extends CI_Model {
		function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function listar(){
		$this->sanatorio->order_by("id","desc");
		$query = $this->sanatorio->get('lista_negra');
		return $query->result();
	}

	function listar_trabajador($id){
		$this->sanatorio->select('*,lista_negra.id lista_id, lista_negra.fecha fecha_ln');
		$this->sanatorio->from('lista_negra');
		$this->sanatorio->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$this->sanatorio->order_by("fecha_ln","desc");
		$this->sanatorio->where("id_usuario",$id);
		$query = $this->sanatorio->get();
		//$query = $this->sanatorio->get('lista_negra');
		return $query->result();
	}

	function contar_anotaciones_trabajador($id){
		$this->sanatorio->select('count(id) as total');
		$this->sanatorio->from('lista_negra');
		$this->sanatorio->where("id_usuario",$id);
		$query = $this->sanatorio->get();
		return $query->row();
	}
	
	function get($id){
		$this->sanatorio->where("id",$id);
		$query = $this->sanatorio->get('lista_negra');
		return $query->row();
	}
	
	function ingresar($data){
		$this->sanatorio->insert('lista_negra',$data);
		return $this->sanatorio->insert_id();
	}
	
	function eliminar($id){
		$this->sanatorio->delete('lista_negra', array('id' => $id)); 
	}
	
	function editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('lista_negra', $data); 
	}

	function listado_usuario(){
		$this->sanatorio->select('*,lista_negra.fecha fecha_ln');
		$this->sanatorio->from('lista_negra');
		$this->sanatorio->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$query = $this->sanatorio->get();
		return $query->result();
	}
	
}