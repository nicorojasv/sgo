<?php
class Listanegra_model extends CI_Model {
		function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function listar(){
		$this->carrera->order_by("id","desc");
		$query = $this->carrera->get('lista_negra');
		return $query->result();
	}

	function listar_trabajador($id){
		$this->carrera->select('*,lista_negra.id lista_id, lista_negra.fecha fecha_ln');
		$this->carrera->from('lista_negra');
		$this->carrera->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$this->carrera->order_by("fecha_ln","desc");
		$this->carrera->where("id_usuario",$id);
		$query = $this->carrera->get();
		//$query = $this->carrera->get('lista_negra');
		return $query->result();
	}

	function contar_anotaciones_trabajador($id){
		$this->carrera->select('count(id) as total');
		$this->carrera->from('lista_negra');
		$this->carrera->where("id_usuario",$id);
		$query = $this->carrera->get();
		return $query->row();
	}
	
	function get($id){
		$this->carrera->where("id",$id);
		$query = $this->carrera->get('lista_negra');
		return $query->row();
	}
	
	function ingresar($data){
		$this->carrera->insert('lista_negra',$data);
		return $this->carrera->insert_id();
	}
	
	function eliminar($id){
		$this->carrera->delete('lista_negra', array('id' => $id)); 
	}
	
	function editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('lista_negra', $data); 
	}

	function listado_usuario(){
		$this->carrera->select('*,lista_negra.fecha fecha_ln');
		$this->carrera->from('lista_negra');
		$this->carrera->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$query = $this->carrera->get();
		return $query->result();
	}
	
}