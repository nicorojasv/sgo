<?php
class Ciudades_model extends CI_Model {
	
	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function listar(){
		$this->wood->select('*');
		$this->wood->from('ciudades');
		$query = $this->wood->get();
		return $query->result();
	}

	function get($id){
		$this->wood->where('id', $id);
		$query = $this->wood->get('ciudades');
		return $query->row();
	}

	function editar($id,$data){
		//$this->wood->cache_delete_all();
		$this->wood->where('id', $id);
		$this->wood->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->general->insert('usuarios',$data); 
		return $this->general->insert_id();
	}

	function eliminar($id){
		//$this->wood->cache_delete_all();
		$this->wood->delete('usuarios', array('id' => $id)); 
	}

	function listar_region($id_region){
		$this->wood->where("id_regiones",$id_region);
		$this->wood->order_by("desc_ciudades");
		$query = $this->wood->get('ciudades');
		return $query->result();
	}

}
?>