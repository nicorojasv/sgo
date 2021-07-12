<?php
class Areas_model extends CI_Model {

	function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}



	function listar(){
		$this->sanatorio->order_by("desc_area");
		$query = $this->sanatorio->get('areas');
		return $query->result();
	}
	function lista(){
		$this->sanatorio->order_by("id");
		$query = $this->sanatorio->get('r_areas');
		return $query->result();
	}


	function lista_orden_nombre(){
		$this->sanatorio->order_by("nombre");
		$query = $this->sanatorio->get('r_areas');
		return $query->result();
	}


	function validar_area($nombre){
		$this->sanatorio->select('*');
		$this->sanatorio->from('r_areas');
		$this->sanatorio->where('nombre', $nombre);
		$query = $this->sanatorio->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function r_get_result($id){
		$this->sanatorio->where("id",$id);
		$query = $this->sanatorio->get('r_areas');
		return $query->result();
	}

	function listar_planta($id){
		$this->sanatorio->where("id_planta",$id);
		$this->sanatorio->order_by("desc_area");
		$query = $this->sanatorio->get('areas');
		return $query->result();
	}
	function listar_empresa($id){
		$this->sanatorio->where("id_empresa",$id);
		$this->sanatorio->order_by("desc_area");
		$query = $this->sanatorio->get('r_areas');
		return $query->result();
	}
	function get($id){
		$this->sanatorio->where("id",$id);
		$query = $this->sanatorio->get('areas');
		return $query->row();
	}



	function r_get($id){
		$this->sanatorio->where("id",$id);
		$query = $this->sanatorio->get('r_areas');
		return $query->row();
	}


	function get_empresa($id){
		$this->sanatorio->where("id",$id);
		$query = $this->sanatorio->get('r_areas');
		return $query->row();
	}
	function get_eval($id_planta,$nb){
		$this->sanatorio->where("id_planta",$id_planta);
		$this->sanatorio->where("desc_area",$nb);
		$query = $this->sanatorio->get('areas');
		return $query->row();
	}
	function ingresar($data){
		$this->sanatorio->insert('areas',$data); 
	}
	function insert($data){
		$this->sanatorio->insert('r_areas',$data); 
	}
	function eliminar($id){
		$this->sanatorio->delete('areas', array('id' => $id)); 
	}
	function r_eliminar($id){
		$this->sanatorio->delete('r_areas', array('id' => $id)); 
	}
	function editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('areas', $data); 
	}
	function r_editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('r_areas', $data); 
	}
}