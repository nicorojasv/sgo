<?php
class Empresa_planta_model extends CI_Model {

	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function get($id){
		$this->terramar->where('id',$id);
		$query = $this->terramar->get('empresa_planta');
		return $query->row();
	}

	function listar(){
		$this->terramar->order_by('nombre', 'asc');
		$query = $this->terramar->get('empresa_planta');
		return $query->result();
	}

	function plantas_celulosas(){
		$this->terramar->select('*');
		$this->terramar->from('empresa_planta');
		$this->terramar->where('id_centro_costo', 1);
		$query = $this->terramar->get();
		return $query->result();
	}

	function plantas_paneles(){
		$this->terramar->select('*');
		$this->terramar->from('empresa_planta');
		$this->terramar->where('id_centro_costo', 2);
		$query = $this->terramar->get();
		return $query->result();
	}

	function plantas_forestal(){
		$this->terramar->select('*');
		$this->terramar->from('empresa_planta');
		$this->terramar->where('id_centro_costo', 3);
		$query = $this->terramar->get();
		return $query->result();
	}

	function listar_centro_costo($id_centro_costo){
		$this->terramar->from('empresa_planta');
		$this->terramar->where('id_centro_costo', $id_centro_costo);
		$query = $this->terramar->get();
		return $query->result();
	}


	function get_planta_centro_costo($id){
		$this->terramar->select('*');
		$this->terramar->from('empresa_planta ep');
		$this->terramar->join('centro_costos cc','ep.id_centro_costo = cc.id','left');
		$this->terramar->where('ep.id',$id);
		$query = $this->terramar->get();
		return $query->row();
	}
	

	function editar($id,$data){
		$this->terramar->where('id', $id);
		$this->terramar->update('empresa_planta', $data); 
	}
	
	function ingresar($data){
		$this->terramar->insert('empresa_planta',$data); 
		return $this->terramar->insert_id();
	}
	
	function eliminar($id){
		$this->terramar->delete('empresa_planta', array('id' => $id)); 
	}

}