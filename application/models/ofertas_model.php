<?php
class Ofertas_model extends CI_Model {

	function listar(){
		$this->db->order_by("activo asc, id desc");
		$query = $this->db->get('ofertas_trabajo');
		return $query->result();
	}

	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('ofertas_trabajo');
		return $query->row();
	}

	function ingresar($data){
		$this->db->insert('ofertas_trabajo',$data);
		return $this->db->insert_id();
	}

	function eliminar($id){
		$this->db->delete('ofertas_trabajo', array('id' => $id)); 
	}

	function eliminar_oferta($data){
		$this->db->insert('ofertas_eliminar',$data); 
	}

	function listar_limite($_n,$tipo){
		$this->db->select('*,o.id oferta_id');
		$this->db->from('ofertas_trabajo o');
		$this->db->join('ofertas_usuarios ou','ou.id_ofertas_trabajo = o.id');
		$this->db->where("ou.id_tipo_usuarios",$tipo);
		$this->db->where("o.activo",0);
		$this->db->order_by("o.id","desc");
		$this->db->limit($_n);
		$query = $this->db->get();
		return $query->result();
	}

	function mostrar_listado($id,$id_usuario = FALSE,$inicio=FALSE,$tamano=FALSE){
		$this->db->select('*,o.id oferta_id');
		$this->db->from('ofertas_trabajo o');
		$this->db->join('ofertas_usuarios ou','ou.id_ofertas_trabajo = o.id');
		if($id_usuario)
		 	$this->db->where('NOT EXISTS (SELECT 1 FROM ofertas_eliminar oe WHERE oe.id_ofertas = o.id AND oe.id_usuarios = '.$id_usuario.')', '', FALSE);  
		$this->db->where("ou.id_tipo_usuarios",$id);
		$this->db->order_by("o.activo asc, o.id desc");
		if ($tamano)
			$this->db->limit($tamano, $inicio);
		$query = $this->db->get();
		return $query->result();
	}

	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('ofertas_trabajo', $data);
		return $id;
	}

	//ADJUNTOS
	function ingresar_adjuntos($data){
		$this->db->insert('ofertas_adjuntos',$data); 
	}
	
	function listar_adjuntos($id_ofertas){
		$this->db->where("id_ofertas",$id_ofertas);
		$query = $this->db->get('ofertas_adjuntos');
		return $query->result();
	}

	//INGRESO TIPO DE USUARIOS

	function ingresar_usuario($data){
		$this->db->insert('ofertas_usuarios',$data);
	}

	function get_tu($id_oferta){
		$this->db->where("id_ofertas_trabajo",$id_oferta);
		$query = $this->db->get('ofertas_usuarios');
		return $query->result();
	}

	function editar_tu($id,$data){
		$this->db->where('id_ofertas_trabajo', $id);
		$this->db->update('ofertas_usuarios', $data);
		return $id;
	}

	function eliminar_tu($id){
		$this->db->delete('ofertas_usuarios', array('id_ofertas_trabajo' => $id)); 
	}

	/**** TABLA 'OFERTAS_REVISAR' *****/
	function get_revisar($id_usr,$id_oferta){
		$this->db->where('id_oferta', $id_oferta);
		$this->db->where('id_usuario', $id_usr);
		$query = $this->db->get('ofertas_revisar');
		return $query->num_rows();
	}

	function ingresar_revisar($data){
		$this->db->insert('ofertas_revisar',$data); 
	}
	function eliminar_revisar($id){
		$this->db->delete('ofertas_revisar', array('id' => $id)); 
	}


	//BUSCAR OFERTAS NO LEIDAS POR EL USUARIO

	function noticias_noleidas_usr($id_oferta,$id_usuario){
		$this->db->where("id_usuario",$id_usuario);
		$this->db->where("id_oferta",$id_oferta);
		$this->db->from('ofertas_revisar');
		$query = $this->db->get();
		return $query->row();
	}

	function noticias_noleidas_id($id_oferta,$id_usuario){
		$this->db->where("id_usuario",$id_usuario);
		$this->db->where("id_oferta",$id_oferta);
		$query = $this->db->get('ofertas_revisar');
		return $query->row();
	}

	function cont_ofertas_noleidas($id){
		$this->db->select('*,o.id as id_oferta');
		$this->db->from('ofertas_trabajo o');
		$this->db->join('ofertas_usuarios ou','ou.id_ofertas_trabajo = o.id');
		$this->db->where("ou.id_tipo_usuarios",2);
		$this->db->group_by("o.id");
		$query = $this->db->get();
		$tot_ofertas = $query->num_rows();
		$query->free_result();
		
		$this->db->where("orv.id_usuario",$id);
		$this->db->from('ofertas_revisar orv');
		$this->db->join('ofertas_trabajo o','orv.id_oferta = o.id');
		$cant = $this->db->count_all_results();
		$res = $tot_ofertas - $cant;
		return $res;
	}

}