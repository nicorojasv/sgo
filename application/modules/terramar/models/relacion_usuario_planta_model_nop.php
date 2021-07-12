<?php
class Relacion_usuario_planta_model extends CI_Model {
		function __construct(){
		$this->terramar = $this->load->database('terramar', TRUE);
	}
	function get_usuario($usuario_id, $empresa_planta){
		$this->terramar->select('id');
		$this->terramar->from('relacion_usuario_planta');
		$this->terramar->where('usuario_id', $usuario_id);
		$this->terramar->where('empresa_planta_id', $empresa_planta);
		$query = $this->terramar->get();
		return $query->row();
	}

	function get_usuario_plantas($usuario_id, $id_centro_costo){
		$this->terramar->select('*');
		$this->terramar->from('relacion_usuario_planta rel_usu');
		$this->terramar->join('empresa_planta ep','rel_usu.empresa_planta_id = ep.id','left');
		$this->terramar->where('rel_usu.usuario_id', $usuario_id);
		$this->terramar->where('ep.id_centro_costo', $id_centro_costo);
		$query = $this->terramar->get();
		return $query->result();
	}

	function get_usuario_plantas_relacion($usuario_id){
		$this->terramar->select('*');
		$this->terramar->from('relacion_usuario_planta rel_usu');
		$this->terramar->join('empresa_planta ep','rel_usu.empresa_planta_id = ep.id','left');
		$this->terramar->where('rel_usu.usuario_id', $usuario_id);
		$this->terramar->order_by('ep.nombre', 'asc');
		//$this->terramar->where('ep.id_centro_costo', $id_centro_costo);
		$query = $this->terramar->get();
		return $query->result();
	}

	function eliminar_relacion_planta_usuario($usuario){
		$this->terramar->delete('relacion_usuario_planta', array('usuario_id' => $usuario));
	}

	function guardar_relacion($data){
		$this->terramar->insert('relacion_usuario_planta',$data); 
	}

	function actualizar_relacion($usuario_id, $data){
		$this->terramar->where('usuario_id', $usuario_id);
		$this->terramar->update('relacion_usuario_planta', $data);
	}
	
	function ver_relacion_planta_usuario($id_usuario, $planta){
		$this->terramar->SELECT('*');
		$this->terramar->from('relacion_usuario_planta');
		$this->terramar->where('usuario_id', $id_usuario);
		$this->terramar->where('empresa_planta_id', $planta);
		$query = $this->terramar->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}




	
	function get($id){
		$this->terramar->where('id',$id);
		$query = $this->terramar->get('empresa_planta');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->terramar->where('id', $id);
		$this->terramar->update('empresa_planta', $data); 
	}
	
	
	
	function eliminar($id){
		$this->terramar->delete('empresa_planta', array('id' => $id)); 
	}

}