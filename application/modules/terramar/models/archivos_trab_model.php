<?php
class Archivos_trab_model extends CI_Model {
		function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}
	function listar(){
		$query = $this->terramar->get('archivos_trab');
		return $query->result();
	}
	
	function get($id){
		$this->terramar->where('id',$id);
		$query = $this->terramar->get('archivos_trab');
		return $query->row();
	}
	
	function get_archivo($id_usuario,$id_archivo){
		$this->terramar->where('id_usuarios',$id_usuario);
		$this->terramar->where('id_tipoarchivo',$id_archivo);
		$query = $this->terramar->get('archivos_trab');
		return $query->result();
	}

	function get_archivo2($id_usuario,$id_archivo){
		$this->terramar->select('*');
		$this->terramar->from('archivos_trab');
		$this->terramar->where('id_usuarios',$id_usuario);
		$this->terramar->where('id_tipoarchivo',$id_archivo);
		$this->terramar->order_by('id','desc');
		$query = $this->terramar->get();
		return $query->row();
	}

	function get_existe_archivo($id_usuario,$id_archivo){
		$this->terramar->select('*');
		$this->terramar->from('archivos_trab');
		$this->terramar->where('id_usuarios',$id_usuario);
		$this->terramar->where('id_tipoarchivo',$id_archivo);
		$query = $this->terramar->get();
		if($query->num_rows > 0){
			return $query->row();
		}else{
			return "NE";
		}
	}
	
	function get_usuario($id){
		$this->terramar->select('*,archivos_trab.id as id_archivo, tipo_archivos.id as id_tipo');
		$this->terramar->from('archivos_trab');
		$this->terramar->join("tipo_archivos",'archivos_trab.id_tipoarchivo = tipo_archivos.id');
		$this->terramar->where('archivos_trab.id_usuarios',$id);
		$query = $this->terramar->get();
		return $query->result();
	}
	
	function editar($id,$data){
		$this->terramar->where('id', $id);
		$this->terramar->update('archivos_trab', $data); 
	}
	
	function ingresar($data){
		$this->terramar->insert('archivos_trab',$data); 
	}
	function eliminar($id){
		$this->terramar->delete('archivos_trab', array('id' => $id)); 
	}
}