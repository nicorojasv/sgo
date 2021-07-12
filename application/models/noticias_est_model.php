<?php
class Noticias_est_model extends CI_Model {
	function listar(){
		$this->db->where("id_noticia_tipo",1);
		$this->db->order_by("id","desc");
		$query = $this->db->get('noticias');
		return $query->result();
	}

	function listar_cap(){
		$this->db->where("id_noticia_tipo",2);
		$this->db->order_by("id","desc");
		$query = $this->db->get('noticias');
		return $query->result();
	}
	
	function listar_limite($_n,$tipo){
		$this->db->select('*,n.id noticia_id');
		$this->db->from('noticias n');
		$this->db->join('noticias_usuarios nu','nu.id_noticias = n.id');
		$this->db->where("nu.usuarios_categoria_id",$tipo);
		$this->db->where("n.id_noticia_tipo",1);
		//$this->db->or_where("id_tipousuarios",NULL);
		$this->db->order_by("n.id","desc");
		$this->db->limit($_n);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function listar_limite_cap($_n,$tipo){
		$this->db->select('*,n.id noticia_id');
		$this->db->from('noticias n');
		$this->db->join('noticias_usuarios nu','nu.id_noticias = n.id');
		$this->db->where("nu.usuarios_categoria_id",$tipo);
		$this->db->where("n.id_noticia_tipo",2);
		//$this->db->or_where("id_tipousuarios",NULL);
		$this->db->order_by("n.id","desc");
		$this->db->limit($_n);
		$query = $this->db->get();
		return $query->result();
	}
	
	function listar_categoria($id_cat){
		$this->db->where('id_categoria',$id_cat);
		$this->db->where("id_noticia_tipo",1);
		$query = $this->db->get('noticias');
		return $query->result();
	}
	
	function get($id){
		$this->db->where("id",$id);
		$query = $this->db->get('noticias');
		return $query->row();
	}

	function get_result($id){
		$this->db->where("id",$id);
		$query = $this->db->get('noticias');
		return $query->result();
	}
	
	function listar_usuario($tipo){
		$this->db->select('*');
		$this->db->from('noticias n');
		$this->db->join('noticias_usuarios nu','nu.id_noticias = n.id');
		$this->db->where("nu.id_tipo_usuarios",$tipo);
		$this->db->where("n.id_noticia_tipo",1);
		$this->db->order_by("n.id","desc");
		$query = $this->db->get();
		return $query->result();
	}
	
	function mostrar_listado($id,$id_usuario = FALSE,$inicio=FALSE,$tamano=FALSE){
		$this->db->select('*,n.id as id_noticia');
		$this->db->from('noticias n');
		$this->db->join('noticias_usuarios nu','nu.id_noticias = n.id');
		if($id_usuario)
		 	$this->db->where('NOT EXISTS (SELECT 1 FROM noticias_eliminar ne WHERE ne.id_noticia = n.id AND ne.id_usuario = '.$id_usuario.')', '', FALSE);  
		$this->db->where("nu.usuarios_categoria_id",$id);
		$this->db->where("n.id_noticia_tipo",1);
		$this->db->order_by("n.id","desc");
		if ($tamano)
			$this->db->limit($tamano, $inicio);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	function mostrar_listado_cap($id,$inicio=FALSE,$tamano=FALSE){
		$this->db->select('*,n.id as id_noticia');
		$this->db->from('noticias n');
		$this->db->join('noticias_usuarios nu','nu.id_noticias = n.id');
		$this->db->where("nu.usuarios_categoria_id",$id);
		$this->db->where("n.id_noticia_tipo",2);
		$this->db->order_by("n.id","desc");
		if ($tamano)
			$this->db->limit($tamano, $inicio);
		$query = $this->db->get();
		return $query->result();
	}
	
	function ingresar($data){
		$this->db->insert('noticias',$data);
		return $this->db->insert_id();
	}

	function eliminar($id){
		$this->db->delete('noticias', array('id' => $id)); 
	}
	
	function editar($id,$data){
		$this->db->where('id', $id);
		$this->db->update('noticias', $data);
		return $id;
	}
	
	/**** TABLA 'NOTICIAS_REVISAR' *****/
	function get_revisar($id_usr,$id_noticia){
		$this->db->where('id_noticia', $id_noticia);
		$this->db->where('id_usuario', $id_usr);
		$query = $this->db->get('noticias_revisar');
		return $query->num_rows();
	}
	function ingresar_revisar($data){
		$this->db->insert('noticias_revisar',$data); 
	}
	function eliminar_revisar($id){
		$this->db->delete('noticias_revisar', array('id' => $id)); 
		//echo $this->db->last_query();
	}
	
	/**** BUSCAR NOTICIAS NO LEIDAS POR USUARIO ****/
	
	/*function cont_noticias_noleidas($id){
		$this->db->where("nr.id_usuario",$id);
		$this->db->from('noticias_revisar nr');
		$this->db->join('noticias n','nr.id_noticia = n.id');
		$this->db->where("n.id_noticia_tipo",1);
		$cant = $this->db->count_all_results();
		return $cant;
	}*/

	function cont_noticias_noleidas($id){
		$this->db->select('*,n.id as id_noticia');
		$this->db->from('noticias n');
		$this->db->join('noticias_usuarios nu','nu.id_noticias = n.id');
		$this->db->where("nu.usuarios_categoria_id",3);
		$this->db->where("n.id_noticia_tipo",1);
		$this->db->group_by("n.id");
		$query = $this->db->get();
		//$tot_noticias = $this->db->count_all_results();
		$tot_noticias = $query->num_rows();
		
		$query->free_result();
		//$tot_noticias = count($this->mostrar_listado(2));

		$this->db->where("nr.id_usuario",$id);
		$this->db->from('noticias_revisar nr');
		$this->db->join('noticias n','nr.id_noticia = n.id');
		$this->db->where("n.id_noticia_tipo",1);
		$cant = $this->db->count_all_results();
		$res = $tot_noticias - $cant;
		return $res;
	}

	/*function cont_capacitacion_noleidas($id){
		$this->db->where("nr.id_usuario",$id);
		$this->db->from('noticias_revisar nr');
		$this->db->join('noticias n','nr.id_noticia = n.id');
		$this->db->where("n.id_noticia_tipo",2);
		$cant = $this->db->count_all_results();
		return $cant;
	}*/

	function cont_capacitacion_noleidas($id){
		$this->db->select('*,n.id as id_noticia');
		$this->db->from('noticias n');
		$this->db->join('noticias_usuarios nu','nu.id_noticias = n.id');
		$this->db->where("nu.usuarios_categoria_id",3);
		$this->db->where("n.id_noticia_tipo",2);
		$this->db->group_by("n.id");
		$query = $this->db->get();
		//$tot_noticias = $this->db->count_all_results();
		$tot_noticias = $query->num_rows();
		
		$query->free_result();
		//$tot_noticias = count($this->mostrar_listado(2));

		$this->db->where("nr.id_usuario",$id);
		$this->db->from('noticias_revisar nr');
		$this->db->join('noticias n','nr.id_noticia = n.id');
		$this->db->where("n.id_noticia_tipo",2);
		$cant = $this->db->count_all_results();
		$res = $tot_noticias - $cant;
		return $res;
	}

	/*

	function noticias_noleidas_usr($id_noticia,$id_usuario){
		$this->db->where("id_usuario",$id_usuario);
		$this->db->where("id_noticia",$id_noticia);
		$this->db->from('noticias_revisar');
		$query = $this->db->get();
		echo $this->db->last_query();
		return $query->result();
	}
	*/
	function noticias_noleidas_usr($id_noticia,$id_usuario){
		$this->db->where("id_usuario",$id_usuario);
		$this->db->where("id_noticia",$id_noticia);
		$this->db->from('noticias_revisar');
		$query = $this->db->get();
		return $query->row();
	}

	function editar_usr($id_noticia,$id_usuario,$data){
		$this->db->where('id_noticia', $id_noticia);
		$this->db->where('id_usuario', $id_usuario);
		$this->db->update('noticias_revisar', $data);
	}

	function noticias_noleidas_id($id_noticia,$id_usuario){
		$this->db->where("id_usuario",$id_usuario);
		$this->db->where("id_noticia",$id_noticia);
		$query = $this->db->get('noticias_revisar');
		return $query->row();
	}
	
	//ADJUNTOS
	function ingresar_adjuntos($data){
		$this->db->insert('noticias_adjuntos',$data); 
	}
	
	function listar_adjuntos($id_noticias){
		$this->db->where("id_noticias",$id_noticias);
		$query = $this->db->get('noticias_adjuntos');
		return $query->result();
	}

	//INGRESO TIPO DE USUARIOS

	function ingresar_usuario($data){
		$this->db->insert('noticias_usuarios',$data);
	}

	function get_tu($id_noticia){
		$this->db->where("id_noticias",$id_noticia);
		$query = $this->db->get('noticias_usuarios');
		return $query->result();
	}


	/* NOTICIAS ELIMINAR */

	function eliminar_noticia($data){
		$this->db->insert('noticias_eliminar',$data); 
	}

	//union de tablas niticias,ofertas y capacitacion para el listado principal
	function union_tablas($id,$id_usuario = FALSE,$inicio=FALSE,$tamano=FALSE){
		if ($id_usuario)
			$filtro =" AND NOT EXISTS (SELECT 1 FROM noticias_eliminar ne WHERE ne.id_noticia = n.id AND ne.id_usuario = ".$id_usuario.")";
		else
			$filtro = "";
		if ($tamano)
			$limit = "LIMIT $inicio, $tamano";
		else
			$limit = "";
		if ($id_usuario)
			$filtro2 =" AND NOT EXISTS (SELECT 1 FROM ofertas_eliminar oe WHERE oe.id_ofertas = o.id AND oe.id_usuarios = ".$id_usuario.")";
		else
			$filtro2 = "";
		$consulta = "(SELECT n.id as id_noticia, n.titulo,n.desc_noticia,n.fecha,1 as activo, 'ajax-noticias' as tabla FROM noticias n JOIN noticias_usuarios nu ON nu.id_noticias = n.id WHERE nu.usuarios_categoria_id = ".$id.$filtro.") UNION ALL (SELECT o.id oferta_id, o.titulo,o.desc_oferta,o.fecha,o.activo, 'ajax-ofertas' as tabla FROM ofertas_trabajo o JOIN ofertas_usuarios ou ON ou.id_ofertas_trabajo = o.id WHERE ou.id_tipo_usuarios = ".$id.$filtro2.") ORDER BY fecha DESC $limit";
		$query = $this->db->query($consulta);
		return $query->result();
	}

	//continuacion de union de tablas, motrasr todas las eliminadas
	function eliminadas_union($id_usuario,$inicio=FALSE,$tamano=FALSE){
		if ($tamano)
			$limit = "LIMIT $inicio, $tamano";
		else
			$limit = "";

		$consulta = "(SELECT n.id AS id_noticia, n.titulo, n.desc_noticia, n.fecha, 1 AS activo,'ajax-noticias' as tabla FROM noticias_eliminar ne JOIN noticias n ON ne.id_noticia = n.id WHERE ne.id_usuario = $id_usuario) UNION (SELECT o.id oferta_id, o.titulo, o.desc_oferta, o.fecha, o.activo,'ajax-ofertas' as tabla FROM ofertas_trabajo o JOIN ofertas_eliminar oe ON oe.id_ofertas = o.id WHERE oe.id_usuarios = $id_usuario) ORDER BY fecha DESC $limit";
		$query = $this->db->query($consulta);
		return $query->result();
	}
}