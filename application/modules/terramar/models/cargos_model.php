<?php
class Cargos_model extends CI_Model {

	function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}

	function listar(){
		$this->db->order_by("desc_cargo");
		$query = $this->db->get('cargos');
		return $query->result();
	}

	function r_listar(){
		$this->db->order_by("nombre");
		$query = $this->db->get('r_cargos');
		return $query->result();
	} 
	function lista(){
		$this->db->order_by("id");
		$query = $this->db->get('r_cargos');
		return $query->result();
	}




	function lista_orden_nombre(){
		$this->terramar->order_by("nombre");
		$query = $this->terramar->get('r_cargos');
		return $query->result();
	}





	function listar_planta($id){
		$this->db->where("id_planta",$id);
		$this->db->order_by("desc_cargo");
		$query = $this->db->get('cargos');
		return $query->result();
	}
	function listar_empresa($id){
		$this->db->where("id_empresa",$id);
		$this->db->order_by("desc_cargo");
		$query = $this->db->get('r_cargos');
		return $query->result();
	}
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('cargos');
		return $query->row();
	}




	function r_get($id){
		$this->terramar->where("id",$id);
		$query = $this->terramar->get('r_cargos');
		return $query->row();
	}




	function r_get_result($id){
		$this->db->where("id",$id);
		$query = $this->db->get('r_cargos');
		return $query->result();
	}
	function get_empresa($id){
		$this->db->where("id",$id);
		$query = $this->db->get('r_cargos');
		return $query->row();
	}
	function get_eval($id_planta,$nb){
		$this->db->where("id_planta",$id_planta);
		$this->db->where("desc_cargo",$nb);
		$query = $this->db->get('cargos');
		return $query->row();
	}
	function ingresar($data){
		$this->db->insert('cargos',$data); 
	}
	function insert($data){
		$this->db->insert('r_cargos',$data); 
	}
	function eliminar($id){
		$this->db->delete('cargos', array('id' => $id)); 
	}
	function r_eliminar($id){
		$this->db->delete('r_cargos', array('id' => $id)); 
	}
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('cargos', $data); 
	}
	function r_editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('r_cargos', $data); 
	}

	function validar_cargo($nombre){
		$this->db->select('*');
		$this->db->from('r_cargos');
		$this->db->where('nombre', $nombre);
		$query = $this->db->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}
}