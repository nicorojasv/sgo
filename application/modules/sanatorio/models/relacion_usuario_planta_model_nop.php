<?php
class Relacion_usuario_planta_model extends CI_Model {
		function __construct(){
		$this->sanatorio = $this->load->database('sanatorio', TRUE);
	}
	function get_usuario($usuario_id, $empresa_planta){
		$this->sanatorio->select('id');
		$this->sanatorio->from('relacion_usuario_planta');
		$this->sanatorio->where('usuario_id', $usuario_id);
		$this->sanatorio->where('empresa_planta_id', $empresa_planta);
		$query = $this->sanatorio->get();
		return $query->row();
	}

	function get_usuario_plantas($usuario_id, $id_centro_costo){
		$this->sanatorio->select('*');
		$this->sanatorio->from('relacion_usuario_planta rel_usu');
		$this->sanatorio->join('empresa_planta ep','rel_usu.empresa_planta_id = ep.id','left');
		$this->sanatorio->where('rel_usu.usuario_id', $usuario_id);
		$this->sanatorio->where('ep.id_centro_costo', $id_centro_costo);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function get_usuario_plantas_relacion($usuario_id){
		$this->sanatorio->select('*');
		$this->sanatorio->from('relacion_usuario_planta rel_usu');
		$this->sanatorio->join('empresa_planta ep','rel_usu.empresa_planta_id = ep.id','left');
		$this->sanatorio->where('rel_usu.usuario_id', $usuario_id);
		$this->sanatorio->order_by('ep.nombre', 'asc');
		//$this->sanatorio->where('ep.id_centro_costo', $id_centro_costo);
		$query = $this->sanatorio->get();
		return $query->result();
	}

	function eliminar_relacion_planta_usuario($usuario){
		$this->sanatorio->delete('relacion_usuario_planta', array('usuario_id' => $usuario));
	}

	function guardar_relacion($data){
		$this->sanatorio->insert('relacion_usuario_planta',$data); 
	}

	function actualizar_relacion($usuario_id, $data){
		$this->sanatorio->where('usuario_id', $usuario_id);
		$this->sanatorio->update('relacion_usuario_planta', $data);
	}
	
	function ver_relacion_planta_usuario($id_usuario, $planta){
		$this->sanatorio->SELECT('*');
		$this->sanatorio->from('relacion_usuario_planta');
		$this->sanatorio->where('usuario_id', $id_usuario);
		$this->sanatorio->where('empresa_planta_id', $planta);
		$query = $this->sanatorio->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}




	
	function get($id){
		$this->sanatorio->where('id',$id);
		$query = $this->sanatorio->get('empresa_planta');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->sanatorio->where('id', $id);
		$this->sanatorio->update('empresa_planta', $data); 
	}
	
	
	
	function eliminar($id){
		$this->sanatorio->delete('empresa_planta', array('id' => $id)); 
	}

}