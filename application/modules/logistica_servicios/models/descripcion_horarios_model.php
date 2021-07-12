<?php
class Descripcion_horarios_model extends CI_Model {

	function __construct(){
		$this->log_serv = $this->load->database('log_serv', TRUE);
	}

	function get($id){
		$this->log_serv->where("id",$id);
		$query = $this->log_serv->get('descripcion_horarios');
		return $query->row();
	}

	function ingresar($data){
		$this->log_serv->insert('descripcion_horarios',$data); 
		return $this->log_serv->insert_id();
	}

	function editar($id,$data){
		$this->log_serv->where('id', $id);
		$this->log_serv->update('descripcion_horarios', $data); 
	}

	function eliminar($id){
		$this->log_serv->delete('descripcion_horarios', array('id' => $id)); 
	}

	function get_result($id){
		$this->log_serv->select("*");
		$this->log_serv->from("descripcion_horarios");
		$this->log_serv->where("id", $id);
		$query = $this->log_serv->get('');
		return $query->result();
	}

	function listar(){
		$this->log_serv->select("*");
		$this->log_serv->select("dp.id id_horario");
		$this->log_serv->from("descripcion_horarios dp");
		$this->log_serv->join("empresa_planta ep",'dp.id_empresa_planta = ep.id','left');
		$query = $this->log_serv->get('');
		return $query->result();
	}

	function listar_planta($id_planta){
		$this->log_serv->select("*");
		$this->log_serv->from("descripcion_horarios");
		$this->log_serv->where("id_empresa_planta", $id_planta);
		$query = $this->log_serv->get('');
		return $query->result();
	}

}
?>