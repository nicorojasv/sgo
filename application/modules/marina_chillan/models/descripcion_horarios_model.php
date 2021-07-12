<?php
class Descripcion_horarios_model extends CI_Model {

	function __construct(){
		$this->marina_chillan = $this->load->database('marina_chillan', TRUE);
	}

	function ingresar($data){
		$this->marina_chillan->insert('descripcion_horarios',$data); 
		return $this->marina_chillan->insert_id();
	}

	function editar($id,$data){
		$this->marina_chillan->where('id', $id);
		$this->marina_chillan->update('descripcion_horarios', $data); 
	}

	function eliminar($id){
		$this->marina_chillan->delete('descripcion_horarios', array('id' => $id)); 
	}

	function get($id){
		$this->marina_chillan->where("id",$id);
		$query = $this->marina_chillan->get('descripcion_horarios');
		return $query->row();
	}

	function get_result($id){
		$this->marina_chillan->where("id",$id);
		$query = $this->marina_chillan->get('descripcion_horarios');
		return $query->result();
	}

	function listar(){
		$this->marina_chillan->select("*");
		$this->marina_chillan->from("descripcion_horarios");
		$query = $this->marina_chillan->get();
		return $query->result();
	}

}
?>