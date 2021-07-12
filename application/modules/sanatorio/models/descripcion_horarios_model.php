<?php
class Descripcion_horarios_model extends CI_Model {

	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function ingresar($data){
		$this->sanatorio->insert('descripcion_horarios',$data); 
		return $this->sanatorio->insert_id();
	}

	function editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('descripcion_horarios', $data); 
	}

	function eliminar($id){
		$this->sanatorio->delete('descripcion_horarios', array('id' => $id)); 
	}

	function get($id){
		$this->sanatorio->where("id",$id);
		$query = $this->sanatorio->get('descripcion_horarios');
		return $query->row();
	}

	function get_result($id){
		$this->sanatorio->where("id",$id);
		$query = $this->sanatorio->get('descripcion_horarios');
		return $query->result();
	}

	function listar(){
		$this->sanatorio->select("*");
		$this->sanatorio->from("descripcion_horarios");
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function listar_planta($id_planta){
		$this->sanatorio->select("*");
		$this->sanatorio->from("descripcion_horarios");
		$query = $this->sanatorio->get();
		return $query->result();
	}


}
?>