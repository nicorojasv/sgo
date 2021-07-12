<?php
class Descripcion_horarios_model extends CI_Model {

	function __construct(){
		$this->aramark = $this->load->database('aramark', TRUE); 
	}

	function ingresar($data){
		$this->aramark->insert('descripcion_horarios',$data); 
		return $this->aramark->insert_id();
	}

	function editar($id,$data){
		$this->aramark->where('id', $id);
		$this->aramark->update('descripcion_horarios', $data); 
	}

	function eliminar($id){
		$this->aramark->delete('descripcion_horarios', array('id' => $id)); 
	}

	function get($id){
		$this->aramark->where("id",$id);
		$query = $this->aramark->get('descripcion_horarios');
		return $query->row();
	}

	function get_result($id){
		$this->aramark->where("id",$id);
		$query = $this->aramark->get('descripcion_horarios');
		return $query->result();
	}

	function listar(){
		$this->aramark->select("*");
		$this->aramark->from("descripcion_horarios");
		$query = $this->aramark->get();
		return $query->result();
	}

}
?>