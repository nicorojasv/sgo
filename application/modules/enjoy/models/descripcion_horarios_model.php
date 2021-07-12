<?php
class Descripcion_horarios_model extends CI_Model {

	function __construct(){
		$this->enjoy = $this->load->database('enjoy', TRUE);
	}

	function ingresar($data){
		$this->enjoy->insert('descripcion_horarios',$data); 
		return $this->enjoy->insert_id();
	}

	function editar($id,$data){
		$this->enjoy->where('id', $id);
		$this->enjoy->update('descripcion_horarios', $data); 
	}

	function eliminar($id){
		$this->enjoy->delete('descripcion_horarios', array('id' => $id)); 
	}

	function get($id){
		$this->enjoy->where("id",$id);
		$query = $this->enjoy->get('descripcion_horarios');
		return $query->row();
	}

	function get_result($id){
		$this->enjoy->where("id",$id);
		$query = $this->enjoy->get('descripcion_horarios');
		return $query->result();
	}

	function listar(){
		$this->enjoy->select("*");
		$this->enjoy->from("descripcion_horarios");
		$query = $this->enjoy->get();
		return $query->result();
	}

}
?>