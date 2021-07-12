<?php
class Archivos_trab_model extends CI_Model {
		function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}
	function listar(){
		$query = $this->wood->get('archivos_trab');
		return $query->result();
	}
	
	function get($id){
		$this->wood->where('id',$id);
		$query = $this->wood->get('archivos_trab');
		return $query->row();
	}
	
	function get_archivo($id_usuario,$id_archivo){
		$this->wood->where('id_usuarios',$id_usuario);
		$this->wood->where('id_tipoarchivo',$id_archivo);
		$query = $this->wood->get('archivos_trab');
		return $query->result();
	}

	function get_archivo2($id_usuario,$id_archivo){
		$this->wood->select('*');
		$this->wood->from('archivos_trab');
		$this->wood->where('id_usuarios',$id_usuario);
		$this->wood->where('id_tipoarchivo',$id_archivo);
		$this->wood->order_by('id','desc');
		$query = $this->wood->get();
		return $query->row();
	}

	function get_existe_archivo($id_usuario,$id_archivo){
		$this->wood->select('*');
		$this->wood->from('archivos_trab');
		$this->wood->where('id_usuarios',$id_usuario);
		$this->wood->where('id_tipoarchivo',$id_archivo);
		$query = $this->wood->get();
		if($query->num_rows > 0){
			return $query->row();
		}else{
			return "NE";
		}
	}
	
	function get_usuario($id){
		$this->wood->select('*,archivos_trab.id as id_archivo, tipo_archivos.id as id_tipo');
		$this->wood->from('archivos_trab');
		$this->wood->join("tipo_archivos",'archivos_trab.id_tipoarchivo = tipo_archivos.id');
		$this->wood->where('archivos_trab.id_usuarios',$id);
		$query = $this->wood->get();
		return $query->result();
	}
	
	function editar($id,$data){
		$this->wood->where('id', $id);
		$this->wood->update('archivos_trab', $data); 
	}
	
	function ingresar($data){
		$this->wood->insert('archivos_trab',$data); 
	}
	function eliminar($id){
		$this->wood->delete('archivos_trab', array('id' => $id)); 
	}
}