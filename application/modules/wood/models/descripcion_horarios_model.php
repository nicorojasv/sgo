<?php
class Descripcion_horarios_model extends CI_Model {

	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function ingresar($data){
		$this->wood->insert('descripcion_horarios',$data); 
		return $this->wood->insert_id();
	}

	function editar($id,$data){
		$this->wood->where('id', $id);
		$this->wood->update('descripcion_horarios', $data); 
	}

	function eliminar($id){
		$this->wood->delete('descripcion_horarios', array('id' => $id)); 
	}

	function get($id){
		$this->wood->where("id",$id);
		$query = $this->wood->get('descripcion_horarios');
		return $query->row();
	}

	function get_result($id){
		$this->wood->where("id",$id);
		$query = $this->wood->get('descripcion_horarios');
		return $query->result();
	}

	function listar(){
		$this->wood->select("*");
		$this->wood->from("descripcion_horarios");
		$query = $this->wood->get();
		return $query->result();
	}

	function listar_planta($id_planta){
		$this->wood->select("*");
		$this->wood->from("descripcion_horarios");
		$query = $this->wood->get();
		return $query->result();
	}


}
?>