<?php
class Descripcion_horarios_model extends CI_Model {

	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function ingresar($data){
		$this->carrera->insert('descripcion_horarios',$data); 
		return $this->carrera->insert_id();
	}

	function editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('descripcion_horarios', $data); 
	}

	function eliminar($id){
		$this->carrera->delete('descripcion_horarios', array('id' => $id)); 
	}

	function get($id){
		$this->carrera->where("id",$id);
		$query = $this->carrera->get('descripcion_horarios');
		return $query->row();
	}

	function get_result($id){
		$this->carrera->where("id",$id);
		$query = $this->carrera->get('descripcion_horarios');
		return $query->result();
	}

	function listar(){
		$this->carrera->select("*");
		$this->carrera->from("descripcion_horarios");
		$query = $this->carrera->get();
		return $query->result();
	}

	function listar_planta($id_planta){
		$this->carrera->select("*");
		$this->carrera->from("descripcion_horarios");
		$query = $this->carrera->get();
		return $query->result();
	}


}
?>