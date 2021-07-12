<?php
class Descripcion_horarios_model extends CI_Model {

	function __construct(){
		$this->marina = $this->load->database('marina', TRUE);
	}

	function ingresar($data){
		$this->marina->insert('descripcion_horarios',$data); 
		return $this->marina->insert_id();
	}

	function editar($id,$data){
		$this->marina->where('id', $id);
		$this->marina->update('descripcion_horarios', $data); 
	}

	function eliminar($id){
		$this->marina->delete('descripcion_horarios', array('id' => $id)); 
	}

	function get($id){
		$this->marina->where("id",$id);
		$query = $this->marina->get('descripcion_horarios');
		return $query->row();
	}

	function get_result($id){
		$this->marina->where("id",$id);
		$query = $this->marina->get('descripcion_horarios');
		return $query->result();
	}

	function listar(){
		$this->marina->select("*");
		$this->marina->from("descripcion_horarios");
		$query = $this->marina->get();
		return $query->result();
	}

}
?>