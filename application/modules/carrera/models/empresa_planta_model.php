<?php
class Empresa_planta_model extends CI_Model {

	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}

	function get($id){
		$this->carrera->where('id',$id);
		$query = $this->carrera->get('empresa_planta');
		return $query->row();
	}

	function listar(){
		$this->carrera->order_by('nombre', 'asc');
		$query = $this->carrera->get('empresa_planta');
		return $query->result();
	}

	function plantas_celulosas(){
		$this->carrera->select('*');
		$this->carrera->from('empresa_planta');
		$this->carrera->where('id_centro_costo', 1);
		$query = $this->carrera->get();
		return $query->result();
	}

	function plantas_paneles(){
		$this->carrera->select('*');
		$this->carrera->from('empresa_planta');
		$this->carrera->where('id_centro_costo', 2);
		$query = $this->carrera->get();
		return $query->result();
	}

	function plantas_forestal(){
		$this->carrera->select('*');
		$this->carrera->from('empresa_planta');
		$this->carrera->where('id_centro_costo', 3);
		$query = $this->carrera->get();
		return $query->result();
	}

	function listar_centro_costo($id_centro_costo){
		$this->carrera->from('empresa_planta');
		$this->carrera->where('id_centro_costo', $id_centro_costo);
		$query = $this->carrera->get();
		return $query->result();
	}


	function get_planta_centro_costo($id){
		$this->carrera->select('*');
		$this->carrera->from('empresa_planta ep');
		$this->carrera->join('centro_costos cc','ep.id_centro_costo = cc.id','left');
		$this->carrera->where('ep.id',$id);
		$query = $this->carrera->get();
		return $query->row();
	}
	

	function editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('empresa_planta', $data); 
	}
	
	function ingresar($data){
		$this->carrera->insert('empresa_planta',$data); 
		return $this->carrera->insert_id();
	}
	
	function eliminar($id){
		$this->carrera->delete('empresa_planta', array('id' => $id)); 
	}

}