<?php
class Centrocostos_model extends CI_Model {
	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function listar(){
		$this->wood->order_by("desc_centrocosto");
		$query = $this->wood->get('centro_costos');
		return $query->result();
	}

	function listar_planta($id){
		$this->wood->where("id_planta",$id);
		$this->wood->order_by("desc_centrocosto");
		$query = $this->wood->get('centro_costos');
		return $query->result();
	}
	function get($id){
		$this->wood->where("id",$id);
		$query = $this->wood->get('centro_costos');
		return $query->row();
	}
	function ingresar($data){
		$this->wood->insert('centro_costos', $data); 
	}
	function eliminar($id){
		$this->wood->delete('centro_costos', array('id' => $id)); 
	}
	function editar($id,$data){
		$this->wood->where('id', $id);
		$this->wood->update('centro_costos', $data); 
	}
}