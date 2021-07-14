<?php
class Archivos_trab_model extends CI_Model {
		function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}
	function listar(){
		$query = $this->carrera->get('archivos_trab');
		return $query->result();
	}
	
	function get($id){
		$this->carrera->where('id',$id);
		$query = $this->carrera->get('archivos_trab');
		return $query->row();
	}
	
	function get_archivo($id_usuario,$id_archivo){
		$this->carrera->where('id_usuarios',$id_usuario);
		$this->carrera->where('id_tipoarchivo',$id_archivo);
		$query = $this->carrera->get('archivos_trab');
		return $query->result();
	}

	function get_archivo2($id_usuario,$id_archivo){
		$this->carrera->select('*');
		$this->carrera->from('archivos_trab');
		$this->carrera->where('id_usuarios',$id_usuario);
		$this->carrera->where('id_tipoarchivo',$id_archivo);
		$this->carrera->order_by('id','desc');
		$query = $this->carrera->get();
		return $query->row();
	}

	function get_existe_archivo($id_usuario,$id_archivo){
		$this->carrera->select('*');
		$this->carrera->from('archivos_trab');
		$this->carrera->where('id_usuarios',$id_usuario);
		$this->carrera->where('id_tipoarchivo',$id_archivo);
		$query = $this->carrera->get();
		if($query->num_rows > 0){
			return $query->row();
		}else{
			return "NE";
		}
	}
	
	function get_usuario($id){
		$this->carrera->select('*,archivos_trab.id as id_archivo, tipo_archivos.id as id_tipo');
		$this->carrera->from('archivos_trab');
		$this->carrera->join("tipo_archivos",'archivos_trab.id_tipoarchivo = tipo_archivos.id');
		$this->carrera->where('archivos_trab.id_usuarios',$id);
		$query = $this->carrera->get();
		return $query->result();
	}
	
	function editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('archivos_trab', $data); 
	}
	
	function ingresar($data){
		$this->carrera->insert('archivos_trab',$data); 
	}
	function eliminar($id){
		$this->carrera->delete('archivos_trab', array('id' => $id)); 
	}
}