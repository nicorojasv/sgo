<?php
class Grupo_model extends CI_Model {
	function listar(){
		$query = $this->db->get('planta_grupo');
		return $query->result();
	}
	function listar_planta($id){
		$this->db->where("id_planta",$id);
		$query = $this->db->get('planta_grupo');
		return $query->result();
	}
	function listar_empresa($id){
		$this->db->select('g.id, g.nombre');
		$this->db->from('planta_grupo g');
		$this->db->join('empresa_planta ep', 'g.id_planta = ep.id');
		$this->db->where('ep.id_empresa', $id);

		$query = $this->db->get();
		return $query->result();
	}
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('planta_grupo');
		return $query->row();
	}
	function buscar($palabra){
		$this->db->where("nombre",$palabra);
		$query = $this->db->get('planta_grupo');
		return $query->row();
	}
	
	function ingresar($data){
		$this->db->insert('planta_grupo',$data); 
	}
	
	function actualizar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('planta_grupo', $data); 
	}

	function get_planta($id){
		$this->db->where('id_planta',$id);
		$query = $this->db->get('planta_grupo');
		return $query->result();
	}
}