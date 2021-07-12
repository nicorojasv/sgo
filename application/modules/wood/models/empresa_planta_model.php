<?php
class Empresa_planta_model extends CI_Model {

	function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}

	function get($id){
		$this->wood->where('id',$id);
		$query = $this->wood->get('empresa_planta');
		return $query->row();
	}

	function listar(){
		$this->wood->order_by('nombre', 'asc');
		$query = $this->wood->get('empresa_planta');
		return $query->result();
	}

	function plantas_celulosas(){
		$this->wood->select('*');
		$this->wood->from('empresa_planta');
		$this->wood->where('id_centro_costo', 1);
		$query = $this->wood->get();
		return $query->result();
	}

	function plantas_paneles(){
		$this->wood->select('*');
		$this->wood->from('empresa_planta');
		$this->wood->where('id_centro_costo', 2);
		$query = $this->wood->get();
		return $query->result();
	}

	function plantas_forestal(){
		$this->wood->select('*');
		$this->wood->from('empresa_planta');
		$this->wood->where('id_centro_costo', 3);
		$query = $this->wood->get();
		return $query->result();
	}

	function listar_centro_costo($id_centro_costo){
		$this->wood->from('empresa_planta');
		$this->wood->where('id_centro_costo', $id_centro_costo);
		$query = $this->wood->get();
		return $query->result();
	}


	function get_planta_centro_costo($id){
		$this->wood->select('*');
		$this->wood->from('empresa_planta ep');
		$this->wood->join('centro_costos cc','ep.id_centro_costo = cc.id','left');
		$this->wood->where('ep.id',$id);
		$query = $this->wood->get();
		return $query->row();
	}
	

	function editar($id,$data){
		$this->wood->where('id', $id);
		$this->wood->update('empresa_planta', $data); 
	}
	
	function ingresar($data){
		$this->wood->insert('empresa_planta',$data); 
		return $this->wood->insert_id();
	}
	
	function eliminar($id){
		$this->wood->delete('empresa_planta', array('id' => $id)); 
	}

}