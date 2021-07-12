<?php
class Archivos_trab_model extends CI_Model {
		function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}
	function listar(){
		$query = $this->sanatorio->get('archivos_trab');
		return $query->result();
	}
	
	function get($id){
		$this->sanatorio->where('id',$id);
		$query = $this->sanatorio->get('archivos_trab');
		return $query->row();
	}
	
	function get_archivo($id_usuario,$id_archivo){
		$this->sanatorio->where('id_usuarios',$id_usuario);
		$this->sanatorio->where('id_tipoarchivo',$id_archivo);
		$query = $this->sanatorio->get('archivos_trab');
		return $query->result();
	}

	function get_archivo2($id_usuario,$id_archivo){
		$this->sanatorio->select('*');
		$this->sanatorio->from('archivos_trab');
		$this->sanatorio->where('id_usuarios',$id_usuario);
		$this->sanatorio->where('id_tipoarchivo',$id_archivo);
		$this->sanatorio->order_by('id','desc');
		$query = $this->sanatorio->get();
		return $query->row();
	}

	function get_existe_archivo($id_usuario,$id_archivo){
		$this->sanatorio->select('*');
		$this->sanatorio->from('archivos_trab');
		$this->sanatorio->where('id_usuarios',$id_usuario);
		$this->sanatorio->where('id_tipoarchivo',$id_archivo);
		$query = $this->sanatorio->get();
		if($query->num_rows > 0){
			return $query->row();
		}else{
			return "NE";
		}
	}
	
	function get_usuario($id){
		$this->sanatorio->select('*,archivos_trab.id as id_archivo, tipo_archivos.id as id_tipo');
		$this->sanatorio->from('archivos_trab');
		$this->sanatorio->join("tipo_archivos",'archivos_trab.id_tipoarchivo = tipo_archivos.id');
		$this->sanatorio->where('archivos_trab.id_usuarios',$id);
		$query = $this->sanatorio->get();
		return $query->result();
	}
	
	function editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('archivos_trab', $data); 
	}
	
	function ingresar($data){
		$this->sanatorio->insert('archivos_trab',$data); 
	}
	function eliminar($id){
		$this->sanatorio->delete('archivos_trab', array('id' => $id)); 
	}
}