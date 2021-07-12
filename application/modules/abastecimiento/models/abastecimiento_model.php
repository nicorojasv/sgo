<?php
class Abastecimiento_model extends CI_Model {

	function __construct(){
		$this->general = $this->load->database('general', TRUE);
	}

	function ultimo_folio(){
		$this->general->select('id');
		$this->general->order_by('id','desc');
		$this->general->limit(1);
		$query = $this->general->get('abastecimiento');

     	if( is_null($query->row('id')) ) $folio = 0;
     	else $folio = (int)$query->row('id');

     	return $folio + 1;
	}

	function listar(){
		$query = $this->general->get('abastecimiento');
		return $query->result();
	}

	function get($id){
		$query = $this->general->get('abastecimiento');
		$this->general->where('id', $id);
		return $query->result();
	}

	function editar($id,$data){
		//$this->db->cache_delete_all();
		$this->general->where('id', $id);
		$this->general->update('abastecimiento', $data); 
	}

	function ingresar($data){
		//$this->db->cache_delete_all();
		$this->general->insert('abastecimiento',$data); 
		return $this->general->insert_id();
	}
	
	function eliminar($id){
		//$this->db->cache_delete_all();
		$this->general->delete('abastecimiento', array('id' => $id)); 
	}
}