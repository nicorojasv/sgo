<?php
class Planta_model extends CI_Model {
	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}
	function listar(){
		$query = $this->carrera->get('empresa_planta');
		return $query->result();
	}
	
	function get($id){
		$this->carrera->where('id',$id);
		$query = $this->carrera->get('empresa_planta');
		return $query->row();
	}
	function empresa($id){
		$this->carrera->where('id_empresa',$id);
		$query = $this->carrera->get('empresa_planta');
		return $query->row();
	}
	
	function get_empresa($id){
		$this->carrera->where('id_empresa',$id);
		$query = $this->carrera->get('empresa_planta');
		return $query->result();
	}
	
	function get_existe_nombre($nombre,$id_empresa){
		$this->carrera->where('nombre',$nombre);
		$this->carrera->where('id_empresa',$id_empresa);
		$query = $this->carrera->get('empresa_planta');
		return $query->result();
	}
	
	function editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('empresa_planta', $data); 
	}
	
	function validar_existe($data){
		$this->carrera->where('id_empresa',$data['id_empresa']);
		$this->carrera->where('nombre',$data['nombre']);
		$this->carrera->where('fono',$data['fono']);
		$this->carrera->where('fax',$data['fax']);
		$this->carrera->where('email',$data['email']);
		$this->carrera->where('id_regiones',$data['id_regiones']);
		$this->carrera->where('id_ciudades',$data['id_ciudades']);
		$this->carrera->where('id_provincias',$data['id_provincias']);
		$this->carrera->where('direccion',$data['direccion']);
		$query = $this->carrera->get('empresa_planta');
		return $query->row()->id;
	}
	
	function ingresar($data){
		$this->carrera->insert('empresa_planta',$data); 
		return $this->carrera->insert_id();
	}
	
	function eliminar($id){
		$this->carrera->delete('empresa_planta', array('id' => $id)); 
	}
	
	function get_nombre($nb){
		$this->carrera->where('nombre',$nb);
		$query = $this->carrera->get('empresa_planta');
		return $query->row();
	}

}