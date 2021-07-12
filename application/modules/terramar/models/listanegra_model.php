<?php
class Listanegra_model extends CI_Model {
		function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function listar(){
		$this->terramar->order_by("id","desc");
		$query = $this->terramar->get('lista_negra');
		return $query->result();
	}

	function listar_trabajador($id){
		$this->terramar->select('*,lista_negra.id lista_id, lista_negra.fecha fecha_ln');
		$this->terramar->from('lista_negra');
		$this->terramar->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$this->terramar->order_by("fecha_ln","desc");
		$this->terramar->where("id_usuario",$id);
		$query = $this->terramar->get();
		//$query = $this->terramar->get('lista_negra');
		return $query->result();
	}

	function contar_anotaciones_trabajador($id){
		$this->terramar->select('count(id) as total');
		$this->terramar->from('lista_negra');
		$this->terramar->where("id_usuario",$id);
		$query = $this->terramar->get();
		return $query->row();
	}
	
	function get($id){
		$this->terramar->where("id",$id);
		$query = $this->terramar->get('lista_negra');
		return $query->row();
	}
	
	function ingresar($data){
		$this->terramar->insert('lista_negra',$data);
		return $this->terramar->insert_id();
	}
	
	function eliminar($id){
		$this->terramar->delete('lista_negra', array('id' => $id)); 
	}
	
	function editar($id,$data){
		$this->terramar->where('id', $id);
		$this->terramar->update('lista_negra', $data); 
	}

	function listado_usuario(){
		$this->terramar->select('*,lista_negra.fecha fecha_ln');
		$this->terramar->from('lista_negra');
		$this->terramar->join('usuarios', 'usuarios.id = lista_negra.id_usuario');
		$query = $this->terramar->get();
		return $query->result();
	}
	
}