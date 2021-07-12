<?php
class Ciudades_model extends CI_Model {
	
	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function listar(){
		$this->terramar->select('*');
		$this->terramar->from('ciudades');
		$query = $this->terramar->get();
		return $query->result();
	}

	function get($id){
		$this->terramar->where('id', $id);
		$query = $this->terramar->get('ciudades');
		return $query->row();
	}

	function editar($id,$data){
		//$this->terramar->cache_delete_all();
		$this->terramar->where('id', $id);
		$this->terramar->update('usuarios', $data); 
	}

	function ingresar($data){
		$this->general->insert('usuarios',$data); 
		return $this->general->insert_id();
	}

	function eliminar($id){
		//$this->terramar->cache_delete_all();
		$this->terramar->delete('usuarios', array('id' => $id)); 
	}

	function listar_region($id_region){
		$this->terramar->where("id_regiones",$id_region);
		$this->terramar->order_by("desc_ciudades");
		$query = $this->terramar->get('ciudades');
		return $query->result();
	}

}
?>