<?php
class Especialidadtrabajador_model extends CI_Model {
	function listar(){
		//$this->db->order_by("desc_especialidad");
		//$query = $this->db->get('especialidad_trabajador');
		$query = $this->db->query('SELECT * FROM especialidad_trabajador ORDER BY desc_especialidad');
		return $query->result();
	}

	function ingresar($data){
		$this->db->insert('especialidad_trabajador', $data);
		return $this->db->insert_id();
	}

	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('especialidad_trabajador');
		return $query->row();
	}

	function get_usuario($id){
		$this->db->select('*');
		$this->db->from('usuarios');
		$this->db->join('especialidad_trabajador', 'especialidad_trabajador.id = usuarios.id_especialidad_trabajador');
		$this->db->where("usuarios.id",$id);
		$query = $this->db->get();
		return $query->row();
	}

	function buscar($palabra){
		$this->db->where("desc_especialidad",$palabra);
		$query = $this->db->get('especialidad_trabajador');
		return $query->row();
	}

	function actualizar($data,$id){
		$this->db->where('id', $id);
		$this->db->update('especialidad_trabajador', $data); 
	}

}