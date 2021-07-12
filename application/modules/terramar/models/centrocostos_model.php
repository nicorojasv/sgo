<?php
class Centrocostos_model extends CI_Model {
	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function listar(){
		$this->terramar->order_by("desc_centrocosto");
		$query = $this->terramar->get('centro_costos');
		return $query->result();
	}

	function listar_planta($id){
		$this->terramar->where("id_planta",$id);
		$this->terramar->order_by("desc_centrocosto");
		$query = $this->terramar->get('centro_costos');
		return $query->result();
	}
	function get($id){
		$this->terramar->where("id",$id);
		$query = $this->terramar->get('centro_costos');
		return $query->row();
	}
	function ingresar($data){
		$this->terramar->insert('centro_costos', $data); 
	}
	function eliminar($id){
		$this->terramar->delete('centro_costos', array('id' => $id)); 
	}
	function editar($id,$data){
		$this->terramar->where('id', $id);
		$this->terramar->update('centro_costos', $data); 
	}
}