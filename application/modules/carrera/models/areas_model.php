<?php
class Areas_model extends CI_Model {

	function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}



	function listar(){
		$this->carrera->order_by("desc_area");
		$query = $this->carrera->get('areas');
		return $query->result();
	}
	function lista(){
		$this->carrera->order_by("id");
		$query = $this->carrera->get('r_areas');
		return $query->result();
	}


	function lista_orden_nombre(){
		$this->carrera->order_by("nombre");
		$query = $this->carrera->get('r_areas');
		return $query->result();
	}


	function validar_area($nombre){
		$this->carrera->select('*');
		$this->carrera->from('r_areas');
		$this->carrera->where('nombre', $nombre);
		$query = $this->carrera->get();
		if ($query->num_rows >0){
		   return 1;
		}else{
		   return 0;
		}
	}

	function r_get_result($id){
		$this->carrera->where("id",$id);
		$query = $this->carrera->get('r_areas');
		return $query->result();
	}

	function listar_planta($id){
		$this->carrera->where("id_planta",$id);
		$this->carrera->order_by("desc_area");
		$query = $this->carrera->get('areas');
		return $query->result();
	}
	function listar_empresa($id){
		$this->carrera->where("id_empresa",$id);
		$this->carrera->order_by("desc_area");
		$query = $this->carrera->get('r_areas');
		return $query->result();
	}
	function get($id){
		$this->carrera->where("id",$id);
		$query = $this->carrera->get('areas');
		return $query->row();
	}



	function r_get($id){
		$this->carrera->where("id",$id);
		$query = $this->carrera->get('r_areas');
		return $query->row();
	}


	function get_empresa($id){
		$this->carrera->where("id",$id);
		$query = $this->carrera->get('r_areas');
		return $query->row();
	}
	function get_eval($id_planta,$nb){
		$this->carrera->where("id_planta",$id_planta);
		$this->carrera->where("desc_area",$nb);
		$query = $this->carrera->get('areas');
		return $query->row();
	}
	function ingresar($data){
		$this->carrera->insert('areas',$data); 
	}
	function insert($data){
		$this->carrera->insert('r_areas',$data); 
	}
	function eliminar($id){
		$this->carrera->delete('areas', array('id' => $id)); 
	}
	function r_eliminar($id){
		$this->carrera->delete('r_areas', array('id' => $id)); 
	}
	function editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('areas', $data); 
	}
	function r_editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('r_areas', $data); 
	}
}