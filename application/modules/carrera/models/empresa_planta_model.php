<?php
class Empresa_planta_model extends CI_Model {

	function __construct(){
		$this->carerra = $this->load->database('carerra', TRUE);
	}

	function get($id){
		$this->carerra->where('id',$id);
		$query = $this->carerra->get('empresa_planta');
		return $query->row();
	}

	function listar(){
		$this->carerra->order_by('nombre', 'asc');
		$query = $this->carerra->get('empresa_planta');
		return $query->result();
	}

	function plantas_celulosas(){
		$this->carerra->select('*');
		$this->carerra->from('empresa_planta');
		$this->carerra->where('id_centro_costo', 1);
		$query = $this->carerra->get();
		return $query->result();
	}

	function plantas_paneles(){
		$this->carerra->select('*');
		$this->carerra->from('empresa_planta');
		$this->carerra->where('id_centro_costo', 2);
		$query = $this->carerra->get();
		return $query->result();
	}

	function plantas_forestal(){
		$this->carerra->select('*');
		$this->carerra->from('empresa_planta');
		$this->carerra->where('id_centro_costo', 3);
		$query = $this->carerra->get();
		return $query->result();
	}

	function listar_centro_costo($id_centro_costo){
		$this->carerra->from('empresa_planta');
		$this->carerra->where('id_centro_costo', $id_centro_costo);
		$query = $this->carerra->get();
		return $query->result();
	}


	function get_planta_centro_costo($id){
		$this->carerra->select('*');
		$this->carerra->from('empresa_planta ep');
		$this->carerra->join('centro_costos cc','ep.id_centro_costo = cc.id','left');
		$this->carerra->where('ep.id',$id);
		$query = $this->carerra->get();
		return $query->row();
	}
	

	function editar($id,$data){
		$this->carerra->where('id', $id);
		$this->carerra->update('empresa_planta', $data); 
	}
	
	function ingresar($data){
		$this->carerra->insert('empresa_planta',$data); 
		return $this->carerra->insert_id();
	}
	
	function eliminar($id){
		$this->carerra->delete('empresa_planta', array('id' => $id)); 
	}

}