<?php
class Empresa_planta_model extends CI_Model {

	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}

	function get($id){
		$this->sanatorio->where('id',$id);
		$query = $this->sanatorio->get('empresa_planta');
		return $query->row();
	}

	function listar(){
		$this->sanatorio->order_by('nombre', 'asc');
		$query = $this->sanatorio->get('empresa_planta');
		return $query->result();
	}

	function plantas_celulosas(){
		$this->sanatorio->select('*');
		$this->sanatorio->from('empresa_planta');
		$this->sanatorio->where('id_centro_costo', 1);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function plantas_paneles(){
		$this->sanatorio->select('*');
		$this->sanatorio->from('empresa_planta');
		$this->sanatorio->where('id_centro_costo', 2);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function plantas_forestal(){
		$this->sanatorio->select('*');
		$this->sanatorio->from('empresa_planta');
		$this->sanatorio->where('id_centro_costo', 3);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function listar_centro_costo($id_centro_costo){
		$this->sanatorio->from('empresa_planta');
		$this->sanatorio->where('id_centro_costo', $id_centro_costo);
		$query = $this->sanatorio->get();
		return $query->result();
	}


	function get_planta_centro_costo($id){
		$this->sanatorio->select('*');
		$this->sanatorio->from('empresa_planta ep');
		$this->sanatorio->join('centro_costos cc','ep.id_centro_costo = cc.id','left');
		$this->sanatorio->where('ep.id',$id);
		$query = $this->sanatorio->get();
		return $query->row();
	}
	

	function editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('empresa_planta', $data); 
	}
	
	function ingresar($data){
		$this->sanatorio->insert('empresa_planta',$data); 
		return $this->sanatorio->insert_id();
	}
	
	function eliminar($id){
		$this->sanatorio->delete('empresa_planta', array('id' => $id)); 
	}

}