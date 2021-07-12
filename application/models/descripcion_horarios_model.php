<?php
class Descripcion_horarios_model extends CI_Model {

	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('descripcion_horarios');
		return $query->row();
	}

	function ingresar($data){
		$this->db->insert('descripcion_horarios',$data); 
		return $this->db->insert_id();
	}

	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('descripcion_horarios', $data); 
	}

	function eliminar($id){
		$this->db->delete('descripcion_horarios', array('id' => $id)); 
	}

	function get_result($id){
		$this->db->select("*");
		$this->db->from("descripcion_horarios");
		$this->db->where("id", $id);
		$query = $this->db->get();
		return $query->result();
	}

	function listar(){
		$this->db->select("*");
		$this->db->select("dp.id id_horario");
		$this->db->from("descripcion_horarios dp");
		$this->db->join("empresa_planta ep",'dp.id_empresa_planta = ep.id','left');
		$query = $this->db->get();
		return $query->result();
	}

	function listar_menos_transversales(){
		$this->db->select("*");
		$this->db->select("dp.id id_horario");
		$this->db->from("descripcion_horarios dp");
		$this->db->join("empresa_planta ep",'dp.id_empresa_planta = ep.id','left');
		$this->db->where('dp.id !=','1');
		$this->db->where('dp.id !=','2');
		$this->db->where('dp.id !=','3');
		$query = $this->db->get();
		return $query->result();
	}

	function listar_planta($id_planta){
		$this->db->select("*");
		$this->db->from("descripcion_horarios");
		$this->db->where("id_empresa_planta", $id_planta);
		$query = $this->db->get();
		return $query->result();
	}

}
?>