<?php
class Planta_model extends CI_Model {
	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}
	function listar(){
		$query = $this->sanatorio->get('empresa_planta');
		return $query->result();
	}
	
	function get($id){
		$this->sanatorio->where('id',$id);
		$query = $this->sanatorio->get('empresa_planta');
		return $query->row();
	}
	function empresa($id){
		$this->sanatorio->where('id_empresa',$id);
		$query = $this->sanatorio->get('empresa_planta');
		return $query->row();
	}
	
	function get_empresa($id){
		$this->sanatorio->where('id_empresa',$id);
		$query = $this->sanatorio->get('empresa_planta');
		return $query->result();
	}
	
	function get_existe_nombre($nombre,$id_empresa){
		$this->sanatorio->where('nombre',$nombre);
		$this->sanatorio->where('id_empresa',$id_empresa);
		$query = $this->sanatorio->get('empresa_planta');
		return $query->result();
	}
	
	function editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('empresa_planta', $data); 
	}
	
	function validar_existe($data){
		$this->sanatorio->where('id_empresa',$data['id_empresa']);
		$this->sanatorio->where('nombre',$data['nombre']);
		$this->sanatorio->where('fono',$data['fono']);
		$this->sanatorio->where('fax',$data['fax']);
		$this->sanatorio->where('email',$data['email']);
		$this->sanatorio->where('id_regiones',$data['id_regiones']);
		$this->sanatorio->where('id_ciudades',$data['id_ciudades']);
		$this->sanatorio->where('id_provincias',$data['id_provincias']);
		$this->sanatorio->where('direccion',$data['direccion']);
		$query = $this->sanatorio->get('empresa_planta');
		return $query->row()->id;
	}
	
	function ingresar($data){
		$this->sanatorio->insert('empresa_planta',$data); 
		return $this->sanatorio->insert_id();
	}
	
	function eliminar($id){
		$this->sanatorio->delete('empresa_planta', array('id' => $id)); 
	}
	
	function get_nombre($nb){
		$this->sanatorio->where('nombre',$nb);
		$query = $this->sanatorio->get('empresa_planta');
		return $query->row();
	}

}