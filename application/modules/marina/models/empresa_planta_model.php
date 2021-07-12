<?php
class Empresa_planta_model extends CI_Model {

	function __construct(){
		$this->marina = $this->load->database('marina', TRUE);
	}

	function get($id){
		$this->marina->where('id',$id);
		$query = $this->marina->get('empresa_planta');
		return $query->row();
	}

	function listar(){
		$this->marina->order_by('nombre', 'asc');
		$query = $this->marina->get('empresa_planta');
		return $query->result();
	}




	function plantas_celulosas(){
		$this->db->select('*');
		$this->db->from('empresa_planta');
		$this->db->where('id_centro_costo', 1);
		$query = $this->db->get();
		return $query->result();
	}

	function plantas_paneles(){
		$this->db->select('*');
		$this->db->from('empresa_planta');
		$this->db->where('id_centro_costo', 2);
		$query = $this->db->get();
		return $query->result();
	}

	function plantas_forestal(){
		$this->db->select('*');
		$this->db->from('empresa_planta');
		$this->db->where('id_centro_costo', 3);
		$query = $this->db->get();
		return $query->result();
	}

	function listar_centro_costo($id_centro_costo){
		$this->db->from('empresa_planta');
		$this->db->where('id_centro_costo', $id_centro_costo);
		$query = $this->db->get();
		return $query->result();
	}





	function get_planta_centro_costo($id){
		$this->marina->select('*');
		$this->marina->from('empresa_planta ep');
		$this->marina->join('centro_costos cc','ep.id_centro_costo = cc.id','left');
		$this->marina->where('ep.id',$id);
		$query = $this->marina->get();
		return $query->row();
	}
	



	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('empresa_planta', $data); 
	}
	
	function ingresar($data){
		$this->db->insert('empresa_planta',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('empresa_planta', array('id' => $id)); 
	}

}