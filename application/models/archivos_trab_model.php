<?php
class Archivos_trab_model extends CI_Model {
	function listar(){
		$query = $this->db->get('archivos_trab');
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('archivos_trab');
		return $query->row();
	}
	
	function get_archivo($id_usuario,$id_archivo){
		$this->db->where('id_usuarios',$id_usuario);
		$this->db->where('id_tipoarchivo',$id_archivo);
		$query = $this->db->get('archivos_trab');
		return $query->result();
	}

	function get_archivo2($id_usuario,$id_archivo){
		$this->db->select('*');
		$this->db->from('archivos_trab');
		$this->db->where('id_usuarios',$id_usuario);
		$this->db->where('id_tipoarchivo',$id_archivo);
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		return $query->row();
	}

	function get_existe_archivo($id_usuario,$id_archivo){
		$this->db->select('*');
		$this->db->from('archivos_trab');
		$this->db->where('id_usuarios',$id_usuario);
		$this->db->where('id_tipoarchivo',$id_archivo);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return "NE";
		}
	}
	
	function get_usuario($id){
		$this->db->select('*,archivos_trab.id as id_archivo, tipo_archivos.id as id_tipo');
		$this->db->from('archivos_trab');
		$this->db->join("tipo_archivos",'archivos_trab.id_tipoarchivo = tipo_archivos.id');
		$this->db->where('archivos_trab.id_usuarios',$id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('archivos_trab', $data); 
	}
	
	function ingresar($data){
		$this->db->insert('archivos_trab',$data); 
	}
	function eliminar($id){
		$this->db->delete('archivos_trab', array('id' => $id)); 
	}
}