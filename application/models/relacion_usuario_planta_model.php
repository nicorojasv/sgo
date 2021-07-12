<?php
class Relacion_usuario_planta_model extends CI_Model {
	
	function get_usuario($usuario_id, $empresa_planta){
		$this->db->select('id');
		$this->db->from('relacion_usuario_planta');
		$this->db->where('usuario_id', $usuario_id);
		$this->db->where('empresa_planta_id', $empresa_planta);
		$query = $this->db->get();
		return $query->row();
	}

	function get_usuario_plantas($usuario_id, $id_centro_costo){
		$this->db->select('*');
		$this->db->from('relacion_usuario_planta rel_usu');
		$this->db->join('empresa_planta ep','rel_usu.empresa_planta_id = ep.id','left');
		$this->db->where('rel_usu.usuario_id', $usuario_id);
		$this->db->where('ep.id_centro_costo', $id_centro_costo);
		$query = $this->db->get();
		return $query->result();
	}

	function get_usuario_plantas_relacion($usuario_id){
		$this->db->select('*');
		$this->db->from('relacion_usuario_planta rel_usu');
		$this->db->join('empresa_planta ep','rel_usu.empresa_planta_id = ep.id','left');
		$this->db->where('rel_usu.usuario_id', $usuario_id);
		$this->db->order_by('ep.nombre', 'asc');
		//$this->db->where('ep.id_centro_costo', $id_centro_costo);
		$query = $this->db->get();
		return $query->result();
	}

	function eliminar_relacion_planta_usuario($usuario){
		$this->db->delete('relacion_usuario_planta', array('usuario_id' => $usuario));
	}

	function guardar_relacion($data){
		$this->db->insert('relacion_usuario_planta',$data); 
	}

	function actualizar_relacion($usuario_id, $data){
		$this->db->where('usuario_id', $usuario_id);
		$this->db->update('relacion_usuario_planta', $data);
	}
	
	function ver_relacion_planta_usuario($id_usuario, $planta){
		$this->db->SELECT('*');
		$this->db->from('relacion_usuario_planta');
		$this->db->where('usuario_id', $id_usuario);
		$this->db->where('empresa_planta_id', $planta);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		   return 1;
		}else{
		   return 0;
		}
	}




	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('empresa_planta');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('empresa_planta', $data); 
	}
	
	
	
	function eliminar($id){
		$this->db->delete('empresa_planta', array('id' => $id)); 
	}

}