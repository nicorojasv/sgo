<?php
class Relacion_usuario_planta_model extends CI_Model {
		function __construct(){
		$this->wood = $this->load->database('wood', TRUE);
	}
	function get_usuario($usuario_id, $empresa_planta){
		$this->wood->select('id');
		$this->wood->from('relacion_usuario_planta');
		$this->wood->where('usuario_id', $usuario_id);
		$this->wood->where('empresa_planta_id', $empresa_planta);
		$query = $this->wood->get();
		return $query->row();
	}

	function get_usuario_plantas($usuario_id, $id_centro_costo){
		$this->wood->select('*');
		$this->wood->from('relacion_usuario_planta rel_usu');
		$this->wood->join('empresa_planta ep','rel_usu.empresa_planta_id = ep.id','left');
		$this->wood->where('rel_usu.usuario_id', $usuario_id);
		$this->wood->where('ep.id_centro_costo', $id_centro_costo);
		$query = $this->wood->get();
		return $query->result();
	}

	function get_usuario_plantas_relacion($usuario_id){
		$this->wood->select('*');
		$this->wood->from('relacion_usuario_planta rel_usu');
		$this->wood->join('empresa_planta ep','rel_usu.empresa_planta_id = ep.id','left');
		$this->wood->where('rel_usu.usuario_id', $usuario_id);
		$this->wood->order_by('ep.nombre', 'asc');
		//$this->wood->where('ep.id_centro_costo', $id_centro_costo);
		$query = $this->wood->get();
		return $query->result();
	}

	function eliminar_relacion_planta_usuario($usuario){
		$this->wood->delete('relacion_usuario_planta', array('usuario_id' => $usuario));
	}

	function guardar_relacion($data){
		$this->wood->insert('relacion_usuario_planta',$data); 
	}

	function actualizar_relacion($usuario_id, $data){
		$this->wood->where('usuario_id', $usuario_id);
		$this->wood->update('relacion_usuario_planta', $data);
	}
	
	function ver_relacion_planta_usuario($id_usuario, $planta){
		$this->wood->SELECT('*');
		$this->wood->from('relacion_usuario_planta');
		$this->wood->where('usuario_id', $id_usuario);
		$this->wood->where('empresa_planta_id', $planta);
		$query = $this->wood->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}




	
	function get($id){
		$this->wood->where('id',$id);
		$query = $this->wood->get('empresa_planta');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->wood->where('id', $id);
		$this->wood->update('empresa_planta', $data); 
	}
	
	
	
	function eliminar($id){
		$this->wood->delete('empresa_planta', array('id' => $id)); 
	}

}