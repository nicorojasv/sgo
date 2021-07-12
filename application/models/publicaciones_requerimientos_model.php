<?php
class Publicaciones_requerimientos_model extends CI_Model {
	
	function listar(){
		$query = $this->db->get('publicaciones_requerimientos');
		return $query->result();
	}
	
	function listar_usuario($id_usr){
		$this->db->select('*, pr.id as idpr, r.nombre as nombre_requerimiento, ra.id as id_area');
		$this->db->from('publicaciones_requerimientos pr');
		$this->db->join('publicaciones_requerimientos_adjuntos pra', 'pr.id = pra.id_publicaciones_requerimientos','left');
		$this->db->join('publicaciones_requerimientos_trabajador prt', 'pr.id = prt.id_publicaciones_requerimiento','left');
		$this->db->join('requerimiento r', 'r.id = pr.id_requerimiento');
		$this->db->join('requerimiento_areas ra', 'r.id = ra.id_requerimiento');
		$this->db->join('requerimiento_cargos rc', 'ra.id = rc.id_requerimiento_areas');
		$this->db->join('requerimiento_trabajador rt', 'rc.id = rt.id_requerimiento_cargos');
		$this->db->join('asigna_requerimiento ar', 'rt.id = ar.id_requerimientotrabajador');
		$this->db->where("(prt.id_trabajador = $id_usr OR prt.id_trabajador IS NULL)");
		$this->db->where('ar.id_usuarios',$id_usr);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get($id){
		$this->db->where('id',$id);
		$query = $this->db->get('publicaciones_requerimientos');
		return $query->row();
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('publicaciones_requerimientos', $data);
		return $id;
	}
	
	function ingresar($data){
		$this->db->insert('publicaciones_requerimientos',$data); 
		return $this->db->insert_id();
	}
	
	function eliminar($id){
		$this->db->delete('publicaciones_requerimientos', array('id' => $id)); 
	}
	
	function get_pub($id_requerimiento,$id_area){
		$this->db->where('id_requerimiento',$id_requerimiento);
		$query1 = $this->db->get('publicaciones_requerimientos');
		
		if( count ($query->result()) > 1){
			$this->db->where('id_requerimiento',$id_requerimiento);
			$this->db->where('id_area',$id_area);
			$query2 = $this->db->get('publicaciones_requerimientos');
			return $query2->row();
		}
		else{
			return $query1->row();
		}
	}
	
	function get_publicacion($id_requerimiento,$id_area = FALSE, $id_usuario = FALSE,$limite=false){
		$this->db->select('*, pr.id as idpr');
		$this->db->from('publicaciones_requerimientos as pr');
		$this->db->join('publicaciones_requerimientos_adjuntos as pra', 'pr.id = pra.id_publicaciones_requerimientos','left');
		$this->db->join('publicaciones_requerimientos_trabajador as prt', 'pr.id = prt.id_publicaciones_requerimiento','left');
		$this->db->where('pr.id_requerimiento',$id_requerimiento);
		$this->db->where('pr.id_area',$id_area);
		$this->db->or_where('pr.id_area IS NULL');
		$this->db->where('prt.id_trabajador',$id_usuario);
		$this->db->or_where('prt.id_trabajador IS NULL');
		if($limite){
			$this->db->limit($limite);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function get_publicacion_limite($id_requerimiento,$id_area = FALSE, $id_usuario = FALSE,$limite){
		$this->db->select('*, pr.id as idpr');
		$this->db->from('publicaciones_requerimientos as pr');
		$this->db->join('publicaciones_requerimientos_adjuntos as pra', 'pr.id = pra.id_publicaciones_requerimientos','left');
		$this->db->join('publicaciones_requerimientos_trabajador as prt', 'pr.id = prt.id_publicaciones_requerimiento','left');
		//$this->db->where('pr.id_requerimiento',$id_requerimiento);
		//$this->db->where('pr.id_area',$id_area);
		//$this->db->or_where('pr.id_area IS NULL');
		$this->db->where('prt.id_trabajador',$id_usuario);
		$this->db->or_where('prt.id_trabajador IS NULL');
		$this->db->where_not_in('pr.id', $id_requerimiento);
		$this->db->order_by('pr.id DESC');
		$this->db->limit($limite);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	
	function get_publicacion_trabajador($id_requerimiento){
		$this->db->select('*');
		$this->db->from('publicaciones_requerimientos as pr');
		$this->db->join('publicaciones_requerimientos_trabajadores as prt', 'pr.id = prt.id_publicaciones_requerimientos');
		$this->db->where('pr.id_requerimiento',$id_requerimiento);
		$query = $this->db->get();
		return $this->db->count_all_results();
	}
	
}
?>