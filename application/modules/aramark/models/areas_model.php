<?php
class Areas_model extends CI_Model {

	function __construct(){
		$this->aramark = $this->load->database('aramark', TRUE);
	}



	function listar(){
		$this->db->order_by("desc_area");
		$query = $this->db->get('areas');
		return $query->result();
	}
	function lista(){
		$this->db->order_by("id");
		$query = $this->db->get('r_areas');
		return $query->result();
	}





	function lista_orden_nombre(){
		$this->aramark->order_by("nombre");
		$query = $this->aramark->get('r_areas');
		return $query->result();
	}





	function validar_area($nombre){
		$this->db->select('*');
		$this->db->from('r_areas');
		$this->db->where('nombre', $nombre);
		$query = $this->db->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function r_get_result($id){
		$this->db->where("id",$id);
		$query = $this->db->get('r_areas');
		return $query->result();
	}

	function listar_planta($id){
		$this->db->where("id_planta",$id);
		$this->db->order_by("desc_area");
		$query = $this->db->get('areas');
		return $query->result();
	}
	function listar_empresa($id){
		$this->db->where("id_empresa",$id);
		$this->db->order_by("desc_area");
		$query = $this->db->get('r_areas');
		return $query->result();
	}
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('areas');
		return $query->row();
	}



	function r_get($id){
		$this->aramark->where("id",$id);
		$query = $this->aramark->get('r_areas');
		return $query->row();
	}




	function get_empresa($id){
		$this->db->where("id",$id);
		$query = $this->db->get('r_areas');
		return $query->row();
	}
	function get_eval($id_planta,$nb){
		$this->db->where("id_planta",$id_planta);
		$this->db->where("desc_area",$nb);
		$query = $this->db->get('areas');
		return $query->row();
	}
	function ingresar($data){
		$this->db->insert('areas',$data); 
	}
	function insert($data){
		$this->db->insert('r_areas',$data); 
	}
	function eliminar($id){
		$this->db->delete('areas', array('id' => $id)); 
	}
	function r_eliminar($id){
		$this->db->delete('r_areas', array('id' => $id)); 
	}
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('areas', $data); 
	}
	function r_editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('r_areas', $data); 
	}
}