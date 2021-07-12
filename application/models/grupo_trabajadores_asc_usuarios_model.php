<?php
class Grupo_trabajadores_asc_usuarios_model extends CI_Model {

	function listar(){
		$query = $this->db->get('grupo_trabajadores_asc_usuarios');
		return $query->result();
	}

	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('grupo_trabajadores_asc_usuarios');
		return $query->row();
	}

	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('grupo_trabajadores_asc_usuarios', $data); 
	}

	function ingresar($data){
		$this->db->insert('grupo_trabajadores_asc_usuarios',$data); 
		return $this->db->insert_id();
	}

	function eliminar($id){
		$this->db->delete('grupo_trabajadores_asc_usuarios', array('id' => $id)); 
	}

	function cantidad_usuarios($id_grupo){
		$this->db->where('grupo_trabajadores_id',$id_grupo);
		$this->db->from('grupo_trabajadores_asc_usuarios');
		return $this->db->count_all_results();
	}

	function usuarios_grupo($id_grupo){
		$this->db->where('grupo_trabajadores_id',$id_grupo);
		$query = $this->db->get('grupo_trabajadores_asc_usuarios');
		return $query->result();
	}
}