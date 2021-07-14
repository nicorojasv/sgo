<?php
class Descripcion_horarios_model extends CI_Model {

	function __construct(){
		$this->carerra = $this->load->database('carerra', TRUE);
	}

	function ingresar($data){
		$this->carerra->insert('descripcion_horarios',$data); 
		return $this->carerra->insert_id();
	}

	function editar($id,$data){
		$this->carerra->where('id', $id);
		$this->carerra->update('descripcion_horarios', $data); 
	}

	function eliminar($id){
		$this->carerra->delete('descripcion_horarios', array('id' => $id)); 
	}

	function get($id){
		$this->carerra->where("id",$id);
		$query = $this->carerra->get('descripcion_horarios');
		return $query->row();
	}

	function get_result($id){
		$this->carerra->where("id",$id);
		$query = $this->carerra->get('descripcion_horarios');
		return $query->result();
	}

	function listar(){
		$this->carerra->select("*");
		$this->carerra->from("descripcion_horarios");
		$query = $this->carerra->get();
		return $query->result();
	}

	function listar_planta($id_planta){
		$this->carerra->select("*");
		$this->carerra->from("descripcion_horarios");
		$query = $this->carerra->get();
		return $query->result();
	}


}
?>