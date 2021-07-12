<?php
class Planta_model extends CI_Model {
	function listar(){
		$query = $this->db->get('empresa_planta');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('empresa_planta');
		return $query->row();
	}
	function empresa($id){
		$this->db->where('id_empresa',$id);
		$query = $this->db->get('empresa_planta');
		return $query->row();
	}
	
	function get_empresa($id){
		$this->db->where('id_empresa',$id);
		$query = $this->db->get('empresa_planta');
		return $query->result();
	}
	
	function get_existe_nombre($nombre,$id_empresa){
		$this->db->where('nombre',$nombre);
		$this->db->where('id_empresa',$id_empresa);
		$query = $this->db->get('empresa_planta');
		return $query->result();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('empresa_planta', $data); 
	}
	
	function validar_existe($data){
		$this->db->where('id_empresa',$data['id_empresa']);
		$this->db->where('nombre',$data['nombre']);
		$this->db->where('fono',$data['fono']);
		$this->db->where('fax',$data['fax']);
		$this->db->where('email',$data['email']);
		$this->db->where('id_regiones',$data['id_regiones']);
		$this->db->where('id_ciudades',$data['id_ciudades']);
		$this->db->where('id_provincias',$data['id_provincias']);
		$this->db->where('direccion',$data['direccion']);
		$query = $this->db->get('empresa_planta');
		return $query->row()->id;
	}
	
	function ingresar($data){
		$this->db->insert('empresa_planta',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('empresa_planta', array('id' => $id)); 
	}
	
	function get_nombre($nb){
		$this->db->where('nombre',$nb);
		$query = $this->db->get('empresa_planta');
		return $query->row();
	}

}