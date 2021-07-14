<?php
class Centrocostos_model extends CI_Model {
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function listar(){
		$this->carrera->order_by("desc_centrocosto");
		$query = $this->carrera->get('centro_costos');
		return $query->result();
	}

	function listar_planta($id){
		$this->carrera->where("id_planta",$id);
		$this->carrera->order_by("desc_centrocosto");
		$query = $this->carrera->get('centro_costos');
		return $query->result();
	}
	function get($id){
		$this->carrera->where("id",$id);
		$query = $this->carrera->get('centro_costos');
		return $query->row();
	}
	function ingresar($data){
		$this->carrera->insert('centro_costos', $data); 
	}
	function eliminar($id){
		$this->carrera->delete('centro_costos', array('id' => $id)); 
	}
	function editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('centro_costos', $data); 
	}
}