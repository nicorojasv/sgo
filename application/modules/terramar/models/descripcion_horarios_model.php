<?php
class Descripcion_horarios_model extends CI_Model {

	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function ingresar($data){
		$this->terramar->insert('descripcion_horarios',$data); 
		return $this->terramar->insert_id();
	}

	function editar($id,$data){
		$this->terramar->where('id', $id);
		$this->terramar->update('descripcion_horarios', $data); 
	}

	function eliminar($id){
		$this->terramar->delete('descripcion_horarios', array('id' => $id)); 
	}

	function get($id){
		$this->terramar->where("id",$id);
		$query = $this->terramar->get('descripcion_horarios');
		return $query->row();
	}

	function get_result($id){
		$this->terramar->where("id",$id);
		$query = $this->terramar->get('descripcion_horarios');
		return $query->result();
	}

	function listar(){
		$this->terramar->select("*");
		$this->terramar->from("descripcion_horarios");
		$query = $this->terramar->get();
		return $query->result();
	}

	function listar_planta($id_planta){
		$this->terramar->select("*");
		$this->terramar->from("descripcion_horarios");
		$query = $this->terramar->get();
		return $query->result();
	}


}
?>