<?php
class Relacion_usuario_planta_model extends CI_Model {
		function __construct(){
		$this->carrera = $this->load->database('carrera', TRUE);
	}
	function get_usuario($usuario_id, $empresa_planta){
		$this->carrera->select('id');
		$this->carrera->from('relacion_usuario_planta');
		$this->carrera->where('usuario_id', $usuario_id);
		$this->carrera->where('empresa_planta_id', $empresa_planta);
		$query = $this->carrera->get();
		return $query->row();
	}

	function get_usuario_plantas($usuario_id, $id_centro_costo){
		$this->carrera->select('*');
		$this->carrera->from('relacion_usuario_planta rel_usu');
		$this->carrera->join('empresa_planta ep','rel_usu.empresa_planta_id = ep.id','left');
		$this->carrera->where('rel_usu.usuario_id', $usuario_id);
		$this->carrera->where('ep.id_centro_costo', $id_centro_costo);
		$query = $this->carrera->get();
		return $query->result();
	}

	function get_usuario_plantas_relacion($usuario_id){
		$this->carrera->select('*');
		$this->carrera->from('relacion_usuario_planta rel_usu');
		$this->carrera->join('empresa_planta ep','rel_usu.empresa_planta_id = ep.id','left');
		$this->carrera->where('rel_usu.usuario_id', $usuario_id);
		$this->carrera->order_by('ep.nombre', 'asc');
		//$this->carrera->where('ep.id_centro_costo', $id_centro_costo);
		$query = $this->carrera->get();
		return $query->result();
	}

	function eliminar_relacion_planta_usuario($usuario){
		$this->carrera->delete('relacion_usuario_planta', array('usuario_id' => $usuario));
	}

	function guardar_relacion($data){
		$this->carrera->insert('relacion_usuario_planta',$data); 
	}

	function actualizar_relacion($usuario_id, $data){
		$this->carrera->where('usuario_id', $usuario_id);
		$this->carrera->update('relacion_usuario_planta', $data);
	}
	
	function ver_relacion_planta_usuario($id_usuario, $planta){
		$this->carrera->SELECT('*');
		$this->carrera->from('relacion_usuario_planta');
		$this->carrera->where('usuario_id', $id_usuario);
		$this->carrera->where('empresa_planta_id', $planta);
		$query = $this->carrera->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}




	
	function get($id){
		$this->carrera->where('id',$id);
		$query = $this->carrera->get('empresa_planta');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->carrera->where('id', $id);
		$this->carrera->update('empresa_planta', $data); 
	}
	
	
	
	function eliminar($id){
		$this->carrera->delete('empresa_planta', array('id' => $id)); 
	}

}