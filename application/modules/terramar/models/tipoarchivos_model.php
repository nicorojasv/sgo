<?php
class Tipoarchivos_model extends CI_Model {
	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}
	function listar(){
		$this->terramar->order_by("desc_tipoarchivo");
		$query = $this->terramar->get('tipo_archivos');
		return $query->result();
	}

	function listar_2(){
		$this->terramar->order_by("id desc");
		$query = $this->terramar->get('tipo_archivos');
		return $query->result();
	}
	
	function get($id){
		$this->terramar->where("id",$id);
		$query = $this->terramar->get('tipo_archivos');
		return $query->row();
	}
	
	function ingresar($data){
		$this->terramar->insert('tipo_archivos',$data);
		return $this->terramar->insert_id();
	}
	
	function actualizar($data,$id){
		$this->terramar->where('id', $id);
		$this->terramar->update('tipo_archivos', $data); 
	}
}