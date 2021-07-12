<?php
class Cargos_model extends CI_Model {

	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function listar(){
		$this->sanatorio->order_by("desc_cargo");
		$query = $this->sanatorio->get('cargos');
		return $query->result();
	}

	function r_listar(){
		$this->sanatorio->order_by("nombre");
		$query = $this->sanatorio->get('r_cargos');
		return $query->result();
	} 
	function lista(){
		$this->sanatorio->order_by("id");
		$query = $this->sanatorio->get('r_cargos');
		return $query->result();
	}




	function lista_orden_nombre(){
		$this->sanatorio->order_by("nombre");
		$query = $this->sanatorio->get('r_cargos');
		return $query->result();
	}





	function listar_planta($id){
		$this->sanatorio->where("id_planta",$id);
		$this->sanatorio->order_by("desc_cargo");
		$query = $this->sanatorio->get('cargos');
		return $query->result();
	}
	function listar_empresa($id){
		$this->sanatorio->where("id_empresa",$id);
		$this->sanatorio->order_by("desc_cargo");
		$query = $this->sanatorio->get('r_cargos');
		return $query->result();
	}
	function get($id){
		$this->sanatorio->where("id",$id);
		$query = $this->sanatorio->get('cargos');
		return $query->row();
	}




	function r_get($id){
		$this->sanatorio->where("id",$id);
		$query = $this->sanatorio->get('r_cargos');
		return $query->row();
	}




	function r_get_result($id){
		$this->sanatorio->where("id",$id);
		$query = $this->sanatorio->get('r_cargos');
		return $query->result();
	}
	function get_empresa($id){
		$this->sanatorio->where("id",$id);
		$query = $this->sanatorio->get('r_cargos');
		return $query->row();
	}
	function get_eval($id_planta,$nb){
		$this->sanatorio->where("id_planta",$id_planta);
		$this->sanatorio->where("desc_cargo",$nb);
		$query = $this->sanatorio->get('cargos');
		return $query->row();
	}
	function ingresar($data){
		$this->sanatorio->insert('cargos',$data); 
	}
	function insert($data){
		$this->sanatorio->insert('r_cargos',$data); 
	}
	function eliminar($id){
		$this->sanatorio->delete('cargos', array('id' => $id)); 
	}
	function r_eliminar($id){
		$this->sanatorio->delete('r_cargos', array('id' => $id)); 
	}
	function editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('cargos', $data); 
	}
	function r_editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('r_cargos', $data); 
	}

	function validar_cargo($nombre){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_cargos');
		$this->sanatorio->where('nombre', $nombre);
		$query = $this->sanatorio->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}
}