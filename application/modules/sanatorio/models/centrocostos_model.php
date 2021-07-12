<?php
class Centrocostos_model extends CI_Model {
	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function listar(){
		$this->sanatorio->order_by("desc_centrocosto");
		$query = $this->sanatorio->get('centro_costos');
		return $query->result();
	}

	function listar_planta($id){
		$this->sanatorio->where("id_planta",$id);
		$this->sanatorio->order_by("desc_centrocosto");
		$query = $this->sanatorio->get('centro_costos');
		return $query->result();
	}
	function get($id){
		$this->sanatorio->where("id",$id);
		$query = $this->sanatorio->get('centro_costos');
		return $query->row();
	}
	function ingresar($data){
		$this->sanatorio->insert('centro_costos', $data); 
	}
	function eliminar($id){
		$this->sanatorio->delete('centro_costos', array('id' => $id)); 
	}
	function editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('centro_costos', $data); 
	}
}